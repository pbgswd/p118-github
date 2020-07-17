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
                            <h1>Contact info update for {{$data['original_name']}}</h1>

			                <p class="lead">
                                Email: <a href="mailto:{{$data['original_email']}}">{{$data['original_email']}}</a>
                            </p>
                            <p>
                                The following contact information has been updated in the
                                {{env('APP_NAME')}} Web site database:
                            </p>
                              <ul>
                                  @foreach($data as $k => $v)
                                      @if($k != 'original_email' and $k != 'id' and $k != 'original_name')
                                          <li>New {{$k}}: {{$v}}</li>
                                      @endif
                                  @endforeach
                              </ul>
                              @if(Route::currentRouteName() == 'user_edit_update')
                                  <p>This ADMIN update for
                                      {{ $data['Name'] ?? $data['original_name'] }}
                                      was submitted by {{Auth::user()->name}}.
                                  </p>
                              @endif
                          </td>
                            <td class="expander"></td>
                        </tr>
                          <tr>
                              <td>
                                 <p><a title="{{ $data['Name'] ?? $data['original_name']}}"
                                                              href="{{ route('user_edit', $data['id'])}}">
                                         Admin Profile page for
                                         {{ $data['Name'] ?? $data['original_name'] }}
                                                        </a>
                                 </p>
                                  <p><a title="{{ $data['Name'] ?? $data['original_name']}}"
                                                                href="{{ route('member', $data['id'])}}">
                                          Member Profile page for
                                          {{ $data['Name'] ?? $data['original_name'] }}
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
