@extends('layouts.jumbo')
@section('content')
    <div class="container mt-3 mb-3 pt-2 border border-dark rounded mx-1 mx-auto" style="background: rgba(220,220,220,0.8);">
        <div class="row mb-2">
            <div class="col-12 col-md-6">
                <p>
                    <i>
                        @foreach($data['page']->topics as $pt)
                            <a href="{{route('topic_show', $pt->slug)}}"
                               title="{{$pt->name}}">{{$pt->name}}{{$loop->last ? '' : ','}}</a>
                        @endforeach
                    </i>
                </p>
            </div>
            @can(['edit articles'])
                <div class="col-12 col-md-6 text-end">
                    <a href="{{route('page_edit', $data['page']->slug)}}" title="Edit {{$data['page']->title}}">
                        <i class="fas fa-edit"></i> Admin Edit
                    </a>
                </div>
            @endcan
        </div>
        <div  class="col-12">
            <h1 class="text-center mb-2">{{$data['page']->title}}</h1>
        </div>
        <div class="col-12">
            {!! $data['page']->content !!}
        </div>
        @if(count($data['page']->attachments) > 0)
            <div class="col-12 mt-3 mb-3">
                <h4>
                    <i class="far fa-folder-open"></i>
                    Files
                </h4>
                @foreach ($data['page']->attachments as $pa)
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <a href="{{route('attachment_download',
                                        [$data['page']->getAttachmentFolder(), $pa->id])}}"
                               title="Download {{$pa->file_name}}">
                                <i class="far fa-file"></i>
                                {{$pa->description ? : $pa->file_name}}
                            </a>
                        </li>
                    </ul>
                @endforeach
            </div>
        @endif
    </div>
@endsection
