<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * General-purpose branded email — uses emails/base.blade.php.
 * Sent from the admin Compose panel for any non-invoice email.
 *
 * Usage:
 *   Mail::to($to)
 *       ->send(
 *           (new GeneralMail($data))->from($fromAddress, $fromName)
 *       );
 */
class GeneralMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public readonly array $data,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->data['subject'],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.base',
            with: [
                'subject'     => $this->data['subject'],
                'preheader'   => $this->data['preheader']   ?? '',
                'emailType'   => $this->data['emailType']   ?? 'Message',
                'indexLabel'  => $this->data['indexLabel']  ?? '01 — Message',
                'heading'     => $this->data['heading']     ?? $this->data['subject'],
                'bodyLine1'   => $this->data['bodyLine1']   ?? '',
                'bodyLine2'   => $this->data['bodyLine2']   ?? null,
                'note'        => $this->data['note']        ?? null,
                'details'     => $this->data['details']     ?? [],
                'ctaUrl'      => $this->data['ctaUrl']      ?? null,
                'ctaLabel'    => $this->data['ctaLabel']    ?? null,
            ],
        );
    }
}
