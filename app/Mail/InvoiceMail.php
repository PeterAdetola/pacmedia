<?php

// app/Mail/InvoiceMail.php

namespace App\Mail;

use App\Models\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Invoice $invoice,
        public ?string $pdfContent,     // raw PDF bytes — null if generation failed
        public string  $customSubject,  // subject line from the send form
        public string  $customMessage,  // body text from the send form
        public bool    $failedPdf = false,
    ) {}

    public function build(): self
    {
        $mail = $this
            ->subject($this->customSubject)
            ->view('emails.invoice-sent')   // resources/views/emails/invoice-sent.blade.php
            ->with([
                'invoice'       => $this->invoice,
                'customMessage' => $this->customMessage,
                'failedPdf'     => $this->failedPdf,
            ]);

        if ($this->pdfContent) {
            $mail->attachData(
                base64_decode($this->pdfContent),
                'Invoice-' . $this->invoice->number . '.pdf',
                ['mime' => 'application/pdf']
            );
        }

        return $mail;
    }
}
