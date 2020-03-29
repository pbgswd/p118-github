<?php
$data['organizations'] = $data['data']['organizations'];
//dd($data);
?>
@extends('layouts.jumbo')
@section('content')
<div class="jumbotron">
    <div class="container border border-dark rounded-lg" style="background: rgba(220,220,220,0.6); padding:2em;">
        <div class="col-12">
            <h1 class="display-3">organizations</h1>
        </div>
        <div class="col-12">
            <a href="{{ route('hello') }}">Home /</a>
            <a href="{{route('organizations')}}">organizations /</a>
            <h2>Where we work</h2>
        </div>
        <!-- Example row of columns -->
        <div class="row">
            @foreach ( $data['organizations'] as $organization )
                <div class="col-3 border border-dark rounded-lg mt-3 mr-3" style="margin: 1em;">
                    <h2>{{ $organization->name }}</h2>
                    <p>{!! $organization->summary !!} </p>
                    <p>
                        <a class="btn btn-secondary" href="{{ route('organization', $organization->slug) }}" role="button">View details &raquo;</a>
                    </p>
                </div>
            @endforeach
        </div>
    <div class="row">
        <div class="col"></div>
        <div class="col">
            <div class="list-group">
                <ul class="pagination">
                    {!! $data['organizations']->links() !!}
                </ul>
            </div>
        </div>
        <div class="col"></div>
    </div>
</div>
<div class="row" style="margin-top:6em;"></div>
@endsection




