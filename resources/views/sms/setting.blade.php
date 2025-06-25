@extends('layouts.app')

@section('content')
@include('partials.sidebar')
<div class="container">
    <h3>SMS Settings</h3>
    <form method="POST" action="{{ route('sms.settings.update') }}">
        @csrf
        <div class="form-group">
            <label>Provider URL</label>
            <input type="text" class="form-control" name="provider_url" value="{{ $setting->provider_url ?? '' }}" required>
        </div>
        <div class="form-group">
            <label>Username</label>
            <input type="text" class="form-control" name="username" value="{{ $setting->username ?? '' }}" required>
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" class="form-control" name="password" value="{{ $setting->password ?? '' }}" required>
        </div>
        <button type="submit" class="btn btn-primary mt-2">Save</button>
    </form>
</div>
@endsection
