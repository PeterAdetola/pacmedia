<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * General-purpose branded email — uses emails/base.blade.php.
 * Sent from the admin Compose panel for any non-invoice email.
 *
 * Usage:
 *   Mail::send(new GeneralMail($request->validated()));
 */
class GeneralMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public readonly array $data,
    ) {}

    /*
    |--------------------------------------------------------------------------
    | Envelope — From is driven by the compose form's from_address dropdown.
    | This means the footer email automatically matches the sender.
    |--------------------------------------------------------------------------
    */
    public function envelope(): Envelope
    {
        return new Envelope(
            from:    new Address($this->data['from_address']),
            subject: $this->data['subject'],
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Content
    |--------------------------------------------------------------------------
    */
    public function content(): Content
    {
        // Body paragraphs — filter blanks, preserve order.
        // The closing paragraph is included as the last element by the form.
        $paragraphs = collect($this->data['body_paragraphs'] ?? [])
            ->filter(fn ($p) => filled($p))
            ->values()
            ->all();

        // Fallback: support legacy bodyLine1 / bodyLine2 keys
        if (empty($paragraphs)) {
            if (filled($this->data['bodyLine1'] ?? null)) {
                $paragraphs[] = $this->data['bodyLine1'];
            }
            if (filled($this->data['bodyLine2'] ?? null)) {
                $paragraphs[] = $this->data['bodyLine2'];
            }
        }

        // Detail block — zip labels + values into ['Label' => 'Value']
        $details = [];
        $labels  = $this->data['detail_labels'] ?? [];
        $values  = $this->data['detail_values'] ?? [];
        foreach ($labels as $i => $label) {
            if (filled($label) && filled($values[$i] ?? null)) {
                $details[$label] = $values[$i];
            }
        }

        // Fallback: support legacy $details array passed directly
        if (empty($details) && !empty($this->data['details'])) {
            $details = $this->data['details'];
        }

        return new Content(
            view: 'emails.base',
            with: [
                // ── Meta ──────────────────────────────────────
                'subject'      => $this->data['subject'],
                'preheader'    => $this->data['preheader']    ?? '',

                // ── Template ──────────────────────────────────
                'emailType'    => $this->data['email_type']   ?? $this->data['emailType']  ?? 'Message',
                'indexLabel'   => $this->data['index_label']  ?? $this->data['indexLabel'] ?? '01 — Message',
                'heading'      => $this->data['heading']      ?? $this->data['subject'],
                'paragraphs'   => $paragraphs,
                'details'      => $details,
                'ctaUrl'       => $this->data['cta_url']      ?? $this->data['ctaUrl']     ?? null,
                'ctaLabel'     => $this->data['cta_label']    ?? $this->data['ctaLabel']   ?? null,
                'note'         => $this->data['note']         ?? null,

                // ── Signature ─────────────────────────────────
                'sigName'      => $this->data['sig_name']     ?? null,
                'sigRole'      => $this->data['sig_role']     ?? null,

                // ── Footer ────────────────────────────────────
                // from_address selected in the compose form drives
                // the footer email automatically — no manual override needed.
                'footerEmail'   => $this->data['from_address'],
                'footerWebsite' => $this->data['footer_website'] ?? 'https://thepacmedia.com',
                'footerPrivacy' => $this->data['footer_privacy'] ?? 'https://thepacmedia.com/privacy',
                'footerName'    => $this->data['footer_name']    ?? 'The Pacmedia',
                'footerTagline' => $this->data['footer_tagline'] ?? 'Forging Identity. Engineering Digital Infrastructure.',
            ],
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Attachments
    | Streams each uploaded file from its temp path — no disk storage needed.
    |--------------------------------------------------------------------------
    */
    public function attachments(): array
    {
        $files = $this->data['attachments'] ?? [];

        return collect($files)
            ->filter()
            ->map(fn ($file) => Attachment::fromPath($file->getRealPath())
                ->as($file->getClientOriginalName())
                ->withMime($file->getMimeType())
            )
            ->all();
    }
}
