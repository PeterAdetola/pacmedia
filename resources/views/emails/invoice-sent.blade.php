<!DOCTYPE html>
<html lang="en" xmlns:v="urn:schemas-microsoft-com:vml">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="color-scheme" content="light dark"/>
    <meta name="supported-color-schemes" content="light dark"/>
    <title>Invoice #{{ $invoice->number }} — The Pacmedia</title>

    <style>
        /* ── Reset ─────────────────────────────────────────────── */
        *, *::before, *::after { box-sizing: border-box; }
        body, table, td, a { -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }
        table, td { mso-table-lspace: 0pt; mso-table-rspace: 0pt; }
        img { border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none; }
        body { margin: 0 !important; padding: 0 !important; width: 100% !important; }

        /* ── Font stack ─────────────────────────────────────────── */
        body, table, td, p, a, li, span, h1, h2, h3, h4 {
            font-family: 'Trebuchet MS', -apple-system, BlinkMacSystemFont, 'Segoe UI', Helvetica, Arial, sans-serif;
        }

        /* ── Light mode (default) ───────────────────────────────── */
        :root { color-scheme: light dark; }

        body                { background-color: #babec8; }
        .email-wrapper      { background-color: #babec8; }
        .email-container    { background-color: #d8dde7; border: 1px solid #8f93a1; }
        .email-header       { border-bottom: 1px solid #8f93a1; }
        .brand-name         { color: #151617; }
        .brand-tagline      { color: #797d83; }
        .email-body-text    { color: #44474a; }
        .email-heading      { color: #151617; }
        .email-muted        { color: #797d83; }
        .divider            { background-color: #8f93a1; }
        .detail-block       { background-color: #cdd2dc; border: 1px solid #8f93a1; }
        .detail-row td      { border-bottom: 1px solid #8f93a1; }
        .detail-label       { color: #797d83; }
        .detail-value       { color: #151617; }
        .email-footer       { border-top: 1px solid #8f93a1; }
        .footer-text        { color: #797d83; }
        .footer-link        { color: #797d83; }
        .sig-rule           { background-color: #e0dcd6; }
        .sig-name           { color: #151617; }
        .sig-role           { color: #797d83; }
        .sig-label          { color: #9d9fa5; }
        .sig-value          { color: #151617; }
        .sig-divider        { border-left: 1px solid #d0cdc8; }
        .amount-cell        { background-color: #c4c9d4; }
        .alert-block        { background-color: #fff3cd; border: 1px solid #e6c84a; }
        .alert-text         { color: #7a5c00; }

        /* ── Dark mode overrides ────────────────────────────────── */
        @media (prefers-color-scheme: dark) {
            body, .email-wrapper        { background-color: #000000 !important; }
            .email-container            { background-color: #141414 !important; border-color: #535762 !important; }
            .email-header               { border-bottom-color: #535762 !important; }
            .brand-name                 { color: #f2f5fc !important; }
            .brand-tagline              { color: #505258 !important; }
            .email-body-text            { color: #aeb5c5 !important; }
            .email-heading              { color: #f2f5fc !important; }
            .email-muted                { color: #505258 !important; }
            .divider                    { background-color: #535762 !important; }
            .detail-block               { background-color: #1c1c1c !important; border-color: #535762 !important; }
            .detail-row td              { border-bottom-color: #535762 !important; }
            .detail-label               { color: #505258 !important; }
            .detail-value               { color: #f2f5fc !important; }
            .email-footer               { border-top-color: #535762 !important; }
            .footer-text, .footer-link  { color: #505258 !important; }
            .sig-rule                   { background-color: #2a2a2a !important; }
            .sig-name                   { color: #f2f5fc !important; }
            .sig-role                   { color: #505258 !important; }
            .sig-label                  { color: #505258 !important; }
            .sig-value                  { color: #aeb5c5 !important; }
            .sig-divider                { border-left-color: #535762 !important; }
            .amount-cell                { background-color: #252525 !important; }
            .alert-block                { background-color: #2a2200 !important; border-color: #5c4800 !important; }
            .alert-text                 { color: #e6c84a !important; }
        }

        /* ── Responsive ─────────────────────────────────────────── */
        @media only screen and (max-width: 600px) {
            .email-container    { width: 100% !important; border-radius: 0 !important; border-left: none !important; border-right: none !important; }
            .email-padding      { padding: 32px 24px !important; }
        }
    </style>
</head>

<body>
<div class="email-wrapper" style="background-color:#babec8; padding:40px 16px;">

    <!-- ── Container ──────────────────────────────────────────── -->
    <table class="email-container" width="100%" cellpadding="0" cellspacing="0" role="presentation"
           style="max-width:580px; margin:0 auto; background-color:#d8dde7; border-radius:20px; border:1px solid #8f93a1; overflow:hidden;">

        <!-- ══════════════════════════════════════════════════════
             HEADER
        ═══════════════════════════════════════════════════════ -->
        <tr>
            <td class="email-header" style="padding:28px 40px; border-bottom:1px solid #8f93a1;">
                <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
                    <tr>
                        <td style="vertical-align:middle;">
                            <table cellpadding="0" cellspacing="0" role="presentation">
                                <tr>
                                    <td style="vertical-align:middle; padding-right:10px;">

                                    </td>
                                    <td style="vertical-align:middle;">
                                        <span class="brand-name"
                                              style="font-size:15px; font-weight:600; letter-spacing:0.04em; color:#151617;">
                                            THE PACMEDIA
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td align="right" style="vertical-align:middle;">
                            <span class="brand-tagline"
                                  style="font-size:11px; font-weight:400; letter-spacing:0.1em; text-transform:uppercase; color:#797d83;">
                                Invoice
                            </span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <!-- ══════════════════════════════════════════════════════
             BODY
        ═══════════════════════════════════════════════════════ -->
        <tr>
            <td class="email-padding" style="padding:44px 40px 36px 40px;">

                <!-- Index label -->
                <p class="email-muted"
                   style="font-size:11px; font-weight:400; letter-spacing:0.16em; text-transform:uppercase; color:#797d83; margin:0 0 20px 0;">
                    {{ $invoice->number }} &mdash; Invoice
                </p>

                <!-- Heading -->
                <h2 class="email-heading"
                    style="font-size:28px; font-weight:300; line-height:1.2; color:#151617; margin:0 0 16px 0;">
                    Your invoice is<br/>ready, {{ $invoice->client->name }}.
                </h2>

                <!-- Divider -->
                <div class="divider"
                     style="width:32px; height:1px; background-color:#8f93a1; margin:24px 0;"></div>

                <!-- Intro -->
                <p class="email-body-text"
                   style="font-size:15px; font-weight:400; line-height:1.8; color:#44474a; margin:0 0 16px 0;">
                    Please find your invoice attached to this email as a PDF. A summary of the charges is included below for your reference.
                </p>

                @if($failedPdf)
                    <!-- ── PDF failure alert ────────────────────────── -->
                    <table class="alert-block" width="100%" cellpadding="0" cellspacing="0" role="presentation"
                           style="background-color:#fff3cd; border:1px solid #e6c84a; border-radius:10px; margin-bottom:24px;">
                        <tr>
                            <td style="padding:14px 20px;">
                                <p class="alert-text"
                                   style="font-size:13px; font-weight:400; line-height:1.6; color:#7a5c00; margin:0;">
                                    We encountered an issue generating the PDF attachment for this invoice. Please contact us and we will resend it promptly.
                                </p>
                            </td>
                        </tr>
                    </table>
                @endif

                <!-- ══════════════════════════════════════════════
                     INVOICE DETAILS BLOCK
                ════════════════════════════════════════════════ -->
                <table class="detail-block" width="100%" cellpadding="0" cellspacing="0" role="presentation"
                       style="background-color:#cdd2dc; border:1px solid #8f93a1; border-radius:12px; margin-bottom:12px; overflow:hidden;">

                    <!-- Invoice number -->
                    <tr class="detail-row">
                        <td style="padding:14px 20px; border-bottom:1px solid #8f93a1; width:38%;">
                            <span class="detail-label"
                                  style="font-size:11px; font-weight:600; text-transform:uppercase; letter-spacing:0.12em; color:#797d83;">
                                Invoice No.
                            </span>
                        </td>
                        <td style="padding:14px 20px; border-bottom:1px solid #8f93a1;">
                            <span class="detail-value"
                                  style="font-size:14px; font-weight:600; color:#151617;">
                                {{ $invoice->number }}
                            </span>
                        </td>
                    </tr>

                    @if($invoice->project_name)
                        <!-- Project -->
                        <tr class="detail-row">
                            <td style="padding:14px 20px; border-bottom:1px solid #8f93a1; width:38%;">
                            <span class="detail-label"
                                  style="font-size:11px; font-weight:600; text-transform:uppercase; letter-spacing:0.12em; color:#797d83;">
                                Project
                            </span>
                            </td>
                            <td style="padding:14px 20px; border-bottom:1px solid #8f93a1;">
                            <span class="detail-value"
                                  style="font-size:14px; font-weight:400; color:#151617;">
                                {{ $invoice->project_name }}
                            </span>
                            </td>
                        </tr>
                    @endif

                    <!-- Date issued -->
                    <tr class="detail-row">
                        <td style="padding:14px 20px; border-bottom:1px solid #8f93a1; width:38%;">
                            <span class="detail-label"
                                  style="font-size:11px; font-weight:600; text-transform:uppercase; letter-spacing:0.12em; color:#797d83;">
                                Date Issued
                            </span>
                        </td>
                        <td style="padding:14px 20px; border-bottom:1px solid #8f93a1;">
                            <span class="detail-value"
                                  style="font-size:14px; font-weight:400; color:#151617;">
                                {{ $invoice->submitted_at->format('d M Y') }}
                            </span>
                        </td>
                    </tr>

                    <!-- Due date -->
                    <tr class="detail-row">
                        <td style="padding:14px 20px; border-bottom:1px solid #8f93a1; width:38%;">
                            <span class="detail-label"
                                  style="font-size:11px; font-weight:600; text-transform:uppercase; letter-spacing:0.12em; color:#797d83;">
                                Due Date
                            </span>
                        </td>
                        <td style="padding:14px 20px; border-bottom:1px solid #8f93a1;">
                            <span class="detail-value"
                                  style="font-size:14px; font-weight:400; color:#151617;">
                                {{ $invoice->due_date }}
                            </span>
                        </td>
                    </tr>

                    <!-- Subtotal -->
                    <tr class="detail-row">
                        <td style="padding:14px 20px; border-bottom:1px solid #8f93a1; width:38%;">
                            <span class="detail-label"
                                  style="font-size:11px; font-weight:600; text-transform:uppercase; letter-spacing:0.12em; color:#797d83;">
                                Subtotal
                            </span>
                        </td>
                        <td style="padding:14px 20px; border-bottom:1px solid #8f93a1;">
                            <span class="detail-value"
                                  style="font-size:14px; font-weight:400; color:#151617;">
                                {{ $invoice->formatAmount($invoice->completedSubtotal()) }}
                            </span>
                        </td>
                    </tr>

                    @if($invoice->completed_discount > 0)
                        <!-- Discount -->
                        <tr class="detail-row">
                            <td style="padding:14px 20px; border-bottom:1px solid #8f93a1; width:38%;">
                            <span class="detail-label"
                                  style="font-size:11px; font-weight:600; text-transform:uppercase; letter-spacing:0.12em; color:#797d83;">
                                {{ $invoice->completed_discount_label ?: 'Discount' }}
                            </span>
                            </td>
                            <td style="padding:14px 20px; border-bottom:1px solid #8f93a1;">
                            <span class="detail-value"
                                  style="font-size:14px; font-weight:400; color:#151617;">
                                &minus; {{ $invoice->formatAmount($invoice->completed_discount) }}
                            </span>
                            </td>
                        </tr>
                    @endif

                    @if($invoice->tax_enabled)
                        <!-- Tax -->
                        <tr class="detail-row">
                            <td style="padding:14px 20px; border-bottom:1px solid #8f93a1; width:38%;">
                            <span class="detail-label"
                                  style="font-size:11px; font-weight:600; text-transform:uppercase; letter-spacing:0.12em; color:#797d83;">
                                {{ $invoice->tax_label }} ({{ $invoice->tax_rate }}%)
                            </span>
                            </td>
                            <td style="padding:14px 20px; border-bottom:1px solid #8f93a1;">
                            <span class="detail-value"
                                  style="font-size:14px; font-weight:400; color:#151617;">
                                {{ $invoice->formatAmount($invoice->completedTax()) }}
                            </span>
                            </td>
                        </tr>
                    @endif

                    @if($invoice->wht_enabled)
                        <!-- WHT -->
                        <tr class="detail-row">
                            <td style="padding:14px 20px; border-bottom:1px solid #8f93a1; width:38%;">
                            <span class="detail-label"
                                  style="font-size:11px; font-weight:600; text-transform:uppercase; letter-spacing:0.12em; color:#797d83;">
                                {{ $invoice->wht_label }}
                            </span>
                            </td>
                            <td style="padding:14px 20px; border-bottom:1px solid #8f93a1;">
                            <span class="detail-value"
                                  style="font-size:14px; font-weight:400; color:#151617;">
                                &minus; {{ $invoice->formatAmount($invoice->completedWht()) }}
                            </span>
                            </td>
                        </tr>
                    @endif

                    @if($invoice->paid_amount > 0)
                        <!-- Amount paid -->
                        <tr class="detail-row">
                            <td style="padding:14px 20px; border-bottom:1px solid #8f93a1; width:38%;">
                            <span class="detail-label"
                                  style="font-size:11px; font-weight:600; text-transform:uppercase; letter-spacing:0.12em; color:#797d83;">
                                Paid
                            </span>
                            </td>
                            <td style="padding:14px 20px; border-bottom:1px solid #8f93a1;">
                            <span class="detail-value"
                                  style="font-size:14px; font-weight:400; color:#151617;">
                                &minus; {{ $invoice->formatAmount($invoice->paid_amount) }}
                            </span>
                            </td>
                        </tr>
                    @endif

                    <!-- Amount due — highlighted last row -->
                    <tr>
                        <td class="amount-cell" style="padding:18px 20px; background-color:#c4c9d4; width:38%;">
                            <span class="detail-label"
                                  style="font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:0.12em; color:#797d83;">
                                Amount Due
                            </span>
                        </td>
                        <td class="amount-cell" style="padding:18px 20px; background-color:#c4c9d4;">
                            <span class="detail-value"
                                  style="font-size:17px; font-weight:700; color:#151617;">
                                {{ $invoice->formatAmount(max(0, $invoice->completedOutstanding())) }}
                            </span>
                        </td>
                    </tr>

                </table>

                @if($invoice->bank_name)
                    <!-- ══════════════════════════════════════════════
                     PAYMENT DETAILS BLOCK
                ════════════════════════════════════════════════ -->
                    <table class="detail-block" width="100%" cellpadding="0" cellspacing="0" role="presentation"
                           style="background-color:#cdd2dc; border:1px solid #8f93a1; border-radius:12px; margin-bottom:36px; overflow:hidden;">

                        <tr class="detail-row">
                            <td colspan="2" style="padding:12px 20px; border-bottom:1px solid #8f93a1;">
                            <span class="detail-label"
                                  style="font-size:10px; font-weight:700; letter-spacing:0.16em; text-transform:uppercase; color:#797d83;">
                                Payment Details
                            </span>
                            </td>
                        </tr>

                        <tr class="detail-row">
                            <td style="padding:14px 20px; border-bottom:1px solid #8f93a1; width:38%;">
                            <span class="detail-label"
                                  style="font-size:11px; font-weight:600; text-transform:uppercase; letter-spacing:0.12em; color:#797d83;">
                                Bank
                            </span>
                            </td>
                            <td style="padding:14px 20px; border-bottom:1px solid #8f93a1;">
                            <span class="detail-value"
                                  style="font-size:14px; font-weight:400; color:#151617;">
                                {{ $invoice->bank_name }}
                            </span>
                            </td>
                        </tr>

                        @if($invoice->bank_account_name)
                            <tr class="detail-row">
                                <td style="padding:14px 20px; border-bottom:1px solid #8f93a1; width:38%;">
                            <span class="detail-label"
                                  style="font-size:11px; font-weight:600; text-transform:uppercase; letter-spacing:0.12em; color:#797d83;">
                                Account Name
                            </span>
                                </td>
                                <td style="padding:14px 20px; border-bottom:1px solid #8f93a1;">
                            <span class="detail-value"
                                  style="font-size:14px; font-weight:400; color:#151617;">
                                {{ $invoice->bank_account_name }}
                            </span>
                                </td>
                            </tr>
                        @endif

                        @if($invoice->bank_account_number)
                            <tr>
                                <td style="padding:14px 20px; width:38%;">
                            <span class="detail-label"
                                  style="font-size:11px; font-weight:600; text-transform:uppercase; letter-spacing:0.12em; color:#797d83;">
                                Account No.
                            </span>
                                </td>
                                <td style="padding:14px 20px;">
                            <span class="detail-value"
                                  style="font-size:14px; font-weight:600; color:#151617; letter-spacing:0.04em;">
                                {{ $invoice->bank_account_number }}
                            </span>
                                </td>
                            </tr>
                        @endif

                    </table>
                @else
                    <div style="height:36px;"></div>
                @endif

                <!-- Closing note -->
                <p class="email-body-text"
                   style="font-size:15px; font-weight:400; line-height:1.8; color:#44474a; margin:0 0 8px 0;">
                    If you have any questions regarding this invoice, reply directly to this email and it will land straight in our queue.
                </p>

            </td>
        </tr>

        <!-- ══════════════════════════════════════════════════════
             SENDER SIGNATURE
        ═══════════════════════════════════════════════════════ -->
        <tr>
            <td style="padding:0 40px 36px 40px;">

                <table cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse;">
                    <tr>
                        <td style="vertical-align:middle; padding-right:14px;">
                            <!--[if !mso]><!-->
                            <div style="
                                width:40px; height:40px; border-radius:50%;
                                background:linear-gradient(to right, #faf195 0%, #e6da00 50%, #2b261f 100%);
                                display:inline-block; vertical-align:middle;
                            "></div>
                            <!--<![endif]-->
                            <!--[if mso]>
                            <v:oval xmlns:v="urn:schemas-microsoft-com:vml"
                                    style="width:40px;height:40px;" fillcolor="#e6e200" stroked="f">
                            </v:oval>
                            <![endif]-->
                        </td>
                        <td class="sig-divider"
                            style="vertical-align:middle; border-left:1px solid #d0cdc8; padding-left:14px;">
                            <p class="sig-name"
                               style="font-size:14px; font-weight:600; color:#151617; margin:0 0 3px 0; padding:0;">
                                Peter
                            </p>
                            <p class="sig-role"
                               style="font-size:10px; font-weight:400; letter-spacing:0.1em; text-transform:uppercase; color:#797d83; margin:0; padding:0;">
                                Founder, The Pacmedia
                            </p>
                        </td>
                    </tr>
                </table>

                <div class="sig-rule"
                     style="width:260px; height:1px; background-color:#e0dcd6; margin:12px 0; font-size:0; line-height:0;">&nbsp;</div>

                <table cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse;">
                    <tr>
                        <td style="padding:2px 16px 2px 0; vertical-align:middle;">
                            <span class="sig-label"
                                  style="font-size:10px; font-weight:600; letter-spacing:0.12em; text-transform:uppercase; color:#9d9fa5;">
                                Web
                            </span>
                        </td>
                        <td style="padding:2px 0; vertical-align:middle;">
                            <a href="https://thepacmedia.com" class="sig-value"
                               style="font-size:12px; font-weight:400; color:#151617; text-decoration:none;">
                                thepacmedia.com
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:2px 16px 2px 0; vertical-align:middle;">
                            <span class="sig-label"
                                  style="font-size:10px; font-weight:600; letter-spacing:0.12em; text-transform:uppercase; color:#9d9fa5;">
                                Email
                            </span>
                        </td>
                        <td style="padding:2px 0; vertical-align:middle;">
                            <a href="mailto:&#112;&#101;&#116;&#101;&#114;&#64;&#116;&#104;&#101;&#112;&#97;&#99;&#109;&#101;&#100;&#105;&#97;&#46;&#99;&#111;&#109;" class="sig-value"
                               style="font-size:12px; font-weight:400; color:#151617; text-decoration:none;">
                                &#112;&#101;&#116;&#101;&#114;&#64;&#116;&#104;&#101;&#112;&#97;&#99;&#109;&#101;&#100;&#105;&#97;&#46;&#99;&#111;&#109;
                            </a>
                        </td>
                    </tr>
                </table>

            </td>
        </tr>

        <!-- ══════════════════════════════════════════════════════
             FOOTER
        ═══════════════════════════════════════════════════════ -->
        <tr>
            <td class="email-footer"
                style="padding:24px 40px; border-top:1px solid #8f93a1;">
                <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
                    <tr>
                        <td>
                            <p class="footer-text"
                               style="font-size:12px; color:#797d83; margin:0 0 6px 0; line-height:1.6;">
                                The Pacmedia &mdash; Forging Identity. Engineering Digital Infrastructure.
                            </p>
                            <p class="footer-text"
                               style="font-size:12px; color:#797d83; margin:0; line-height:1.6;">
                                <a href="mailto:&#114;&#101;&#97;&#99;&#104;&#64;&#116;&#104;&#101;&#112;&#97;&#99;&#109;&#101;&#100;&#105;&#97;&#46;&#99;&#111;&#109;" class="footer-link"
                                   style="color:#797d83; text-decoration:none;">
                                    &#114;&#101;&#97;&#99;&#104;&#64;&#116;&#104;&#101;&#112;&#97;&#99;&#109;&#101;&#100;&#105;&#97;&#46;&#99;&#111;&#109;
                                </a>
                                &nbsp;&middot;&nbsp;
                                <a href="https://thepacmedia.com" class="footer-link"
                                   style="color:#797d83; text-decoration:none;">thepacmedia.com</a>
                            </p>
                        </td>
                        <td align="right" style="vertical-align:bottom;">
                            <div style="
                                width:6px; height:6px; border-radius:50%;
                                background:linear-gradient(to right, #faf195 0%, #e6da00 50%, #2b261f 100%);
                            "></div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

    </table>

    <div style="height:40px;"></div>

</div>
</body>
</html>
