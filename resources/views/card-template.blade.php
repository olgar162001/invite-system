@extends('layouts.card')

@section('content')
{{-- @include('partials.sidebar') --}}
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">

                <div class="card">
                    <img src={{ asset('resources/design.png') }} alt="">
                    <h4 class="host-text position-absolute card-font-2 fw-bold">Mr. and Mrs John Doe</h4>
                    <p class="position-absolute invite-text text-center">INVITE YOU <br><span class="card-font fw-bolder guest-font">JONAS CARTER</span><br>TO THE WEDDING CELEBRATION OF</p>

                    <h1 class="card-texty card-font position-absolute text-center fw-bold">Harley <br> & <br>World</h1>
                    <h3 class="venue-text position-absolute fs-5 fw-bold">Mr Price City Hall</h3>
                    <h3 class="location-text position-absolute">Location: <a href="https://maps.app.goo.gl/Vg1w85UNMXghyHpk7">Mbezi Beach</a></h3>
                    <h3 class="time-text"></h3>
                    <h3 class="date-text card-font position-absolute">Friday <span class="text-success fs-2">15</span> December 2023</h3>
                    <h3 class="time-text position-absolute card-font-2 fs-6 fw-bolder">Time: 20:00</h3>
                    <h3 class="position-absolute other-desc card-font-2">Other Descriptions: </h3>

                    <div class="cta position-absolute">
                        <a class="btn btn-success bg-gradient mx-1">Attending</a>
                        <a class="btn btn-danger bg-gradient">Won't attend</a>
                    </div>

                    <div class="contacts position-absolute">
                        {{-- <p>RSVP</p> --}}
                        <p>Contacts: +255713779149</p>
                    </div>

                    <p class="badge rounded-pill text-bg-primary bg-gradient badge-text position-absolute">Single</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection