<?php
$venue = $data['venue'];
?>
@extends('layouts.jumbo')
@section('content')
<div class="jumbotron">
    <div class="container border border-dark rounded-lg pl-lg-1" style="background: rgba(220,220,220,0.8);">
        <a href="{{ route('hello') }}">Home /</a>
        <a href="{{route('venues')}}">venues /</a> {{$venue->name}}
        <div class="col-12">
            <h1>{{$venue->name}}</h1>
        </div>
        <div class="col-12">
            <p>
                <i class="fas fa-external-link-alt"></i>
                <a href="{{$venue->url}}" title="{{$venue->name}}" target="_blank">{{$venue->url}}</a>
            </p>
        </div>
        <div class="col-12">
            {!! $venue->description !!}
        </div>
        @if (0 < $data['agreements']->count())
            <div class="row mt-lg-5 p-lg-5 border border-dark">
                <div class="col-12">
                    Agreements attached to {{$venue->name}}
                </div>
                <div class="col-12">
                    <table class="table">
                        <thead></thead>
                        <tbody>
                        @foreach($data['agreements'] as $va)
                            <tr>
                                <td>
                                    @if(\Carbon\Carbon::parse($va->until)->isPast())
                                        <i>(Not current)</i>
                                    @endif
                                    <a title="{{ $va->title }}" href="{{route('agreement_show', $va->id)}}">
                                        {{ $va->title }}
                                    </a>
                                </td>
                                <td>From: {{$va->from->format('F j Y')}}</td>
                                <td>Until: {{$va->until->format('F j Y')}}</td>
                            </tr>
                        @endforeach
                        <td colspan="3">&nbsp;</td>
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
