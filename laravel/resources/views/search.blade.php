<?php

?>
@extends('layouts.jumbo')
@section('content')
<div class="jumbotron">
    <div class="container border border-dark rounded-lg pt-lg-2" style="background: rgba(220,220,220,0.8);">
        <div class="col-12">
            <h1 class="display-8">Search Results</h1>
        </div>
        <div class="col-12">
            <h3>
                {{ $data['results']->count() }} {{ Str::plural('Result', $data['results']->count()) }} for "{{$data['search']}}"
            </h3>
        </div>
        <!-- Example row of columns -->
        <div class="row">
            @if($data['results']->count() < 1)
                <div class="col-10 border border-dark rounded-lg mt-3 mr-3">
                    <h2>Modify your search term and try again in the search field, or use the navigation links to find what you are looking for.</h2>
                    <p><a class="btn btn-primary btn-lg" href="/" role="button">Return To Home Page</a></p>
                </div>
            @else
                @foreach ( $data['results'] as $r )
                    <div class="col-3 border border-dark rounded-lg mt-3 mr-3">
                        <h2>{{$r->title}}</h2>
                        <p>
                            <a class="btn btn-secondary" href="{{$r->url}}" role="button">View details &raquo;</a>
                        </p>
                    </div>
                @endforeach
            @endif
        </div>
    <div class="row">
        <div class="col"></div>
        <div class="col">
            <div class="list-group">
                <ul class="pagination">

                </ul>
            </div>
        </div>
        <div class="col"></div>
    </div>
</div>

<div class="row mt-lg-5"></div>

@endsection




