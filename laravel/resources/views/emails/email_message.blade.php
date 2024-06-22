@extends('layouts.email')
@section('content')
    <table class="body">
        <tr>
            <td>
                <table class="row">
                    <tr>
                        <td class="wrapper last">
                            <table class="twelve columns">
                                <tr>
                                    <td>
                                        <a href="https://iatse118.com/" title="IATSE Local 118">
                                            <img src="https://iatse118.com/storage/public/wrITw0NW1mBky0LidKwgBwtOg9mLcUuDCmQDuiPk.png" style="margin-right: 1rem;"/>
                                            <h1>email</h1>
                                        </a>
                                    </td>
                                    <td class="expander"></td>
                                </tr>
                                <tr>
                                    <td style="text-align:center;">
                                        <hr />
                                        <h2 class="lead" style="padding-top: 1rem; padding-bottom: 1rem;">{{$data['message']['subject']}}</h2>
                                        <hr />
                                    </td>
                                    <td class="expander"></td>
                                </tr>
                                <tr>
                                    <td>
                                        {!! $data['message']['content'] !!}
                                    </td>
                                    <td class="expander"></td>
                                </tr>
                                <tr>
                                    <td style="text-align:center;">
                                        <h5 class="lead" style="padding-top: 1rem; padding-bottom: 1rem; text-align:center;">
                                            <a href="{{route('message', $data['message']['id'])}}" title="Link to {{$data['message']['subject']}}" target="_blank">
                                                link to message on website >>
                                            </a>
                                        </h5>
                                    </td>
                                    <td class="expander"></td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                </table>
                @if(count($data['attachments']) > 0)
                    <table class="twelve columns">
                        <tr>
                            <td style="padding-left: 2rem;">
                                {{count($data['attachments'])}}
                                {{Str::plural('attachment', count($data['attachments']))}}
                                with this message.
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <table class="row">
                                    <tr>
                                        <td class="wrapper last" style="padding-left: 3rem;">
                                            <table class="twelve columns">
                                                <tr>
                                                    <td colspan="12">
                                                        <ul>
                                                            @forelse($data['attachments'] as $att)
                                                                <li class="list-group-item">
                                                                    {{$att->description ? : $att->file_name}}
                                                                </li>
                                                            @empty
                                                                <li class="list-group-item"> No attachments </li>
                                                            @endforelse
                                                        </ul>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                @endif
            </td>
        </tr>
    </table>
@endsection
