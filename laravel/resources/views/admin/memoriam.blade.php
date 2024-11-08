@extends('layouts.dashboard',  ['title_icon' => ' <i class="fas fa-edit"></i>', 'title' => $data["action"] .
    ' Memoriam ' . ($data["action"] == 'Edit' ? $data['memoriam']->title : '') ])
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
                <div class="col-12 mt-3">
                    <h4>Title</h4>
                    <p>Normally, a name</p>
                </div>
                <div class="col-12">
                    <input type="text" class="form-control"  placeholder="Title" name="memoriam[title]"
                           value="{{ old('memoriam.title', $data['memoriam']->title)}}" size="80" required/>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <div class="col-12 mt-3">
                    <h4>Content</h4>
                </div>
                <div class="col-12">
                    <div class="col-12 mb-4">
                        <div class=" col editor-container editor-container_classic-editor" id="editor-container">
                            <div class="editor-container__editor">
                                <textarea name="memoriam[content]" id="textarea" placeholder="Content" class="form-control text-black">
                                </textarea>
                            </div>
                        </div>
                    </div>
                    <script type="importmap">
                        {
                            "imports": {
                                "ckeditor5": "/js/ckeditor5/ckeditor5.js",
                                "ckeditor5/": "/js/ckeditor5/"
                            }
                        }
                    </script>
                    <script>
                        var textarea = @json($data['memoriam']->content ?? '');
                        var textarea1 = @json($data['textarea1'] ?? '');
                    </script>
                    <script type="module" src="{{mix('js/admin/ckeditor5/ck_main_admin.js')}}"></script>
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
            <div class="col-12 mt-3">
                <h4>Status of post</h4>
            </div>
            <div class="col-12">
                <input name="memoriam[live]" type="hidden" value="0" />
                 <div class="form-check">
                    <input class="form-check-input" name="memoriam[live]" type="checkbox" value="1"
                           id="flexCheckDefault"  {{ checked( old('memoriam.live', $data['memoriam']->live)) }}
                    >
                    <label class="form-check-label" for="flexCheckDefault">
                        Check to make Memoriam live.
                    </label>
                </div>
            </div>
        </div>
        <div class="row mt-5">
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
                        <input type="hidden" name="id[]" value="{{ $data['memoriam']->id }}">
                        <input class="btn btn-outline-danger" type="submit" value="Delete">
                    </form>
                </div>
            @endif
        </div>
</div>
@endsection
