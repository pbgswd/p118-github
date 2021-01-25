<footer class="container flex">
    <div class="col-12 border border-dark rounded-lg pl-md-5 pt-2 pb-2 mb-4">
        @guest
            <div class="col-12 p-lg-3 d-flex justify-content-center">
                <a href="/login">
                    <button class="btn btn-success my-2 my-sm-0" type="submit">Login</button>
                </a>
            </div>
        @else
            <div class="col-12 p-lg-3 d-flex justify-content-center">
                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="btn btn-success my-2 my-sm-0 float-left pl-2" type="submit">
                        Logout
                    </button>
                </form>
            </div>
            <div class="col-12 m-md-3 d-flex justify-content-center">
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
        @endguest
        <div class="row mt-sm-2 mt-md-5 p-0 d-flex justify-content-around">
            <div class="col-md-6 col-sm-12 mb-lg-3">
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
                </ul>
            </div>
            <div class="col-md-4 col-sm-6 mb-lg-3 mt-sm-5 mt-md-0">
                <h5>
                    <i class="fas fa-hashtag"></i>
                    Social Media
                </h5>
                <ul class="list-group list-group-flush flex">
                    <li class="list-group-item p-0 m-0">
                        <a class="list-group-item" href="https://twitter.com/iatse118" target="_blank"
                           title="IATSE Local 118">
                            <i class="fab fa-twitter"></i>
                            @iatse118
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

            <div class="col-12 mt-3">
                <h3>Our Affiliations</h3>
            </div>
            <div class="pb-md-3 d-flex justify-content-md-center">
                <div class="col pl-md-5">
                    <a href="http://www.bcfed.com/" title="BC Federation of Labour" target="_blank">
                        <img src="/storage/public/w8x7LmSqnTLjEHyftPbYRh3JFmBNh1GOVgjvGX6z.png"
                             alt="BC Federation of Labor" class="flex-fill img-fluid association-img" />
                    </a>
                </div>
                <div class="col pl-md-5">
                    <a href="http://www.iatse-intl.org/" title="IATSE International" target="_blank">
                        <img src="/storage/public/E9psVVljWX9afHmiwfyeTCuXEU6WnKHUIoevll6Y.jpeg"
                             alt="IATSE International" class="p-1 img-fluid association-img" />
                    </a>
                </div>
                <div class="col pl-md-5">
                    <a href="https://canadianlabour.ca/" title="Canadian labour Congress" target="_blank">
                        <img src="/storage/public/KKVqVfiv4hU4ayxNukvYJsN5EKgIqnYfx5mssuT7.png"
                             alt="Canadian Labour Congress" class="p-1 flex-fill img-fluid  association-img" />
                    </a>
                </div>
                <div class="col pl-md-5">
                    <a href="http://www.vdlc.ca/" title="Vancouver & District Labour Congress" target="_blank">
                        <img src="/storage/public/mlL21yHivsR7ztxYh3hRB2Y8j9rcFzY5BfXtSLE1.jpeg"
                             alt="Vancouver & District Labour Congress" class="p-1 flex-fill img-fluid  association-img" />
                    </a>
                </div>
            </div>
        </div>
        <div class="col-12 mt-5 mb-5 mt-md-5 mb-md-5 d-flex justify-content-around">
            <div>
                <i class="far fa-copyright"></i> <?php echo date('Y'); ?> {{ config('app.name')}}
            </div>
            <div>
                <h6 align="center">Site by <br />IATSE 118 <br /> Members</h6>
            </div>
            <div>
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
