<?php
$meeting = $data['meeting'];
//dd($meeting->attachments);
?>
@extends('layouts.dashboard',  ['title' => ' <i class="fas fa-edit"></i>' . $data["action"] . ' Meeting ' . ($data["action"] == 'Edit' ? $meeting->name : '') ])
@section('content')
    <script>
        tinymce.init({
            selector: 'textarea#meeting-description',
            height: 200,
            width:800,
            menubar: false,
            plugins: [
                'advlist autolink lists link image charmap print preview anchor textcolor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table paste code help wordcount'
            ],
            toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
            content_css: [
                '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
                '//www.tiny.cloud/css/codepen.min.css'
            ]
        });
    </script>
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
                    <input type="text" class="form-control"  placeholder="YYYY-MM-DD" name="meeting[date]" value="{{ old('meeting.date', $meeting->date)}}" size="80" required/>
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
        <div class="row" style="margin-top:2em;"> &nbsp;</div>


            <div class="col-md-12">
                <div class="form-group">
                    <label for="exampleInputFile">
                        <i class="fas fa-cloud-upload-alt fa-2x"></i>
                        Add File(s) To Meeting
                    </label>
                    <input type="file" id="inputFile" name="files[]" multiple />
                    <p class="help-block">
                        Upload file(s) to server & database.
                    </p>
                </div>
            </div>
        @if ($data['action'] == 'Edit')
            <div class="col-md-12">
                <h2>Files</h2>

                @if(count($meeting->attachments) > 0)
                    <table class="table table-striped table-sm">
                            <thead>
                                <tr>
                                    <th> # </th>
                                    <th> File </th>
                                    <th> Description </th>
                                    <th> Created At </th>
                                    <th> Updated At </th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($meeting->attachments as $file)
                                <tr>
                                    <td>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="id[]" value="{{$file->id}}" />
                                        </label>
                                    </div>
                                    </td>
                                    <td>
                                        <a href="#">{{$file->file}}</a>
                                    </td>
                                    <td>
                                        {{$file->description}}
                                    </td>
                                    <td>
                                        {{$file->created_at}}
                                    </td>
                                    <td>
                                        {{$file->updated_at}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        @endif
        <div class="row" style="margin-top:2em;"> &nbsp;</div>
        <div class="row">
            <div class="col-md-4">
                <div class="col-lg-2"><h4>Status</h4></div>

                <div class="col-sm">
                    <label>
                         <input name="meeting[live]" type="hidden" value="0" />
                         <input name="meeting[live]" type="checkbox" value="1" {{ checked( old('meeting.live', $meeting->live)) }} /> Check now to make Live
                    </label>
                    <p>ie.: Draft or Published.</p>
                </div>
            </div>
        </div>
        <div class="row" style="margin-top:30px;"> &nbsp;</div>

        <div class="row">
            <div class="col-sm">
                <i class="fas fa-edit fa-2x"></i>
                <input class="btn btn-outline-primary" type="submit" value="{{ $data['action'] }}" />
            </div>
    </form>

    <div class="col-sm"> &nbsp;</div>
    @if ($data['action'] == 'Edit')
         <div class="col-sm" style="float:right">
             <form name="delete" method="POST" action="{{route('meeting_destroy')}}">
                 {!! csrf_field() !!}
                 {!! method_field('DELETE') !!}
                <i class="far fa-trash-alt fa-2x"></i>
                <input type="hidden" name="id[]" value="{{ $meeting->id }}">
                <input class="btn btn-outline-danger" type="submit" value="Delete">
            </form>
         </div>
    @endif
    <div class="row" style="margin-top:100px;"> &nbsp;</div>
</div>
@endsection
