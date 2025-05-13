<div class="sidebar">  
    <div class="card bg-dark-subtle">
        <ul class="list-group">
            <li class="list-group-item list-group-item-action list-group-item-secondary p-2">
                <a href="/home" class="nav-link p-1"><i class="fa fa-dashboard pe-2"></i>Dashboard</a>
            </li>

            <li class="list-group-item list-group-item-action list-group-item-secondary p-2">
                <a href="/event" class="nav-link p-1"><span class="fa fa-table-list pe-2"></span>Events</a>
            </li>

            <li class="list-group-item list-group-item-action list-group-item-secondary p-2">
                <a href="/event/create" class="nav-link p-1"><span class="fa fa-shopping-cart pe-2"></span>Create Event</a>
            </li>

            {{-- Everyone can see available card templates --}}
            <li class="list-group-item list-group-item-action list-group-item-secondary p-2">
                <a href="{{ route('templates.index') }}" class="nav-link p-1"><span class="fa fa-table-columns pe-2"></span>Card Templates</a>
            </li>

            {{-- Only admin can manage templates --}}
            @if(Auth::check() && Auth::user()->role === 'admin')
                <li class="list-group-item list-group-item-action list-group-item-secondary p-2 ps-4">
                    <a href="{{ route('templates.create') }}" class="nav-link p-1"><span class="fa fa-plus-circle pe-2"></span>Create Template</a>
                </li>
            @endif

            {{-- Only admin can manage customers --}}
            @if(Auth::check() && Auth::user()->role === 'admin')
                <li class="list-group-item list-group-item-action list-group-item-secondary p-2">
                    <a href="/customers" class="nav-link p-1"><span class="fa fa-users pe-2"></span>Manage Customers</a>
                </li>
            @endif

            <li class="list-group-item list-group-item-action list-group-item-secondary p-2">
                <a href="/calendar" class="nav-link p-1"><span class="fa fa-calendar pe-2"></span>Calendar</a>
            </li>

            <li class="list-group-item list-group-item-action list-group-item-secondary p-2">
                <a href="/profile" class="nav-link p-1"><span class="fa fa-user pe-2"></span>Profile</a>
            </li>
            
            <li class="list-group-item list-group-item-action list-group-item-secondary p-2">
                <a href="{{ route('logout') }}"
                onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();" class="nav-link p-1">
                    <span class="fa fa-sign-out pe-2"></span>Logout
                </a>
            </li>
        </ul>
    </div>
</div>
