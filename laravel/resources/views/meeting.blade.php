<?php
$meeting = $data['meeting'];
?>
@extends('layouts.jumbo')
@section('content')
<div class="jumbotron">
    <div class="container border border-dark rounded-lg" style="background: rgba(220,220,220,0.6);">
        <div class="col-12">
            <h4><a href="{{route('list_meetings')}}"><i class="far fa-arrow-alt-circle-left"></i>  Meetings & Minutes</a></h4>
        </div>
        <div  class="col-12">
            <h1 class="display-4">{{$meeting->title}}</h1>
        </div>
        <div class="col-12">
            <p>{{$meeting->date->format('F j Y')}}</p>
            <p>{!! $meeting->description !!}</p>
        </div>
        @if(count($meeting->attachments) > 0)
            <ul>
                @foreach($meeting->attachments as $att)
                    <li>
                        <h4>
                            <a href="{{route('meeting_attachment_download', $att->id)}}" title="{{$att->description}}" target="_blank">
                            {{$att->file}}
                            </a> 
                            {{$att->description}}
                        </h4>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
    <div class="row" style="margin-top:6em;"></div>
</div>
@endsection




