@extends('layouts.jumbo')
@section('content')
    <div class="container border border-dark rounded-lg pt-lg-2 mb-3 mt-3" style="background: rgba(220,220,220,0.8);">
        @foreach ($data['post']->topics as $topic)
            <div class="col-12">
                <a href="{{ route('topic_show', $topic->slug)}}">{{$topic->name}}</a>
            </div>
        @endforeach
        <div class="col-12">
            <h1>{{$data['post']->title}}</h1>
        </div>
        <div class="col-12">
            {!! $data['post']->content !!}
        </div>
        @if(!empty($data['post']->tagNames()))
            <div class="col-12 p-2">
                Tags: {{join(', ', $data['post']->tagNames())}}
            </div>
        @endif
        @if(count($data['post']->attachments) > 0)
            <div class="col-12 mt-3">
                <h4>
                    <i class="far fa-folder-open"></i>
                    Files
                </h4>
                <ul class="list-group">
                    @foreach ($data['post']->attachments as $pa)
                        <ul class="list-group-item">
                            <a href="{{route('attachment_download',
                                [$data['post']->getAttachmentFolder(), $pa->id])}}"
                               title="Download {{ $pa->description ?? $pa->file_name}}">
                                <i class="far fa-file"></i>
                                {{ $pa->description != '' ? $pa->description : $pa->file_name}}
                            </a>
                        </ul>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
@endsection




