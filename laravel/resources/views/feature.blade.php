@extends('layouts.jumbo')
@section('content')
    <div class="container mt-3 mb-3 pt-2 border border-dark rounded" style="background: rgba(220,220,220,0.8);">
        <div class="row mb-2">
            <div class="col-6 text-left">
                <a href="{{route('features')}}"
                   title="Features">Features
                </a>
            </div>
            <div class="col-6 text-right">
                @can(['edit articles'])
                    <a href="{{route('admin_feature_edit', $data['feature']->slug)}}"
                       title="Edit {{$data['feature']->title}}">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                @endcan
            </div>
        </div>
        @if($data['feature']->image)
        <div class="col-12 text-center d-flex align-items-center justify-content-center">
            <picture>
                <source srcset="{{asset('storage/public/'. $data['feature']->image)}}" media="(min-width: 577px)">
                <img srcset="{{asset('storage/public/'.$data['feature']->thumb)}}" alt="{{$data['feature']->name}}"
                     class="rounded img-fluid d-block">
            </picture>
        </div>
        @endif
        <div  class="col-12">

            <h1 class="text-center">
                {{$data['feature']->title}}
            </h1>

        </div>
        <div class="col-12">
            {!! $data['feature']->content !!}
        </div>
    </div>
@endsection
