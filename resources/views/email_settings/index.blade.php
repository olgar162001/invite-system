<!-- resources/views/email_settings/index.blade.php -->
@extends('layouts.app')

@section('content')
@section('title', 'Email Setting')
    @include('partials.sidebar')
    <div class="container p-4">
        <h1 class="text-center">Email Settings</h1>
        <form method="POST" action="{{ route('email.settings.update') }}">
            @csrf

            <div class="row container">
                @foreach(['mailer', 'host', 'port', 'username', 'password', 'encryption', 'from_address', 'from_name'] as $field)
                    <div class="mb-3 col-6">
                        <label class="form-label">{{ ucwords(str_replace('_', ' ', $field)) }}</label>
                        <input type="{{ $field === 'password' ? 'password' : 'text' }}" name="{{ $field }}" class="form-control"
                            value="{{ old($field, $setting->$field ?? '') }}">
                    </div>
                @endforeach
            </div>

            <div class="container">
                <button type="submit" class="btn btn-success">Save Settings</button>
            </div>
        </form>
    </div>
@endsection