<nav class="navbar navbar-expand-md navbar-light bg-dark bg-gradient text-white shadow sticky-top">
    <div class="container">
        <a class="navbar-brand text-light" href="{{ url('/') }}">
            <img src="{{asset('resources/invite-card-logo.png')}}" width="28" height="36" alt="">
            {{ config('app.name', 'Laravel') }}
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav me-auto">
                @guest

                @else
                    <li class="nav-item">
                        <a href="/home" class="nav-link text-light d-md-none">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a href="/event" class="nav-link text-light d-md-none">Event</a>
                    </li>
                    <li class="nav-item">
                        <a href="/event/create" class="nav-link text-light d-md-none">Create Event</a>
                    </li>
                    <li class="nav-item">
                        <a href="/card-template" class="nav-link text-light d-md-none">Card Template</a>
                    </li>
                @endguest
                
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ms-auto">
                <!-- Authentication Links -->
                @guest
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link text-light" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                    @endif

                    @if (Route::has('register'))
                        {{-- <li class="nav-item">
                            <a class="nav-link text-light" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li> --}}
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle text-light" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>