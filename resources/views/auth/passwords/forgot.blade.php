@extends('layouts.auth_app')

@section('content')
@section('title', 'Forgot Password')

    <div class="container">
        <h2>Forgot Password</h2>
        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif
        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="col-6">
                <div class="form-group">
                    <label for="email">Enter Your Email:</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
            </div>

            <div class="">
                <button type="submit" class="btn btn-md bg-gradient-info ">
                    <span class="btn-text">Send Password Reset Link</span>
                </button>
            </div>
        </form>
    </div>
@endsection