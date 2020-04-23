<?php
$employment = $data['employment'];
?>
@extends('layouts.jumbo')
@section('content')
<div class="jumbotron">
    <div class="container border border-dark rounded-lg mb-lg-5" style="background: rgba(220,220,220,0.6);">
        <div class="col-12">
            <h4><a href="{{url()->previous()}}"><i class="far fa-arrow-alt-circle-left"></i>  Employment postings</a></h4>
        </div>
        <div class="row">
            <div  class="col-12">
                <h1 class="display-8">{{$employment->title}}</h1>
            </div>
        </div>
        <div class="row mb-lg-2">
            <div class="col-md-4">
                <h4>Deadline: {{$employment->deadline->format('F j Y')}}</h4>
            </div>
            <div class="col-md-4">
                <h4>Status:
                    @if($employment->jobstatus == 1)
                        <i class="fas fa-check"></i> Open
                    @else
                        <i class="far fa-times-circle"></i> Closed
                    @endif
                </h4>
            </div>
        </div>
        @if($employment->url != '')
            <div class="row mb-lg-2">
                <div class="col-12">
                    <h4>
                        <a href="{{$employment->url}}" title="External link to {{$employment->title}}" target="_blank"><i class="fas fa-external-link-alt fa-2x"></i>{{ $employment->url }}</a>
                    </h4>
                </div>
            </div>
        @endif
        <div class="row">
            <div class="col-12">
                {!! $employment->description !!}
            </div>
        </div>

        <div class="row mt-lg-2">
            <div class="col-12">
                @if(count($employment->attachments) > 0)
                    <ul>
                        @foreach($employment->attachments as $att)
                            <li>
                                <h4>
                                    <a href="{{route('attachment_download', [$att->subfolder, $att->id])}}" title="Download {{$att->description}}" target="_blank">
                                        <i class="fas fa-file-download fa-1x"></i>
                                    {{$att->file_name}}
                                    </a> &nbsp;
                                    {{$att->description}}
                                </h4>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection




