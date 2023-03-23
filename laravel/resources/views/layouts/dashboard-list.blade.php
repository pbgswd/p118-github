
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('hello') }}">
                    <span data-feather="home"></span>
                    <i class="fas fa-home"></i>
                    Home Page
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('landing_page') }}">
                    <i class="fas fa-industry"></i>
                    Landing Page
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin') }}">
                    <span data-feather="home"></span>
                    <i class="fas fa-tachometer-alt"></i>
                    Admin Dashboard <span class="sr-only">(current)</span>
                </a>
            </li>
                @can('create articles')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('meetings_list') }}">
                        <span data-feather="file"></span>
                        Meeting Minutes
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin_bylaws_list') }}">
                        <span data-feather="file"></span>
                        Constitution & By-Laws
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('agreements_list') }}">
                        <span data-feather="file"></span>
                        Collective Agreements
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('policies_list') }}">
                        <span data-feather="file"></span>
                        Policies
                    </a>
                </li>
            @endcan
            @can('manage committee')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('committees_list') }}">
                        <span data-feather="file"></span>
                        Committees
                    </a>
                </li>
            @endcan
            @can(['create users', 'edit users', 'delete users'])
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <span data-feather="file"></span>
                        <h5>Membership</h5>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin_executives_list') }}">
                        <span data-feather="file"></span>
                        Executives
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('users_list') }}">
                        <span data-feather="file"></span>
                        Members List
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin_list_invited_users') }}">
                        <span data-feather="file"></span>
                        Invite Members
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin_memoriam_list') }}">
                        <span data-feather="file"></span>
                        In Memoriam
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('roles_list') }}">
                        <span data-feather="file"></span>
                        Website Roles
                    </a>
                </li>
            @endcan
            @can(['create articles'])
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <span data-feather="file"></span>
                        <h5 class="font-weight-bold">Content </h5>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin_proofreader')}}">
                    ProofReader
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('topics_list') }}">
                        <span data-feather="file"></span>
                        Topics
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin_features_list') }}">
                        <span data-feather="file"></span>
                        Features
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('pages_list') }}">
                        <span data-feather="file"></span>
                        Pages
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('posts_list') }}">
                        <span data-feather="file"></span>
                        Posts
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin_carousel_list') }}">
                        <span data-feather="file"></span>
                        Carousel Management
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('venues_list') }}">
                        <span data-feather="file"></span>
                        Venues
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('organizations_list') }}">
                        <span data-feather="file"></span>
                        Organizations
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin_employment_list') }}">
                        <span data-feather="file"></span>
                        Employment
                    </a>
                </li>
            @endcan
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('attachments_list') }}">
                        <span data-feather="file"></span>
                        Images & Attachments
                    </a>
                </li>

            @role('super-admin')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('blank') }}">
                        <span data-feather="file"></span>
                        Blank Page
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('developer') }}">
                        <span data-feather="file"></span>
                        Developer Resources
                    </a>
                </li>
            @endrole
        </ul>

