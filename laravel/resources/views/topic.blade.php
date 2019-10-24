<?php
$topic = $data['topic'];
$tags = join(', ', $topic->tagNames());
$pages = $topic->pages;
?>
@extends('layouts.jumbo')
@section('content')
<div class="jumbotron">
    <div class="container border border-dark rounded-lg" style="background: rgba(220,220,220,0.6); padding:1em;">

        <a href="{{ route('hello') }}">Home/</a>
        <a href="{{route('topics')}}">Topics/</a>{{$topic->name}}/

        <div class="col-12">
            <h1 class="display-3">{{$topic->name}}</h1>
        </div>
        <div class="col-12">
                <h2>{!! $topic->description !!}</h2>
        </div>
        <div class="col-12">
            @if( $topic->image )
                <div class="col-md-6">
                    <div class="col">
                        <img src="{{ asset('storage/'.$topic->image) }}" />
                    </div>
                </div>
            @endif
            {!! $topic->description !!}
        </div>
        <div class="col-12" style="margin: 2px;">
            Tags: {{$tags}}
        </div>
    </div>
    @if (count($pages)  > 0)
        <div class="container border border-dark rounded-lg" style="background: rgba(220,220,220,0.6); padding:1em; margin-top:1em;" >
            <div class="col-12" style="margin: 2px;">
                <h4>Related Pages</h4>
                @foreach($pages as $page)
                    <a href="{{ route('page_show', $page->slug) }}">{{$page['title']}}</a> <br />
                @endforeach
            </div>
        </div>
    @endif
</div>
<div class="row" style="margin-top:6em;"></div>
@endsection
