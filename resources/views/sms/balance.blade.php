@extends('layouts.app')

@section('content')
@include('partials.sidebar')
<div class="container">
    <h3>SMS Unit Balance</h3>
    <ul class="list-group">
        <li class="list-group-item">Total Units: <strong>{{ $balance->total_units }}</strong></li>
        <li class="list-group-item">Available Units: <strong>{{ $balance->available_units }}</strong></li>
        <li class="list-group-item">Assigned to Customers: 
            <strong>{{ $balance->total_units - $balance->available_units }}</strong>
        </li>
    </ul>
</div>
@endsection
