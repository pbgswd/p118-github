<?php
$venue = $data['venue'];
?>
@extends('layouts.jumbo')
@section('content')
<div class="jumbotron">
    <div class="container border border-dark rounded-lg pl-lg-1" style="background: rgba(220,220,220,0.8);">
        <div class="row">
            <div class="col-12">
                <a href="{{ route('hello') }}">Home /</a>
                <a href="{{route('venues')}}">venues /</a>
            </div>
            <div class="col-12">
                <h1>{{$venue->name}}</h1>
            </div>
            <div class="col-12">
                <p>
                    <i class="fas fa-external-link-alt"></i>
                    <a href="{{$venue->url}}" title="{{$venue->name}}" target="_blank">{{$venue->url}}</a>
                </p>
            </div>
            <div class="col-12 p-lg-5">
                {!! $venue->description !!}
            </div>
        </div>
    </div>
    @if (0 < $data['agreements']->count())
        <div class="container border border-dark
                    rounded-lg pl-lg-1 mt-lg-3" style="background: rgba(220,220,220,0.8);">
            <div class="row mt-lg-5 p-lg-5">
                <div class="col-12">
                    <h4>Agreements attached to {{$venue->name}}</h4>
                </div>
                <table class="table">
                    <tbody>
                    @foreach($data['agreements'] as $va)
                        <tr>
                            <td>
                                <p>
                                    @if(\Carbon\Carbon::parse($va->until)->isPast())
                                        <i>(Not current)</i>
                                    @endif
                                    <a title="{{ $va->title }}" href="{{route('agreement_show', $va->id)}}">
                                        {{ $va->title }}
                                    </a>
                                </p>
                            </td>
                            <td>
                                <p>From: {{$va->from->format('F j Y')}}</p>
                            </td>
                            <td>
                                <p>Until: {{$va->until->format('F j Y')}}</p>
                            </td>
                        </tr>
                    @endforeach
                    <td colspan="4">&nbsp;</td>
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
@endsection
