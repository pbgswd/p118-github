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
                            <td class="six sub-columns"><a href="{{route('front_page')}}" title="{{env('SITE_NAME')}}"><img src="{{Request::root()}}/images/world-globe-mail-blur.jpg" alt="{{env('SITE_NAME')}}"></a>
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
                                <h1>Hello {{$data['first_name']}} {{$data['last_name']}},</h1>
                                <p class="lead">Welcome to {{env('SITE_NAME')}}.</p>			
			                </td>
                            <td class="expander"></td>
			            </tr>	
                        <tr>
                            <td>
                                You have started your subscription to {{$data['publication']}} on
                                {{ date('F j, Y', strtotime($data['start_date']))}} and goes until {{ date('F j, Y', strtotime($data['end_date'])) }}.
                                <br />
                                You will receive your newsletter issues at this email address, and additionally
                                you can access your newsletters by logging in to {{env('SITE_NAME')}}, as well
                                as update your contact information there. <br />
                            </td>
                            <td class="expander"></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
@endsection