@extends('layouts.jumbo')
@section('content')
<div class="jumbotron">
    <div class="container border border-dark rounded-lg pb-2" style="background: rgba(220,220,220,0.8);">
        <div class="row mb-3">
            <div class="col-12 col-md-6">
                <a href="{{route('memoriam_list')}}">In Memoriam List</a>
            </div>
            @can('edit members')
                <div class="col-12 col-md-6 text-md-right">
                    <a href="{{route('admin_memoriam_edit', $data['memoriam']->slug)}}"
                       title="Edit {{$data['memoriam']->title}}">
                        <i class="fas fa-edit"></i> Admin Edit
                    </a>
                </div>
            @endcan
        </div>
        @if($data['memoriam']->image)
            <div class="row mb-2">
                <div class="col-12 text-center d-flex align-items-center justify-content-center">
                    <picture>
                        <source srcset="{{asset('storage/'. $data['folder'] .'/'. $data['memoriam']->image)}}"
                                media="(min-width: 577px)">
                        <img srcset="{{asset('storage/'. $data['folder'] .'/'. $data['memoriam']->thumb)}}"
                             alt="{{$data['memoriam']->title}}"
                             class="rounded img-fluid d-block">
                    </picture>
                </div>
            </div>
        @endif
        <div class="row mb-2">
            <div class="col-12 text-center">
                <h1>{{$data['memoriam']->title}}</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                {!! $data['memoriam']->content !!}
            </div>
        </div>
    </div>
@endsection
