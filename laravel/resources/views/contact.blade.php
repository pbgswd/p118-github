@extends('layouts.jumbo')
@section('content')
    <div class="container mb-3" style="background: rgba(220,220,220,0.8);">
        <div class="row mt-3 m-2 border border-dark rounded-lg">
            <div class="col-12 p-2 text-center">
                <h2>Contact IATSE Local 118</h2>
            </div>
        </div>
        <form class="form-horizontal" role="form" action="{{route('contact')}}" method="post">
            {!! csrf_field() !!}
            <div class="row p-2 mb-3">
                <div class="input-group mb-3">
                    <span class="input-group-text" id="inputGroup-sizing-default">Name</span>
                    <input type="text" class="form-control" placeholder="Name" name="name"
                           value="{{ old('name')}}" size="80" required/>
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="inputGroup-sizing-default">Email</span>
                    <input type="text" class="form-control" placeholder="you@email.com" name="email"
                           value="{{ old('email')}}" size="80" required/>
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="inputGroup-sizing-default">Subject</span>
                    <input type="text" class="form-control" placeholder="Subject" name="mail_subject"
                           value="{{ old('mail_subject')}}" size="80" required/>
                </div>
                <div class="col-12 input-group mt-2 d-flex justify-content-center">
                    <label for="mail_body" class="col-sm-2 control-label">
                        <h3>Message</h3>
                    </label>
                </div>
                <div class="col-12 input-group mt-2 mb-2 d-flex justify-content-center">
                    <textarea name="mail_body" placeholder="Message" class="form-control input-lg" rows="3"
                    cols="100">{{old('mail_body')}}</textarea>
                </div>
            <div class="col-6">
                <button
                    class="btn btn-primary g-recaptcha"
                    data-sitekey="6LcxikAUAAAAAAvZhKMlu3bH9dndScyhJk5d4NoF"
                    data-callback=""
                    name="submit">
                    Send
                </button>
            </div>

                <div class="col-6 text-right">
                    <button
                        type="reset"
                        class="btn btn-info btn-reset"
                        name="Reset">
                        Reset
                    </button>
                </div>
            </div>
        </form>

        <div class="row mt-2 p-2 mb-lg-5 border border-dark rounded-lg">
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
                    <a href="tel:604-685-9553">
                        <i class="fas fa-phone-square"></i> 604-685-9553</a>
                </h3>
                <h3>
                    <a href="mailto:office@iatse118.com">
                        <i class="fas fa-envelope"></i> office@iatse118.com</a>
                </h3>
                <h3>
                    <a href="mailto:admin@iatse118.com">
                        <i class="fas fa-envelope"></i> admin@iatse118.com</a>
                </h3>
            </div>
            <div class="col-12 mt-3 content">
                <h3>
                    <a href="tel:6042597365">
                        <i class="fas fa-phone-square"></i> Local 118 Dispatch:
                        604-259-7365
                    </a>
                </h3>
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
                <div class="d-none d-md-block col-12 m-0 mt-4 pt-4">
                    {!! $data['contactPage'][0]->content ?? '' !!}
                </div>
            @endauth
        </div>
    </div>

@endsection
