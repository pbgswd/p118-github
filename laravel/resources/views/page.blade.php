<?php
$page = $data['page'];
?>
@extends('layouts.jumbo')
@section('content')
<div class="jumbotron">
    <div class="container">
        <h1 class="display-3">{{$page->title}}</h1>
        <h2>{{$page->description}}</h2>
        @if( $page->image )
            <div class="col-md-6">
                <div class="col">
                    <h4>
                        <i class="far fa-images"></i>
                        Image preview
                    </h4>

                    <h5>Currently: {{ $page->image }}</h5>
                    <img src="{{ asset('storage/'.$page->image) }}" />
                </div>
            </div>
        @endif
        {{$page->content}}

    </div>



<div class="row" style="margin-top:6em;"></div>

@endsection




