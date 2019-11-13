<?php
$attachment = $data['attachment'];
?>
@extends('layouts.dashboard',  ['title' => '<i class="fas fa-paperclip"></i> ' . $data['action'] . ' File'])
@section('content')
<div class="container">
    <form method="post" name="attachment" action="{{ url()->current() }}" enctype="multipart/form-data" class="needs-validation" novalidate>
        <input type="hidden" name="attachment[id]" value="{{ $attachment['id'] }}">
        {!! csrf_field() !!}
        @if ($data['action'] == 'Add')
        <div class="col-md-12">
            <div class="form-group">
                <label for="exampleInputFile">
                    <i class="fas fa-cloud-upload-alt fa-2x"></i>
                    File input
                </label>
                <input type="file" id="inputFile" name="images[]" multiple />
                <p class="help-block">
                    Upload file to server & database. Insert or attach to content after. You may add many images at once.
                </p>
            </div>
        </div>
        @else
            <div class="row">
                <div class="col-md-6">
                    <img src="{{ asset('storage/' . $attachment['name']) }}" {{$attachment['imageData'][3]}} />
                </div>
                <div class="col-md-6">
                    <h3>Image Info</h3>
                    <ul>
                        <li>Location: {{env('APP_URL')}}/storage/{{$attachment['name']}}</li>
                        <li>File Size: {{$attachment['filesize']}}</li>
                        <li>Width: {{$attachment['imageData'][0]}} px</li>
                        <li>Height: {{$attachment['imageData'][1]}} px</li>
                        <li>Mime Type: {{$attachment['imageData']['mime']}}</li>
                    </ul>
                    <h4>Insert into content with:</h4>
                    <textarea><img src="{{env('APP_URL')}}/storage/{{$attachment['name']}}" /></textarea>
                </div>
            </div>
        @endif
        <div class="row">
            <div class="col-md-6">
                <i class="fas fa-edit fa-2x"></i>
                <input class="btn btn-outline-primary" type="submit" value="{{ $data['action'] }}" />
            </div>
    </form>
        @if ($data['action'] == 'Edit')
            <div class="col-md-6" style="float:right">
                <form name="delete" method="POST" action="{{route('attachment_destroy')}}">
                    {!! csrf_field() !!}
                    {!! method_field('DELETE') !!}
                    <i class="far fa-trash-alt fa-2x"></i>
                    <input type="hidden" name="id[]" value="{{ $attachment->id }}">
                    <input class="btn btn-outline-danger" type="submit" value="Delete">
                </form>
            </div>
        @endif
    </div>
</div>
<div class="row" style="margin-top:30px;"> &nbsp;</div>
<div class="row" style="margin-top:30px;"> &nbsp;</div>
@endsection
