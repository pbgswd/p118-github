@extends('layouts.dashboard',  ['title_icon' => ' <i class="fas fa-edit"></i>', 'title' => $data["action"]. ' Employer Contacts ' .
    ($data["action"] == 'Edit' ? $data['contactlist']->title : '') ])
@section('content')
    @include('admin.admin_partials.admin_tinymce')
<div class="container">
    <div class="row my-4">
        <div class="col-12 col-md-3">
            <h4>
                <a href="{{ route('contactlistdata_list') }}">
                    <i class="far fa-arrow-alt-circle-left"></i>
                    bla bla go back
                </a>
            </h4>
        </div>
        @if ($data['action'] == 'Edit')
            <div class="col-12 col-md-3 text-md-right">
                <h4>
                    <a href="{{route('post_show', $data['contactlist']->slug)}}"
                       title="View {{$data['contactlist']->title}}">
                        <i class="fas fa-eye"></i> View on website
                    </a>
                </h4>
            </div>
            @if($data['existing_message'] === false)
                <div class="col-12 col-md-3 text-md-right">
                    <h4>
                        <a href="{{route('admin_post_message', $data['contactlist']->slug)}}">
                            <i class="far fa-envelope-open"></i>
                            Send as a message
                        </a>
                    </h4>
                </div>
            @endif
            <div class="col-12 col-md-3 text-md-right">
                <h4>
                    <a href="{{route('admin_post_feature', $data['contactlist']->slug)}}">
                        <i class="far fa-envelope-open"></i>
                        Send to Feature
                    </a>
                </h4>
            </div>
        @endif
    </div>
    <form method="post" name="post" action="{{url()->current()}}" enctype="multipart/form-data"
          class="needs-validation" novalidate>
        {!! csrf_field() !!}
        <div class="row">
            <div class="col-12 mt-2">
                <h4>Title</h4>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <input type="text" class="form-control"  placeholder="Title" name="post[title]"
                           value="{{ old('contactlist.title', $data['contactlist']->title)}}" size="80" required/>
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
                                <textarea name="post[content]" id="textarea" placeholder="Content" class="form-control text-black">
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
                            var textarea = @json($data['contactlist']->content ?? '');
                            var textarea1 = @json($data['textarea1'] ?? '');
                        </script>
                        <script type="module" src="{{mix('js/admin/ckeditor5/ck_main_admin.js')}}"></script>
                    </div>
                </div>
            </div>
        <div class="row mt-3 mb-2 pb-2 pt-2">
            <div class="col-12 col-md-4 text-md-right">
                <h4>Access Level for content</h4>
            </div>
            <div class="col-12 col-md-5 text-left">
                <div class="form-group">
                    {{ select_options($data['access_levels'], old('contactlist.access_level',
                        $data['contactlist']->access_level), ['name' => 'post[access_level]',
                        'class' => 'form-control']) }}
                </div>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-12 col-md-4 text-md-right">
                <h4>Status</h4>
            </div>
            <div class="col-12 col-md-6">
            <div class="d-flex flex-row pl-2 pr-2 mr-2">
                <div class="p-2">
                    <label>
                        <input name="post[front_page]" type="hidden" value="0" />
                        <input name="post[front_page]" type="checkbox" value="1"
                            {{ checked(old('post.front_page',$data['contactlist']->front_page ?? 0)) }} /> Front Page
                    </label>
                </div>
                <div class="p-2">
                    <label>
                        <input name="post[landing_page]" type="hidden" value="0" />
                        <input name="post[landing_page]" type="checkbox" value="1"
                            {{ checked(old('post.landing_page', $data['contactlist']->landing_page ?? 0)) }} />
                        Landing Page
                    </label>
                </div>
                <div class="p-2">
                    <label>
                         <input name="post[live]" type="hidden" value="0" />
                         <input name="post[live]" type="checkbox" value="1"
                             {{ checked( old('post.live', $data['contactlist']->live)) }} /> Check now to make Live
                    </label>
                    <p>ie.: Draft or Published.</p>
                </div>
            </div>
        </div>
        <div class="row mt-3 mb-3">
            <div class="col-12">
                <h2>Files</h2>
                <div class="form-group">
                    <label for="exampleInputFile">
                        <i class="fas fa-cloud-upload-alt fa-2x"></i>
                        Add File(s) To Page
                    </label>
                    <input type="file" id="inputFile" name="attachments[]" multiple />
                </div>
            </div>
        </div>

        <div class="row m-0 mt-5 mb-5 p-0 pb-0">
            <div class="col text-left">
                <i class="fas fa-edit fa-2x"></i>
                <input class="btn btn-outline-primary" type="submit" value="{{ $data['action'] }}" />
            </div>
    </form>
            @if ($data['action'] == 'Edit')
                 <div class="col text-right">

                 </div>
            @endif
    </div>
@endsection
