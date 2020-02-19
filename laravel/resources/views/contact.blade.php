@extends('layouts.jumbo')
@section('content')
<div class="container">
    <div class="row border border-dark rounded-lg p-lg-5" style="background: rgba(220,220,220,0.6);">
        <div class="col-12 mb-4">
            <h1 class="display-3">Contact IATSE Local 118</h1>
        </div>
        <div class="col-md-6 content">
                <h3><i class="far fa-building"></i> IATSE Local 118 <br />
                    #206 - 2940 Main Street<br />
                    Vancouver, BC, V5T 3G3</h3>
        </div>
        <div class="col-md-6 content">
                <h3><a href="https://goo.gl/maps/h1ftiTc6NoBXj5D1A" target="_blank" title="IATSE Local 118 Office"><i class="fas fa-map-marked-alt"></i> Maps</a></h3>
                <h3><a href="tel:604-685-9553"><i class="fas fa-phone-square"></i> 604-685-9553</a></h3>
            <h3><a href="mailto:office@iatse118.com"><i class="fas fa-envelope"></i> office@iatse118.com</a></h3>
        </div>
        @guest
        @else
            <div class="col-md-12 mt-5 content">
                <h3><a href="tel:6042597365"><i class="fas fa-phone-square"></i> Local 118 Dispatch: 604-259-7365</a></h3>
            </div>
        @endguest
        <div class="col-md-12 mt-5 content">
            <form class="form-horizontal" role="form" action="{{route('contact')}}" method="post">
                {!! csrf_field() !!}
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-default">Name</span>
                        <input type="text" class="form-control"  placeholder="Name" name="name" value="{{ old('name')}}" size="80" required/>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-default">Email</span>
                        <input type="text" class="form-control"  placeholder="you@email.com" name="email" value="{{ old('email')}}" size="80" required/>
                    </div>
                </div>
                <div class=" input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-default">Subject</span>
                        <input type="text" class="form-control"  placeholder="Subject" name="mail_subject" value="{{ old('mail_subject')}}" size="80" required/>
                    </div>
                </div>
                <div class="form-group mt-4">
                    <label for="mail_body"  class="col-sm-2 control-label"><h3>Message</h3></label>
                        <textarea name="mail_body" placeholder="Message" form-control input-lg" rows="3" cols="100">{{old('mail_body')}}</textarea>
                </div>
                <div class="row mt-lg-2">
                    <div class="col-6">
                        <button
                                class="btn btn-primary g-recaptcha"
                                data-sitekey="6LcxikAUAAAAAAvZhKMlu3bH9dndScyhJk5d4NoF"
                                data-callback=""
                                name="submit">
                            Send
                        </button>
                    </div>
                    <div class="col-6">
                        <button type="reset"
                                class="btn btn-info btn-reset"
                                name="Reset">
                            Reset
                        </button>
                    </div>
                </div>
            </form>
        </div>
        @guest
        @else
            <div class="col-12 mt-lg-4 pt-4">
                <h2>Contact Information for Members</h2>
                <h3>Email Links and phone numbers</h3>
                <h3>Executive Board:</h3>
                <ul>
                    <li>President - Derral Dunlop - <a href="mailto:president@iatse118.com">president@iatse118.com</a></li>
                    <li>Vice-President - Eric St. Laurent - <a href="mailto:vicepresident@iatse118.com">vicepresident@iatse118.com</a></li>
                    <li>Recording Secretary - Kate Rittenhouse - <a href="mailto:recsec@iatse118.com">recsec@iatse118.com</a></li>
                    <li>Financial Secretary-Treasurer - Jordan Both - <a href="mailto:financialsecretary@iatse118.com">financialsecretary@iatse118.com</a></li>
                    <li>Business Agent - Josef Chung - <a href="mailto:businessagent@iatse118.com">businessagent@iatse118.com</a></li>
                    <li>Members-at-Large &ndash; Dave Wilson and Brian Heath&ndash; memberatlarge@iatse118.com</li>
                </ul>
                <h3>Health &amp; Welfare:</h3>
                <ul>
                    <li>H&amp;W Administrator - Margaret Underhill</li>
                </ul>
                <h3>Trustees:</h3>
                <ul>
                    <li>Local 118 Trustees - Alex Livland &amp; Don Underhill &amp; Kate Rittenhouse - trustee@iatse118.com</li>
                 </ul>

                <h3>Constitution &amp; Bylaw Committee:</h3>
                <ul>
                    <li>constitution@iatse118.com</li>
                </ul>
                <ul>
                    <li>For office administration matters please contact: admin@iatse118.com</li>
                    <li>Dispatch: General Dispatch: Text message: 236-886-5797 Email: dispatch@iatse118.com</li>
                    <li>ACT Costume Dispatch: Kirsten McGhie: 604-687-5315 ext 106 Email: kmcghie@artsclub.com</li>
                    <li>Okanagan Dispatch: Gord Osland: 250-809-0741 Email: oslandgord@gmail.com</li>
                </ul>
                <h3>Members:</h3>
                <ul>
                    <li><a href="{{route('members')}}" title="Members Page">Members List</a></li>
                    <li>Training Committee - training@iatse118.com</li>
                    <li>Young Workers Committee - ywc@iatse118.com</li>
                    <li>Payroll: Email: payroll@iatse118.com</li>
                </ul>
            </div>
        @endguest
    </div>
</div>
@endsection
