<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * Sent TO: hello@thepacmedia.com when someone submits the contact form.
 *
 * Usage in your controller:
 *
 *   Mail::to('hello@thepacmedia.com')->send(new InternalContactAlert([
 *       'name'        => $validated['name'],
 *       'email'       => $validated['email'],
 *       'message'     => $validated['message'],
 *       'company'     => $validated['company']     ?? null,
 *       'location'    => $validated['location']    ?? null,
 *       'services'    => $validated['services']    ?? [],
 *       'ip_address'  => $request->ip(),
 *   ]));
 */
class InternalContactAlert extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public readonly array $data,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '[New Lead] ' . $this->data['name'] . ' — ' . now()->format('d M Y'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.internal-contact-alert',
            with: [
                'data' => $this->data,
            ],
        );
    }
}
