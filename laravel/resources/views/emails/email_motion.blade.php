@extends('layouts.email', ['title' => env('APP_NAME') . " email message - " . $data['subject']])
@section('content')
    <table class="body" style="margin-left: auto; margin-right: auto;">
        <tr>
            <td style="padding: 12px; text-align: center;">
                <table class="row">
                    <tr>
                        <td class="wrapper last" style="text-align: center; padding-bottom:1rem;">
                            <a href="{{route('motion', $data['id'])}}"
                               title="Link to {{$data['title']}}" target="_blank">
                                View motion on website >>
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
                                       <h4 class="lead" style=" font-weight: bold; padding-top: 1rem; padding-bottom: 1rem; text-align:center;">
                                           {{$data['subject']}}
                                       </h4>
                                       <hr style="height: 3px; background-color: black; border: none;" />
                                   </td>
                                   <td class="expander"></td>
                               </tr>
                               <tr>
                                   <td  style="padding: 2rem;">
                                       <h4>
                                            {!! $data['delete_message'] ?? null !!}

                                           By: {{$data['user']['name']}},
                                           <a href="mailto:{{$data['user']['email']}}">{{$data['user']['email']}}</a>
                                           <br />
                                           Created: {{$data['created_at']->format('M j Y, g:i:s A')}}
                                           <br />
                                           @if($data['updated_at'] > $data['created_at'])
                                                Last updated by: {{Auth::user()->name}},
                                               {{$data['updated_at']->format('M j Y, g:i:s A')}}
                                           @endif
                                       </h4>
                                   </td>
                                   <td class="expander"></td>
                               </tr>
                               <tr>
                                  <td style="padding: 2rem;">
                                    <h4>
                                        <a href="{{route('motion', $data['id'])}}"
                                           title="View {{$data['title']}} on website" target="_blank">
                                            {{$data['title']}}
                                        </a>
                                    </h4>
                                  </td>
                                  <td class="expander"></td>
                               <tr>
                                  <td style="padding: 2rem;">
                                      {!! $data['description'] !!}
                                  </td>
                                  <td class="expander"></td>
                               </tr>
                               <tr>
                                   <td style="padding: 2rem;">
                                       <h5>
                                            @if($data['meeting_id'] != null)
                                               <a href="{{route('meeting', $data['meeting_id'])}}"
                                                  title="Link to meeting {{$data['meeting']['title']}}" target="_blank">
                                                   For {{$data['meeting']['meeting_type']}} Meeting
                                                   {{$data['meeting']['title']}} on
                                                   {{$data['meeting']['date']->format('M j Y, g:i:s A')}}
                                               </a>
                                            @else
                                                This {{$data['submission_type']}} is not yet associated with a meeting.
                                            @endif
                                       </h5>
                                </td>
                                <td class="expander"></td>
                                </tr>
                               <tr>
                                   <td  style="padding:2rem;">
                                       <h5>
                                           Important: Motions and New Business may be reviewed for grammar,
                                           completeness, appropriateness, and duplication.
                                           @if($data['user_id'] !== Auth::user()->id)
                                               Please contact the Editor of this {{$data['submission_type']}}
                                               to review any changes.
                                           @endif
                                       </h5>
                                   </td>
                               </tr>
                           </table>
                       </td>
                    </tr>
                </table>
                @if(count($data['attachments']) > 0)
                    <table class="twelve columns">
                        <tr>
                            <td style="padding-left: 2rem; padding-top:2em;">
                                {{count($data['attachments'])}} File
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
