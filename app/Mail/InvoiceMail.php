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
        public ?string $pdfContent,     // raw PDF bytes — null if Browsershot failed
        public bool $failedPdf = false
    ) {}

    public function build(): self
    {
        $subject = "Invoice {$this->invoice->number} — The Pacmedia";
        if ($this->invoice->project_name) {
            $subject .= ' · ' . $this->invoice->project_name;
        }

        $mail = $this
            ->subject($subject)
            ->view('emails.invoice')        // resources/views/emails/invoice.blade.php
            ->with([
                'invoice'    => $this->invoice,
                'failedPdf'  => $this->failedPdf,
            ]);

        if ($this->pdfContent) {
            $mail->attachData(
                $this->pdfContent,
                'Invoice-' . $this->invoice->number . '.pdf',
                ['mime' => 'application/pdf']
            );
        }

        return $mail;
    }
}
