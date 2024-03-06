<nav class="navbar navbar-expand-md fixed-top bg-dark">
    <div class="container-fluid">
    <a href="{{ route('hello') }}" title="{{config('app.name')}}" class="navbar-brand">
        <img src="/storage/public/wrITw0NW1mBky0LidKwgBwtOg9mLcUuDCmQDuiPk.png"
             alt="{{config('app.name')}}"
             class="rounded mx-2"/>
    </a>
    <button class="p-2 mx-2 navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExampleDefault"
            aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">Menus
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse ml-2" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto mb-0 d-flex align-items-center">
            <li class="nav-item mr-2 d-flex align-items-stretch d-block d-md-none">
                <a class="nav-link" href="{{route('landing_page')}}" title="Landing Page">
                    <i class="fas fa-home fa-2"></i>
                    Landing Page
                </a>&nbsp;
                @hasanyrole(['super-admin|office|writer|committee'])
                &nbsp; <a class="nav-link ml-sm-3" href="{{route('admin')}}" title="Admin">
                        <i class="fas fa-tachometer-alt"></i> Admin
                    </a>
                @endrole
            </li>
        </ul>
            <div class="btn-group mx-1 mb-1" role="group">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2"
                        data-bs-toggle="dropdown" aria-expanded="false">
                    About Us
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{route('faqs_list_public')}}" title="Faqs">FAQs</a></li>
                    <li><a class="dropdown-item" href="{{route('page_show', 'history')}}" title="History">History</a></li>
                    <li><a class="dropdown-item" href="{{route('executive')}}" title="Executive">Executive</a></li>
                    <li><a class="dropdown-item" href="{{route('bylaws_list_public')}}" title="Constitution & Bylaws">Constitution & Bylaws</a></li>
                    <li><a class="dropdown-item" href="{{route('page_show', 'links')}}" title="Links">Links</a></li>
                </ul>
            </div>
            <div class="btn-group mx-1 mb-1" role="group">
                <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    Membership
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{route('page_show', 'apply-for-overhire-work')}}"
                           title="Apply for Overhire Work">Apply for Overhire Work</a></li>
                    <li><a class="dropdown-item" href="{{route('page_show', 'requirements-for-membership')}}"
                           title="Apply for Membership">Apply for Membership</a></li>
                    <li><a class="dropdown-item" href="{{route('page_show', 'skills-verification-procedure')}}"
                           title="Skills Update Procedure">Skills Update Procedure</a></li>
                    @auth
                    <li><a class="dropdown-item" href="{{route('page_show', 'union-dues-members')}}"
                           title="Union Dues">Union Dues for Members</a></li>
                    @else
                    <li><a class="dropdown-item" href="{{route('page_show', 'leaving-membership')}}"
                           title="Leaving Membership">Leaving Membership</a></li>
                    @endauth
                    <li><a class="dropdown-item" title="Request Representation"
                           href="{{route('page_show', 'request-representation')}}">Request Representation</a></li>
                    <li><a class="dropdown-item" title="In Memoriam" href="{{route('memoriam_list')}}">In Memoriam</a></li>
                </ul>
            </div>
        @auth
            <div class="btn-group mx-1 mb-1" role="group">
                <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    Benefits
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{route('topic_show', 'health-and-welfare')}}"
                           title="Health & Welfare Overview">H & W Overview</a></li>
                    <li><a class="dropdown-item font-weight-bolder"
                             href="https://service.pac.bluecross.ca/member/login/" target="_blank">
                            Pacific Blue Cross</a></li>
                    <li><a class="dropdown-item font-weight-bolder"
                           href="https://www.ceirp.ca/en/" title="CEIRP" target="_blank">
                            CEIRP</a></li>
                </ul>
            </div>
        @endauth
        <div class="btn-group mx-1 mb-1" role="group">
            <button class="btn btn-secondary dropdown-toggle " type="button" id="dropdownMenu2"
                    data-bs-toggle="dropdown" aria-expanded="false">
                Employers & Venues
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{route('organizations')}}" title="Organizations">
                        <i class="fas fa-user-tie"></i>
                        Organizations</a></li>
                <li><a class="dropdown-item" href="{{route('page_show', 'history')}}" title="History">History</a></li>
                <li><a class="dropdown-item" href="{{route('venues')}}" title="Venues">
                        <i class="far fa-building"></i>
                        Venues</a></li>
                <li><a class="dropdown-item" href="{{route('agreements_list_public')}}" title="Collective Agreements">
                        <i class="far fa-handshake"></i>
                        Collective Agreements</a></li>
                <li><a class="dropdown-item" href=" /topic/contract-ratifications" title="Contract Ratifications">
                        <i class="far fa-handshake"></i>
                        Contract Ratifications</a></li>
            </ul>
        </div>
        @guest
        @else
            <div class="btn-group mx-1 mb-1 mt-md-0" role="group">
                <button class="btn btn-secondary dropdown-toggle " type="button" id="dropdownMenu2"
                        data-bs-toggle="dropdown" aria-expanded="false">
                    Members
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{route('list_meetings')}}" title="Meeting Minutes">
                            <i class="far fa-folder"></i>
                            Meeting Minutes</a></li>
                    <li><a class="dropdown-item" href="{{route('topic_show','Financial')}}" title="Financial">
                            <i class="far fa-folder"></i> Financial</a></li>
                    <li><a class="dropdown-item" href="{{route('committees')}}" title="Committees">
                            <i class="fas fa-users"></i>
                            Committees</a></li>
                    <li><a class="dropdown-item" href="{{route('topic_show','elections')}}" title="Elections">
                            <i class="fas fa-users"></i> Elections</a></li>
                    <li><a class="dropdown-item" href="{{route('jobs_list')}}" title="Job Postings">
                            <i class="fas fa-hard-hat"></i>
                            Job Postings</a></li>
                    <li><a class="dropdown-item" href="{{route('page_show','apply-for-sister-local-status')}}"
                           title="Job Postings">
                            <i class="fas fa-hard-hat"></i>
                            Apply for Sister Local Status</a></li>
                    <li>
			   <a class="dropdown-item" href="/page/master-call-list"
                           title="Master Call List">
                            <i class="fas fa-user-friends"></i> Master Call List</a>
	            </li>
                    <li><a class="dropdown-item" href="{{route('members')}}" title="Member list">
                            <i class="fas fa-user-friends"></i> Member List</a></li>
                    <li><a class="dropdown-item" href="{{route('bylaws_list_public')}}" title="Constitution & Bylaws">
                            <i class="fas fa-gavel"></i> Constitution & By-Laws</a></li>
                    <li><a class="dropdown-item" href="{{route('policies_list_public')}}" title="Policies">
                            <i class="fas fa-scroll"></i>  Policies</a></li>
                </ul>
            </div>
        @endguest
        <div class="btn-group mx-1 mb-1" role="group">
            <button class="btn btn-secondary dropdown-toggle " type="button" id="dropdownMenu2"
                    data-bs-toggle="dropdown" aria-expanded="false">
                Contact Us
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{route('contact')}}" title="Contact Us">Contact Us</a></li>
                <li><a class="dropdown-item" href="{{route('page_show','payroll-trust-account')}}"
                       title="Payroll">Payroll</a></li>
            </ul>
        </div>
        @auth
            <li class="nav-item mx-1 d-flex">
                <a class="nav-link d-none d-md-block" href="{{route('landing_page')}}" title="Landing Page">
                     <span style="color: white">
                        <i class="fas fa-home fa-lg"></i>
                     </span>
                </a>
            </li>
            <form class="d-flex mx-1 mb-1 mt-sm-3 mt-md-2" role="search" action="{{route('search')}}" method="POST">
                {!! csrf_field() !!}
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search"
                       name="search" size="30" required>
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
            <li class="d-flex d-sm-block d-md-none mx-1 mb-1">
                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="btn btn-outline-success mx-3  my-sm-0" type="submit">
                        Logout
                    </button>
                </form>
            </li>
        @endauth
            @guest
                <li class="nav-item d-sm-block">
                    <a class="btn btn-outline-success my-2 my-sm-0 d-md-none" href="/login">
                        Login
                    </a>
                </li>
            @endguest
        </ul>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <!-- Right Side Of Navbar -->
                <ul class="navbar-nav d-flex align-items-right">
                <!-- Authentication Links -->
                @guest
                        <a class="nav-link" href="/login">
                            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Login</button>
                        </a>
                @else
                    <form class="d-flex mx-1 mb-1 mt-5 mt-md-2" id="logout-form" action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="btn btn-outline-success float-right" type="submit">
                            Logout
                        </button>
                    </form>
                @endguest
            </ul>
        </div>
    </div>
    </div>
</nav>
