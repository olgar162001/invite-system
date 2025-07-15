<!-- resources/views/email_settings/index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Email Settings</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('email.settings.update') }}">
        @csrf

        @foreach(['mailer', 'host', 'port', 'username', 'password', 'encryption', 'from_address', 'from_name'] as $field)
            <div class="mb-3">
                <label class="form-label">{{ ucwords(str_replace('_', ' ', $field)) }}</label>
                <input type="{{ $field === 'password' ? 'password' : 'text' }}"
                       name="{{ $field }}"
                       class="form-control"
                       value="{{ old($field, $setting->$field) }}">
            </div>
        @endforeach

        <button type="submit" class="btn btn-primary">Save Settings</button>
    </form>
</div>
@endsection
