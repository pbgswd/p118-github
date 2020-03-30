<?php

$post = $data['post_comment']->committee_post;
$comment = $data['post_comment'];
$committee = $data['post_comment']['committee'];
//dd($post);
?>
@extends('layouts.dashboard',  ['title' => ' <i class="fas fa-edit"></i>' . $data["action"] . ' post  comment under "' . $post->title . '" in ' . $committee->name ])
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
            {{$committee->name}} Committee
        </a>
<br />
        <a href="{{ route('committee_post_edit',[$committee->slug, $post->slug]) }}" title="Edit {{ $post->title }}">
            <i class="fas fa-edit"></i> Back to {{$post->title}} post page
        </a>
        <br />
        <a href="{{ route('committee_posts_list', $committee->slug) }}">
            <i class="far fa-arrow-alt-circle-left"></i> List of posts
        </a>
    </h3>

    <form method="post" name="comment" action="{{ url()->current() }}" enctype="multipart/form-data" class="needs-validation" novalidate>
        {!! csrf_field() !!}
        <div class="row">
        Comment By: {{$data['post_comment']->comment_author->name}} Created:
            {{ \Carbon\Carbon::parse($data['post_comment']->created_at)->format(' F j, Y H:i:s') }}
        </div>
        <div class="row">
            <div class="form-group">
                <div class="col-lg-2">
                    <h4>Content</h4>
                </div>
                <div class="col-lg-10">
                    <textarea name="comment[content]" id="post-content" placeholder="Content" class="form-control">{{old('post.content', $data['post_comment']->content)}}</textarea>
                </div>
            </div>
        </div>
        <div class="row mt-lg-3"> &nbsp;</div>
        <div class="row">
            <div class="col-md-4">
                <div class="col-lg-2"><h4>Status</h4></div>

                <div class="col-sm">
                    <label>
                         <input name="comment[live]" type="hidden" value="0" />
                         <input name="comment[live]" type="checkbox" value="1" {{ checked( old('comment.live', $data['post_comment']->live)) }} /> Check now to make Live
                    </label>
                    <p>ie.: Draft or Published.</p>
                </div>
            </div>
        </div>
        <div class="row mt-lg-3">
            <div class="col-sm">
                <i class="fas fa-edit fa-2x"></i>
                <input class="btn btn-outline-primary" type="submit" value="{{ $data['action'] }}" />
            </div>
    </form>
        @if ($data['action'] == 'Edit')

                 <div class="col-sm" style="float:right">
                     <form name="delete" method="POST" action="{{route('committee_post_comment_destroy')}}">
                         {!! csrf_field() !!}
                         {!! method_field('DELETE') !!}
                        <i class="far fa-trash-alt fa-2x"></i>
                         <input type="hidden" name="id[]" value="{{$data['post_comment']->id}}">
                        <input class="btn btn-outline-danger" type="submit" value="Delete">
                    </form>
                 </div>
            </div>
    </div>
            <div class="row mt-lg-3 mb-lg-3">
                Post added by {{$post->creator->name}}
            </div>
        @endif

        <div class="h-50"></div>

@endsection
