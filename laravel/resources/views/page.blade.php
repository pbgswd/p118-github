<?php
$page = $data['page'];
$tags = join(', ', $page->tagNames());
?>
@extends('layouts.jumbo')
@section('content')
<div class="jumbotron">
    <div class="container border border-dark rounded-lg" style="background: rgba(220,220,220,0.6); padding: 2em">
        <div class="row">
            @foreach ($page->topics as $topic)
                <a href="{{route('topics')}}">Topics / </a>&nbsp;<a href="{{ route('topic_show', $topic->slug) }}">{{$topic->name}} / </a>&nbsp;
            @endforeach
                {{$page->title}}
        </div>
        <div  class="col-12">
            <h1 class="display-3">{{$page->title}}</h1>
        </div>
        <div class="col-12">
            <h2>{!! $page->description !!}</h2>
        </div>
        <div class="col-12">
            {!! $page->content !!}
         </div>
        @if ($tags != '')
            <div class="row">
                Tags: {{$tags}}
            </div>
        @endif
        <div class="row">
            @foreach ($page->topics as $topic)
                <a href="{{route('topics')}}">Topics / </a>&nbsp; <a href="{{ route('topic_show', $topic->slug) }}">{{$topic->name}} / </a> &nbsp;
            @endforeach
            {{$page->title}}
        </div>
        <div class="row">
            <h6>Added by &nbsp;<a title="{{$page->user->name}}" href="{{route('member', $page->user->id)}}">{{$page->user->name}}</h6>
        </div>
    </div>
<div class="row" style="margin-top:6em;"></div>
</div>
@endsection




