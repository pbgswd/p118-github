<?php
$attachment = $data['attachment'];
//dd($attachment);

?>
@extends('layouts.dashboard',  ['title' => '<i class="fas fa-paperclip"></i> ' . $data['action'] . ' File'])
@section('content')
    <form method="post" name="attachment" action="{{ url()->current() }}" enctype="multipart/form-data" class="needs-validation" novalidate>
        {!! csrf_field() !!}
        @if ($data['action'] == 'Add')
        <div class="col-md-8 border border-primary rounded p-lg-2">
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
                        <h2><i class="far fa-file"></i> File Info</h2>
                        <h4>
                        <ul style="line-height: 1.6; list-style-type: none;">
                            <li>Location: <a href="{{env('APP_URL')}}/storage/{{$attachment->subfolder}}/{{$attachment['file']}}" target="_blank">{{env('APP_URL')}}/storage/{{$attachment->subfolder}}/{{$attachment['file']}}</a></li>
                            <li>File Size: {{$attachment['filesize']}}</li>
                            <li>Original File Name: {{$attachment['file_name']}}</li>
                            <li>Uploaded File Name: {{$attachment['file']}}</li>
                            <li><a href="{{route('attachment_download', [$attachment->subfolder, $attachment->id])}}" title="Download {{$attachment->file_name}}"><i class="fas fa-file-download fa-4x"></i> Download {{$attachment['file_name']}}</a></li>
                            <li>File Type: {{$attachment['extension']}}</li>
                            <li>Last Updated: {{$attachment['updated_at']}}</li>
                            <li>Description: {{$attachment['description']}}</li>
                        </ul>
                        </h4>
                        <h4>Insert into content with:</h4>
<pre>
<code>
@if($attachment['extension'] == 'pdf')
&lt;i class="far fa-file-pdf fa-8x"&gt;&lt;/i&gt;
@else
&lt;i class="far fa-file fa-8x"&gt;&lt;/i&gt;
@endif
&lt;a href="{{env('APP_URL')}}/storage/{{$attachment->subfolder}}/{{$attachment['file']}}" target="_blank" /&gt;
    {{env('APP_URL')}}/storage/{{$attachment->subfolder}}/{{$attachment['file_name']}}
&lt;/a&gt;
</code>
</pre>
                    </div>
                    <div class="col-md-2"></div>
                </div>
            @else
                <div class="row">
                    <div class="col-md-6 mb-lg-1">
                        <img src="{{ asset('storage/' . $attachment->subfolder . "/" . $attachment['file']) }}" {{$attachment['imageData'][3]}} />
                    </div>
                    <div class="col-md-12 ml" style="margin-left:2em;">
                        <h3><i class="far fa-file-image"></i> Image Info</h3>
                        <ul>
                            <li>Location: <a href="{{env('APP_URL')}}/storage/{{$attachment->subfolder}}/{{$attachment['file']}}" target="_blank">{{env('APP_URL')}}/storage/{{$attachment->subfolder}}/{{$attachment['file']}}</a></li>
                            <li>File Size: {{$attachment['filesize']}}</li>
                            <li>Original File Name: {{$attachment['file_name']}}</li>
                            <li><a href="{{route('attachment_download', [$attachment->subfolder, $attachment->id])}}" title="Download {{$attachment->file_name}}"><i class="fas fa-file-download"></i> Download {{$attachment['file_name']}}</a></li>
                            <li>Uploaded File Name: {{$attachment['file']}}</li>
                            <li>File Type: {{$attachment['extension']}}</li>
                            <li>Width: {{$attachment['imageData'][0]}} px</li>
                            <li>Height: {{$attachment['imageData'][1]}} px</li>
                            <li>Mime Type: {{$attachment['imageData']['mime']}}</li>
                            <li>Last Updated: {{$attachment['updated_at']}}</li>
                        </ul>
                        <h4>Insert into content with:</h4>
<pre>
    <code>
&lt;img src="{{env('APP_URL')}}/storage/{{$attachment->subfolder}}/{{$attachment['file']}}" style="padding:1em;" /&gt;
    </code>
</pre>
                    </div>
                </div>
                @endif
        @endif
        <div class="row mt-1">
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
<div class="row mt-lg-3"> &nbsp;</div>
@endsection
