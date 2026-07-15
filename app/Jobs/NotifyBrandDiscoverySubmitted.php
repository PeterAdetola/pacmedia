<?php
// app/Jobs/NotifyBrandDiscoverySubmitted.php

namespace App\Jobs;

use App\Mail\GeneralMail;
use App\Models\BrandDiscovery;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class NotifyBrandDiscoverySubmitted implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public readonly BrandDiscovery $discovery,
    ) {}

    public function handle(): void
    {
        $d = $this->discovery;

        $paragraphs = [
            "A new brand discovery questionnaire just came in" . ($d->client_token ? " for **{$d->brand_name}**" : '') . ".",
        ];

        if ($d->brand_description) {
            $paragraphs[] = $d->brand_description;
        }

        Mail::to(config('mail.admin_address', config('mail.from.address')))
            ->queue(new GeneralMail([
                'from_address'  => config('mail.from.address'),
                'subject'       => 'New Brand Discovery — ' . $d->brand_name,
                'email_type'    => 'Notification',
                'index_label'   => '01 — Brand Discovery',
                'heading'       => 'New Discovery Submitted',
                'body_paragraphs' => $paragraphs,
                'detail_labels' => ['Name', 'Brand', 'Email', 'Industry', 'Urgency'],
                'detail_values' => [
                    $d->name,
                    $d->brand_name,
                    $d->email,
                    $d->industry ?: '—',
                    $d->urgency ?: '—',
                ],
                'cta_url'   => route('admin.brand-discoveries.show', $d),
                'cta_label' => 'Review Submission',
                'sig_name'  => 'The Pacmedia System',
            ]));
    }
}
