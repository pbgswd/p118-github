<?php
$post = $data['post'];
$committee = $data['post']['committee'];
//dd($post);
?>
@extends('layouts.dashboard',  ['title' => ' <i class="fas fa-edit"></i>' . $data["action"] . ' post ' . ($data["action"] == 'Edit' ? $post->title : ' in ' . $committee->name) ])
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
<div class="container">
    <h3>
        <a href="{{route('committee_show', $committee->slug)}}">
            <i class="far fa-arrow-alt-circle-left"></i>
            {{$committee->name}} Committee Page
        </a> |
        <a href="{{ route('committee_posts_list', $committee->slug) }}">
            <i class="far fa-arrow-alt-circle-left"></i> List of posts
        </a>
    </h3>
    <form method="post" name="post" action="{{ url()->current() }}" enctype="multipart/form-data" class="needs-validation" novalidate>
        {!! csrf_field() !!}
        <div class="row">
            <div class="form-group">
                <div class="col-lg-2"><h4>Title</h4></div>
                <div class="col-lg-10">
                    <input type="text" class="form-control"  placeholder="Title" name="post[title]" value="{{ old('post.title', $post->title)}}" size="80" required/>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <div class="col-lg-2">
                    <h4>Content</h4>
                </div>
                <div class="col-lg-10">
                    <textarea name="post[content]" id="post-content" placeholder="Content" class="form-control">{{old('post.content', $post->content)}}</textarea>
                </div>
            </div>
        </div>
        <div class="row" style="margin-top:30px;"> &nbsp;</div>
        <div class="row">
            <div class="col-md-4">
                <div class="col-lg-2"><h4>Status</h4></div>
                <div class="col-sm">
                    <label>
                        <input name="post[sticky]" type="hidden" value="0" />
                        <input name="post[sticky]" type="checkbox" value="1" {{ checked(old('post.sticky',$post->sticky)) }} /> Sticky (on top)?
                    </label>
                </div>
                <div class="col-sm">
                    <label>
                        <input name="post[allow_comments]" type="hidden" value="0" />
                        <input name="post[allow_comments]" type="checkbox" value="1" {{ checked(old('post.allow_comments', $post->allow_comments)) }} /> Allow Comments
                    </label>
                </div>
                <div class="col-sm">
                    <label>
                         <input name="post[live]" type="hidden" value="0" />
                         <input name="post[live]" type="checkbox" value="1" {{ checked( old('post.live', $post->live)) }} /> Check now to make Live
                    </label>
                    <p>ie.: Draft or Published.</p>
                </div>
            </div>
        </div>
        <div class="row" style="margin-top:30px;">
            <div class="col-sm">
                <i class="fas fa-edit fa-2x"></i>
                <input class="btn btn-outline-primary" type="submit" value="{{ $data['action'] }}" />
            </div>

    </form>

        @if ($data['action'] == 'Edit')

                 <div class="col-sm" style="float:right">
                     <form name="delete" method="POST" action="{{route('committee_post_destroy', $committee->slug  )}}">
                         {!! csrf_field() !!}
                         {!! method_field('DELETE') !!}
                        <i class="far fa-trash-alt fa-2x"></i>
                        <input type="hidden" name="id[]" value="{{ $post->id }}">
                        <input class="btn btn-outline-danger" type="submit" value="Delete">
                    </form>
                 </div>
            </div>
            <div class="row" style="margin-top:3em; margin-bottom: 3em;">
                post added by {{$post->creator->name}}
            </div>
        @endif
    </div>
@endsection
