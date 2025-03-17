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
            <div class="col-sm-12 col-md-6 text-end">
                <h4>
                    @if($data['motion']->user_id == Auth::user()->id)
                        <div class="badge bg-primary-outline">
                            <a href="{{route('motion_edit', $data['motion']->id)}}">Edit</a>
                        </div>
                    @endif
                    @can(['edit articles'])
                        <div class="badge bg-primary-outline">
                            <a href="{{route('admin_motion_edit', $data['motion']->id)}}">Admin Edit</a>
                        </div>
                    @endcan
                </h4>
            </div>
        </div>
        <div class="row">
            <div class="col-12 mt-3 mx-auto text-center">
                <h1 class="text-center">
                   Proposed   {{$data['motion']->submission_type}}
                </h1>
                <h2>
                    Submitted by
                    <a href="{{route('member', $data['motion']->user->id)}}" title="{{$data['motion']->user->name}}">
                        {{$data['motion']->user->name}}</a>,
                    {{$data['motion']->created_at->format('F j, Y')}}
                </h2>
            </div>
        </div>
        <div class="row">
            <div class="col-12 text-center">
                <h3>
                    @if(!is_null($data['motion']->meeting_id))
                        <div class="badge bg-primary text-sm">
                            {{$data['motion']->meeting->meeting_type}}
                            Meeting
                        </div>
                        <a href="{{route('meeting', $data['motion']->meeting->id)}}">
                            {{$data['motion']->meeting->title}}
                            {{$data['motion']->meeting->created_at->format('F j, Y')}}
                        </a>
                    @else
                        For the next General meeting to be scheduled
                    @endif
                </h3>
            </div>
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




