@extends('layouts.dashboard',  ['title_icon' => '<i class="fas fa-paperclip"></i>', 'title' => $data['action'] .
    ' File ' . $data['attachment']['file_name']])
@section('content')
    <div class="row mb-3">
        <h4>
        <a href="{{route('attachments_list')}}">
            Back to Images & Attachments</a>
        </h4>
    </div>
    <form method="post" name="attachment" action="{{ url()->current() }}" enctype="multipart/form-data"
          class="needs-validation" novalidate>
        {!! csrf_field() !!}
        @if ($data['action'] == 'Add')
            <div class="col-12 p-4 mt-1">
                <div class="form-group">
                    <h3>
                        <label for="exampleInputFile">
                            <i class="fas fa-cloud-upload-alt fa-3x"></i>
                            File input
                        </label>
                        <input type="file" id="inputFile" name="images[]" multiple/>
                    </h3>
                    <p class="help-block p-4">
                        Upload file to server & database. Insert or attach to content after.
                        You may add many images at once.
                    </p>
                    <h5>Access Level for content:  {{$data['attachment']->access_level}}</h5>
                    <div class="form-group">
                        {{ select_options($data['access_levels'],
                            old('attachment.access_level', $data['attachment']->access_level),
                            ['name' => 'attachment[access_level]', 'class' => 'form-control',
                            'placeholder' => 'Access Level'], 'required') }}
                    </div>
                </div>
            </div>
        @else
            @if(!in_array($data['attachment']->extension, ['jpg', 'jpeg', 'png', 'gif']))
                <div class="row">
                    <div class="col-md-4">
                        {!! $data['attachment']->extension == 'pdf' ? '<i class="far fa-file-pdf fa-8x"></i>' :
                            '<i class="far fa-file fa-8x"></i>' !!}
                    </div>
                    <div class="col-md-8 text-wrap">
                        <h2>
                            <i class="fas fa-info-circle"></i>
                            File Info
                        </h2>
                        <ul class="list-group-flush">
                            <li class="list-group-item">Location:
                                <a href="{{env('APP_URL') .'/storage/'. $data['attachment']->subfolder .'/'.
                                    $data['attachment']['file']}}" target="_blank">{{env('APP_URL') .'/storage/'.
                                    $data['attachment']->subfolder .'/'. $data['attachment']['file']}}
                                </a>
                            </li>
                            <li class="list-group-item">File Size: {{$data['attachment']->filesize}}</li>
                            <li class="list-group-item">Original File Name: {{$data['attachment']['file_name']}}</li>
                            <li class="list-group-item">Uploaded File Name: {{$data['attachment']['file']}}</li>
                            <li class="list-group-item">
                                <a href="{{route('attachment_download', [$data['attachment']->subfolder,
                                   $data['attachment']->id])}}"
                                   title="Download {{$data['attachment']->file_name}}">
                                    {!! $data['attachment']->extension == 'pdf' ?
                                        '<i class="far fa-file-pdf fa-4x"></i>' :
                                        '<i class="fas fa-file-download fa-4x"></i>' !!}
                                    Download {{$data['attachment']['file_name']}}
                                </a>
                            </li>
                            <li class="list-group-item">File Type: {{$data['attachment']->extension}}</li>
                            <li class="list-group-item">
                                Last Updated: {{$data['attachment']->updated_at->format('F j Y H:i:s')}}
                            </li>
                        </ul>
                    </div>
                </div>
                @include('admin.admin_partials.attachment_description_access_level_form_elements')
                <div class="row">
                    <div class="col-12 mt-4 mb-3">
                        <h4>
                            To embed the file in content, insert into html source code of the content field of pages,
                            posts, topics etc. with:
                        </h4>
                    </div>
                    <div class="col-12 col-md-6">
                        <h4>Code</h4>
<pre>
    <code>
    &lt;a href={{env('APP_URL')}}/{{$data['attachment']->subfolder}}/download/{{$data['attachment']['id']}}"
            title="Download {!! $data['attachment']['file_name'] !!}"
            target="_blank" /&gt;
        {{$data['attachment']->extension == 'pdf' ? '<i class="far fa-file-pdf fa-4x"></i>' :
            '<i class="far fa-file fa-4x"></i>' }}
          {{$data['attachment']->description ? : $data['attachment']->file_name}}
        &lt;/a&gt;
    </code>
