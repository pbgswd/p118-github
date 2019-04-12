@extends('layouts.jumbo')
@section('content')
<div class="container">
    <h1 class="display-3">Contact Us</h1>



    <div class="row">
        <div class="col-md-12 content">
            <form class="form-horizontal" role="form" action="{{route('contact')}}" method="post">
                {!! csrf_field() !!}
                <div class="form-group ">
                    <label for="inputName3" class="col-sm-2 control-label input-lg">Name</label>
                    <div class="col-sm-10">
                        <input name="name" type="text" maxlength="60" class="form-control input-lg" id="inputName3" placeholder="Name" value="{{old('name')}}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
                    <div class="col-sm-10">
                        <input name="email" type="email" class="form-control input-lg" maxlength="60" id="inputEmail3" placeholder="Email" value="{{old('email')}}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputSubject3" class="col-sm-2 control-label">Subject</label>
                    <div class="col-sm-10">
                        <input name="mail_subject" type="text" class="form-control input-lg" maxlength="60" id="inputSubject3" placeholder="Subject" value="{{old('mail_subject')}}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="mail_body"  class="col-sm-2 control-label">Message</label>
                    <div class="col-sm-10">
                        <textarea name="mail_body" placeholder="Message" form-control input-lg" rows="3" cols="100">{{old('mail_body')}}</textarea>
                    </div>
                </div>

                <div class="col-sm-2 col-sm-offset-2">

                    <button
                            class="btn btn-primary g-recaptcha"
                            data-sitekey="6LcxikAUAAAAAAvZhKMlu3bH9dndScyhJk5d4NoF"
                            data-callback=""
                            name="submit">
                        Send
                    </button>

                </div>

                <div class="col-sm-1 col-sm-offset-6">
                    <button type="reset" class="btn btn-info btn-reset"  name="Reset">Reset</button>
                </div>
            </form>
          </div>
@endsection
