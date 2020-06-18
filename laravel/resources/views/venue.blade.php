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
            <div class="row mt-lg-5">
                <div class="col-11 m-1 m-lg-4 border border-dark">
                    Agreements attached to {{$venue->name}}
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col">Name</th>
                            <th scope="col">From</th>
                            <th scope="col">Until</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data['agreements'] as $va)
                            <tr>
                                <th scope="row">

                                </th>
                                <td>
                                    @if(\Carbon\Carbon::parse($va->until)->isPast())
                                        <i>(Not current)</i>
                                    @endif
                                    <a title="{{ $va->title }}" href="{{route('agreement_show', $va->id)}}">
                                        {{ $va->title }}
                                    </a>
                                </td>
                                <td>{{$va->from->format('F j Y')}}</td>
                                <td>{{$va->until->format('F j Y')}}</td>
                            </tr>
                        @endforeach
                        <td colspan="4">&nbsp;</td>
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
