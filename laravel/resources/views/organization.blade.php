@extends('layouts.jumbo')
@section('content')
    <div class="jumbotron">
        <div class="container border border-dark rounded-lg" style="background: rgba(220,220,220,0.8);">
            <div class="row">
                <div class="col-12 col-md-6">
                    <a href="{{route('organizations')}}">
                        Organizations
                    </a>
                </div>
                @can('edit articles')
                    <div class="col-12 col-md-6 text-md-right">
                        <a href="{{route('organization_edit', $data['organization']->slug)}}"
                           title="Edit {{$data['organization']->name}}">
                            <i class="fas fa-edit"></i> Admin Edit
                        </a>
                    </div>
                @endcan
            </div>
            @if($data['organization']->image)
                <div class="row mb-2">
                    <div class="col-12 text-center d-flex align-items-center justify-content-center">
                        <picture>
                            <source srcset="{{asset('storage/public/'. $data['organization']->image)}}"
                                    media="(min-width: 577px)">
                            <img srcset="{{asset('storage/public/'.$data['organization']->thumb)}}"
                                 alt="{{$data['organization']->name}}"
                                 class="rounded img-fluid d-block">
                        </picture>
                    </div>
                </div>
            @endif
            <div class="row mt-2">
                <div class="col-12 text-center">
                    <h1>
                        {{$data['organization']->name}}
                    </h1>
                </div>
            </div>
            @if($data['organization']->url)
                <div class="row mt-2">
                    <div class="col-12 text-center">
                        <p>
                            <a href="{{$data['organization']->url}}" title="{{$data['organization']->name}}"
                               target="_blank">
                                <i class="fas fa-external-link-alt"></i>
                                {{$data['organization']->url}}
                            </a>
                        </p>
                    </div>
                </div>
                <a id="agreements"></a>
            @endif
            <div class="col-12">
                <p>{!! $data['organization']->description !!}</p>
            </div>
            @if ($data['agreements']->count() > 0)
                <div class="col-12 border border-dark rounded-lg mb-3 p-2">

                    <h4>
                        Agreements with {{$data['organization']->name}}
                    </h4>
                    @if($data['agreements']->count() > 1)
                        <h5>
                            Order by: @sortablelink('title', 'Title')| @sortablelink('until', 'End Date')
                        </h5>
                    @endif
                    <ul class="list-group list-group-flush">
                        @foreach($data['agreements'] as $va)
                            <li class="list-group-item">
                                {!! (\Carbon\Carbon::parse($va->until)->isPast()) ? "<i>(Not current)</i>" : '' !!}
                                <a title="View {{ $va->title }}" href="{{route('agreement_show', $va->id)}}">
                                    {{ $va->title }}
                                </a>
                                {{$va->from->format('F j Y')}} - {{$va->until->format('F j Y')}}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if(count($data['organization']->attachments) > 0)
                <div class="col-12 mt-3">
                    <h4>
                        <i class="far fa-folder-open"></i>
                        Files
                    </h4>
                    @foreach ($data['organization']->attachments as $pa)
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <a href="{{route('attachment_download',
                                        [$data['organization']->getAttachmentFolder(), $pa->id])}}"
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
    </div>
@endsection
