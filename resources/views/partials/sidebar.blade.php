<div class="sidebar">  
    <div class="card bg-dark-subtle">
        {{-- <div class="card-header">
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><span class="fa fa-globe fa-xl me-2"></span> My Companies</a>
                </li>
            </ul>
        </div> --}}

        
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

                <li class="list-group-item list-group-item-action list-group-item-secondary p-2">
                    <a href="/card-template" class="nav-link p-1"><span class="fa fa-table-columns pe-2"></span>Card Template</a>
                </li>
                
                {{-- <li class="list-group-item list-group-item-action list-group-item-secondary p-2">
                    <a href="/sales/create" class="nav-link p-1"><span class="fa fa-dollar-sign pe-2"></span>Input Sales</a>
                </li>

                <li class="list-group-item list-group-item-action list-group-item-secondary p-2">
                    <a href="/monthly-analysis" class="nav-link p-1"><span class="fa fa-line-chart pe-2"></span>Monthly Analysis</a>
                </li> --}}

                <li class="list-group-item list-group-item-action list-group-item-secondary p-2">
                    <a href="/profile" class="nav-link p-1"><span class="fa fa-user pe-2"></span>Profile</a>
                </li>
                
                <li class="list-group-item list-group-item-action list-group-item-secondary p-2">
                    <a href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();" class="nav-link p-1"><span class="fa fa-sign-out pe-2"></span>Logout</a>
                </li>
            </ul>
    </div>
</div>