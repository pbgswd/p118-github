<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
    <a class="" href="{{ route('hello') }}">
        <img src="/storage/public/wrITw0NW1mBky0LidKwgBwtOg9mLcUuDCmQDuiPk.png"
             alt="{{config('app.name')}}"
             title="{{config('app.name')}}"
             class="mr-1;" />
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault"
            aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">Menus
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse ml-2" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    About Us
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                    <a class="dropdown-item" href="{{route('page_show', 'history')}}" title="History">
                        History
                    </a>
                    <a class="dropdown-item" href="{{route('executive')}}">Executive</a>
                    <a class="dropdown-item" href="{{route('bylaws_list_public')}}">C & B</a>
                    <a class="dropdown-item" href="{{route('page_show', 'links')}}">Links</a>
                </div>
            </div>&nbsp;
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Membership
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdown">
                    <a class="dropdown-item" href="{{route('page_show', 'apply-for-work')}}"
                       title="Apply for Work">Apply</a>
                    <a class="dropdown-item" href="{{route('page_show', 'skills-verification-procedure')}}">
                        Skills Update Procedure
                    </a>
                    <a class="dropdown-item" href="#">Availability & Dispatch</a>
                    <a class="dropdown-item" href="#">Dues</a>
                    <a class="dropdown-item" href="#">Leaving Membership</a>
                </div>
            </div>&nbsp;
            @guest
            @else
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Benefits
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdown">
                        <a class="dropdown-item" href="{{route('topic_show', 'health-and-welfare-info')}}"
                           title="Health & Welfare Overview">H & W Overview</a>
                    </div>
                </div>&nbsp;
            @endguest
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Employers & Venues
                </button>&nbsp;
                <div class="dropdown-menu" aria-labelledby="dropdown">
                    <a class="dropdown-item" href="{{route('organizations')}}">
                        <i class="fas fa-user-tie"></i>
                        Organizations</a>
                    <a class="dropdown-item" href="{{route('venues')}}">
                        <i class="far fa-building"></i>
                        Venues</a>
                    <a class="dropdown-item" href="{{route('agreement_show', 38)}}" title="">
                        Master Rate Sheet</a>
                    <a class="dropdown-item" href="{{route('agreements_list_public')}}">
                        <i class="far fa-handshake"></i>
                        Agreements</a>
                </div>
            </div>
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Contact Us
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdown">
                    <a class="dropdown-item" href="{{route('hire-us')}}">Why Hire Union</a>
                    <a class="dropdown-item" href="{{route('contact')}}">Contact</a>
                </div>
            </div>
            @guest
            @else&nbsp;
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Members
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdown">
                        <a class="dropdown-item" href="{{route('list_meetings')}}">
                            <i class="far fa-folder"></i>
                            Meetings & Minutes</a>
                        <a class="dropdown-item" href="#"><i class="far fa-folder"></i> Budgets & Audits</a>
                        <a class="dropdown-item" href="{{route('committees')}}"><i class="fas fa-users"></i>
                            Committees</a>
                        <a class="dropdown-item" href="#"><i class="fas fa-users"></i> elections</a>
                        <a class="dropdown-item" href="{{route('jobs_list')}}"><i class="fas fa-hard-hat"></i>
                            Jobs</a>
                        <a class="dropdown-item" href="https://login.callsteward.ca/" target="_blank"
                           title="Link to CallSteward">
                            <i class="fas fa-headset"></i> CS</a>
                        <a class="dropdown-item" href="{{route('member', Auth::user()->id)}}"
                           title="My Profile">
                            <i class="fas fa-user"></i> {{ Auth::user()->name }}</a>
                        <a class="dropdown-item" href="{{route('members')}}">
                            <i class="fas fa-user-friends"></i> Members</a>
                        <a class="dropdown-item" href="{{route('bylaws_list_public')}}">
                            <i class="fas fa-gavel"></i> By-Laws</a>
                        <a class="dropdown-item" href="{{route('policies_list_public')}}">
                            <i class="fas fa-scroll"></i>  Policies</a>
                        <a class="dropdown-item" href="/site"><i class="fas fa-industry">
                            </i> Landing Page</a>
                    </div>
                </div>
            @endguest
            @guest
            @else
            <li class="nav-item">
                <a class="nav-link" href="/site"><i class="fas fa-industry"></i> Landing Page</a>
            </li>
                @role('super-admin')
                     <li class="nav-item">
                        <a class="nav-link" href="{{route('admin')}}" title="Admin">
                            <i class="fas fa-tachometer-alt"></i>
                        </a>
                    </li>
                @endrole
                @can('edit articles')
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin')}}" title="Admin">
                        <i class="fas fa fa-feather fa-w-16"></i>
                    </a>
                </li>
                @endcan
            @endguest
        </ul>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                    <li class="nav-item">
                        <a href="/login">
                            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Login</button>
                        </a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item float-right">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item">
                        <form id="logout-form" action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="btn btn-outline-success my-2 my-sm-0 float-right" type="submit">
                                Logout
                            </button>
                        </form>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
