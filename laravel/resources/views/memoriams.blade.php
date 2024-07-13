@extends('layouts.jumbo')
@section('content')

    <div class="container border border-dark rounded mt-3" style="background: rgba(220,220,220,0.8);">
        <div class="row">
            <div class="col-0 col-md-4"></div>
            <div class="col-12 pt-2 col-md-4 text-center">
                <h1>In Memoriam</h1>
            </div>
            <div class="col-0 col-md-4 text-md-end">
                @can('edit users')
                    <a href="{{route('admin_memoriam_list')}}">Admin Edit</a>
                @endcan
            </div>
        </div>
        <div class="row">
            <div class="col-12 mt-1 mb-2 text-center">
                <a href="{{route('page_show', 'in-case-of-death')}}">
                    <i class="fas fa-info-circle"></i>
                    <i>In Case Of Death: <br />
                        Information on how to announce a passing of a Local 118 member.</i>
                </a>
            </div>
        </div>
        <div class="row mb-3">
            @foreach ( $data['memoriam'] as $memoriam )
                <div class="col-md-4 col-12 p-2">
                    <div class="col border border-dark rounded h-100 w-100 p-2 text-center d-flex align-items-center
                        justify-content-center">
                        <a href="{{ route('memoriam', $memoriam->slug) }}">
                            @if($memoriam->image)
                                <img src="{{asset('storage/'. $data['folder'] .'/'. $data['tn_prefix'].$memoriam->image)}}"
                                     class="img-fluid rounded mb-2" title="{{$memoriam->name}}"/>
                            @endif
                            <h3>{{ $memoriam->title }}</h3>
                        <h5>{{$memoriam->date->format('F jS, Y')}}</h5>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="row mb-2">
            <div class="col-12 d-flex justify-content-center">
                <div class="list-group">
                    <ul class="pagination">
                        {!! $data['memoriam']->links() !!}
                    </ul>
                </div>
            </div>
        </div>

@endsection




