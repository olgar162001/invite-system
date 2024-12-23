@extends('layouts.card')

@section('content')
{{-- @include('partials.sidebar') --}}
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">

                <div class="card">
                    <img src={{ asset('resources/finalist.png') }} alt="">
                    <h1 class="card-texty card-font position-absolute text-center fw-bold">Thank You <br> For <br>Your Response</h1>
                </div>
                <div class="container">
                    <a href="/card-template/{{$guest->id}}" class="position-absolute location-text btn btn-dark bg-gradient">Show Card</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection