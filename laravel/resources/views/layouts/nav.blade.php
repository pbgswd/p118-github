<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark d-flex align-items-center pt-2">
    <a href="{{ route('hello') }}" title="{{config('app.name')}}">
        <img src="/storage/public/wrITw0NW1mBky0LidKwgBwtOg9mLcUuDCmQDuiPk.png"
             alt="{{config('app.name')}}"
             class="rounded" />
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault"
            aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">Menus
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse ml-2" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto mb-0 d-flex align-items-center">
            <li class="nav-item mt-2 mr-2 d-flex align-items-stretch d-block d-md-none">
                <a class="nav-link" href="{{route('landing_page')}}" title="Landing Page">
                    <i class="fas fa-industry fa-2"></i>
                    Landing Page
                </a>
            </li>
            <div class="dropdown mr-1 mt-2 mt-md-0">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    About Us
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                    <a class="dropdown-item" href="{{route('page_show', 'history')}}" title="History">
                        History
                    </a>
                    <a class="dropdown-item" href="{{route('executive')}}" title="Executive">Executive</a>
                    <a class="dropdown-item" href="{{route('bylaws_list_public')}}" title="Constitution & Bylaws">
                        Constitution & Bylaws
                    </a>
                    <a class="dropdown-item" href="{{route('page_show', 'links')}}" title="Links">Links</a>
                </div>
            </div>
            <div class="dropdown mr-1 mt-2 mt-md-0">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Membership
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdown">
                    <a class="dropdown-item" href="{{route('page_show', 'apply-for-overhire-work')}}"
                       title="Apply for Overhire Work">Apply for Overhire Work</a>
                    <a class="dropdown-item" href="{{route('page_show', 'requirements-for-membership')}}"
                       title="Apply for Membership">Apply for Membership</a>
                    <a class="dropdown-item" href="{{route('page_show', 'skills-verification-procedure')}}"
                        title="Skills Update Procedure">
                        Skills Update Procedure
                    </a>
                    <a class="dropdown-item" href="{{route('page_show', 'availability-and-dispatch')}}"
                        title="Availability & Dispatch">
                        Availability & Dispatch
                    </a>
                    <a class="dropdown-item" href="{{route('page_show', 'apply-for-sister-local-status')}}"
                       title="Union Dues">Apply for Sister Local Status</a>
                    @auth
                        <a class="dropdown-item" href="{{route('page_show', 'union-dues-members')}}"
                           title="Union Dues">Union Dues for Members</a>
                    @else
                        <a class="dropdown-item" href="{{route('page_show', 'union-dues-overview')}}"
                           title="Union Dues">Union Dues Overview</a>
                    @endauth
                    <a class="dropdown-item" href="{{route('page_show', 'leaving-membership')}}"
                        title="Leaving Membership">Leaving Membership</a>
                    <a class="dropdown-item" title="Request Representation"
                        href="{{route('page_show', 'request-representation')}}">
                        Request Representation
                    </a>
                    <a class="dropdown-item" title="In Memoriam" href="{{route('memoriam_list')}}">
                        In Memoriam
                    </a>
                </div>
            </div>
            @auth
                <div class="dropdown mr-1 mt-2 mt-md-0">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Benefits
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdown">
                        <a class="dropdown-item" href="{{route('topic_show', 'health-and-welfare')}}"
                           title="Health & Welfare Overview">H & W Overview</a>
                        <a class="dropdown-item font-weight-bolder"
                           href="https://service.pac.bluecross.ca/member/login/" target="_blank">
                            Pacific Blue Cross
                        </a>
                    </div>
                </div>
            @endauth
            <div class="dropdown mr-1 mt-2 mt-md-0">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Employers & Venues
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdown">
                    <a class="dropdown-item" href="{{route('organizations')}}" title="Organizations">
                        <i class="fas fa-user-tie"></i>
                        Organizations</a>
                    <a class="dropdown-item" href="{{route('venues')}}" title="Venues">
                        <i class="far fa-building"></i>
                        Venues</a>
                    <a class="dropdown-item" href="{{route('agreements_list_public')}}" title="Collective Agreements">
                        <i class="far fa-handshake"></i>
                        Collective Agreements</a>
                </div>
            </div>
            <div class="dropdown mr-1 mt-2 mt-md-0">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Contact Us
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdown">
                    <a class="dropdown-item" href="{{route('hire-us')}}" title="Why Hire Union">Why Hire Union</a>
                    <a class="dropdown-item" href="{{route('contact')}}" title="Contact Us">Contact Us</a>
                    <a class="dropdown-item" href="{{route('page_show','payroll-trust-account')}}"
                        title="Payroll">Payroll</a>
                </div>
            </div>
            @guest
            @else
                <div class="dropdown mr-1 mt-2 mt-md-0">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Members
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdown">
                        @hasanyrole(['super-admin|office|writer|committee'])
                        <a class="dropdown-item" href="{{route('admin')}}" title="Admin">
                            <i class="fas fa-tachometer-alt"></i> Admin
                        </a>
                        @endrole
                        <a class="dropdown-item" href="/site" title="Landing Page">
                            <i class="fas fa-industry"></i>
                            Landing Page</a>
                        <a class="dropdown-item" href="{{route('list_meetings')}}" title="Meeting Minutes">
                            <i class="far fa-folder"></i>
                            Meeting Minutes</a>
                        <a class="dropdown-item" href="{{route('topic_show','Financial')}}" title="Financial">
                            <i class="far fa-folder"></i> Financial</a>
                        <a class="dropdown-item" href="{{route('committees')}}" title="Committees">
                            <i class="fas fa-users"></i>
                            Committees</a>
                        <a class="dropdown-item" href="{{route('topic_show','elections')}}" title="Elections">
                            <i class="fas fa-users"></i> Elections</a>
                        <a class="dropdown-item" href="{{route('jobs_list')}}" title="Job Postings">
                            <i class="fas fa-hard-hat"></i>
                            Job Postings</a>
                        <a class="dropdown-item" href="{{route('page_show','apply-for-sister-local-status')}}"
                           title="Job Postings">
                            <i class="fas fa-hard-hat"></i>
                            Apply for Sister Local Status</a>
                        <a class="dropdown-item" href="https://login.callsteward.ca/" target="_blank"
                           title="Link to CallSteward">
                            <i class="fas fa-headset"></i>
                            Call Steward <i class="fas fa-headset"></i>
                        </a>
                        <a class="dropdown-item" href="{{route('member', Auth::user()->id)}}"
                           title="My Profile">
                            <i class="fas fa-user"></i> {{ Auth::user()->name }}</a>
                        <a class="dropdown-item" href="{{route('members')}}" title="Member list">
                            <i class="fas fa-user-friends"></i> Member List</a>
                        <a class="dropdown-item" href="{{route('bylaws_list_public')}}" title="Constitution & Bylaws">
                            <i class="fas fa-gavel"></i> Constitution & By-Laws</a>
                        <a class="dropdown-item" href="{{route('policies_list_public')}}" title="Policies">
                            <i class="fas fa-scroll"></i>  Policies</a>
                    </div>
                </div>
            @endguest
            @auth
                <li class="nav-item mt-2 mr-2 d-flex align-items-stretch justify-content-center text-center">
                    <a class="nav-link d-none d-md-block" href="{{route('landing_page')}}" title="Landing Page">
                        <i class="fas fa-industry fa-lg"></i>
                    </a>
                </li>
                <li class="nav-item mt-2 d-block d-md-none d-lg-block">
                    <form class="form-inline" action="{{route('search')}}" method="POST">
                        {!! csrf_field() !!}
                            <div class="input-group input-group-sm mr-1">
                                <div class="input-group-prepend">
                            <span class="input-group-text d-none d-md-block" id="basic-addon1">
                                <i class="fas fa-search"></i>
                            </span>
                                </div>
                                <input class="form-control" type="text" placeholder="Search"
                                       aria-label="Search" name="search" size="30" required>
                            </div>
                            <button type="submit" name="Submit" value="Submit"
                                    class="btn btn-sm btn-success mt-2 mt-md-0">
                                Search
                            </button>
                    </form>
                </li>
                <li class="nav-item d-sm-block d-md-none">
                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">
                            Logout
                        </button>
                    </form>
                </li>
            @endauth
            @guest
                <li class="nav-item d-sm-block d-md-none">
                    <a href="/login">
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Login</button>
                    </a>
                </li>
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
