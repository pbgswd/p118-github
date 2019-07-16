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
              <a href="{{ Request::root() }}" title="{{ env('SITE_NAME') }}" target="_blank">
          <img src="{{ Request::root() }}/images/world-globe-mail-blur.jpg" alt="{{ env('SITE_NAME') }}">
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
<p>Dear {{ $data['subscriber']->first_name }} {{ $data['subscriber']->last_name }}, here is the latest issue of
    <b>{{ $data['newsletter']->publication->title }}</b>
    {{ $data['newsletter']->title}}, {{ date('F d, Y', strtotime($data['newsletter']->date)) }}.</p>

<p class="lead">{!! $data['newsletter']->summary !!}</p>

<p>See the file attached to this message: (<b>{{ $data['newsletter_data']->file_name }}</b>). Or <a href="{{ Request::root() }}/login" title="{{ env('SITE_NAME') }}">log on to our site and download the latest issue.</a></p>

@if ($data['subscriber']->show_warning)    
    <h3>Renew your subscription to {{ $data['newsletter']->publication->title }}</h3>
    <p>You have until <b>{{ $data['subscriber']->grace_date->toFormattedDateString() }}</b> to renew your subscription.  We hope you enjoy {{ $data['newsletter']->publication->title }} and will continue with us. Please visit <a href="{{ Request::root() }}" title="{{ env('SITE_NAME') }}" target="_blank">{{ env('SITE_NAME') }}</a> to get your renewal started.</p>
@else
    <p><i>Please note: your subscription to {{ $data['newsletter']->publication->title }} is good until {{ date('F d, Y', strtotime($data['subscriber']->end_date)) }}</i></p>
@endif    
    </td>
    <td class="expander"></td>
			          </tr>	                                     		
			      <tr>
			  <td>
    &nbsp;
  	        </td><td class="expander"></td>
                       </tr>
                      </table>
                    </td>
                  </tr>
                </table>
@endsection
                                              