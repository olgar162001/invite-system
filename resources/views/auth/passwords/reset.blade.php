@extends('layouts.auth_app')

@section('content')
@Section('title', 'Reset Password')

    <div class="container d-flex justify-content-center align-items-center flex-column" style="height: 90vh;">
        <div class="card p-5 w-50 mt-4">
            <h2 class="text-center">Reset Password</h2>

            <div class="col-12 col-md-12 col-sm-12">
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="form-group">
                        <label for="email">Email Address:</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="password">New Password:</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Confirm Password:</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>

                    <button type="submit" class="btn form-control btn-success mt-3">Reset Password</button>
                </form>
            </div>
        </div>
    </div>
@endsection