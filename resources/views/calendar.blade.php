@extends('layouts.app')

@section('content')
@section('title', 'Calendar')
@include('partials.sidebar')

<div class="container">
    <h2 class="text-center">Event Calendar</h2>
    <div id="calendar"></div>
</div>

<!-- Event Details Modal -->
<div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eventModalLabel">Event Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><strong>Title:</strong> <span id="eventTitle"></span></p>
                <p><strong>Date:</strong> <span id="eventDate"></span></p>
                <p><strong>Description:</strong> <span id="eventDescription"></span></p>
            </div>
        </div>
    </div>
</div>

<!-- Include jQuery and Bootstrap (if not already included) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://uicdn.toast.com/calendar/latest/toastui-calendar.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const Calendar = tui.Calendar;
    const calendar = new Calendar('#calendar', {
        defaultView: 'month',
        useFormPopup: false,
        useDetailPopup: false,
        taskView: false,
        scheduleView: true
    });

    // Fetch events from backend
    fetch("/events")
    .then(response => response.json())
    .then(response => {
        if (!response.success) throw new Error("Invalid data");

        console.log("Fetched Events:", response.data); // Debugging

        const schedules = response.data.map(event => ({
            id: event.id.toString(),
            calendarId: '1',
            title: event.title,
            category: 'time',
            start: event.start,  // Ensure date format is correct
            end: event.end,
            body: event.description || "No description available."
        }));

        console.log("Formatted Schedules:", schedules); // Debugging

        calendar.clear();
        calendar.createEvents(schedules);
        calendar.render();  // ✅ Force UI update

        // ✅ Highlight dates with events
        schedules.forEach(schedule => {
            const eventDate = new Date(schedule.start).toISOString().split('T')[0];
            const dateCell = document.querySelector(`[data-date="${eventDate}"]`);
            if (dateCell) {
                dateCell.style.backgroundColor = "#ffeb3b"; // Highlight event date
            }
        });
    })
    .catch(error => console.error('Error loading events:', error));

    // ✅ Handle event click to show modal
    calendar.on('selectSchedule', function(event) {
        console.log("Clicked Event:", event);

        const { title, start, body } = event.schedule;
        document.getElementById('eventTitle').innerText = title;
        document.getElementById('eventDate').innerText = new Date(start).toLocaleString();
        document.getElementById('eventDescription').innerText = body;

        $('#eventModal').modal('show'); // Show Bootstrap modal
    });
});
</script>

@endsection
