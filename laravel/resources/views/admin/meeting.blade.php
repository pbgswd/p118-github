<?php
$meeting = $data['meeting'];
?>
@extends('layouts.dashboard',  ['title' => ' <i class="fas fa-edit"></i>' . $data["action"] . ' Meeting ' . ($data["action"] == 'Edit' ? $meeting->name : '') ])
@section('content')
    @include('admin.admin_partials.admin_tinymce')
<div class="container">
    <h3><a href="{{ route('meetings_list') }}"> <i class="far fa-arrow-alt-circle-left"></i> List of meetings</a></h3>
    <form method="post" name="meeting" action="{{ url()->current() }}" enctype="multipart/form-data" class="needs-validation" novalidate>
        {!! csrf_field() !!}
        <div class="row" style="margin-top:30px;"> &nbsp;</div>
        <div class="row">
            <div class="form-group">
                <div class="col-lg-2"><h4>Title</h4></div>
                <div class="col-lg-10">
                    <input type="text" class="form-control"  placeholder="Title" name="meeting[title]" value="{{ old('meeting.title', $meeting->title)}}" size="80" required/>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <div class="col-lg-2"><h4><i class="fas fa-calendar-alt"></i> Date</h4></div>
                <div class="col-lg-10">
                    <input
                        type="text"
                        class="form-control"
                        placeholder="YYYY-MM-DD"
                        name="meeting[date]"
                        value="{{ old('meeting.date', \optional($meeting->date)->toDateString())}}"
                        size="80"
                        data-provide="datepicker"
                        data-date-format="yyyy-mm-dd"
                        required />
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <div class="col-lg-2">
                    <h4>Description</h4>
                </div>
                <div class="col-lg-10">
                    <textarea name="meeting[description]" id="meeting-description" placeholder="Summary content" class="form-control">{{old('meeting.description', $meeting->description)}}</textarea>
                </div>
            </div>
        </div>
        <div class="row mt-lg-2">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="exampleInputFile">
                        <i class="fas fa-cloud-upload-alt fa-2x"></i>
                        Add File(s) To Meeting
                    </label>
                    <input type="file" id="inputFile" name="attachments[]" multiple />
                </div>
            </div>
            <div class="col-md-4">
                <div class="col-2"><h4>Status</h4></div>
                <div class="col-sm">
                    <label>
                        <input name="meeting[live]" type="hidden" value="0" />
                        <input name="meeting[live]" type="checkbox" value="1" {{ checked( old('meeting.live', $meeting->live)) }} /> Check now to make Live
                    </label>
                    <p>ie.: Draft or Published.</p>
                </div>
            </div>
        </div>
        @if ($data['action'] == 'Edit')
            @if(count($meeting->attachments) > 0)
                <div class="col-md-12">
                    <h2>Files</h2>
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th> # </th>
                                <th> File </th>
                                <th> Access Level </th>
                                <th> <i class="far fa-edit"></i> </th>
                                <th> Description </th>
                                <th> Created At </th>
                                <th> Updated At </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($meeting->attachments as $ma)
                                <tr>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="attachment[{{$ma->id}}][id]" value="{{$ma->id}}" />
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="{{route('attachment_download', [$meeting->getAttachmentFolder(), $ma->id])}}" title="Download {{$ma->file_name}}">{{$ma->file_name}}</a>
                                    </td>
                                    <td>
                                        {{$ma->access_level}}
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
                            @endforeach
                            <tr>
                                <td colspan="5">
                                    <i class="far fa-trash-alt"></i> Select checkbox to delete a file
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            @endif
        @endif
        <div class="row mt-lg-3"> &nbsp;</div>
        <div class="row mb-lg-5">
            <div class="col-sm">
                <i class="fas fa-edit fa-2x"></i>
                <input class="btn btn-outline-primary" type="submit" value="{{ $data['action'] }}" />
            </div>
    </form>
            <div class="col-sm"></div>
            @if ($data['action'] == 'Edit')
                 <div class="col-sm" style="float:right">
                     <form name="delete" method="POST" action="{{route('meeting_destroy')}}">
                         {!! csrf_field() !!}
                         {!! method_field('DELETE') !!}
                        <i class="far fa-trash-alt fa-2x"></i>
                        <input type="hidden" name="id[]" value="{{ $meeting->id }}">
                        <input class="btn btn-outline-danger" type="submit" value="Delete Meeting">
                    </form>
                 </div>
            @endif
        </div>
</div>
@endsection
