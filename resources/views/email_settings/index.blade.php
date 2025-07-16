<!-- resources/views/email_settings/index.blade.php -->
@extends('layouts.app')

@section('content')
@section('title', 'Email Setting')
@include('partials.sidebar')
<div class="container">
    <h2>Email Settings</h2>
    <form method="POST" action="{{ route('email.settings.update') }}">
        @csrf

        @foreach(['mailer', 'host', 'port', 'username', 'password', 'encryption', 'from_address', 'from_name'] as $field)
            <div class="mb-3">
                <label class="form-label">{{ ucwords(str_replace('_', ' ', $field)) }}</label>
                <input type="{{ $field === 'password' ? 'password' : 'text' }}"
                    name="{{ $field }}"
                    class="form-control"
                    value="{{ old($field, $setting->$field ?? '') }}">
            </div>
        @endforeach


        <button type="submit" class="btn btn-primary">Save Settings</button>
    </form>
</div>
@endsection
