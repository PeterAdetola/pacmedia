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
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Spatie\Browsershot\Browsershot;

class SendInvoiceEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries   = 2;      // retry once on failure
    public int $timeout = 60;     // give Browsershot enough time

    public function __construct(public Invoice $invoice) {}

    public function handle(): void
    {
        $this->invoice->load([
            'client',
            'completedItems'    => fn($q) => $q->orderBy('sort_order'),
            'subscriptionItems' => fn($q) => $q->orderBy('sort_order'),
            'proposedItems'     => fn($q) => $q->orderBy('sort_order'),
        ]);

        // ── Attempt Browsershot PDF generation ──────────────
        try {
            $pdfContent = Browsershot::html(
                view('admin.invoices.pdf', ['invoice' => $this->invoice])->render()
            )
                ->format('A4')
                ->landscape(false)
                ->margins(0, 0, 0, 0)
                ->showBackground(true)
                ->waitUntilNetworkIdle()
                ->timeout(30)
                ->noSandbox()
                ->setOption('displayHeaderFooter', false)
                ->setOption('preferCSSPageSize', true)
                ->pdf();

        } catch (\Throwable $e) {
            // ── Fallback: send email without PDF, flag it ────
            Log::error("Browsershot failed for invoice #{$this->invoice->number}: " . $e->getMessage());

            Mail::to($this->invoice->client->email)
                ->send(new InvoiceMail($this->invoice, null, failedPdf: true));

            return;
        }

        // ── Happy path: send with PDF attached ───────────────
        Mail::to($this->invoice->client->email)
            ->send(new InvoiceMail($this->invoice, $pdfContent));
    }

    public function failed(\Throwable $e): void
    {
        Log::error("SendInvoiceEmail job failed for invoice #{$this->invoice->number}: " . $e->getMessage());
    }
}
