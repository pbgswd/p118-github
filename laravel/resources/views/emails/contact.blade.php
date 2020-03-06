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
                          <a href="{{Request::root()}}" title="{{env('SITE_NAME')}}">{{env('SITE_NAME')}}</a>
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
                            <h1>Message from {{$data['name']}}</h1>
			    <p class="lead">Email: <a href="mailto:{{$data['email']}}">{{$data['email']}}</a></p>
                            <p class="lead">Subject: {{$data['mail_subject']}}</p>
                            <p>Message: <br />
			    {!! $data['mail_body'] !!}
			    </p>
                          </td>
                          <td class="expander"></td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>
@endsection
