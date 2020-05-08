<?php
$bylaw = $data['bylaw'];
?>
@extends('layouts.jumbo')
@section('content')
<div class="jumbotron">
    <div class="container border border-dark rounded-lg" style="background: rgba(220,220,220,0.8);">
        <div class="col-12">
            <h4><a href="{{url()->previous()}}"><i class="far fa-arrow-alt-circle-left"></i>  bylaw postings</a></h4>
        </div>
        <div class="row">
            <div  class="col-12">
                <h1 class="display-8"><i class="fas fa-gavel"></i> {{$bylaw->title}}</h1>
            </div>
        </div>
        <div class="row mb-lg-2">
            <div class="col-md-12">
                <h4>From: {{$bylaw->date->format('F j Y')}}</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                {!! $bylaw->description !!}
            </div>
        </div>
        <div class="row mt-lg-2">
            <div class="col-12">
                @if(count($bylaw->attachments) > 0)
                    <ul>
                        @foreach($bylaw->attachments as $att)
                            <li>
                                <h4>
                                    <a href="{{route('attachment_download', [$att->subfolder, $att->id])}}" title="Download {{$att->description}}" target="_blank">
                                        <i class="fas fa-file-download fa-1x"></i>
                                    {{$att->file_name}}
                                    </a>
                                    {{$att->description}}
                                </h4>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
    <div class="row mt-lg-5"></div>
</div>
@endsection




