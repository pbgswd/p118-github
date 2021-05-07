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
                                      <img src="{{env('APP_URL')}}/storage/public/wrITw0NW1mBky0LidKwgBwtOg9mLcUuDCmQDuiPk.png"
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
                            <h3>
                                Contact info update for {{$data['name']}}
                            </h3>
			                <p class="lead">
                                Email: <a href="mailto:{{$data['email']}}">
                                            {{$data['email']}}
                                       </a>
                            </p>
                            <p style="margin-bottom: 2em;">
                                The following contact information has been updated in the
                                {{env('APP_NAME')}} Web site database:
                            </p>
                              <div style="background: #cce5ff; margin: 5px; padding:15px;">
                                  <ul>
                                      @foreach($data as $k => $v)
                                          <li style="margin: 5px; padding:5px; list-style-type:none;">
                                              {{$k}}: {{$v}}
                                          </li>
                                      @endforeach
                                  </ul>
                              </div>

                              @if(Route::currentRouteName() == 'user_edit_update')
                                  <p style="margin-top: 2em;">This ADMIN update for
                                      {{ $data['name']}}
                                      was submitted by {{Auth::user()->name}}.
                                  </p>
                              @endif
                          </td>
                            <td class="expander"></td>
                        </tr>
                          <tr>
                              <td>
                                 <p>
                                     <a title="{{ $data['name']}}"
                                          href="{{ route('user_edit', $data['id'])}}">
                                         Admin Profile page for
                                         {{ $data['name'] }}
                                    </a>
                                 </p>
                                  <p>
                                      <a title="{{ $data['name']}}"
                                            href="{{ route('member', $data['id'])}}">
                                          Member Profile page for
                                          {{ $data['name'] }}
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
