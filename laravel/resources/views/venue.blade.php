@extends('layouts.jumbo')
@section('content')
<div class="jumbotron">
    <div class="container border border-dark rounded-lg" style="background: rgba(220,220,220,0.8);">
        <div class="row">
            <div class="col-12">
                <a href="{{route('venues')}}">Venues</a>
                <h1>{{$data['venue']->name}}</h1>
                <p>
                    <a href="{{$data['venue']->url}}" title="{{$data['venue']->name}}" target="_blank">
                        <i class="fas fa-external-link-alt"></i>
                        {{$data['venue']->url}}
                    </a>
                </p>
            </div>
            <div class="col-12">
                {!! $data['venue']->description !!}
            </div>
        </div>
    @if (0 < $data['agreements']->count())
        <div class="row border border-dark rounded-lg mt-3">
            <div class="col-12">
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
                        <td colspan="3">&nbsp;</td>
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
@endsection
