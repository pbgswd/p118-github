@extends('layouts.jumbo')
@section('content')
<div class="jumbotron">
    <div class="container border border-dark rounded" style="background: rgba(220,220,220,0.8);">
        <div class="row d-flex justify-content-end">
            <div class="col-12 col-md-6 mt-3">
                <h4>
                    @if($data['year'] == '')
                        <a href="{{route('list_meetings')}}" title="List Meetings">
                            <i class="far fa-arrow-alt-circle-left"></i>
                            Meetings
                        </a>
                    @else
                        <a href="{{route('list_meetings_year', $data['year'])}}" title="List Meetings">
                            Back to all {{$data['year']}} Meetings
                        </a>
                    @endif
                </h4>
            </div>
            <div class="col-12 col-md-6 mt-3 text-lg-end">
                @can('edit articles')
                    <a href="{{route('meeting_edit', $data['meeting']->id)}}" title="Edit {{$data['meeting']->title}}">
                        <i class="fas fa-edit"></i> Admin Edit
                    </a>
                @endcan
            </div>
        </div>
        <div class="row">
            <div class="col-3 mx-auto mb-3 text-center">
                <div class="badge bg-primary text-sm text-center">
                    {{$data['meeting']->meeting_type}} Meeting
                </div>
            </div>
            <div class="col-12 text-center">
                <h1>
                    {{$data['meeting']->title}}
                </h1>
            </div>
        </div>
        <div class="row">
            <div class="col-12 text-center">
                <h5>
                    @if($data['meeting']->date > now())
                        Scheduled: {{$data['meeting']->date->format('F j, Y')}},
                        {{$data['meeting']->date->format('g:i:s A')}}
                        <div class="badge bg-warning text-dark">Upcoming</div>
                        {{ Carbon\Carbon::today()->diffInDays($data['meeting']->date)  }} days until meeting.
                    @else
                        Held on: {{$data['meeting']->date->format('F j, Y')}}
                    @endif
                </h5>
            </div>
            <div class="col-12">
                <p>{!! $data['meeting']->description !!}</p>
            </div>
        </div>

            <div class="row">
                <div class="col-12 mb-3">
                    <h5>
                        <i class="far fa-folder-open"></i>
                        Files
                    </h5>
                    <ul class="list-group">
                        @forelse($data['meeting']->attachments as $att)
                            <li class="list-group-item">
                                <a href="{{route('attachment_download', [$att->subfolder, $att->id])}}"
                                   title="Download {{$att->file_name}}" target="_blank">
                                    <i class="fas fa-file-download fa-1x"></i>
                                    {{$att->description ??  $att->file_name}}
                                </a>
                            </li>
                        @empty
                            <li class="list-group-item">No files</li>
                        @endforelse
                    </ul>
                </div>
            </div>



        @if(count($data['meeting']->motions) > 0 && $data['meeting']->meeting_type == 'General')
        <div class="row">
            <div class="col-12 my-4">
                <h3>
                    <i class="far fa-file-alt"></i>
                    Submitted Motions and New Business
                </h3>
            </div>
        </div>

            @forelse($data['meeting']->motions as $motion)
            <div class="row">
                <div class="col-12 p-4 border-bottom border-dark rounded-bottom">
                    <h4>
                        <span class="badge bg-warning text-dark">{{ucfirst($motion->submission_type)}}</span>
                            {{$motion->user->name}}
                    </h4>
                    <h4>
                        <a href="{{route('motion',$motion->id)}}" title="View {{$motion->title}}">
                           {{$motion->title}}
                        </a>
                    </h4>
                    <span class="h6">
                        Created: {{$motion->created_at->format('F j Y, h:i:s A')}}
                        @if($motion->updated_at > $motion->created_at)
                            Last Updated: {{$motion->updated_at->format('F j Y, h:i:s A')}}
                        @endif
                    </span>
                    <span class="float-end">
                       @if($motion->user_id == Auth::user()->id)
                           @if($motion->submission_type == 'Motion' &&
                               ($data['upcoming']->count() > 0 &&
                               (Carbon\Carbon::today()->diffInDays($data['upcoming']->date)-10 > 0) ||
                               $data['upcoming']->count() == 0))
                                    <a class="btn btn-outline-primary" href="{{route('motion_edit', $motion->id)}}"
                                       title="{{Auth::user()->name . "can edit"}}"
                                       role="button">
                                        Edit
                                    </a>
                           @endif
                           @if($motion->submission_type == 'New Business' &&
                                ($data['upcoming']->count() > 0 &&
                                Carbon\Carbon::today()->diffInHours($data['upcoming']->date)-48 > 0 )
                                || $data['upcoming']->count() == 0)
                                   <a class="btn btn-outline-primary" href="{{route('motion_edit', $motion->id)}}"
                                      title="{{Auth::user()->name . " can edit"}}"
                                      role="button">
                                        Edit
                                    </a>
                           @endif
                       @endif
                       @can(['create articles'])
                           <a class="btn btn-outline-primary" href="{{route('admin_motion_edit', $motion->id)}}"
                                  title="Admin Edit" role="button">
                                        Admin Edit
                           </a>
                       @endcan
                    </span>
                </div>
            </div>
            @empty
                <div class="row">
                    <div class="col-12 mb-3">
                        <h6>
                            <i class="far fa-file-alt"></i>
                            No Motions or New Business have been submitted through the website.
                        </h6>
                    </div>
                </div>
            @endforelse
        @endif
        <div class="d-flex justify-content-center mt-4">
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    @if($data['next'])
                        <li class="page-item">
                            <a class="page-link" href="{{ route('meeting', [$data['next']->id])}}"
                               title="Next Meeting: {{$data['next']->title}}">
                                Newer Meetings
                            </a>
                        </li>
                    @endif
                    @if ($data['previous'])
                        <li class="page-item">
                            <a class="page-link" href="{{ route('meeting', [$data['previous']->id])}}"
                               title="Previous Meeting: {{$data['previous']->title}}">
                                Older Meetings
                            </a>
                        </li>
                    @endif
                </ul>
            </nav>
        </div>
    </div>
</div>
@endsection
