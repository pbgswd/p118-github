<?php
$topic = $data['topic'];
$tags = join(', ', $topic->tagNames());
$pages = $topic->pages;
$posts = $topic->posts;
?>
@extends('layouts.jumbo')
@section('content')
<div class="jumbotron">
    <div class="container border border-dark rounded-lg" style="background: rgba(220,220,220,0.6); padding:1em;">
        <a href="{{ route('hello') }}">Home /</a>
        <a href="{{route('topics')}}">Topics /</a> {{$topic->name}}
        <div class="col-12">
            <h1 class="display-3">{{$topic->name}}</h1>
        </div>
        <div class="col-12">
                <h2>{!! $topic->description !!}</h2>
        </div>
        <div class="col-12">
            {!! $topic->description !!}
        </div>
        <div class="col-12" style="margin: 2px;">
            Tags: {{$tags}}
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-1"></div>
            @if (count($pages) > 0)
                <div class="col-4 border border-dark rounded-lg" style="background: rgba(220,220,220,0.6); padding:1em; margin-top:1em;">
                    <h4>Related Pages</h4>
                    @foreach($pages as $page)
                        <a href="{{ route('page_show', $page->slug) }}">{{$page['title']}}</a> <br />
                    @endforeach
                </div>
            @endif
            <div class="col-2"></div>
            @if (count($posts) > 0)
                <div class="col-4 border border-dark rounded-lg" style="background: rgba(220,220,220,0.6); padding:1em; margin-top:1em;">
                    <h4>Related Posts</h4>
                    @foreach($posts as $post)
                        <a href="{{ route('post_show', $post->slug) }}">{{$post['title']}}</a> <br />
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
<div class="row" style="margin-top:6em;"></div>
@endsection
