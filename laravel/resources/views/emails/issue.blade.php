@extends('layouts.email')
@section('content')
  <table class="body">
    <tr>
      <td class="center" align="center" valign="top">
        <center>

          <table class="row header">
            <tr>
              <td class="center" align="center">
                <center>

                  <table class="container">
                    <tr>
                      <td class="wrapper last">
                  <table class="twelve columns">
                      <tr>
                          <td class="six sub-columns">
                              <a href="{{Request::root()}}" title="{{env('SITE_NAME')}}">
                      <img src="{{Request::root()}}/images/world-globe-mail-blur.jpg" alt="{{env('SITE_NAME')}}">
                              </a>
                          </td>
                          <td class="six sub-columns last" style="text-align:right; vertical-align:middle;">
                              <span class="template-label"></span>
                          </td>
                          <td class="expander"></td>
                      </tr>
                  </table>
                      </td>
                    </tr>
                  </table>
                </center>
              </td>
            </tr>
          </table>
          <table class="container">
            <tr>
              <td>
                <table class="row">
                  <tr>
                    <td class="wrapper last">
                     <table class="twelve columns">
                        <tr>
                          <td>
<?php echo date('Y-m-d H:i:s'); ?>
<h1>Dear {{$data['subscriber']->first_name}} {{$data['subscriber']->last_name}},</h1>
<h2>Here is the latest issue of <br /> {{$data['publications'][0]->title}}</h2>
<h3>{{ $data['nl']->title}}</h3>
<p class="lead">{!!$data['nl']->summary!!}</p>
<p>See the file attached to this newsletter (<b>{{$data['newsletter_data']->file_name}}</b>). Dont forget you can also <a href="{{Request::root()}}/login" title="{{env('SITE_NAME')}}">log on to our site and download the latest issue.</a></p>
<p>Your subscription is paid until {{$data['subscriber']->end_date_readable}}.</p>

@if($data['subscriber']->grace_msg == true)
    <h3>Time To Renew</h3>
    <p>We have given you until {{$data['subscriber']->end_date_grace_readable}} to renew your subscription.
       We hope you enjoy {{$data['publications'][0]->title}} and will continue with us.
           Please visit <a href="{{Request::root()}}" title="{{env('SITE_NAME')}}" target="_blank">{{env('SITE_NAME')}}</a> to get your renewal started. 
    </p>
@endif    
			             </td><td class="expander"></td>
			          </tr>	                                     		
			      <tr>
			  <td>
<p>
    <strong>Note:</strong> you have received this email because you submitted
                       a file request for
    <a href="{{Request::root()}}" title="{{env('SITE_NAME')}}">{{env('SITE_NAME')}}</a>,
    a financial newsletter publication.
</p>
  	        </td><td class="expander"></td>
                       </tr>
                      </table>
                    </td>
                  </tr>
                </table>
@endsection