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
                          <a href="{{Request::root()}}" title="{{env('APP_NAME')}}">{{env('APP_NAME')}}</a>
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
                            <h1>Hi {{$data['invitation']['name']}}</h1>
			                <p class="lead">This is your invitation to join the completely updated IATSE Local 118 website. </p>
                            <p class="lead">The site has been rebuilt completely from the ground up. This means you will
                                need to create a secure password to go with your profile to log on to the site.
                                Use the following link to begin the registration process.
                            </p>
                              {{$data['invitation']['message'] ?? ''}}
                            <p>
                                <a href="{{route('invite_user_signup', ['inviteUser' => $data['invitation']['id'], 'password' => $data['invitation']['password']])}}" target="_blank">
                                    {{route('invite_user_signup', [$data['invitation']['id'], $data['invitation']['password']])}}
                                </a>
			                </p>
                          </td>
                          <td class="expander"></td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>
@endsection
