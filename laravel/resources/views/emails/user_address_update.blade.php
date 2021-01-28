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
                                {{$update_type}} update for {{$user['name']}}
                            </h3>
			                <p class="lead">
                                Email: <a href="mailto:{{$user['email']}}">
                                            {{$user['email']}}
                                       </a>
                            </p>
                            <p style="margin-bottom: 2em;">
                                {{$user['name']}} has submitted a change to personal {{$update_type}} info.
                                Could the administration please update this information.
                            </p>
                              <div style="background: #cce5ff; margin: 5px; padding:15px;">
                                  <ul>
                                      @foreach($data as $k => $v)
                                          <li style="margin: 5px; padding:5px; list-style-type:none;">
                                              {{$k}}:
                                              @if($k == 'Message')
                                                {!! $v !!}
                                              @else
                                                {{$v}}
                                              @endif
                                          </li>
                                      @endforeach
                                  </ul>
                              </div>
                        </td>
                            <td class="expander"></td>
                        </tr>
                      <tr>
                          <td>
                             <p>
                                 <a title="{{ $user['name']}}"
                                    href="{{ route('user_edit', $user['id'])}}">
                                     Admin Profile page for {{ $user['name'] }}
                                </a>
                             </p>
                              <p>
                                  <a title="{{ $user['name']}}"
                                    href="{{ route('member', $user['id'])}}">
                                      Member Profile page for
                                      {{ $user['name']}}
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
