
@extends('layouts.admin.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Planning de {{ $employee->name }}</h1>

    <!-- Calendrier -->
    <div id="calendar"></div>
</div>

<!-- Inclure FullCalendar -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const calendarEl = document.getElementById('calendar');
        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'timeGridWeek',
            events: [
                @foreach($plannings as $planning)
                {
                    title: '{{ $planning->event_name }}',
                    start: '{{ $planning->start_time }}',
                    end: '{{ $planning->end_time }}',
                },
                @endforeach
            ],
        });
        calendar.render();
    });
</script>
@endsection