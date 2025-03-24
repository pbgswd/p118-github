@extends('layouts.jumbo')
@section('content')
<div class="jumbotron">
    <div class="container border border-dark rounded" style="background: rgba(220,220,220,0.8);">
        <div class="row">
            <div class="col-sm-12 col-md-6 text-start">

            <a href="{{route('list_meetings')}}" title="List Meetings">
                <i class="far fa-arrow-alt-circle-left"></i>
                Meetings
            </a>
            </div>
            <div class="col-sm-12 col-md-6 pt-2 text-end">
                <h4>
                    @if($data['motion']->user_id == Auth::user()->id)
                        <a class="btn btn-outline-primary"
                           title="Edit {{$data['motion']->submission_type}} {{$data['motion']->title}}"
                           href="{{route('motion_edit', $data['motion']->id)}}">Edit Motion</a>
                    @endif
                    @can(['edit articles'])
                        <a class="btn btn-outline-primary"
                           title="Admin Edit {{$data['motion']->submission_type}} {{$data['motion']->title}}"
                           href="{{route('admin_motion_edit', $data['motion']->id)}}">Admin Edit</a>
                    @endcan
                </h4>
            </div>
        </div>
        <div class="row">
            <div class="col-12 mt-3 mx-auto text-center">
                <div class="badge bg-primary text-sm text-center mb-4">
                    {{$data['motion']->meeting->meeting_type ?? 'upcoming'}}
                    Meeting
                </div>
                <h1 class="text-center">
                   Proposed   {{$data['motion']->submission_type}}
                </h1>
                <h2>
                     @if(!is_null($data['motion']->meeting_id))
                        <a href="{{route('meeting', $data['motion']->meeting->id)}}">
                            {{$data['motion']->meeting->title}}
                            {{$data['motion']->meeting->date->format('F j, Y, h:i:s A')}}
                        </a>
                    @else
                        For the next General Meeting to be scheduled.
                    @endif
                </h2>
                <h3>
                    Submitted by
                    {{$data['motion']->user->name}}
                </h3>
                <h4>
                    Created {{$data['motion']->created_at->format('F j, Y')}}.
                    @if($data['motion']->updated_at > $data['motion']->created_at)
                        Last Update: {{$data['motion']->updated_at->format('F j, Y')}}.
                    @endif
                </h4>
            </div>
        </div>
        <div class="row">
            <div class="col-12 mt-3">
                <h2 class="text-center">{{$data['motion']->title}}</h2>
                <p>{!! $data['motion']->description !!}</p>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-12 text-left">
                <h3>Attached files</h3>
            </div>
            <div class="col-12 mb-6">
                <ul class="list-group mb-6">
                    @forelse($data['motion']->attachments as $ma)
                        <li class="list-group-item h5">
                            <a href="{{route('attachment_download', [$data['motion']->getAttachmentFolder(), $ma->id])}}" title="Download {{$ma->file_name}}">{{$ma->file_name}}</a>
                            {{$ma->description}}
                        </li>
                    @empty
                        <li class="list-group-item">
                            No attached files
                        </li>
                    @endforelse
                </ul>
            </div>
        </div>
@endsection
