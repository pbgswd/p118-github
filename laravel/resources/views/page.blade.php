@extends('layouts.jumbo')
@section('content')
    <div class="container mt-3 mb-3 pt-2 border border-dark rounded-lg" style="background: rgba(220,220,220,0.8);">
        <div class="col-12 mb-2">
            <p>
                <i>
                    @foreach($data['page']->topics as $pt)
                        <a href="{{route('topic_show', $pt->slug)}}"
                           title="{{$pt->name}}">{{$pt->name}}{{$loop->last ? '' : ','}}</a>
                    @endforeach
                </i>
            </p>
        </div>
        <div  class="col-12">
            <h1>{{$data['page']->title}}</h1>
            <h2>{!! $data['page']->description !!}</h2>
        </div>
        <div class="col-12">
            {!! $data['page']->content !!}
        </div>
        @if ($data['page']->tagNames != '')
            <div class="col-12">
                Tags: {{join(', ', $data['page']->tagNames())}}
            </div>
        @endif
        @if(count($data['page']->attachments) > 0)
            <div class="col-12 mt-3">
                <h4>
                    <i class="far fa-folder-open"></i>
                    Files
                </h4>
                @foreach ($data['page']->attachments as $pa)
                    <ul class="list-group">
                        <li class="list-group-item">
                            <a href="{{route('attachment_download',
                                            [$data['page']->getAttachmentFolder(), $pa->id])}}"
                               title="Download {{$pa->file_name}}">
                                <i class="far fa-file"></i>
                                {{$pa->description == '' ? $pa->file_name : $pa->description}}
                            </a>
                        </li>
                    </ul>
                @endforeach
            </div>
        @endif
    </div>
@endsection
