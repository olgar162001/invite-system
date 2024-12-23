@extends('layouts.auth_app')

@section('content')

<div class="container my-4">
    <div class="row align-items-center justify-content-center">
        <div class="col-md-6">
            <div class="card py-4 shadow">
                {{-- <img src="{{asset('assets/images/img2.png')}}" class="card-img-top mx-auto " style="width: 30%; height: 100%;" alt=""> --}}
                <div class="text-center p-3"><h1>{{ __('Login') }}</h1></div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="email" class="col-md-3 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-8 form-group">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ 'Wrong Email or Password' }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-3 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-8">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>   
                                </div>
                            </div>
                        </div>

                        <div class="row mb-1">
                            <div class="col-md-8 offset-md-3">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-dark bg-gradient form-control">
                                        {{ __('Login') }}
                                    </button>
                                </div> 

                                @if (Route::has('password.request'))
                                <div class="mt-1">
                                    <a class="btn link-dark btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif

                                    {{-- <a href="/register" class="link-body-emphasis mx-3">Register here</a> --}}
                                </div>    
                            </div>    
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
