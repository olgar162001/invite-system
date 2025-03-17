<!DOCTYPE html>
<html>
<head>
    <title>Event Confirmation</title>
</head>
<body>
    <h2>Hello {{ $guest->name }},</h2>
    <p>Thank you for confirming your attendance for <strong>{{ $event->event_name }}</strong>!</p>

    <p><strong>Event Details:</strong></p>
    <p><strong>Date:</strong> {{ date('F j, Y, g:i A', strtotime($event->start)) }}</p>
    <p><strong>Location:</strong> {{ $event->event_location ?: 'Not specified' }}</p>
    <p><strong>Description:</strong> {{ $event->event_name ?: 'No description available' }}</p>

    <p>The event details have been attached to this email as an **ICS calendar file**.</p>
    <p>You can open it to add the event to your calendar.</p>

    <br>
    <p>Best Regards,</p>
    <p>Event Organizer</p>
</body>
</html>
