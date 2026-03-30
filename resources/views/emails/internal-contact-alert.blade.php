{{--
    resources/views/emails/internal-contact-alert.blade.php
    --------------------------------------------------------
    Email sent TO: hello@thepacmedia.com (your team alert).
    Triggered when someone submits the contact/briefing form.
    Uses: base.blade.php as the visual shell.

    Expected data (passed via $data array from your Mailable):
      $data['name']        string   required
      $data['email']       string   required
      $data['message']     string   required
      $data['company']     string   optional
      $data['location']    string   optional
      $data['services']    array    optional  e.g. ['Brand Identity', 'Web Development']
      $data['ip_address']  string   optional
--}}
@php
    $subject    = '[New Lead] ' . $data['name'] . ' — ' . now()->format('d M Y');
    $preheader  = 'New briefing request from ' . $data['name'] . ' via thepacmedia.com.';
    $emailType  = 'Internal Alert';
    $indexLabel = '00 — New Lead';
    $heading    = 'New briefing<br/>request received.';

    $bodyLine1  = 'A new contact form submission has arrived. Full details are below. Use the button to reply directly to the sender.';
    $bodyLine2  = null;
    $note       = null;

    // Build the detail rows — only include fields that have values
    $details = [];
    $details['Name']    = $data['name'];
    $details['Email']   = $data['email'];

    if (!empty($data['company'])) {
        $details['Company'] = $data['company'];
    }

    if (!empty($data['location'])) {
        $details['Location'] = $data['location'];
    }

    if (!empty($data['services']) && is_array($data['services'])) {
        // Join array into readable string — fits the detail row cleanly
        $details['Services'] = implode(', ', $data['services']);
    }

    // Truncate message to 160 chars so it fits the detail block
    $details['Message']    = \Illuminate\Support\Str::limit($data['message'], 160);
    $details['Received']   = now()->format('d M Y, H:i') . ' UTC';
    $details['Source']     = 'thepacmedia.com/contact';

    if (!empty($data['ip_address'])) {
        $details['IP Address'] = $data['ip_address'];
    }

    // CTA opens a pre-filled reply in their email client
    $subject_line = rawurlencode('Re: Your enquiry — The Pacmedia');
    $ctaUrl       = 'mailto:' . $data['email'] . '?subject=' . $subject_line;
    $ctaLabel     = 'Reply to ' . $data['name'] . ' →';
@endphp

@include('emails.base')
