<footer class="container mt-2">
    @auth
        <div class="row p-2 d-none d-md-block d-lg-none">
            <div class="col-12 border border-secondary rounded-lg p-2 pt-3">
            <form class="form-inline" action="{{route('search')}}" method="POST">
                {!! csrf_field() !!}
                <div class="col-12 mb-0 mt-md-3 mb-md-3">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text d-none d-md-block" id="basic-addon1">
                                <i class="fas fa-search"></i>
                            </span>
                        </div>
                        <input class="form-control" type="text" placeholder="Search"
                               aria-label="Search" name="search" size="80" required>
                    </div>
                </div>
                <div class="col-12 mt-2 d-flex justify-content-end">
                    <button type="submit" name="Submit" value="Submit"
                            class="btn btn-success">
                        Search
                    </button>
                </div>
            </form>
            </div>
        </div>
    @endauth
    <div class="row mt-1 mt-md-5 px-2 d-flex justify-content-around">
        <div class="col-12 col-md-4 mb-3 pb-2 border border-secondary rounded pt-3">
            <h5>
                <i class="fas fa-hashtag"></i>
                To Read
            </h5>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <a href="{{route('page_show', 'terms-of-use')}}">Terms of Use</a>
                </li>
                <li class="list-group-item">
                    <a href="{{route('page_show', 'privacy-policy')}}">Privacy Policy</a>
                </li>
                <li class="list-group-item"><a href="{{route('page_show', 'disclaimer')}}">Disclaimer</a></li>
                <li class="list-group-item"><a href="{{route('page_show', 'links')}}">Links</a></li>
                <li class="list-group-item"><a href="{{route('page_show', 'apply-for-overhire-work')}}">Apply for work</a>
                </li>
            </ul>
        </div>
        <div class="col-12 col-md-4 mb-3 pb-2 mt-sm-5 mt-md-0 border border-secondary rounded pt-3">
            <h5>
                <i class="fas fa-hashtag"></i>
                Social Media
            </h5>

            <ul class="list-group list-group-flush">
                <li class="list-group-item d-flex justify-content-center">
                    <a href="https://www.facebook.com/IATSE118" target="_blank"
                       title="IATSE Local 118 Facebook">
                        <i class="fab fa-facebook"></i> FaceBook
                    </a>
                    &nbsp;
                    &nbsp;
                    <a href="https://www.instagram.com/iatse118/" target="_blank">
                        <i class="fab fa-instagram"></i> InstaGram
                    </a>
                </li>
                <li class="list-group-item">
                    <a href="https://twitter.com/118IATSE" target="_blank"
                       title="IATSE Local 118">
                        <i class="fab fa-twitter"></i>
                        @118IATSE
                    </a>
                </li>
                <li class="list-group-item">
                    <a href="https://twitter.com/IATSECANADA" target="_blank"
                       title="IATSE Canada">
                        <i class="fab fa-twitter"></i>
                        @IATSECANADA
                    </a>
                </li>
                <li class="list-group-item">
                    <a href="https://twitter.com/IATSEYWC" target="_blank"
                       title="IATSE Young Workers">
                        <i class="fab fa-twitter"></i>
                        @IATSEYWC
                    </a>
                </li>
                <li class="list-group-item">
                    <a href="https://twitter.com/IATSE" target="_blank" title="IATSE">
                        <i class="fab fa-twitter"></i>
                        @IATSE
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="col-12 mt-3 text-center">
        <h3>Our Affiliations</h3>
    </div>
    <div class="pb-md-3 d-flex justify-content-md-center">
        <div class="col text-center">
            <a href="http://www.bcfed.com/" title="BC Federation of Labour" target="_blank">
                <img src="/storage/public/w8x7LmSqnTLjEHyftPbYRh3JFmBNh1GOVgjvGX6z.png"
                     alt="BC Federation of Labor" class="flex-fill img-fluid association-img" />
            </a>
        </div>
        <div class="col text-center">
            <a href="http://www.iatse-intl.org/" title="IATSE International" target="_blank">
                <img src="/storage/public/3qm1aQMeYkDEl30q8gh0iMiyorfRz6sqemdf0Skp.jpg"
                     alt="IATSE International" class="p-1 img-fluid association-img" />
            </a>
        </div>
        <div class="col text-center">
            <a href="https://canadianlabour.ca/" title="Canadian labour Congress" target="_blank">
                <img src="/storage/public/KKVqVfiv4hU4ayxNukvYJsN5EKgIqnYfx5mssuT7.png"
                     alt="Canadian Labour Congress" class="p-1 flex-fill img-fluid  association-img" />
            </a>
        </div>
        <div class="col text-center">
            <a href="http://www.vdlc.ca/" title="Vancouver & District Labour Congress" target="_blank">
                <img src="/storage/public/mlL21yHivsR7ztxYh3hRB2Y8j9rcFzY5BfXtSLE1.jpeg"
                     alt="Vancouver & District Labour Congress" class="p-1 flex-fill img-fluid  association-img" />
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-12 mt-5 mb-5 mt-md-5 mb-md-5 d-flex">
            <div class="p-2 flex-fill text-left">
                <i class="far fa-copyright"></i> {{date('Y')}}
                <br />
                {{ config('app.name')}}
            </div>
            <div class="p-2 flex-fill text-center">
                <h6 align="center">Site by <br />IATSE 118 <br /> Members</h6>
            </div>
            <div class="p-2 flex-fill text-right">
                <a href="#top" title="Top of page">
                    <i class="fas fa-angle-up"></i>
                    Top of page
                </a>
            </div>
        </div>
    </div>
</footer>
<link rel="stylesheet" href="/css/fontawesome/fontawesome-free-5.15.2-web/css/all.min.css" />
<!-- Scripts -->
<script src="/js/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
        crossorigin="anonymous">
</script>
<script>window.jQuery.ready || document.write('<script src="/js/jquery.slim.min.js"><\/script>')</script>
<script src="/js/bootstrap.bundle.min.js"
        integrity="sha384-6khuMg9gaYr5AxOqhkVIODVIvm9ynTT5J4V1cfthmT+emCG6yVmEZsRHdxlotUnm"
        crossorigin="anonymous">
</script>
<script>
    setTimeout(function(){
        // code to be executed after 1 second
    }, 1000);

</script>
<script  src="{{ asset('js/app.js') }}" defer></script>
