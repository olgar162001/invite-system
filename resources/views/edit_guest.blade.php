@extends('layouts.app')
@include('partials.sidebar')

@section('content')
<div class="container profile-card">
    <div class="row justify-content-center">
        <div class="col-md-7">
            {{-- <div class="container">
                <h1 class="text-center pb-4">Welcome </h1>
            </div> --}}
            <a href="/event" class="btn btn-dark bg-gradient mb-3"><i class="fa fa-arrow-left me-1"></i> Go Back</a>

            <div class="card">
                <div class="py-3 text-center"><h2>Edit Guest Details</h2></div>

                <div class="card-body shadow py-5">
                    <form method="POST" action="/guest/{{$guest->id}}">
                        
                        {{ csrf_field() }}
                        {{method_field('PUT')}}

                        {{-- Name section --}}
                        <div class="row mb-4">
                            <label for="name" class="col-md-4 col-form-label text-md-end">Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ $guest->name }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- Title section --}}
                        <div class="row mb-4">
                            <label for="title" class="col-md-4 col-form-label text-md-end">Title</label>

                            <div class="col-md-6">
                                <input id="title" type="text" class="form-control" name="title" value="{{ $guest->title }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- Email section --}}
                        <div class="row mb-4">
                            <label for="email" class="col-md-4 col-form-label text-md-end">Email</label>

                            <div class="col-md-6">
                                <input id="address" type="email" class="form-control" name="email" value="{{ $guest->email }}" autocomplete="address">
                            </div>
                        </div>

                        {{-- Phone section --}}

                        <div class="row mb-4">
                            <label for="phone" class="col-md-4 col-form-label text-md-end">Phone</label>

                            <div class="col-md-6">
                                <input id="phone" type="text" class="form-control" name="phone" value="{{ $guest->phone }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- Type section --}}

                        <div class="row mb-4">
                            <label for="name" class="col-md-4 col-form-label text-md-end">Type</label>

                            <div class="col-md-6">
                                <select name="type" id="" class="form-select">
                                    <option value="Single">Single</option>
                                    <option value="Double">Double</option>
                                </select>
                                {{-- <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus> --}}
                            </div>
                        </div>

                        {{-- Status section --}}
                        <div class="row mb-4">
                            <label for="company" class="col-md-4 col-form-label text-md-end">Status</label>

                            <div class="col-md-6">
                                <select name="status" class="form-select" value="{{ $guest->status }}" id="status">
                                    <option value="Pending">Pending</option>
                                    <option value="Attending">Attending</option>
                                    <option value="Not Attending">Not Attending</option>
                                </select>
                            </div>
                        </div>

                        {{-- Invite Link --}}
                        {{-- <div class="row mb-4">
                            <label for="name" class="col-md-4 col-form-label text-md-end">Invite Link</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="invite_link" value="{{ $guest->invite_link }}" required autocomplete="name" autofocus>
                            </div>
                        </div> --}}

                        {{-- Edit button --}}

                        <div class="row mb-0">
                            <div class="col-md-6 form-group offset-md-4">
                                <button type="submit" class="btn btn-success bg-gradient form-control">
                                    {{ __('Edit') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
