 @extends('layouts.jumbo')
@section('content')
    <div class="container mb-3  pt-2 pb-2 mt-3 rounded" style="background: rgba(220,220,220,0.8);">
        <div class="row mt-3 m-2 border border-dark rounded">
            <div class="col-12 p-2 px-4">
                <h1 class="text-center py-4">Contact IATSE Local 118</h1>
                <h4 class="">Whether you need skilled stagehands for your production or have
                    questions about our services, we’re here to help. Reach out to us for professional
                    and reliable stagehand labor. We look forward to supporting your event with our experienced team.
                    The office and Business Agent will respond to you promptly.
                </h4>
            </div>
        </div>
        <div style="display: inline">
            <form class="form-horizontal" id="contact-form" role="form" action="{{route('contact')}}" method="post">
                {!! csrf_field() !!}
                <div class="row p-2 mb-3">
                    <div class="input-group input-group-lg mb-3">
                        <span class="input-group-text" id="inputGroup-sizing-lg">Name</span>
                        <input type="text" class="form-control" placeholder="Name" name="name"
                               value="{{ old('name')}}" size="80" required/>
                    </div>
                    <div class="input-group input-group-lg mb-3">
                        <span class="input-group-text" id="inputGroup-sizing-lg">Email</span>
                        <input type="text" class="form-control" placeholder="you@email.com" name="email"
                               value="{{ old('email')}}" size="80" required/>
                    </div>
                    <div class="input-group input-group-lg mb-3">
                        <span class="input-group-text" id="inputGroup-sizing-lg">Subject</span>
                        <input type="text" class="form-control" placeholder="Subject" name="mail_subject"
                               value="{{ old('mail_subject')}}" size="80" required/>
                    </div>
                    <div class="col-12 mt-3 text-start">
                        <label for="mail_body" class="col-sm-2 control-label text-start mx-auto">
                            <h3>Message</h3>
                        </label>
                    </div>
                    <div class="col-12 input-group my-3 d-flex">
                        <textarea name="mail_body" placeholder="Your Message" class="form-control input-lg" rows="5"
                        cols="100">{{old('mail_body')}}</textarea>
                    </div>
                    <div class="row my-4">
                        <div class="col-sm-12 col-md-6 text-center mx-auto">
            <script
                src="https://www.google.com/recaptcha/api.js?render=6Ldv4sQaAAAAAJApVGt3T9XUyZcNFDrKLS_Umu1A"></script>
            <script>
                function onSubmit(token) {
                    document.getElementById("contact-form").submit();
                }
            </script>
                            <button class="btn btn-outline-primary g-recaptcha pb-2 mb-3"
                                    data-sitekey="6Ldv4sQaAAAAAJApVGt3T9XUyZcNFDrKLS_Umu1A"
                                    data-callback='onSubmit'
                                    data-action='submit'>Submit</button>
                        </div>
                        <div class="col-sm-12 col-md-6 text-center mt-sm-2 pt-sm-4 pt-md-0">
                            <button
                                type="reset"
                                class="btn btn-outline-info btn-reset"
                                name="Reset">
                                Reset
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="row mt-2 m-2 p-2 mb-2 border border-dark rounded">
            <div class="col-12 col-md-6 p-sm-4 p-2">
                <h4>
                    <i class="far fa-building"></i> IATSE Local 118 <br/>
                    #206 - 2940 Main Street<br/>
                    Vancouver, BC, V5T 3G3
                </h4>
            </div>
            <div class="col-12 col-md-6 p-2">
                <h3>
                    <a href="https://goo.gl/maps/h1ftiTc6NoBXj5D1A" target="_blank" title="IATSE Local 118 Office">
                        <i class="fas fa-map-marked-alt"></i> Maps</a>
                </h3>
                <h3>
                    <a href="tel:6046859553">
                        <i class="fas fa-phone-square"></i> 604-685-9553</a>
                </h3>
                <h3>
                    <a href="mailto:office@iatse118.com">
                        <i class="fas fa-envelope"></i> office@iatse118.com</a>
                </h3>
            </div>
            <div class="col-12 mt-3 content">
                <h3>
                    <a href="tel:7787451118">
                        <i class="fas fa-phone-square"></i> Local 118 Dispatch:
                        778-745-1118
                    </a>
                </h3>
            </div>
            <div class="d-block col-12 pt-4 pb-5 rounded">
                {!! $data['office-hours']->content ?? '' !!}
            </div>
            @auth
                <div class="d-sm-block d-md-none col-12 mt-4 mb-3">
                    <h3>
                        <a href="{{route('page_show', 'contact-us')}}">
                            <i class="far fa-lg fa-address-book"></i>
                            Contacts for Administration, Health & Welfare, and Committees
                        </a>
                    </h3>
                </div>

                <div class="d-none d-md-block col-12 m-4 pt-4 pb-5 rounded">
                    {!! $data['contactPage'][0]->content ?? '' !!}
                </div>

            @endauth
        </div>
    </div>
@endsection
