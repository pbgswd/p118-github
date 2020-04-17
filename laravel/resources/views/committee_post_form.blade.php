<?php
$post = $data['post'];
//dd($post);
?>
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
            toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
            content_css: [
                '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
                '//www.tiny.cloud/css/codepen.min.css'
            ]
        });
    </script>

<div class="container  border border-dark rounded-lg p-4" style="background: rgba(220,220,220,0.6);">
    <h3>
        <a href="{{ route('committee', $post['committee']->slug) }}">{{$post['committee']->name}}</a>
     / {{$data['action']}} Post
        @if($data['action'] == "Edit")
            <a href="{{route('committee_post_show', [$post['committee']->slug, $post->slug])}}">{{$post->title}}</a>
            <a href="{{ route('committee', $post['committee']->slug) }}"> <i class="far fa-arrow-alt-circle-left"></i> List of posts</a>
        @endif
    </h3>
    <form method="post" name="post" action="{{ url()->current() }}" enctype="multipart/form-data" class="needs-validation" novalidate>
        {!! csrf_field() !!}
        <div class="row mt-4">
            <div class="col-12">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-default">Title</span>
                        <input type="text" class="form-control"  placeholder="Title" name="post[title]" value="{{ old('post.title', $post->title)}}" size="80" required/>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <div class="col-12">
                    <h4>Content</h4>
                </div>
                <div class="col-12">
                    <textarea name="post[content]" id="post-content" placeholder="Content" class="form-control">{{old('post.content', $post->content)}}</textarea>
                </div>
            </div>
        </div>
        <div class="row mt-lg-3"> &nbsp;</div>
        <div class="row mb-lg-5">
            <div class="col-sm">
                <i class="fas fa-edit fa-2x"></i>
                <input class="btn btn-primary" type="submit" value="{{ $data['action'] }}" />
            </div>
    </form>
    <div class="col-sm"> &nbsp;</div>
    @if ($data['action'] == 'Edit')
         <div class="col-sm" style="float:right">
             <form name="delete" method="POST" action="{{route('public_committee_post_destroy', [$post['committee']->slug, $post->slug])}}">
                 {!! csrf_field() !!}
                 {!! method_field('DELETE') !!}
                <i class="far fa-trash-alt fa-2x"></i>
                <input type="hidden" name="id[]" value="{{ $post->id }}">
                <input class="btn btn-outline-danger" type="submit" value="Delete">
            </form>
         </div>
    @endif
</div>
    @if ( $data['action'] == 'Edit')
        <div class="row mt-lg-3 mb-lg-3"> post added by {{$post->creator->name}}</div>
    @endif
@endsection
