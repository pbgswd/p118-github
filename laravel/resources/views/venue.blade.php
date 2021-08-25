@extends('layouts.jumbo')
@section('content')
<div class="jumbotron">
    <div class="container border border-dark rounded-lg pb-2" style="background: rgba(220,220,220,0.8);">
        <div class="row mb-3">
            <div class="col-12 col-md-6">
                <a href="{{route('venues')}}">Venues</a>
            </div>
            @can('edit articles')
                <div class="col-12 col-md-6 text-md-right">
                    <a href="{{route('venue_edit', $data['venue']->slug)}}"
                       title="Edit {{$data['venue']->name}}">
                        <i class="fas fa-edit"></i> Admin Edit
                    </a>
                </div>
            @endcan
        </div>
        @if($data['venue']->image)
            <div class="row mb-2">
                <div class="col-12 text-center d-flex align-items-center justify-content-center">
                    <picture>
                        <source srcset="{{asset('storage/public/'. $data['venue']->image)}}" media="(min-width: 577px)">
                        <img srcset="{{asset('storage/public/'.$data['venue']->thumb)}}" alt="{{$data['venue']->name}}"
                             class="rounded img-fluid d-block">
                    </picture>
                </div>
            </div>
        @endif
        <div class="row mb-2">
            <div class="col-12 text-center">
                <h1>{{$data['venue']->name}}</h1>
            </div>
        </div>
        @if($data['venue']->url)
            <div class="row mb-2">
                <div class="col-12 text-center">
                    <p>
                        <a href="{{$data['venue']->url}}" title="{{$data['venue']->name}}" target="_blank">
                            <i class="fas fa-external-link-alt"></i>
                            {{$data['venue']->url}}
                        </a>
                    </p>
                </div>
            </div>
        @endif
        <div class="row">
            <div class="col-12">
                {!! $data['venue']->description !!}
            </div>
        </div>
        @if ($data['agreements']->count() > 0)
            <div class="row border border-dark rounded-lg mb-3 p-2">
                <div class="col-12">
                    <h4>
                        Agreements with {{$data['venue']->name}}
                    </h4>
                </div>
                @if($data['agreements']->count() > 1)
                    <div class="col-6">
                        Order by: @sortablelink('title', 'Title')
                    </div>
                    <div class="col-6">
                        @sortablelink('until', 'End Date')
                    </div>
                @endif
                <div class="col-12">
                    <ul class="list-group list-group-flush">
                        @forelse($data['agreements'] as $va)
                            <li class="list-group-item">
                                {!! (\Carbon\Carbon::parse($va->until)->isPast()) ? "<i>(Not current)</i>" : '' !!}
                                <a title="View {{ $va->title }}" href="{{route('agreement_show', $va->id)}}">
                                    {{ $va->title }}
                                </a>
                                {{$va->from->format('F j Y')}} - {{$va->until->format('F j Y')}}
                            </li>
                            <ul>
                                @forelse($va->attachments as $att)
                                    <li>
                                        <a href="{{route('attachment_download', [$att->subfolder, $att->id])}}"
                                           title="Download {{$att->file_name}}" target="_blank">
                                            <i class="fas fa-file-download fa-1x"></i>
                                            {{$att->file_name}} {{$att->description ? : ''}}
                                        </a>
                                    </li>
                                @empty
                                    <li>No attached files</li>
                                @endforelse
                            </ul>
                        @empty
                            <li></li>
                        @endforelse
                    </ul>
                    <div class="col-12 d-flex justify-content-center">
                        <div class="list-group text-center">
                            <ul class="pagination text center">
                                {{ $data['agreements']->links() }}
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if(count($data['venue']->attachments) > 0)
            <div class="col-12 mt-3">
                <h4>
                    <i class="far fa-folder-open"></i>
                    Files
                </h4>
                @foreach ($data['venue']->attachments as $va)
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <a href="{{route('attachment_download',
                                [$data['venue']->getAttachmentFolder(), $va->id])}}"
                                title="Download {{$va->file_name}}">
                                <i class="far fa-file"></i>
                                {{$va->description ? : $va->file_name}}
                            </a>
                        </li>
                    </ul>
                @endforeach
            </div>
        @endif
    </div>
@endsection
