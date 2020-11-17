        <footer class="container border border-dark rounded-lg mb-lg-5">
            <div class="row mb-5">
                <div class="col-3">
                    <a href="http://www.bcfed.com/" title="BC Federation of Labour" target="_blank">
                        <img src="/storage/public/w8x7LmSqnTLjEHyftPbYRh3JFmBNh1GOVgjvGX6z.png"
                             alt="BC Federation of Labor" class="p-1" />
                    </a>
                </div>
                <div class="col-3">
                    <a href="http://www.iatse-intl.org/" title="IATSE International" target="_blank">
                        <img src="/storage/public/E9psVVljWX9afHmiwfyeTCuXEU6WnKHUIoevll6Y.jpeg"
                             alt="IATSE International" class="p-1" />
                    </a>
                </div>
                <div class="col-3">
                    <a href="https://canadianlabour.ca/" title="Canadian labour Congress" target="_blank">
                        <img src="/storage/public/KKVqVfiv4hU4ayxNukvYJsN5EKgIqnYfx5mssuT7.png"
                             alt="Canadian Labour Congress" class="p-1" />
                    </a>
                </div>
                <div class="col-3">
                    <a href="http://www.vdlc.ca/" title="Vancouver & District Labour Congress" target="_blank">
                        <img src="/storage/public/mlL21yHivsR7ztxYh3hRB2Y8j9rcFzY5BfXtSLE1.jpeg"
                             alt="Vancouver & District Labour Congress" class="p-1" />
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-12 mb-4">
                    <a href="/page/terms-of-use">Terms of Use</a> |
                    <a href="/page/privacy-policy">Privacy Policy</a> |
                    <a href="/page/disclaimer">Disclaimer</a> |
                    <a href="/page/links">Links</a> |
                    <a href="/page/apply-for-work">Apply for work</a>
                    @guest
                    @else
                        @role('super-admin')
                            | <a href="{{route('admin')}}" title="Admin">
                                <i class="fas fa-tachometer-alt"></i>
                            </a>
                        @endrole
                    @endguest
                </div>
            </div>
                @guest
                <div class="row">
                    <div class="col-12 mb-4">
                        <a href="/login">
                            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Login</button>
                        </a>
                    </div>
                </div>
                @else
                <div class="row">
                    <div class="col-6 mb-4">
                        <form id="logout-form" action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="btn btn-outline-success my-2 my-sm-0 float-left" type="submit">
                                Logout
                            </button>
                        </form>
                    </div>
                    <div class="col-6 mb-5">
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
            </div>
            <div class="row mb-6">
                <div class="col-4">
                    <h2>IATSE Local 118</h2>
                    <h4>#206 - 2940 Main Street<br />
                    Vancouver, BC, V5T 3G3</h4>
                </div>
                <div class="col-4">
                    <h3>
                        <a href="https://goo.gl/maps/pXb7Bv8n1jHGykjh8" target="_blank" title="IATSE Local 118 Office">
                            <i class="fas fa-map-marked-alt"></i> Maps
                        </a>
                    </h3>
                    <h3>
                        <a href="tel:604-685-9553">
                            <i class="fas fa-phone-square"></i> 604-685-9553
                        </a>
                    </h3>
                    <h3>
                        <a href="mailto:office@iatse118.com">
                            <i class="fas fa-envelope"></i> office@iatse118.com
                        </a>
                    </h3>
                </div>
                <div class="col-4">
                    <h5>
                        <i class="fas fa-hashtag"></i>
                        Social Media
                    </h5>
                    <ul class="list-group p-0 m-0">
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
            <div class="row mt-2 mb-lg-2">
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
