@extends('layouts.email', ['title' => env('APP_NAME') . " email message - " . $data['message']['subject']])
@section('content')
    <table class="body" style="margin-left: auto; margin-right: auto;">
        <tr>
            <td style="padding: 12px; text-align: center;">
                <table class="row">
                    <tr>
                        <td class="wrapper last" style="text-align: center; padding-bottom:1rem;">
                            <a href="{{route('message', [$data['message']['id'], $data['message']['slug']])}}"
                               title="Link to {{$data['message']['subject']}}" target="_blank">
                                View message on website >>
                            </a>
                        </td>
                    </tr>
                    <tr>
                       <td align="center">
                           <table class="twelve columns" style="background-color: #FFFFFF; border-bottom: 1px solid #CCCCCC; margin-left: auto; margin-right: auto; padding:2px;">
                               <tr>
                                   <td align="center" style="padding-top: 1rem; padding-bottom: 1rem; padding-left: 2rem; padding-right: 2rem; text-align:center; margin-left: auto; margin-right: auto; display: flex;">
                                       <a href="{{env('APP_URL')}}" title="IATSE Local 118" style="text-align: center; margin-left: auto; margin-right: auto; ">
                                           <img src="{{env('APP_URL')}}/email/118_logo_webp.webp" style="margin-left: auto; margin-right: auto; display: block;" />
                                       </a>
                                   </td>
                                   <td class="expander"></td>
                               </tr>
                               <tr>
                                   <td style="text-align:center; padding: 1rem;">
                                       <hr style="height: 3px; background-color: black; border: none;" />
                                       <h2 class="lead" style=" font-weight: bold; padding-top: 1rem; padding-bottom: 1rem; text-align:center;">
                                           {{$data['message']['subject']}}
                                       </h2>
                                       <hr style="height: 3px; background-color: black; border: none;" />
                                   </td>
                                   <td class="expander"></td>
                               </tr>
                               <tr>
                                   <td  style="padding: 2rem;">
                                       {!! $data['message']['content'] !!}
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
                            <td style="padding-left: 2rem; padding-top:2em;">
                                {{count($data['attachments'])}}
                                {{Str::plural('Attachment', count($data['attachments']))}}
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
