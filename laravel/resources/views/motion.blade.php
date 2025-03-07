@extends('layouts.jumbo')
@section('content')

<div class="jumbotron">
    <div class="container border border-dark rounded" style="background: rgba(220,220,220,0.8);">
        <div class="row">
            <a href="{{route('list_meetings')}}" title="List Meetings">
                <i class="far fa-arrow-alt-circle-left"></i>
                Meetings
            </a>
        </div>
        <div class="row">
            <div class="col-12 mt-3 mx-auto text-center">
                <h1 class="text-center">
                   Proposed   {{$data['motion']->submission_type}}
                </h1>
                <h2>
                    Submitted by
                    <a href="{{route('member', $data['motion']->user->id)}}" title="{{$data['motion']->user->name}}">
                        {{$data['motion']->user->name}}
                    </a>,
                    {{$data['motion']->date->format('F j, Y')}}
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
                            {{$data['motion']->meeting->date->format('F j, Y')}}
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
        <div class="row">
            <div class="col-12 text-center">
                <h3>Attachments</h3>
            </div>
            @if($data['motion']->user_id == Auth::id() || Auth::user()->is_admin)
                @if(count($data['motion']->attachments) > 0)
                    <div class="col-12">
                        <table class="table table-striped table-sm">
                            <thead>
                            <tr>
                                <th> # </th>
                                <th> File </th>
                                <th> <i class="far fa-edit"></i> </th>
                                <th> Description </th>
                                <th> Created At </th>
                                <th> Updated At </th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($data['motion']->attachments as $ma)
                                <tr>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="attachment[{{$ma->id}}][id]" value="{{$ma->id}}" />
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="{{route('attachment_download', [$data['motion']->getAttachmentFolder(), $ma->id])}}" title="Download {{$ma->file_name}}">{{$ma->file_name}}</a>
                                    </td>
                                    <td>
                                        <a title="Edit page for {{ $ma->file_name }}" href="{{ route('admin_attachment_edit', $ma->id) }}"><i class="far fa-edit"></i></a>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control"  placeholder="Add a description for this file" name="attachment[{{$ma->id}}][description]" value="{{ old('attachments.description', $ma->description)}}" size="40"/>
                                    </td>
                                    <td>
                                        {{$ma->created_at}}
                                    </td>
                                    <td>
                                        {{$ma->updated_at}}
                                    </td>
                                </tr>
                            @empty
                                <td colspan="7">
                                    No attached files
                                </td>
                            @endforelse
                            <tr>
                                <td colspan="7">
                                    <i class="far fa-trash-alt"></i> Select checkbox to delete a file
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
              @endif
            @else
                <div class="col-12">
                    <ul class="list-group">
                        @forelse($data['motion']->attachments as $ma)
                            <li class="list-group-item">
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
            @endif
    </div>
@endsection




