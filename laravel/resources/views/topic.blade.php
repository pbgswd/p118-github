<?php
$topic = $data['topic'];
//$tags = join(', ', $topic->tagNames());
$pages = $topic->pages;
$posts = $topic->posts;
?>
@extends('layouts.jumbo')
@section('content')
<div class="jumbotron">
    <div class="container border border-dark rounded-lg p-1" style="background: rgba(220,220,220,0.6);">
        <div class="col-12">
            <h1 class="display-3">{{$topic->name}}</h1>
            <a href="{{route('topics')}}">Topics /</a> {{$topic->name}}
        </div>
        <div class="col-12">
            <h2>{!! $topic->description !!}</h2>
            {!! $topic->description !!}
        </div>
        <div class="row p-lg-4">
            @if (count($pages) > 0)
                <div class="col-6">
                    <div class="col-12 border border-dark rounded-lg p-1 mr-1">
                        <h4>Pages in {{$topic->name}}</h4>
                    </div>
                    @foreach($pages as $page)
                        <div class=" border border-dark rounded-lg p-1 mr-1 mt-1" style="background: rgba(220,220,220,0.6);">
                            <a href="{{ route('page_show', $page->slug) }}">{{$page['title']}}</a>
                            {!! $page['description'] !!}
                        </div>
                    @endforeach
                </div>
            @endif
            @if (count($posts) > 0)
                <div class="col-6">
                    <div class="col-12 border border-dark rounded-lg p-1">
                        <h4>Posts in {{$topic->name}}</h4>
                    </div>
                    @foreach($posts as $post)
                        <div class=" border border-dark rounded-lg p-1 mr-1 mt-1" style="background: rgba(220,220,220,0.6);">
                            <a href="{{ route('post_show', $post->slug) }}">{{$post['title']}}</a>
                            {!! $post['description'] !!}
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        @if(count($topic->attachments) > 0)
            <div class="col-md-12">
                <h4>Files</h4>
                <table class="table table-striped table-sm">
                    <thead>
                    <tr>
                        <th> File </th>
                        <th> Description </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($topic->attachments as $ta)
                        <tr>
                            <td>
                                <a href="{{route('attachment_download', [$topic->getAttachmentFolder(), $ta->id])}}" title="Download {{$ta->file_name}}">{{$ta->file_name}}</a>
                            </td>
                            <td>
                                {{ $ta->description}}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
<div class="row mt-lg-5"></div>
@endsection
