@extends('layouts.jumbo')
@section('content')
<div class="jumbotron">
    <div class="container border border-dark rounded-lg pb-2" style="background: rgba(220,220,220,0.8);">
        <div class="row">
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
        <div class="row d-flex justify-content-around mb-2 mb-md-3">
            <div class="col-12 col-md-4"></div>
            <div class="col-12 col-md-4 text-center">
                <h1>{{$data['venue']->name}}</h1>
            </div>
            <div class="col-12 col-md-4 text-md-right">
                <p>
                    <a href="{{$data['venue']->url}}" title="{{$data['venue']->name}}" target="_blank">
                        <i class="fas fa-external-link-alt"></i>
                        {{$data['venue']->url}}
                    </a>
                </p>
            </div>
        </div>
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
