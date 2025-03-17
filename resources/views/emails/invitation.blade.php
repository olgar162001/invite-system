<!DOCTYPE html>
<html>
<head>
    <title>Event Invitation</title>
</head>
<body>
    <h2>Hello {{ $guest->name }},</h2>
    <p>You are invited to the event: <strong>{{ $guest->event->event_name }}</strong>.</p>
    <p>Click below to view your invitation:</p>
    <a href="{{ $guest->invite_link }}" style="padding: 10px; background: green; color: white; text-decoration: none;">
        View Invitation
    </a>
    <p>We look forward to seeing you!</p>
</body>
</html>
