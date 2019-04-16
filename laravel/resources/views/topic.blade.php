<?php
$topic = $data['topic'];
?>
@extends('layouts.jumbo')
@section('content')
<div class="jumbotron">
    <div class="container">
        <h1 class="display-3">{{$topic->name}}</h1>
        <h2>asd</h2>
        @if( $topic->image )
            <div class="col-md-6">
                <div class="col">
                    <h4>
                        <i class="far fa-images"></i>
                        Image preview
                    </h4>

                    <h5>Currently: {{ $topic->image }}</h5>
                    <img src="{{ asset('storage/'.$topic->image) }}" />
                </div>
            </div>
        @endif
        {{$topic->description}}

    </div>



<div class="row" style="margin-top:6em;"></div>

@endsection




