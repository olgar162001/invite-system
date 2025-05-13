@extends('layouts.app')

@section('content')
@include('partials.sidebar')

<div class="container mt-4">
    <h1 class="text-center text-dark">Dashboard</h1>
    <hr style="margin: auto; width: 8%;">

    {{-- Stats --}}
    <div class="d-flex flex-wrap my-4 justify-content-center">
        <div class="card m-2 shadow-sm" style="min-width: 250px;">
            <div class="card-header bg-primary text-white">
                <h5>Total Events</h5>
            </div>
            <div class="card-body">
                <h3>{{ count($events) }}</h3>
            </div>
        </div>

        <div class="card m-2 shadow-sm" style="min-width: 250px;">
            <div class="card-header bg-info text-white">
                <h5>Templates</h5>
            </div>
            <div class="card-body">
                <h3>1</h3> {{-- Change this to dynamic if needed --}}
            </div>
        </div>
    </div>

    {{-- Calendar --}}
    <div class="mt-4">
        <h4 class="text-center text-dark">Event Calendar</h4>
        <div id="calendar" style="height: 550px; max-width: 100%; margin: auto;"></div>
    </div>
</div>

{{-- Modal for Event Details --}}
<div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content shadow">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="eventTitle"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p><strong>Date:</strong> <span id="eventDate"></span></p>
                <p><strong>Description:</strong></p>
                <p id="eventDescription"></p>
            </div>
        </div>
    </div>
</div>

{{-- Required JS --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="https://uicdn.toast.com/calendar/latest/toastui-calendar.min.css">
<script src="https://uicdn.toast.com/calendar/latest/toastui-calendar.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const Calendar = tui.Calendar;
    const calendar = new Calendar('#calendar', {
        defaultView: 'month',
        useFormPopup: false,
        useDetailPopup: false,
        taskView: false,
        scheduleView: true,
        template: {
            monthDayname: function(dayname) {
                return '<span class="calendar-dayname">' + dayname.label + '</span>';
            }
        }
    });

    fetch("/events")
        .then(response => response.json())
        .then(response => {
            if (!response.success) throw new Error("Invalid data");

            const schedules = response.data.map(event => ({
                id: event.id.toString(),
                calendarId: '1',
                title: event.title,
                category: 'time',
                start: event.start,
                end: event.end,
                body: event.description || "No description."
            }));

            calendar.clear();
            calendar.createEvents(schedules);
        })
        .catch(error => console.error('Error loading events:', error));

    calendar.on('selectSchedule', function(event) {
        const { title, start, body } = event.schedule;
        document.getElementById('eventTitle').innerText = title;
        document.getElementById('eventDate').innerText = new Date(start).toLocaleString();
        document.getElementById('eventDescription').innerText = body;
        $('#eventModal').modal('show');
    });
});
</script>
@endsection
