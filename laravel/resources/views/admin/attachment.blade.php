<?php
$attachment = $data['attachment'];
?>
@extends('layouts.dashboard',  ['title' => '<i class="fas fa-paperclip"></i> ' . $data['action'] . ' File'])
@section('content')
    <form method="post" name="attachment" action="{{ url()->current() }}" enctype="multipart/form-data" class="needs-validation" novalidate>
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
                    Upload file to server & database. Insert or attach to content after.
                    You may add many images at once.
                </p>
            </div>
        </div>
        @else
            @if(!in_array($attachment['extension'], ['jpg', 'jpeg', 'png', 'gif']))
                <div class="row">
                    <div class="col-md-2">
                        @if($attachment['extension'] == 'pdf')
                        <i class="far fa-file-pdf fa-8x"></i>
                        @else
                            <i class="far fa-file fa-8x"></i>
                        @endif
                    </div>
                    <div class="col-md-8 text-wrap">
                        <ul>
                            <li>Location: <a href="{{env('APP_URL')}}/storage/{{$attachment['name']}}" target="_blank">{{env('APP_URL')}}/storage/{{$attachment['name']}}</a></li>
                            <li>File Size: {{$attachment['filesize']}}</li>
                            <li>File Type: {{$attachment['extension']}}</li>
                            <li>Last Updated: {{$attachment['updated_at']}}</li>
                        </ul>
                        <h4>Insert into content with:</h4>
<pre>
<code>
@if($attachment['extension'] == 'pdf')
&lt;i class="far fa-file-pdf fa-8x"&gt;&lt;/i&gt;
@else
&lt;i class="far fa-file fa-8x"&gt;&lt;/i&gt;
@endif
&lt;a href="{{env('APP_URL')}}/storage/{{$attachment['name']}} target="_blank" /&gt;
    {{env('APP_URL')}}/storage/{{$attachment['name']}}
&lt;/a&gt;
</code>
</pre>
                    </div>
                    <div class="col-md-2"></div>
                </div>
            @else
                <div class="row">
                    <div class="col-md-6" style="margin-bottom: 1em;">
                        <img src="{{ asset('storage/' . $attachment['name']) }}" {{$attachment['imageData'][3]}} />
                    </div>


                    <div class="col-md-6" style="margin-left:2em;">
                        <h3>Image Info</h3>
                        <ul>
                            <li>Location: <a href="{{env('APP_URL')}}/storage/{{$attachment['name']}}" target="_blank">{{env('APP_URL')}}/storage/{{$attachment['name']}}</a></li>
                            <li>File Size: {{$attachment['filesize']}}</li>
                            <li>Width: {{$attachment['imageData'][0]}} px</li>
                            <li>Height: {{$attachment['imageData'][1]}} px</li>
                            <li>Mime Type: {{$attachment['imageData']['mime']}}</li>
                            <li>Last Updated: {{$attachment['updated_at']}}</li>
                        </ul>
                        <h4>Insert into content with:</h4>
<pre>
    <code>
&lt;img src="{{env('APP_URL')}}/storage/{{$attachment['name']}}" style="padding:1em;" /&gt;
    </code>
</pre>
                    </div>
                </div>
                @endif
        @endif
        <div class="row" style="margin-top:1em;">
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

<div class="row" style="margin-top:3em;"> &nbsp;</div>
@endsection
