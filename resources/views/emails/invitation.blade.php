<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>You're Invited!</title>
    <style>
        /* Base styles */
        body {
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            color: #495057;
            line-height: 1.6;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        a {
            color: #6c5ce7;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        a:hover {
            color: #5649c0;
        }

        .header-bg {
            background: #1c1c1c;
        }

        .footer-bg {
            background: #1c1c1c;
        }

        .event-card {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .btn-primary {
            background-color: #6c5ce7;
            color: white !important;
            padding: 14px 28px;
            border-radius: 50px;
            font-weight: 600;
            display: inline-block;
            text-align: center;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #5649c0;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(108, 92, 231, 0.3);
        }

        .social-icon {
            display: inline-block;
            width: 36px;
            height: 36px;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            text-align: center;
            line-height: 36px;
            margin: 0 5px;
            transition: all 0.3s ease;
        }

        .social-icon:hover {
            background-color: rgba(255, 255, 255, 0.2);
            transform: translateY(-3px);
        }

        .divider {
            height: 1px;
            background-color: rgba(0, 0, 0, 0.1);
            margin: 25px 0;
        }

        .event-details {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }

        .detail-item {
            margin-bottom: 12px;
        }

        .detail-label {
            font-weight: 600;
            color: #6c5ce7;
            display: inline-block;
            width: 100px;
        }

        .calendar-links {
            margin: 20px 0;
            text-align: center;
        }

        .calendar-btn {
            display: inline-block;
            padding: 8px 16px;
            background-color: #f1f1f1;
            border-radius: 4px;
            margin: 0 5px;
            color: #333;
            font-size: 14px;
        }
    </style>
</head>

<body
    style="margin:0; padding:0; background-color:#f8f9fa; font-family:'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;">
    <!-- Preheader text (shows in inbox preview) -->
    <div style="display:none; max-height:0px; overflow:hidden;">
        You're invited to {{ $guest->event->event_name }}. Join us for this special occasion!
    </div>

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f8f9fa;">
        <tr>
            <td align="center" style="padding: 40px 0;">
                <!-- Main container -->
                <table role="presentation" width="600" cellpadding="0" cellspacing="0"
                    style="background-color:#ffffff; border-radius:12px; overflow:hidden; box-shadow:0 5px 15px rgba(0,0,0,0.05);">

                    <!-- Logo Header -->
                    <tr>
                        <td align="center" class="header-bg" style="padding: 40px 30px;">
                            <img src="{{ asset('resources/logo-white.png') }}" alt="NiaEvents Logo" width="170"
                                style="display:block; max-width:100%; height:auto;">
                            <h1 style="color:white; margin:20px 0 0; font-size:24px; font-weight:300;">You're Invited!
                            </h1>
                        </td>
                    </tr>

                    <!-- Email body -->
                    <tr>
                        <td style="padding: 40px 40px 30px;">
                            <h2 style="margin-top: 0; color:#2d3436;">Hello {{ $guest->name }},</h2>
                            <p style="font-size: 16px; line-height: 1.6; margin-bottom:25px;">
                                We're thrilled to invite you to <strong
                                    style="color:#6c5ce7;">{{ $guest->event->event_name }}</strong>.
                                Please find the event details below and RSVP at your earliest convenience.
                            </p>

                            <!-- Event Details Card -->
                            <div class="event-details">
                                <div class="detail-item">
                                    <span class="detail-label">When:</span>
                                    <span>{{ $guest->event->event_date }} at
                                        {{ $guest->event->event_time }}</span>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-label">Where:</span>
                                    <span>{{ $guest->event->location }}</span>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-label">Dress Code:</span>
                                    <span>{{ $guest->event->dress_code ?? 'Smart Casual' }}</span>
                                </div>
                            </div>

                            <!-- Calendar Links -->
                            <div class="calendar-links">
                                <p style="margin-bottom:10px; font-size:14px;">Add to calendar:</p>
                                {{-- <a href="{{ $guest->calendar_links['google'] }}" class="calendar-btn">Google</a>
                                <a href="{{ $guest->calendar_links['outlook'] }}" class="calendar-btn">Outlook</a>
                                <a href="{{ $guest->calendar_links['ics'] }}" class="calendar-btn">iCal</a> --}}
                            </div>

                            <!-- CTA Button -->
                            <div style="text-align:center; margin: 30px 0;">
                                <a href="{{ $guest->invite_link }}" class="btn-primary">
                                    View Full Invitation & RSVP
                                </a>
                            </div>

                            <!-- Divider -->
                            <div class="divider"></div>

                            <!-- Map Preview -->
                            <p style="font-weight:600; margin-bottom:15px;">Event Location:</p>
                            <a href="https://maps.google.com/?q={{ urlencode($guest->event->location) }}"
                                target="_blank">
                                <img src="https://maps.googleapis.com/maps/api/staticmap?center={{ urlencode($guest->event->location) }}&zoom=14&size=600x200&maptype=roadmap&markers=color:red%7C{{ urlencode($guest->event->location) }}&key=YOUR_API_KEY"
                                    alt="Map to {{ $guest->event->location }}"
                                    style="width:100%; height:auto; border-radius:8px; border:1px solid #eee;">
                            </a>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td class="footer-bg" style="padding: 30px; color:#ffffff; text-align:center; font-size: 14px;">
                            <!-- Social Links -->
                            <div style="margin-bottom:20px;">
                                <a href="#" class="social-icon" style="color:white;">FB</a>
                                <a href="#" class="social-icon" style="color:white;">TW</a>
                                <a href="#" class="social-icon" style="color:white;">IG</a>
                                <a href="#" class="social-icon" style="color:white;">IN</a>
                            </div>

                            <!-- Footer Links -->
                            <p style="margin:0 0 15px;">
                                <a href="{{env('APP_URL')}}" style="color:#a29bfe; margin: 0 10px;">Home</a> •
                                <a href="{{env('APP_URL')}}/about" style="color:#a29bfe; margin: 0 10px;">About</a> •
                                <a href="{{env('APP_URL')}}/contact" style="color:#a29bfe; margin: 0 10px;">Contact</a>
                                •
                                <a href="{{env('APP_URL')}}/events" style="color:#a29bfe; margin: 0 10px;">Events</a>
                            </p>

                            <!-- Copyright -->
                            <p style="margin:10px 0 0; color:rgba(255,255,255,0.7); font-size:13px;">
                                &copy; {{ date('Y') }} Niacraft Solutions. All rights reserved.<br>
                                <a href="{{env('APP_URL')}}/privacy" style="color:rgba(255,255,255,0.7);">Privacy
                                    Policy</a> |
                                <a href="{{env('APP_URL')}}/terms" style="color:rgba(255,255,255,0.7);">Terms of
                                    Service</a>
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>