@extends('layouts.card')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card position-relative text-center">

                {{-- Event Image (If exists) --}}
                @if($guest->event->image)
                    <img src="{{ asset('storage/' . $guest->event->image) }}" class="img-fluid rounded-top" alt="Event Image">
                @else
                    <img src="{{ asset('resources/design.png') }}" class="img-fluid rounded-top" alt="Default Event Design">
                @endif

                {{-- Event Host --}}
                <h4 class="host-text position-absolute card-font-2 fw-bold">{{ $guest->event->event_host }}</h4>

                {{-- Invitation Message --}}
                <p class="position-absolute invite-text text-center">
                    INVITE YOU <br>
                    <span class="card-font fw-bolder guest-font">{{ $guest->title }}. {{ $guest->name }}</span><br>
                    TO THE WEDDING CELEBRATION OF
                </p>

                {{-- Bride & Groom Names --}}
                <h1 class="card-texty card-font position-absolute text-center fw-bold">
                    {{ $guest->event->groom }} <br> & <br> {{ $guest->event->bride }}
                </h1>

                {{-- Venue & Location --}}
                <p class="venue-text position-absolute fw-bold">{{ $guest->event->venue }}</p>
                <h3 class="location-text position-absolute">
                    Location: <a href="{{ $guest->event->location_link }}">{{ $guest->event->location_name }}</a>
                </h3>

                {{-- Date & Time --}}
                <h3 class="date-text card-font position-absolute">
                    <span class="text-success">{{ date('D d F Y', strtotime($guest->event->date)) }}</span>
                </h3>
                <p class="time-text position-absolute card-font-2 fw-bolder">
                    Time: {{ $guest->event->time }}
                </p>

                {{-- Other Descriptions --}}
                <h3 class="position-absolute other-desc card-font-2">Other Descriptions:</h3>

                {{-- Video (If exists) --}}
                @if($guest->event->video)
                    <div class="my-3">
                        <video class="w-100 rounded" controls>
                            <source src="{{ asset('storage/' . $guest->event->video) }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                @endif

                {{-- Audio (If exists) --}}
                @if($guest->event->audio)
                    <div class="my-3">
                        <audio controls class="w-100">
                            <source src="{{ asset('storage/' . $guest->event->audio) }}" type="audio/mpeg">
                            Your browser does not support the audio element.
                        </audio>
                    </div>
                @endif

                {{-- Guest Type Badge --}}
                <p class="badge rounded-pill text-bg-primary bg-gradient badge-text position-absolute">{{ $guest->type }}</p>

                {{-- ✅ QR Code Embedded in Invitation --}}
                <div class="qr-code position-absolute" style="bottom: 20px; right: 20px;">
                    {!! QrCode::size(120)->generate(route('guest.checkin', $guest->qr_code)) !!}
                    <p class="small mt-1 text-muted">Scan to Check-In</p>
                </div>


                {{-- RSVP Buttons --}}
                <div class="cta position-absolute">
                    @if ($guest->status == '1')
                        <a href="/card-confirm/{{ $guest->id }}/response" class="btn btn-sm btn-success bg-gradient mx-1">Attending</a>
                        <a href="/card-deny/{{ $guest->id }}/response" class="btn btn-sm btn-danger bg-gradient">Won't Attend</a>
                    @endif
                </div>

                {{-- Contact Information --}}
                <div class="contacts position-absolute">
                    <p>Contacts: {{ $guest->event->contacts }}</p>
                </div>

                {{-- Guest Type Badge --}}
                <p class="badge rounded-pill text-bg-primary bg-gradient badge-text position-absolute">{{ $guest->type }}</p>

            </div>
        </div>
    </div>
</div>
@endsection
