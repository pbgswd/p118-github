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
                          <p>Dear {{$data['name']}},<br />
                             Your free sample of {{$data['publication'][0]->title}}
                             is attached to this message.</p>			
			  </td><td class="expander"></td>
			</tr>	
            <tr>
                <td>
                    <h3>{{$data['publication'][0]->title}}</h3>
                    {!! $data['publication'][0]->description !!}
               </td><td class="expander"></td>
			</tr>	
			<tr>
			<td>
			<p><strong>Note:</strong> you have received this email because you
                                         or someone using your email has entered
			                             a sample request from <a href="{{Request::root()}}"
                                         title="{{env('SITE_NAME')}}">{{env('SITE_NAME')}}</a>,
                                         a newsletter publication.</p>
			   </td><td class="expander"></td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>
@endsection