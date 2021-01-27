@extends('layouts.jumbo')
@section('content')
<div class="jumbotron">
    <div class="container border border-dark rounded-lg pb-2" style="background: rgba(220,220,220,0.8);">
        <div class="row pl-2">
            <a href="{{route('venues')}}">Venues</a>
        </div>
        <div class="row d-flex justify-content-around mb-2 mb-md-3">
            <div class="col-12 col-md-6">
                <h1>{{$data['venue']->name}}</h1>
            </div>
            <div class="col-12 col-md-6 text-md-right">
                <p>
                    <a href="{{$data['venue']->url}}" title="{{$data['venue']->name}}" target="_blank">
                        <i class="fas fa-external-link-alt"></i>
                        {{$data['venue']->url}}
                    </a>
                </p>
            </div>
            </div>
        <div class="row">
            <div class="col-12">
                {!! $data['venue']->description !!}
            </div>
        </div>
        @if (0 < $data['agreements']->count())
            <div class="row border border-dark rounded-lg m-2">
                <div class="col-12 pt-2">
                    <h4>Agreements attached to {{$data['venue']->name}}</h4>
                </div>
                <div class="table-responsive">
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
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
@endsection
