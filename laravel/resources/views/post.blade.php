<?php
$post = $data['post'];
$tags = join(', ', $post->tagNames());
?>
@extends('layouts.jumbo')
@section('content')
<div class="jumbotron">
    <div class="container border border-dark rounded-lg pt-lg-2" style="background: rgba(220,220,220,0.8);">
        <div class="row">
            @foreach ($post->topics as $topic)
                <div class="col-12">
                <a href="{{route('topics')}}">Topics/</a>
                    <a href="{{ route('topic_show', $topic->slug)}}">{{$topic->name}}/</a>
            </div>
            @endforeach
        </div>
        <div class="row mb-lg-5">
            <div class="col-4 border border-dark rounded-lg">xxx</div>
            <div class="col-8 border border-dark rounded-lg">
                <div class="col-12">
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
            </div>
        </div>
    </div>
</div>
@endsection




