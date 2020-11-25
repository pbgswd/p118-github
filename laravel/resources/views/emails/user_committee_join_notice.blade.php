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
                                  <a href="{{Request::root()}}" title="{{env('APP_NAME')}}">
                                      <img
                                          src="{{env('APP_URL')}}/storage/public/wrITw0NW1mBky0LidKwgBwtOg9mLcUuDCmQDuiPk.png"
                                          alt="{{env('APP_NAME')}}" style="padding:1em;" />
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
                                <h1 style="margin-bottom: 0.5em;">
                                    Committee Membership Notice
                                </h1>
                                <h2 style="margin-bottom: 0.5em;">
                                    {{$data['committee']->name}}
                                </h2>
                                <p style="font-size: x-large">
                                    Hi {{$data['user']->name}}
                                </p>
                                <p style="margin-bottom: 2em;">
                                    You are now a
                                    <strong>{{$data['role']}}</strong>
                                    in the IATSE Local 118 committee:
                                </p>
                                <h3>
                                    {{ $data['committee']->name }}
                                </h3>
                                <p style="margin-top:2em;">
                                    ...on the {{env('APP_NAME')}} website.
                                </p>

                                @if(in_array($data['role'], \App\Models\Options::committee_executive_roles()))
                                    <p>As <strong>{{$data['role']}}</strong>, you will have content
                                        management privileges for the committee.
                                    </p>
                                @endif

                                <p>Have an awesome day. <br /><br /><br />
                                    <br />Sincerely,<br /><br />
                                The {{env('APP_NAME')}} website.</p>
                          </td>
                        <td class="expander"></td>
                        </tr>
                        <tr>
                            <td>
                            </td>
                            <td class="expander"></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
@endsection
