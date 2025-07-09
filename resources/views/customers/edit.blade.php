@extends('layouts.app')

@section('content')
@include('partials.sidebar')
<div class="container bg-secondary-subtle rounded p-4">
     <h1 class="text-center">Edit Customer</h1>
     <div class="container px-4">
        <form action="{{ url('/customers/'.$customer) }}" method="post">
            @csrf
            <div class="mb-3">
                 <label class="form-label">Name</label>
                 <input type="text" name="name" value="{{ $customer->name}}" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" value = "{{ $customer->email}}" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Phone</label>
                <input type="tel" name="phone" value="{{$customer->phone}}" class="form-control" required>
            </div>
           
            <div class="form-group my-4">
                    <input type="submit" value="Update Event" class="form-control btn btn-success bg-gradient">
            </div>
        </form>
</div>
</div>
@endsection
                
            
