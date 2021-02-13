@extends('layouts.jumbo')
@section('content')
    <div class="container mt-3 mb-3 pt-2 border border-dark rounded-lg" style="background: rgba(220,220,220,0.8);">
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
        <div  class="col-12">
            <img src="{{ asset('storage/public/'. $data['feature']->image) }}" class="border border-lg img-fluid" />
            <br />
            <h1 class="text-center">
                {{$data['feature']->title}}
            </h1>

        </div>
        <div class="col-12">
            {!! $data['feature']->content !!}
        </div>
    </div>
@endsection
