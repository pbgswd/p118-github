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
                            <td class="six sub-columns"><a href="{{Request::root()}}" title="{{env('SITE_NAME')}}"><img src="{{Request::root()}}/images/world-globe-mail-blur.jpg" alt="{{env('SITE_NAME')}}"></a>
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
<h1>Hello {{$data['subscription_order_data']['user']['first_name']}}  {{$data['subscription_order_data']['user']['last_name']}}  </h1>
<p class="lead">Welcome to {{env('SITE_NAME')}}.</p>			
			             </td>
                         <td class="expander"></td>
			           </tr>	
                       <tr>
                          <td>
Log in with your email address, using the password: {{$data['subscription_order_data']['user']['newpass']}}
                          </td>
                          <td class="expander"></td>
                        </tr>
			            <tr>
			            <td>
                           &nbsp;
			            </td>
                        <td class="expander"></td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>
@endsection