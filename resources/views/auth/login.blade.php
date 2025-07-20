@extends('layouts.auth_app')

@section('content')
@section('title', 'Login')

  <div class="page-header min-vh-75">
    <div class="container">
    <div class="row d-flex align-items-center">
      <div class="col-xl-4 col-lg-5 col-md-6 d-flex flex-column mx-auto">
      <div class="card card-plain mt-8">
        <div class="card-header pb-0 text-left bg-transparent">
        <h3 class="font-weight-bolder text-info text-gradient">Welcome back</h3>
        <p class="mb-0">Enter your email and password Login</p>
        </div>
        <div class="card-body">
        <form method="POST" action="{{ route('login') }}">
          @csrf
          <label>Email</label>
          <div class="mb-3">
          <input type="email" aria-label="Email" aria-describedby="email-addon" id="email"
            class="form-control @error('email') is-invalid @enderror" placeholder="example@mail.com" name="email"
            value="{{ old('email') }}" required autocomplete="email" autofocus>
          </div>
          <label>Password</label>
          <div class="mb-3">
          <input type="password" class="form-control" placeholder="xxxxxxxx" aria-label="Password"
            aria-describedby="password-addon" name="password" required autocomplete="current-password">
          </div>

          <div class="form-check form-switch">
          <input class="form-check-input" type="checkbox" id="rememberMe" name="remember" id="remember" {{ old('remember')
    ? 'checked' : '' }}>
          <label class="form-check-label" for="rememberMe">Remember me</label>
          </div>
          <div class="text-center">

          <button type="submit" id="login-btn" class="btn btn-md bg-gradient-info w-100 mt-4 mb-0 fs-6">
            <span class="btn-text">Login</span>
            <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
          </button>

          </div>
        </form>
        </div>
        <div class="card-footer text-center pt-0 px-lg-2 px-1">
        <p class="mb-4 text-sm mx-auto">
          Forgot Password?
          <a href="{{ route('password.request') }}" class="text-info text-gradient font-weight-bold">Click Here</a>
        </p>
        </div>
      </div>
      </div>
      <div class="col-md-6 mt-5">
      <img src="{{asset('resources/NiaEvent-laptop.png')}}" alt="" style="padding-top: 6.2rem; margin-right: 3rem;"
        width="650">
      {{-- <div class="oblique position-absolute top-0 h-100 d-md-block d-none me-n8"> --}}

        {{-- </div> --}}
      </div>
    </div>
    </div>
  </div>
@endsection