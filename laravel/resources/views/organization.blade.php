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
            @endif
            @if($data['organization']->image)
                <div class="row mb-2">
                    <div class="col-12 text-center">
                        <img src="{{asset('storage/public/'. $data['organization']->image)}}" class="img-fluid"
                             title="{{$data['organization']->name}}"/>
                    </div>
                </div>
            @endif
            <div class="col-12">
                <p>{!! $data['organization']->description !!}</p>
            </div>
            @if ($data['agreements']->count() > 0)
                <div class="col-12 border border-dark rounded-lg mb-3 p-2">
                    <h4>
                        Agreements with {{$data['organization']->name}}
                    </h4>
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
        </div>
    </div>
@endsection
