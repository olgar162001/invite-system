@extends('layouts.card')

@section('content')
{{-- @include('partials.sidebar') --}}
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">

                <div class="card">
                    <img src={{ asset('resources/design.png') }} alt="">
                    {{-- <img src={{ asset('resources/yellow-flower-card.png') }} alt=""> --}}
                    <h4 class="host-text position-absolute card-font-2 fw-bold">{{$guest->event->event_host}}</h4>
                    <p class="position-absolute invite-text text-center">INVITE YOU <br><span class="card-font fw-bolder guest-font">{{$guest->title}}. {{$guest->name}}</span><br>TO THE WEDDING CELEBRATION OF</p>

                    <h1 class="card-texty card-font position-absolute text-center fw-bold">{{$guest->event->groom}} <br> & <br>{{$guest->event->bride}}</h1>
                    <p class="venue-text position-absolute fw-bold">{{$guest->event->venue}}</p>
                    <h3 class="location-text position-absolute">Location: <a href="{{$guest->event->location_link}}">{{$guest->event->location_name}}</a></h3>
                    <h3 class="time-text"></h3>
                    <h3 class="date-text card-font position-absolute"><span class="text-success">{{date('D d F Y', strtotime($guest->event->date))}}</span></h3>
                    <p class="time-text position-absolute card-font-2 fw-bolder">Time: {{$guest->event->time}}</p>
                    <h3 class="position-absolute other-desc card-font-2">Other Descriptions: </h3>

                    <div class="cta position-absolute">
                        @if ($guest->status == '1')
                            <a href="/card-confirm/{{$guest->id}}/response" class="btn btn-sm btn-success bg-gradient mx-1">Attending</a>
                            <a href="/card-deny/{{$guest->id}}/response" class="btn btn-sm btn-danger bg-gradient">Won't attend</a>
                        @endif
                    </div>

                    <div class="contacts position-absolute">
                        {{-- <p>RSVP</p> --}}
                        <p>Contacts: {{$guest->event->contacts}}</p>
                    </div>

                    <p class="badge rounded-pill text-bg-primary bg-gradient badge-text position-absolute">{{$guest->type}}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection