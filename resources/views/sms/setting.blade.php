@extends('layouts.app')

@section('content')
@section('title', 'SMS Settings')
    @include('partials.sidebar')
    <div class="container">
        <h3>SMS Settings</h3>
        <form method="POST" action="{{ route('sms.settings.update') }}">
            @csrf

            <div class="row">
                <div class="form-group col-6 col-md-6 col-sm-12">
                    <label>Provider URL</label>
                    <input type="text" class="form-control" name="provider_url" value="{{ $setting->provider_url ?? '' }}"
                        required>
                </div>

                <div class="form-group col-6 col-md-6 col-sm-12">
                    <label>Username</label>
                    <input type="text" class="form-control" name="username" value="{{ $setting->username ?? '' }}" required>
                </div>

                <div class="form-group col-6 col-md-6 col-sm-12">
                    <label>Password</label>
                    <input type="password" class="form-control" name="password" value="{{ $setting->password ?? '' }}"
                        required>
                </div>

            </div>

            <div class="row">
                <div class="form-group col-6 col-md-6 col-sm-12">
                    <label>SMS Template</label>
                    <textarea name="template_message" class="form-control" rows="8"
                        placeholder="Example: Hello {name}, you're invited to {event}.">{{ $setting->template_message ?? '' }}</textarea>
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-2">Save</button>
        </form>
    </div>
@endsection