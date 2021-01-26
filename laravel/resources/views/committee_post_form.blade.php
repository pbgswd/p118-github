@extends('layouts.jumbo',  ['title' => ' <i class="fas fa-edit"></i>' . $data["action"] . 'post' ])
@section('content')
    <script>
        tinymce.init({
            mode: 'textareas',
            height: 200,
            width:800,
            menubar: false,
            plugins: [
                'advlist autolink lists link image charmap print preview anchor textcolor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table paste code help wordcount'
            ],
            toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify |' +
                ' bullist numlist outdent indent | removeformat | help',
            content_css: [
                '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
                '//www.tiny.cloud/css/codepen.min.css'
            ]
        });
    </script>
<div class="container border border-dark rounded-lg mt-3 mb-3" style="background: rgba(220,220,220,0.8);">
    <div class="row d-flex justify-content-around">

        <div class="col-12 col-md-6">
            <h3>
                <a href="{{ route('committee', $data['post']['committee']->slug) }}">
                    {{$data['post']['committee']->name}}
                </a>
            </h3>
        </div>
        <div class="col-12 col-md-6">
            <h3>
                {{$data['action']}} Post
                @if($data['action'] == "Edit")
                    <a href="{{route('public_committee_post_show',
                        [$data['post']['committee']->slug, $data['post']->slug])}}">
                        {{$data['post']->title}}
                    </a>
                @endif
            </h3>
        </div>
    </div>

    <form method="post" name="post" action="{{ url()->current() }}" enctype="multipart/form-data"
          class="needs-validation" novalidate>
        {!! csrf_field() !!}

            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-default">Title</span>
                <input type="text" class="form-control"  placeholder="Title" name="post[title]"
                       value="{{ old('post.title', $data['post']->title)}}" size="80" required/>
            </div>


            <label for="post-content" class="control-label">
                <h4>Content</h4>
            </label>

        <div class="col-12 mb-3 input-group">
            <textarea name="post[content]" id="post-content" placeholder="Content" class="form-control">
                {{old('post.content', $data['post']->content)}}
            </textarea>
        </div>

        <div class="row d-flex justify-content-between">
            <div class="col-md-6 col-sm-12 mb-lg-3">
                <i class="fas fa-edit fa-2x"></i>
                <input class="btn btn-primary" type="submit" value="{{ $data['action'] }}" />
            </div>
    </form>

    @if ($data['action'] == 'Edit')
        <div class="col-md-6 col-sm-12 mb-lg-3">
             @can('manage committee')
                 <form name="delete" method="POST" action="{{route('public_committee_post_destroy',
                    [$data['post']['committee']->slug, $data['post']->slug])}}">
                     {!! csrf_field() !!}
                     {!! method_field('DELETE') !!}
                    <i class="far fa-trash-alt fa-2x"></i>
                    <input type="hidden" name="id[]" value="{{ $data['post']->id }}">
                    <input class="btn btn-outline-danger" type="submit" value="Delete">
                </form>
             @endcan
         </div>
    @endif
</div>
    @if ( $data['action'] == 'Edit')
        <div class="row mt-3 mb-3">
            Post added by {{$data['post']->creator->name}}
        </div>
    @endif
</div>

@endsection