</pre>
                    </div>
                    <div class="col-12 col-md-6">
                        <h4>...which will appear on the page like this:</h4>
                        <a href="{{env('APP_URL') .'/'. $data['attachment']->subfolder .'/download/'.
                            $data['attachment']['id']}}"
                           title="Download {{$data['attachment']['file_name']}}" target="_blank" />
                            {!! $data['attachment']->extension == 'pdf' ? '<i class="far fa-file-pdf fa-4x"></i>' :
                                '<i class="far fa-file fa-4x"></i>' !!}
                            {{$data['attachment']->description ? : $data['attachment']->file_name}}
                        </a>
                    </div>
                </div>
            @else
                <div class="row">
                    <div class="col-12 col-md-6">
                        <img class="border rounded m-1 img-fluid"
                              src="{!! asset('storage/' .
                                $data['attachment']->subfolder . "/" . $data['attachment']['file']) .'"' !!}}"/>
                    </div>
                    <div class="col-12 col-md-6">
                        <h3>
                            <i class="far fa-file-image"></i>
                            Image Info
                        </h3>
                        <ul class="list-group-flush">
                            <li class="list-group-item">Location:
                                <a href="{{env('APP_URL') .'/storage/'. $data['attachment']->subfolder .'/'.
                                    $data['attachment']['file']}}" target="_blank">
                                    {{env('APP_URL') .'/storage/'.
                                    $data['attachment']->subfolder .'/'. $data['attachment']['file'] }}
                                </a>
                            </li>
                            <li class="list-group-item">File Size: {{$data['attachment']->filesize}}</li>
                            <li class="list-group-item">Original File Name: {{$data['attachment']['file_name']}}</li>
                            <li class="list-group-item">
                                <a href="{{route('attachment_download', [$data['attachment']->subfolder,
                                    $data['attachment']->id])}}"
                                   title="Download {{$data['attachment']->file_name}}">
                                    <i class="fas fa-file-download"></i>
                                    Download {{$data['attachment']['file_name']}}
                                </a>
                            </li>
                            <li class="list-group-item">Uploaded File Name: {{$data['attachment']['file']}}</li>
                            <li class="list-group-item">File Type: {{$data['attachment']->extension}}</li>
                            <li class="list-group-item">Width: {{$data['attachment']->imagedata[0]}} px</li>
                            <li class="list-group-item">Height: {{$data['attachment']->imagedata[1]}} px</li>
                            <li class="list-group-item">Mime Type: {{$data['attachment']->imagedata['mime']}}</li>
                            <li class="list-group-item">
                                Last Updated: {{$data['attachment']['updated_at']->format('F j Y H:i:s')}}
                            </li>
                        </ul>
                    </div>
                </div>
                @include('admin.admin_partials.attachment_description_access_level_form_elements')
                <div class="row">
                    <div class="col-12 mt-3 mb-1">
                        <h4>Insert into content with:</h4>
<pre>
    <code>
&lt;img src="/storage/{{$data['attachment']->subfolder}}/{{$data['attachment']['file']}}" class="border rounded m-1 img-fluid" /&gt;
    </code>
</pre>
                    </div>
                </div>
                @endif
        @endif
        <div class="row mt-3 mb-5 p-4">
            <div class="col-12 col-md-6">
                <i class="fas fa-edit fa-2x"></i>
                <input class="btn btn-outline-primary" type="submit" value="{{ $data['action'] }}" />
            </div>
    </form>
        @if ($data['action'] == 'Edit')
            <div class="col-12 col-md-6" style="float:right">
                <form name="delete" method="POST" action="{{route('attachment_destroy')}}">
                    {!! csrf_field() !!}
                    {!! method_field('DELETE') !!}
                    <i class="far fa-trash-alt fa-2x"></i>
                    <input type="hidden" name="id[]" value="{{ $data['attachment']->id }}">
                    <input class="btn btn-outline-danger" type="submit" value="Delete">
                </form>
            </div>
        @endif
@endsection
