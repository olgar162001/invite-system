@extends('layouts.auth_app')

@section('content')
@section('title', 'Forgot Password')

    <div class="container d-flex justify-content-center align-items-center flex-column" style="height: 90vh;">
        <div class="card p-5 w-50">
            <h2 class="text-center py-2">Forgot Password</h2>
            @if (session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif
            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="col-md-12 col-sm-12">
                    <div class="form-group">
                        <label for="email">Enter Your Email:</label>
                        <input type="email" name="email" class="form-control" placeholder="example@mail.com" required>
                    </div>
                </div>

                <div class="py-3">
                    <button type="submit" class="btn btn-md form-control bg-gradient-info ">
                        <span class="btn-text">Send Password Reset Link</span>
                    </button>

                    <p class="mb-4 text-sm mx-auto">
                        <a href="{{ route('login') }}" class="text-dark font-weight-bold"> <i class="fa fa-arrow-left"></i> Back to Login</a>
                    </p>
                </div>
            </form>
        </div>
    </div>
@endsection