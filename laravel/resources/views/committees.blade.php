@extends('layouts.jumbo')
@section('content')
<div class="jumbotron">
    <div class="container border border-dark rounded-lg mb-lg-5" style="background: rgba(220,220,220,0.8);">
        <div class="row">
            <div class="col-12">
                <h1 class="display-3">Committees</h1>
            </div>
            <div class="col-12">
                <a href="{{ route('hello') }}">Home /</a>
                <a href="{{route('committees')}}">Committees /</a>
            </div>
        </div>
        <div class="row">
            @foreach ( $data['committees'] as $c )
                <div class="col-12 mt-1">
                    <div class="col border border-dark rounded-lg p-3">
                        <h2>
                            <a href="{{ route('committee', $c->slug) }}">{{ $c->name }}</a>
                        </h2>
                        <p>{!! $c->description !!} </p>
                    </div>
                </div>

            @endforeach
        </div>
        <div class="row">
            <div class="col"></div>
            <div class="col">
                <div class="list-group">
                    <ul class="pagination">
                        {{$data['committees']->links()}}
                    </ul>
                </div>
            </div>
            <div class="col"></div>
        </div>
    </div>
@endsection




