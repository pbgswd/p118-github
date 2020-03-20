<?php
$post = $data['post'];
$tags = join(', ', $post->tagNames());
?>
@extends('layouts.jumbo')
@section('content')
<div class="jumbotron">
    <div class="container border border-dark rounded-lg pt-lg-2" style="background: rgba(220,220,220,0.6);">
        <div class="row">
            @foreach ($post->topics as $topic)
                <a href="{{ route('hello') }}">Home /</a>
                &nbsp;<a href="{{route('topics')}}">Topics /</a>
                &nbsp;<a href="{{ route('topic_show', $topic->slug) }}">{{$topic->name}} /</a>
                &nbsp; {{$post->title}}
            @endforeach
        </div>
        <div  class="col-12">
            <h1 class="display-5">{{$post->title}}</h1>
        </div>
        <div class="col-12">
            <h3>{!! $post->description !!}</h3>
        </div>
        <div class="col-12">
            {!! $post->content !!}
         </div>
        @if(count($post->attachments) > 0)
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
                    @foreach ($post->attachments as $pa)
                        <tr>
                            <td>
                                <a href="{{route('attachment_download', [$post->getAttachmentFolder(), $pa->id])}}" title="Download {{$pa->file_name}}">{{$pa->file_name}}</a>
                            </td>
                            <td>
                                {{ $pa->description}}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        @if ($tags != '')
            <div class="row">
                Tags: {{$tags}}
            </div>
        @endif
        <div class="row">
            <a href="{{route('posts')}}">Posts /</a> &nbsp;
                {{$post->title}}
        </div>
    </div>
    <div class="row mt-lg-5"></div>
</div>
@endsection




