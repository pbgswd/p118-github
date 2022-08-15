@extends('layouts.dashboard',  ['title' => ' <i class="fas fa-edit"></i>' . $data["action"] . ' Memoriam ' .
    ($data["action"] == 'Edit' ? $data['memoriam']->title : '') ])
@section('content')
@include('admin.admin_partials.admin_tinymce')
<div class="container">
    <div class="row">
        <div class="col-12 col-md-6">
            <h3>
                <a href="{{route('admin_memoriam_list')}}">
                    <i class="far fa-arrow-alt-circle-left"></i>
                    List Memoriams
                </a>
            </h3>
        </div>
        @if ($data['action'] == 'Edit')
            <div class="col-12 col-md-6 text-md-right">
                <a href="{{route('memoriam', $data['memoriam']->slug)}}"
                   title="View {{$data['memoriam']->title}}">
                    <i class="fas fa-eye"></i> View on website (edit)
                </a>
            </div>
        @endif
    </div>

    <form method="POST" name="memoriam" action="{{url()->current()}}"
          enctype="multipart/form-data"
          class="needs-validation" novalidate>
        {!! csrf_field() !!}
        <div class="row">
            <div class="form-group">
                <div class="col-12">
                    <h4>Title</h4>
                </div>
                <div class="col-12">
                    <input type="text" class="form-control"  placeholder="Title" name="memoriam[title]"
                           value="{{ old('memoriam.title', $data['memoriam']->title)}}" size="80" required/>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <div class="col-lg-2">
                    <h4>Content</h4>
                </div>
                <div class="col-lg-10">
                <textarea name="memoriam[content]" id="page-content" placeholder="Content" class="form-control">
                    {{old('memoriam.content', $data['memoriam']->content)}}
                </textarea>
                </div>
            </div>
        </div>
        <div class="row mt-lg-3">
            <div class="col-6">
                <div class="form-group">
                    <h4>Date of passing</h4>
                    <input
                        type="text"
                        class="form-control"
                        placeholder="YYYY-MM-DD"
                        name="memoriam[date]"
                        value="{{old('memoriam.date', \optional($data['memoriam']->date)->toDateString())}}"
                        size="10"
                        data-provide="datepicker"
                        data-date-format="yyyy-mm-dd"
                        required />
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <h4>Status</h4>
            </div>
            <div class="col-12">
                <label>
                    <input name="memoriam[live]" type="hidden" value="0" />
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <input name="memoriam[live]" type="checkbox" value="1"
                                {{ checked( old('memoriam.live', $data['memoriam']->live)) }} />
                        </div>
                        <input type="text" class="form-control" aria-label="Text input with checkbox"
                               value="Check to make Memoriam live." size="40" readonly>
                    </div>
                </label>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12">
                <div class="form-group">
                    @if(!isset($data['memoriam']->image))
                        <label for="exampleInputFile">
                            <i class="far fa-file-image fa-2x"></i>
                            <i class="fas fa-cloud-upload-alt fa-2x"></i>
                            Add Primary Image To Memoriam
                        </label>
                        <input type="file" id="inputFile" name="image" />
                    @else
                        <img src="{{ asset('storage/'. $data['folder'] .'/'. $data['memoriam']->image)}}"
                            class="rounded img-fluid w-50 mx-auto" /><br />
                        {{$data['memoriam']->filesize}}<br />
                        <img src="{{ asset('storage/'. $data['folder'] .'/'. $data['memoriam']->thumb) }}"
                             class="rounded img-fluid" /><br />
                        {{$data['memoriam']->thumb_size}} (thumbnail)<br />
                        <input type="hidden" name="memoriam[image]" value="{{$data['memoriam']->image}}" />
                        <input type="hidden" name="memoriam[file_name]" value="{{$data['memoriam']->file_name}}" />
                        <h5>
                            {{$data['filesize'] ?? ''}}
                        </h5>
                        <label for="exampleInputFile">
                            <i class="far fa-trash-alt"></i>
                            Delete Image
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <input name="delete_image" type="checkbox" value="1" />
                                </div>
                                <input type="text" class="form-control" aria-label="Text input with checkbox"
                                       value="Check to delete image." size="40" readonly>
                            </div>

                        </label>
                    @endif
                </div>
            </div>
        </div>
<!---
        <div class="row mt-lg-3">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="exampleInputFile">
                        <i class="fas fa-cloud-upload-alt fa-2x"></i>
                        Add Attachment files
                    </label>
                    <input type="file" id="inputFile" name="attachments[]" multiple />
                </div>
            </div>
        </div>
-->
        <div class="row mt-3 pt-5">
            <div class="col-6">
                <i class="fas fa-edit fa-2x"></i>
                <input class="btn btn-outline-primary" type="submit" value="{{ $data['action'] }}" />
            </div>
    </form>
            @if ($data['action'] == 'Edit')
                <div class="col-6 text-md-right">
                    <form name="delete" method="POST" action="{{route('admin_memoriam_destroy')}}">
                        {!! csrf_field() !!}
                        {!! method_field('DELETE') !!}
                        <i class="far fa-trash-alt fa-2x"></i>
                        <input type="hidden" name="ids[]" value="{{ $data['memoriam']->id }}">
                        <input class="btn btn-outline-danger" type="submit" value="Delete">
                    </form>
                </div>
            @endif
        </div>
</div>
@endsection
