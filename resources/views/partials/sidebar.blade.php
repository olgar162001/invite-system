<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 "
    id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href="/">
            <img src="{{asset('/resources/logo.png')}}" width="150" class="navbar-brand-img h-100" alt="main_logo">
            <span class="ms-1 font-weight-bold"></span>
        </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link @if (Request::is('home'))
                    active
                @endif " href="/home">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-tachometer-alt text-black {{Request::is('home') ? 'text-white' : 'text-black' }}" href="/home"></i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Event</h6>
            </li>
            <li class="nav-item">
                <a class="nav-link @if (Request::is('event'))
                    active
                @endif " href="/event">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-calendar-alt text-black {{Request::is('event') ? 'text-white' : 'text-black' }}" href="/event"></i>
                    </div>
                    <span class="nav-link-text ms-1">Events</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link @if (Request::is('event/create'))
                    active
                @endif " href="/event/create">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-plus-circle text-black {{Request::is('event/create') ? 'text-white' : 'text-black' }}" href="/event/create"></i>
                    </div>
                    <span class="nav-link-text ms-1">Create Event</span>
                </a>
            </li>
            @if(Auth::check() && Auth::user()->role === 'admin')
                <li class="nav-item">
                    <a class="nav-link @if (Request::is('card-template'))
                        active
                    @endif " href="{{ route('templates.index') }}">
                        <div
                            class="icon icon-shape icon-sm shadow border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fas fa-id-card text-black {{Request::is('card-template') ? 'text-white' : 'text-black' }}" href="/card-template"></i>
                        </div>
                        <span class="nav-link-text ms-1">Card Templates</span>
                    </a>
                </li>
            @endif

            @if(Auth::check() && Auth::user()->role === 'admin')
                <li class="nav-item mt-3">
                    <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Customers</h6>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if (Request::is('customers'))
                        active
                    @endif " href="/customers">
                        <div
                            class="icon icon-shape icon-sm shadow border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fas fa-users text-black {{Request::is('customers') ? 'text-white' : 'text-black' }}" href="/customers"></i>
                        </div>
                        <span class="nav-link-text ms-1">Manage Customers</span>
                    </a>
                </li>
            @endif

            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">SMS</h6>
            </li>

            <li class="nav-item">
                <a class="nav-link @if (Request::is('admin/sms/assign'))
                    active
                @endif " href="{{route('sms.assign')}}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-paper-plane text-black {{Request::is('admin/sms/assign') ? 'text-white' : 'text-black' }}" href="/admin/sms/assign"></i>
                    </div>
                    <span class="nav-link-text ms-1">Assign SMS</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link @if (Request::is('admin/sms/balance'))
                    active
                @endif " href="{{route('sms.balance')}}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-balance-scale text-black {{Request::is('admin/sms/balance') ? 'text-white' : 'text-black' }}" href="/admin/sms/balance"></i>
                    </div>
                    <span class="nav-link-text ms-1">SMS Balance</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link @if (Request::is('admin/sms/settings'))
                    active
                @endif " href="{{route('sms.settings')}}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-cog text-black {{Request::is('admin/sms/settings') ? 'text-white' : 'text-black' }}" href="/admin/sms/settings"></i>
                    </div>
                    <span class="nav-link-text ms-1">SMS Settings</span>
                </a>
            </li>

            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Others</h6>
            </li>

            <li class="nav-item">
                <a class="nav-link @if (Request::is('calendar'))
                    active
                @endif " href="/calendar">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-calendar text-black {{Request::is('calendar') ? 'text-white' : 'text-black' }}" href="/calendar"></i>
                    </div>
                    <span class="nav-link-text ms-1">Calendar</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link @if (Request::is('to-do'))
                    active
                @endif " href="/to-do">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-calendar text-black {{Request::is('to-do') ? 'text-white' : 'text-black' }}" href="/to-do"></i>
                    </div>
                    <span class="nav-link-text ms-1">To-do List</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link @if (Request::is('profile'))
                    active
                @endif " href="/profile">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-user text-black {{Request::is('profile') ? 'text-white' : 'text-black' }}" href="/profile"></i>
                    </div>
                    <span class="nav-link-text ms-1">Profile</span>
                </a>
            </li>

            <li class="nav-item">
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>

                <a class="nav-link  " href="{{ route('logout') }}" onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-sign-out-alt text-black " href="{{ route('logout') }}"></i>
                    </div>
                    <span class="nav-link-text ms-1">Logout</span>
                </a>
            </li>
        </ul>
    </div>
    {{-- <div class="sidenav-footer mx-3 ">
        <div class="card card-background shadow-none card-background-mask-secondary" id="sidenavCard">
            <div class="full-background" style="background-image: url('../assets/img/curved-images/white-curved.jpg')">
            </div>
            <div class="card-body text-start p-3 w-100">
                <div
                    class="icon icon-shape icon-sm shadow text-center mb-3 d-flex align-items-center justify-content-center border-radius-md">
                    <i class="ni ni-diamond text-dark text-gradient text-lg top-0" aria-hidden="true"
                        id="sidenavCardIcon"></i>
                </div>
                <div class="docs-info">
                    <h6 class="text-white up mb-0">Need help?</h6>
                    <p class="text-xs font-weight-bold">Please contact us</p>
                    <a href="https://www.creative-tim.com/learning-lab/bootstrap/license/soft-ui-dashboard"
                        target="_blank" class="btn btn-white btn-sm w-100 mb-0">Documentation</a>
                </div>
            </div>
        </div>
        <a class="btn btn-primary mt-3 w-100"
            href="https://www.creative-tim.com/product/soft-ui-dashboard-pro?ref=sidebarfree">Upgrade to pro</a>
    </div> --}}
</aside>