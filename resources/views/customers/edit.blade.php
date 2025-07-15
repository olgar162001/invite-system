@extends('layouts.app')

@section('content')
@include('partials.sidebar')
<div class="container bg-secondary-subtle rounded p-4">
     <h1 class="text-center">Edit Customer</h1>
     <div class="container px-4">
     <form action="{{ url('/customers/'.$customers->id) }}" method="post">
            @csrf
            @method('PUT')
            <div class="mb-3">
                 <label class="form-label">Name</label>
                 <input type="text" name="name" value="{{ $customers->name}}" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" value = "{{ $customers->email}}" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Phone</label>
                <input type="tel" name="phone" value="{{$customers->phone}}" class="form-control" required>
            </div>
           
            <div class="form-group my-4">
            <input type="submit" value="Update Event" class="form-control btn btn-success bg-gradient">
            </div>
        </form>
</div>
</div>
@endsection

                
            
