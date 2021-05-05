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
                            <h4>Hi {{$data['invitation']['name']}}</h4>

                              {!! $data['invitation']['message'] ?? '' !!}

			                <p class="lead">This is your invitation to join the completely updated IATSE Local 118
                                website. </p>
                            <p class="lead">To join the website you will need to navigate to the page in the link
                                provided below.
                                  On that page you will create a secure login password. Your password must be a minimum
                                of 6 characters. Do not use an easily guessable password.
                            </p>
                            <p>Once you have done that, you will be prompted to log in to the
                              site with your email address and new password.</p>
                            <p>After you have logged in, be sure to look around, and update your personal profile
                              information.</p>
                            <p>Please note that we have not brought across your existing login information as a best
                              security practice. </p>
                              <p>Remember: you use your email address as your login name, not your user name as was
                                  the case before.</p>
                            <p style="margin-top: 2em;">
                                <a href="{{route('invite_user_signup', ['inviteUser' => $data['invitation']['id'],
                                    'password' => $data['invitation']['password']])}}" target="_blank">
                                    {{route('invite_user_signup', [$data['invitation']['id'],
                                        $data['invitation']['password']])}}
                                </a>
			                </p>
                              <p>See anything out of place? Report errors and typos to
                                  <a href="mailto:office@iatse118.com" target="_blank" rel="noopener">
                                      office@iatse118.com</a>.
                              </p>
                              <p>&nbsp;</p>
                              <p>Have a great day.</p>
                              <p>IATSE Local 118.</p>
                          </td>
                          <td class="expander"></td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>
@endsection
