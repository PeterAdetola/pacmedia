<?php

// app/Jobs/SendInvoiceEmail.php

namespace App\Jobs;

use App\Mail\InvoiceMail;
use App\Models\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendInvoiceEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries   = 2;
    public int $timeout = 60;

    public function __construct(
        public Invoice $invoice,
        public string  $customSubject,
        public string  $customMessage,
    ) {}

    public function handle(): void
    {
        $this->invoice->load([
            'client',
            'completedItems'    => fn($q) => $q->orderBy('sort_order'),
            'subscriptionItems' => fn($q) => $q->orderBy('sort_order'),
            'proposedItems'     => fn($q) => $q->orderBy('sort_order'),
        ]);

        // ── PDF via Browserless (same approach as InvoiceController::pdf()) ──
        $pdfContent = null;
        $failedPdf  = false;

        try {
            $html = view('admin.invoices.pdf', ['invoice' => $this->invoice])->render();

            $response = Http::timeout(45)->withHeaders([
                'Cache-Control' => 'no-cache',
                'Content-Type'  => 'application/json',
            ])->post('https://chrome.browserless.io/pdf?token=' . config('services.browserless.token'), [
                'html'    => $html,
                'options' => [
                    'format'          => 'A4',
                    'landscape'       => false,
                    'printBackground' => true,
                    'margin'          => ['top' => '0mm', 'right' => '0mm', 'bottom' => '0mm', 'left' => '0mm'],
                ],
            ]);

            if ($response->successful()) {
                $pdfContent = base64_encode($response->body());
            } else {
                throw new \RuntimeException('Browserless returned HTTP ' . $response->status());
            }
        } catch (\Throwable $e) {
            Log::error("PDF generation failed for invoice #{$this->invoice->number}: " . $e->getMessage());
            $failedPdf = true;
        }

        // ── Send (with PDF if available, flagged if not) ─────────────────────
        Mail::to($this->invoice->client->email)
            ->send(new InvoiceMail(
                invoice:       $this->invoice,
                pdfContent:    $pdfContent,
                customSubject: $this->customSubject,
                customMessage: $this->customMessage,
                failedPdf:     $failedPdf,
            ));
    }

    public function failed(\Throwable $e): void
    {
        Log::error("SendInvoiceEmail permanently failed for invoice #{$this->invoice->number}: " . $e->getMessage());
    }
}
