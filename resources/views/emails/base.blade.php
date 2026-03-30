<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="x-apple-disable-message-reformatting">
    <meta name="color-scheme" content="light dark">
    <meta name="supported-color-schemes" content="light dark">
    <!--[if mso]>
    <noscript><xml><o:OfficeDocumentSettings><o:PixelsPerInch>96</o:PixelsPerInch></o:OfficeDocumentSettings></xml></noscript>
    <![endif]-->
    <title>{{ $subject ?? 'The Pacmedia' }}</title>
    <style>
        /* ── Reset ─────────────────────────────────────── */
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body, table, td, a { -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }
        table, td { mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-collapse: collapse; }
        img { -ms-interpolation-mode: bicubic; border: 0; outline: none; text-decoration: none; display: block; }
        a { text-decoration: none; }
        body { margin: 0 !important; padding: 0 !important; width: 100% !important; }

        /* ── Light mode ────────────────────────────────── */
        :root { color-scheme: light dark; }
        body,
        .email-wrapper   { background-color: #cfd2d7; }
        .email-container { background-color: #d8dde7; border: 1px solid #8f93a1; }
        .email-header    { border-bottom: 1px solid #8f93a1; }
        .email-footer    { border-top: 1px solid #8f93a1; }
        .brand-name      { color: #151617; }
        .index-label     { color: #797d83; }
        .heading-text    { color: #151617; }
        .body-text       { color: #44474a; }
        .muted-text      { color: #797d83; }
        .divider         { background-color: #8f93a1; }
        .cta-button      { background-color: #151617 !important; color: #f2f5fc !important; border: 1px solid #151617 !important; }
        .note-block      { border-left: 2px solid #8f93a1; }
        .note-text       { color: #797d83; }
        .detail-block    { background-color: #cdd2dc; border: 1px solid #8f93a1; }
        .detail-row      { border-bottom: 1px solid #8f93a1; }
        .detail-label    { color: #797d83; }
        .detail-value    { color: #151617; }
        .peridot-dot     { background-color: #b8b800; }
        .footer-link     { color: #797d83; }

        /* ── Dark mode ─────────────────────────────────── */
        @media (prefers-color-scheme: dark) {
            body,
            .email-wrapper   { background-color: #000000 !important; }
            .email-container { background-color: #141414 !important; border-color: #535762 !important; }
            .email-header    { border-bottom-color: #535762 !important; }
            .email-footer    { border-top-color: #535762 !important; }
            .brand-name      { color: #f2f5fc !important; }
            .index-label     { color: #505258 !important; }
            .heading-text    { color: #f2f5fc !important; }
            .body-text       { color: #aeb5c5 !important; }
            .muted-text      { color: #505258 !important; }
            .divider         { background-color: #535762 !important; }
            .cta-button      { background-color: #f2f5fc !important; color: #151617 !important; border-color: #f2f5fc !important; }
            .note-block      { border-left-color: #535762 !important; }
            .note-text       { color: #505258 !important; }
            .detail-block    { background-color: #1c1c1c !important; border-color: #535762 !important; }
            .detail-row      { border-bottom-color: #535762 !important; }
            .detail-label    { color: #505258 !important; }
            .detail-value    { color: #f2f5fc !important; }
            .peridot-dot     { background-color: #e6e200 !important; }
            .footer-link     { color: #505258 !important; }
        }

        /* ── Responsive ────────────────────────────────── */
        @media only screen and (max-width: 600px) {
            .email-container { width: 100% !important; border-radius: 0 !important; border-left: none !important; border-right: none !important; }
            .email-padding   { padding: 28px 24px !important; }
            .header-padding  { padding: 20px 24px !important; }
            .footer-padding  { padding: 20px 24px !important; }
            .cta-button      { display: block !important; width: 100% !important; text-align: center !important; }
            .detail-label-td,
            .detail-value-td { display: block !important; width: 100% !important; }
            .detail-label-td { padding-bottom: 2px !important; }
            .detail-value-td { padding-top: 0 !important; padding-bottom: 12px !important; }
            .hide-mobile     { display: none !important; }
        }
    </style>
</head>

{{--
╔══════════════════════════════════════════════════════════════╗
║  The Pacmedia — Base Email Template                          ║
║  resources/views/emails/base.blade.php                       ║
║                                                              ║
║  Variables (all optional — defaults provided):               ║
║    $subject      Email subject / tab title                   ║
║    $preheader    Hidden inbox preview text                   ║
║    $emailType    Top-right tag e.g. "Confirmation"           ║
║    $indexLabel   e.g. "01 — Message Received"                ║
║    $heading      Main headline — HTML allowed                ║
║    $bodyLine1    First body paragraph                        ║
║    $bodyLine2    Second paragraph (optional)                 ║
║    $note         Italic aside block (optional)               ║
║    $details      Associative array ['Label' => 'Value']      ║
║    $ctaUrl       CTA button URL                              ║
║    $ctaLabel     CTA button text                             ║
╚══════════════════════════════════════════════════════════════╝
--}}
<body>

{{-- Preheader hidden text --}}
@if (!empty($preheader))
    <div style="display:none;max-height:0;overflow:hidden;mso-hide:all;visibility:hidden;opacity:0;font-size:1px;color:#cfd2d7;">{{ $preheader }}&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;</div>
@endif

{{-- ══ OUTER WRAPPER — centres the container ══ --}}
<table class="email-wrapper" width="100%" cellpadding="0" cellspacing="0" role="presentation"
       style="background-color:#cfd2d7;width:100%;">
    <tr>
        <td align="center" style="padding:40px 16px;">

            {{-- ══ CONTAINER ══ --}}
            <table class="email-container" cellpadding="0" cellspacing="0" role="presentation"
                   style="max-width:580px;width:100%;background-color:#d8dde7;border:1px solid #8f93a1;border-radius:20px;overflow:hidden;">

                {{-- ── HEADER ── --}}
                <tr>
                    <td class="email-header header-padding"
                        style="padding:26px 40px;border-bottom:1px solid #8f93a1;">
                        <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
                            <tr>
                                {{-- Dot + name --}}
                                <td style="vertical-align:middle;">
                                    <table cellpadding="0" cellspacing="0" role="presentation">
                                        <tr>
                                            <td style="vertical-align:middle;padding-right:9px;">
                                                <div class="peridot-dot" style="width:8px;height:8px;background-color:#b8b800;border-radius:50%;display:inline-block;vertical-align:middle;"></div>
                                            </td>
                                            <td style="vertical-align:middle;">
                                                <span class="brand-name" style="font-family:'Trebuchet MS',-apple-system,BlinkMacSystemFont,'Helvetica Neue',Helvetica,Arial,sans-serif;font-size:14px;font-weight:700;letter-spacing:0.12em;text-transform:uppercase;color:#151617;">The Pacmedia</span>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                {{-- Email type --}}
                                <td align="right" style="vertical-align:middle;">
                                    <span class="index-label" style="font-family:'Trebuchet MS',-apple-system,BlinkMacSystemFont,'Helvetica Neue',Helvetica,Arial,sans-serif;font-size:10px;font-weight:400;letter-spacing:0.14em;text-transform:uppercase;color:#797d83;">{{ $emailType ?? 'Notification' }}</span>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                {{-- ── BODY ── --}}
                <tr>
                    <td class="email-padding" style="padding:44px 40px 40px 40px;">

                        {{-- Index label --}}
                        <p class="index-label" style="font-family:'Trebuchet MS',-apple-system,BlinkMacSystemFont,'Helvetica Neue',Helvetica,Arial,sans-serif;font-size:10px;font-weight:600;letter-spacing:0.18em;text-transform:uppercase;color:#797d83;margin:0 0 16px 0;">{{ $indexLabel ?? '01 — Notice' }}</p>

                        {{-- Headline --}}
                        <h2 class="heading-text" style="font-family:'Trebuchet MS',-apple-system,BlinkMacSystemFont,'Helvetica Neue',Helvetica,Arial,sans-serif;font-size:30px;font-weight:300;line-height:1.25;letter-spacing:-0.01em;color:#151617;margin:0;">{!! $heading ?? 'Your message<br/>has been received.' !!}</h2>

                        {{-- Rule --}}
                        <div class="divider" style="width:28px;height:1px;background-color:#8f93a1;margin:24px 0;font-size:0;line-height:0;">&nbsp;</div>

                        {{-- Body line 1 --}}
                        <p class="body-text" style="font-family:'Trebuchet MS',-apple-system,BlinkMacSystemFont,'Helvetica Neue',Helvetica,Arial,sans-serif;font-size:15px;font-weight:400;line-height:1.8;color:#44474a;margin:0 0 16px 0;">{{ $bodyLine1 ?? 'We have received your submission and our team is reviewing it now.' }}</p>

                        {{-- Body line 2 (optional) --}}
                        @if (!empty($bodyLine2))
                            <p class="body-text" style="font-family:'Trebuchet MS',-apple-system,BlinkMacSystemFont,'Helvetica Neue',Helvetica,Arial,sans-serif;font-size:15px;font-weight:400;line-height:1.8;color:#44474a;margin:0 0 32px 0;">{{ $bodyLine2 }}</p>
                        @else
                            <div style="margin-bottom:32px;"></div>
                        @endif

                        {{-- Detail block (optional) --}}
                        @if (!empty($details))
                            <table class="detail-block" width="100%" cellpadding="0" cellspacing="0" role="presentation"
                                   style="background-color:#cdd2dc;border:1px solid #8f93a1;border-radius:12px;margin-bottom:32px;overflow:hidden;">
                                @foreach ($details as $label => $value)
                                    <tr>
                                        <td class="detail-label-td detail-row" style="padding:12px 20px;border-bottom:1px solid #8f93a1;width:36%;vertical-align:middle;">
                                            <span class="detail-label" style="font-family:'Trebuchet MS',-apple-system,BlinkMacSystemFont,'Helvetica Neue',Helvetica,Arial,sans-serif;font-size:10px;font-weight:600;text-transform:uppercase;letter-spacing:0.14em;color:#797d83;">{{ $label }}</span>
                                        </td>
                                        <td class="detail-value-td detail-row" style="padding:12px 20px;border-bottom:1px solid #8f93a1;vertical-align:middle;">
                                            <span class="detail-value" style="font-family:'Trebuchet MS',-apple-system,BlinkMacSystemFont,'Helvetica Neue',Helvetica,Arial,sans-serif;font-size:14px;font-weight:500;color:#151617;">{{ $value }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        @endif

                        {{-- CTA (optional) --}}
                        @if (!empty($ctaUrl))
                            <table cellpadding="0" cellspacing="0" role="presentation" style="margin-bottom:32px;">
                                <tr>
                                    <td>
                                        <a href="{{ $ctaUrl }}" class="cta-button" style="display:inline-block;font-family:'Trebuchet MS',-apple-system,BlinkMacSystemFont,'Helvetica Neue',Helvetica,Arial,sans-serif;font-size:13px;font-weight:700;letter-spacing:0.08em;text-transform:uppercase;text-decoration:none;color:#f2f5fc;background-color:#151617;border:1px solid #151617;border-radius:50px;padding:15px 36px;line-height:1;">{{ $ctaLabel ?? 'Visit Our Website &#8594;' }}</a>
                                    </td>
                                </tr>
                            </table>
                        @endif

                        {{-- Note / aside (optional) --}}
                        @if (!empty($note))
                            <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
                                <tr>
                                    <td class="note-block note-text" style="padding:12px 16px;border-left:2px solid #8f93a1;font-family:'Trebuchet MS',-apple-system,BlinkMacSystemFont,'Helvetica Neue',Helvetica,Arial,sans-serif;font-size:13px;line-height:1.7;font-style:italic;color:#797d83;">{{ $note }}</td>
                                </tr>
                            </table>
                        @endif

                    </td>
                </tr>

                {{-- ── FOOTER ── --}}
                <tr>
                    <td class="email-footer footer-padding"
                        style="padding:22px 40px;border-top:1px solid #8f93a1;">
                        <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
                            <tr>
                                <td style="vertical-align:middle;">
                                    <p class="muted-text" style="font-family:'Trebuchet MS',-apple-system,BlinkMacSystemFont,'Helvetica Neue',Helvetica,Arial,sans-serif;font-size:11px;line-height:1.65;color:#797d83;margin:0 0 4px 0;">The Pacmedia &mdash; Forging Identity. Engineering Digital Infrastructure.</p>
                                    <p class="muted-text" style="font-family:'Trebuchet MS',-apple-system,BlinkMacSystemFont,'Helvetica Neue',Helvetica,Arial,sans-serif;font-size:11px;line-height:1.65;color:#797d83;margin:0;">
                                        <a href="mailto:hello@thepacmedia.com" class="footer-link" style="color:#797d83;text-decoration:none;">hello&#64;thepacmedia.com</a>
                                        &nbsp;&middot;&nbsp;
                                        <a href="https://thepacmedia.com" class="footer-link" style="color:#797d83;text-decoration:none;">thepacmedia.com</a>
                                        &nbsp;&middot;&nbsp;
                                        <a href="https://thepacmedia.com/privacy" class="footer-link" style="color:#797d83;text-decoration:none;">Privacy</a>
                                        &nbsp;&middot;&nbsp;
                                        &copy; {{ now()->year }} The Pacmedia
                                    </p>
                                </td>
                                <td class="hide-mobile" align="right" style="vertical-align:middle;padding-left:20px;">
                                    <div class="peridot-dot" style="width:6px;height:6px;background-color:#b8b800;border-radius:50%;"></div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

            </table>
            {{-- /Container --}}

            <div style="height:32px;"></div>

        </td>
    </tr>
</table>

</body>
</html>
