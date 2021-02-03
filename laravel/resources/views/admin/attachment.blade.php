<?php
$attachment = $data['attachment'];
?>
@extends('layouts.dashboard',  ['title' => '<i class="fas fa-paperclip"></i> ' . $data['action'] . ' File'])
@section('content')
    <div class="row mb-3">
        <a href="{{route('attachments_list')}}">Back to Images & Attachments</a>
    </div>
    <form method="post" name="attachment" action="{{ url()->current() }}" enctype="multipart/form-data"
          class="needs-validation" novalidate>
        {!! csrf_field() !!}
        @if ($data['action'] == 'Add')
        <div class="col-md-8 border border-primary rounded p-lg-4 mt-lg-1">
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
                Access Level for content: {{$attachment->access_level}}
                <div class="form-group">
                    {{ select_options($data['access_levels'], old('attachment.access_level', $attachment->access_level),
                            ['name' => 'attachment[access_level]', 'class' => 'form-control',
                            'placeholder' => 'Access Level'], 'required') }}
                </div>
            </div>
        </div>
        @else

            @if(!in_array($attachment->extension, ['jpg', 'jpeg', 'png', 'gif']))
                <div class="row">
                    <div class="col-md-2">
                        @if($attachment->extension == 'pdf')
                            <i class="far fa-file-pdf fa-8x"></i>
                        @else
                            <i class="far fa-file fa-8x"></i>
                        @endif
                    </div>
                    <div class="col-md-8 text-wrap">
                        <h2>File Info</h2>
                        <p>
                            <ul style="line-height: 1.6; list-style-type: none;">
                                <li>Location: <a href="{{env('APP_URL')}}/storage/{{$attachment->subfolder}}/
                                        {{$attachment['file']}}" target="_blank">{{env('APP_URL')}}/storage/
                                        {{$attachment->subfolder}}/{{$attachment['file']}}
                                    </a>
                                </li>
                                <li>File Size: {{$attachment->filesize}}</li>
                                <li>Original File Name: {{$attachment['file_name']}}</li>
                                <li>Uploaded File Name: {{$attachment['file']}}</li>
                                <li>
                                    <a href="{{route('attachment_download', [$attachment->subfolder, $attachment->id])
                                            }}" title="Download {{$attachment->file_name}}">
                                        @if($attachment->extension == 'pdf')
                                            <i class="fas fa-file-pdf fa-4x"></i>
                                        @else
                                            <i class="fas fa-file-download fa-4x"></i>
                                        @endif
                                        Download {{$attachment['file_name']}}</a>
                                </li>
                                <li>File Type: {{$attachment->extension}}</li>
                                <li>Last Updated: {{$attachment->updated_at->format('F j Y H:i:s')}}</li>
                            </ul>
                        </p>
                    </div>
                    <div class="col-md-8 mt-lg-3">
                        Description:
                            <input type="text" class="form-control"  placeholder="Add a description for this file"
                                   name="attachment[description]" value="{{ old('attachment.description',
                                    $attachment->description)}}" size="40"/>
                    </div>
                    <div class="col-md-8 mt-lg-3">
                        Access Level for attachment:
                            <div class="form-group">
                                {{ select_options($data['access_levels'], old('attachment.access_level',
                                    $attachment->access_level), ['name' => 'attachment[access_level]',
                                    'class' => 'form-control', 'placeholder' => 'Access Level'], 'required') }}
                            </div>
                    </div>
                    <div class="col-md-8 mt-lg-4">
                        <h4>Insert into content of pages, posts, topics, or other descriptions with:</h4>

<pre>
    <code>
    @if($attachment['extension'] == 'pdf')
    &lt;i class="far fa-file-pdf fa-8x"&gt;&lt;/i&gt;
    @else
    &lt;i class="far fa-file fa-8x"&gt;&lt;/i&gt;
    @endif
    &lt;a href={{env('APP_URL')}}/{{$attachment->subfolder}}/download/{{$attachment['id']}}" target="_blank" /&gt;
          {{env('APP_URL')}}/{{$attachment->subfolder}}/download/{{$attachment['id']}}
        &lt;/a&gt;
    </code>
</pre>
                    </div>
                </div>
                <div class="col-md-2"></div>
            @else
                <div class="row">
                    <div class="col-md-6 mb-lg-1">
                        <img src="{!! asset('storage/' . $attachment->subfolder . "/" . $attachment['file']) . '"' !!}}
                            {!! $attachment->imagedata[3] ?? '' !!}}"/>

                    </div>
                    <div class="col-md-12 mt-lg-3 ml-lg-2">
                        <h3><i class="far fa-file-image"></i> Image Info</h3>
                        <ul>
                            <li>Location: <a href="{{env('APP_URL')}}/storage/{{$attachment->subfolder}}/
                                    {{$attachment['file']}}" target="_blank">{{env('APP_URL')}}/storage/
                                    {{$attachment->subfolder}}/{{$attachment['file']}}
                                </a>
                            </li>
                            <li>File Size: {{$attachment->filesize}}</li>
                            <li>Original File Name: {{$attachment['file_name']}}</li>
                            <li>
                                <a href="{{route('attachment_download', [$attachment->subfolder, $attachment->id])}}"
                                   title="Download {{$attachment->file_name}}"><i class="fas fa-file-download"></i>
                                    Download {{$attachment['file_name']}}
                                </a>
                            </li>
                            <li>Uploaded File Name: {{$attachment['file']}}</li>
                            <li>File Type: {{$attachment->extension}}</li>
                            <li>Width: {{$attachment->imagedata[0]}} px</li>
                            <li>Height: {{$attachment->imagedata[1]}} px</li>
                            <li>Mime Type: {{$attachment->imagedata['mime']}}</li>
                            <li>Last Updated: {{$attachment['updated_at']->format('F j Y H:i:s')}}</li>
                        </ul>
                    </div>
                    <div class="col-md-12 mb-lg-1">
                        Description
                        <input type="text" class="form-control"  placeholder="Add a description for this file"
                               name="attachment[description]" value="{{ old('attachment.description',
                                $attachment->description)}}" size="40"/>
                    </div>
                    <div class="col-md-12 mt-lg-3 mb-lg-1">
                        Access Level for content:
                        <div class="form-group">
                            {{ select_options($data['access_levels'], old('attachment.access_level',
                                    $attachment->access_level), ['name' => 'attachment[access_level]',
                                    'class' => 'form-control'], 'required') }}
                        </div>

                        <h4>Insert into content with:</h4>
<pre>
    <code>
&lt;img src="/storage/{{$attachment->subfolder}}/{{$attachment['file']}}" style="padding:1em;" /&gt;
    </code>
</pre>
                    </div>
                </div>
                @endif
        @endif
        <div class="row mt-1 mb-lg-5">
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
