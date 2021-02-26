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
        @if (0 < $data['agreements']->count())
            <div class="row border border-dark rounded-lg p-2">
                <div class="col-12 pt-2">
                    <h4>
                        Agreements with {{$data['venue']->name}}
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
                                <a title="{{ $va->title }}" href="{{route('agreement_show', $va->id)}}">
                                    {{ $va->title }}
                                </a>
                                {{$va->from->format('F j Y')}} -
                                {{$va->until->format('F j Y')}}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
    </div>
@endsection
