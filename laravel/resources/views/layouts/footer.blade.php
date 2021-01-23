        <footer class="container border border-dark rounded-lg mt-2 mb-lg-5 flex">
            <div class="row mb-5 mr-2 p-lg-5 flex">
                <div class="col-3">
                    <a href="http://www.bcfed.com/" title="BC Federation of Labour" target="_blank">
                        <img src="/storage/public/w8x7LmSqnTLjEHyftPbYRh3JFmBNh1GOVgjvGX6z.png"
                             alt="BC Federation of Labor" class="p-1 flex-fill img-fluid" />
                    </a>
                </div>
                <div class="col-3">
                    <a href="http://www.iatse-intl.org/" title="IATSE International" target="_blank">
                        <img src="/storage/public/E9psVVljWX9afHmiwfyeTCuXEU6WnKHUIoevll6Y.jpeg"
                             alt="IATSE International" class="p-1 img-fluid" />
                    </a>
                </div>
                <div class="col-3">
                    <a href="https://canadianlabour.ca/" title="Canadian labour Congress" target="_blank">
                        <img src="/storage/public/KKVqVfiv4hU4ayxNukvYJsN5EKgIqnYfx5mssuT7.png"
                             alt="Canadian Labour Congress" class="p-1  flex-fill img-fluid" />
                    </a>
                </div>
                <div class="col-3">
                    <a href="http://www.vdlc.ca/" title="Vancouver & District Labour Congress" target="_blank">
                        <img src="/storage/public/mlL21yHivsR7ztxYh3hRB2Y8j9rcFzY5BfXtSLE1.jpeg"
                             alt="Vancouver & District Labour Congress" class="p-1  flex-fill img-fluid" />
                    </a>
                </div>
            </div>


            @guest
                <div class="row mb-3">
                    <div class="col-12">
                        <a href="/login">
                            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Login</button>
                        </a>
                    </div>
                </div>
                @else
                    <div class="row">
                        <div class="col-6">
                            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button class="btn btn-outline-success my-2 my-sm-0 float-left" type="submit">
                                    Logout
                                </button>
                            </form>
                        </div>
                        <div class="col-6">
                            <form class="form-inline my-2 my-lg-0" action="{{route('search')}}" method="post">
                                {!! csrf_field() !!}
                                <i class="fas fa-search"></i> &nbsp;
                                <input class="form-control mr-sm-2" type="text" placeholder="Search"
                                       aria-label="Search" name="search">
                                <button type="submit" name="Submit" value="Submit"
                                        class="btn btn-outline-success my-2 my-sm-0">
                                    Search
                                </button>
                            </form>
                        </div>
                    </div>
            @endguest



            <div class="row flex">
                <div class="col-6 flex-col">
                    <h5>
                        <i class="fas fa-hashtag"></i>
                        To Read
                    </h5>
                <ul class="list-group list-group">
                    <li class="list-group-item"><a href="{{route('page_show', 'terms-of-use')}}">Terms of Use</a></li>
                    <li class="list-group-item"><a href="{{route('page_show', 'privacy-policy')}}">Privacy Policy</a></li>
                    <li class="list-group-item"><a href="{{route('page_show', 'disclaimer')}}">Disclaimer</a></li>
                    <li class="list-group-item"><a href="{{route('page_show', 'links')}}">Links</a></li>
                    <li class="list-group-item"><a href="{{route('page_show', 'apply-for-work')}}">Apply for work</a></li>
                    @guest
                    @else
                        @role('super-admin')
                            <li class="list-group-item">
                                <a href="{{route('admin')}}" title="Admin">
                                    <i class="fas fa-tachometer-alt"></i>
                                </a>
                            </li>
                        @endrole
                    @endguest
                </ul>
                </div>
                <div class="col-6 flex-col">
                    <h5>
                        <i class="fas fa-hashtag"></i>
                        Social Media
                    </h5>
                    <ul class="list-group list-group-flush flex">
                        <li class="list-group-item p-0 m-0">
                            <a class="list-group-item" href="https://twitter.com/IATSE_118" target="_blank"
                               title="IATSE Local 118">
                                <i class="fab fa-twitter"></i>
                                @IATSE_118
                            </a>
                        </li>
                        <li class="list-group-item p-0 m-0">
                            <a class="list-group-item" href="https://twitter.com/IATSECANADA" target="_blank"
                               title="IATSE Canada">
                                <i class="fab fa-twitter"></i>
                                @IATSECANADA
                            </a>
                        </li>
                        <li class="list-group-item p-0 m-0">
                            <a class="list-group-item" href="https://twitter.com/IATSEYWC" target="_blank"
                               title="IATSE Young Workers">
                                <i class="fab fa-twitter"></i>
                                @IATSEYWC
                            </a>
                        </li>
                        <li class="list-group-item p-0 m-0">
                            <a class="list-group-item" href="https://twitter.com/IATSE" target="_blank" title="IATSE">
                                <i class="fab fa-twitter"></i>
                                @IATSE
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="row mt-lg-5 mb-lg-5">
                <div class="col-4 text-left">
                    <i class="far fa-copyright"></i> <?php echo date('Y'); ?> {{ config('app.name')}}
                </div>
                <div class="col-4 text-left">
                    <h6>Site by IATSE 118 Members</h6>
                </div>
                <div class="col-4 text-right">
                    <a href="#top" title="Top of page">
                        <i class="fas fa-angle-up"></i>
                        Top of page
                    </a>
                </div>
            </div>

        </footer>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css"
              integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf"
              crossorigin="anonymous">
        <script src="/js/jquery-3.4.1.slim.min.js"
                integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
                crossorigin="anonymous">
        </script>
        <script>window.jQuery || document.write('<script src="/js/jquery.slim.min.js"><\/script>')</script>
        <script src="/js/bootstrap.bundle.min.js"
                integrity="sha384-6khuMg9gaYr5AxOqhkVIODVIvm9ynTT5J4V1cfthmT+emCG6yVmEZsRHdxlotUnm"
                crossorigin="anonymous">
        </script>
