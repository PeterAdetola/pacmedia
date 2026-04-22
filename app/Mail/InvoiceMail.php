<?php

// app/Mail/InvoiceMail.php

namespace App\Mail;

use App\Models\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvoiceMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public Invoice $invoice,
        public ?string $pdfContent,         // null if Browsershot failed
        public bool $failedPdf = false
    ) {}

    public function build(): self
    {
        $mail = $this
            ->subject("Invoice #{$this->invoice->number} — The Pacmedia")
            ->view('mail.invoice-sent')
            ->with(['failedPdf' => $this->failedPdf]);

        if ($this->pdfContent) {
            $mail->attachData($this->pdfContent, "Invoice-{$this->invoice->number}.pdf", [
                'mime' => 'application/pdf',
            ]);
        }

        return $mail;
    }
}
