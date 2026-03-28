<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Briefing Request</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: #f4f4f4;
            margin: 0;
            padding: 0;
            color: #1a1a1a;
        }
        .wrapper {
            max-width: 600px;
            margin: 40px auto;
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        .header {
            background: #1a1a1a;
            color: #ffffff;
            padding: 32px 40px;
        }
        .header h1 {
            margin: 0;
            font-size: 20px;
            font-weight: 400;
            letter-spacing: 0.05em;
        }
        .header p {
            margin: 6px 0 0;
            font-size: 12px;
            opacity: 0.5;
            letter-spacing: 0.1em;
            text-transform: uppercase;
        }
        .body {
            padding: 40px;
        }
        .field {
            margin-bottom: 24px;
            border-bottom: 1px solid #f0f0f0;
            padding-bottom: 24px;
        }
        .field:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }
        .field label {
            display: block;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.14em;
            color: #999;
            margin-bottom: 6px;
        }
        .field p {
            margin: 0;
            font-size: 15px;
            line-height: 1.6;
            color: #1a1a1a;
        }
        .services {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin: 0;
            padding: 0;
            list-style: none;
        }
        .services li {
            background: #f4f4f4;
            border-radius: 20px;
            padding: 4px 14px;
            font-size: 12px;
            color: #1a1a1a;
        }
        .footer {
            background: #f9f9f9;
            padding: 20px 40px;
            font-size: 11px;
            color: #aaa;
            text-align: center;
        }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="header">
        <h1>New Briefing Request</h1>
        <p>The PAC Media — Contact Form</p>
    </div>
    <div class="body">
        <div class="field">
            <label>Name</label>
            <p>{{ $data['name'] }}</p>
        </div>

        @if (!empty($data['company']))
            <div class="field">
                <label>Company / Brand</label>
                <p>{{ $data['company'] }}</p>
            </div>
        @endif

        <div class="field">
            <label>Email</label>
            <p><a href="mailto:{{ $data['email'] }}" style="color: #1a1a1a;">{{ $data['email'] }}</a></p>
        </div>

        @if (!empty($data['location']))
            <div class="field">
                <label>Location</label>
                <p>{{ $data['location'] }}</p>
            </div>
        @endif

        @if (!empty($data['services']))
            <div class="field">
                <label>Services Requested</label>
                <ul class="services">
                    @foreach ($data['services'] as $service)
                        <li>{{ $service }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="field">
            <label>Message</label>
            <p>{{ $data['message'] }}</p>
        </div>

        <div class="field">
            <label>IP Address</label>
            <p>{{ $data['ip_address'] }}</p>
        </div>
    </div>
    <div class="footer">
        Submitted via thepacmedia.com · {{ now()->format('d M Y, H:i') }}
    </div>
</div>
</body>
</html>
