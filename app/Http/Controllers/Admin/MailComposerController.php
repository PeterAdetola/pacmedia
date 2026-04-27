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
     * Route: GET /admin/mail/compose
     */
    public function index()
    {
        $fromAddresses = config('mail.from_addresses', []);

        return view('admin.mail.compose', compact('fromAddresses'));
    }

    /**
     * Send the composed email.
     * Route: POST /admin/mail/compose
     */
    public function send(Request $request)
    {
        $validated = $request->validate([
            'from_address'    => 'required|email',
            'to'              => 'required|email',
            'subject'         => 'required|string|max:255',
            'email_type'      => 'required|string|max:60',
            'index_label'     => 'nullable|string|max:60',
            'heading'         => 'nullable|string|max:255',

            // Dynamic paragraphs — at least one required
            'paragraphs'      => 'required|array|min:1',
            'paragraphs.*'    => 'required|string',

            'note'            => 'nullable|string',
            'cta_url'         => 'nullable|url',
            'cta_label'       => 'nullable|string|max:80',

            // Optional detail rows
            'detail_labels.*' => 'nullable|string|max:80',
            'detail_values.*' => 'nullable|string|max:255',
        ]);

        // Whitelist check
        $allowed = array_column(config('mail.from_addresses', []), 'address');
        if (!in_array($validated['from_address'], $allowed)) {
            return back()->withErrors(['from_address' => 'Invalid sender address.'])->withInput();
        }

        // Resolve sender name from config
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

        // Build paragraphs — filter empty, then split into bodyLine1/bodyLine2/extra
        // base.blade.php supports bodyLine1 + bodyLine2 natively.
        // For 3+ paragraphs we join the extras into bodyLine2 separated by double breaks.
        $paragraphs = array_values(array_filter($validated['paragraphs'], fn($p) => trim($p) !== ''));

        $bodyLine1 = $paragraphs[0] ?? '';
        $bodyLine2 = null;

        if (count($paragraphs) > 1) {
            // Join remaining paragraphs — the template renders each as its own <p>
            // We pass them as an array so the view can loop them
            $bodyLine2 = implode("\n\n", array_slice($paragraphs, 1));
        }

        $data = [
            'subject'      => $validated['subject'],
            'preheader'    => $bodyLine1,
            'emailType'    => $validated['email_type'],
            'indexLabel'   => $validated['index_label'] ?? '01 — Message',
            'heading'      => $validated['heading']     ?? $validated['subject'],
            'bodyLine1'    => $bodyLine1,
            'bodyLine2'    => $bodyLine2,
            'paragraphs'   => $paragraphs,   // full array — used by invoice-style templates
            'note'         => $validated['note']      ?? null,
            'details'      => $details,
            'ctaUrl'       => $validated['cta_url']   ?? null,
            'ctaLabel'     => $validated['cta_label'] ?? null,
        ];

        Mail::to($validated['to'])
            ->send(
                (new GeneralMail($data))->from($validated['from_address'], $fromName)
            );

        return back()->with('success', 'Email sent to ' . $validated['to'] . '.');
    }
}
