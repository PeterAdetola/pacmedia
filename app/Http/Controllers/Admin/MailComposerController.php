<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\GeneralMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailComposerController extends Controller
{
    /**
     * Show the compose page.
     * GET /admin/mail/compose
     */
    public function index()
    {
        $fromAddresses = config('mail.from_addresses', []);

        return view('admin.mail.compose', compact('fromAddresses'));
    }

    /**
     * Send the composed email.
     * POST /admin/mail/compose
     */
    public function send(Request $request)
    {
        $validated = $request->validate([
            'from_address'       => 'required|email',
            'to'                 => 'required|email',
            'subject'            => 'required|string|max:255',
            'email_type'         => 'required|string|max:60',
            'index_label'        => 'nullable|string|max:60',
            'heading'            => 'nullable|string|max:255',

            // Dynamic body paragraphs — at least one required
            'body_paragraphs'    => 'required|array|min:1',
            'body_paragraphs.*'  => 'nullable|string',

            'note'               => 'nullable|string',
            'cta_url'            => 'nullable|url',
            'cta_label'          => 'nullable|string|max:80',

            // Signature fields
            'sig_name'           => 'nullable|string|max:120',
            'sig_role'           => 'nullable|string|max:120',

            // Optional detail rows
            'detail_labels.*'    => 'nullable|string|max:80',
            'detail_values.*'    => 'nullable|string|max:255',

            // Attachments
            'attachments'        => 'nullable|array',
            'attachments.*'      => 'nullable|file|max:10240', // 10MB per file
        ]);

        // Whitelist check
        $allowed = array_column(config('mail.from_addresses', []), 'address');
        if (!in_array($validated['from_address'], $allowed)) {
            return back()->withErrors(['from_address' => 'Invalid sender address.'])->withInput();
        }

        // Resolve sender name
        $fromConfig = collect(config('mail.from_addresses'))
            ->firstWhere('address', $validated['from_address']);
        $fromName = $fromConfig['name'] ?? 'The Pacmedia';

        // Build detail rows — skip empty pairs
        $details = [];
        $labels  = $request->input('detail_labels', []);
        $values  = $request->input('detail_values', []);
        foreach ($labels as $i => $label) {
            if (!empty($label) && !empty($values[$i])) {
                $details[$label] = $values[$i];
            }
        }

        // Build paragraphs — filter blanks
        $paragraphs = array_values(
            array_filter(
                $validated['body_paragraphs'] ?? [],
                fn($p) => trim($p) !== ''
            )
        );

        $data = [
            'from_address' => $validated['from_address'],
            'subject'    => $validated['subject'],
            'preheader'  => $paragraphs[0] ?? '',
            'email_type' => $validated['email_type'],
            'index_label'=> $validated['index_label'] ?? '01 — Message',
            'heading'    => $validated['heading']     ?? $validated['subject'],
            'body_paragraphs' => $paragraphs,
            'note'       => $validated['note']        ?? null,
            'details'    => $details,
            'cta_url'    => $validated['cta_url']     ?? null,
            'cta_label'  => $validated['cta_label']   ?? null,
            'sig_name'   => $validated['sig_name']    ?? 'Peter',
            'sig_role'   => $validated['sig_role']    ?? 'Founder, The Pacmedia',
        ];

        // Pass uploaded files into $data so GeneralMail::attachments() can stream them
        $data['attachments'] = $request->file('attachments') ?? [];

        $mailable = (new GeneralMail($data))->from($validated['from_address'], $fromName);

        Mail::to($validated['to'])->send($mailable);

        return back()->with('success', 'Email sent to ' . $validated['to'] . '.');
    }
}
