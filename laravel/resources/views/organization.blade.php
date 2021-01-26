@extends('layouts.jumbo')
@section('content')
    <div class="jumbotron">
        <div class="container border border-dark rounded-lg" style="background: rgba(220,220,220,0.8);">
            <div class="col-12 m-0">

                <p>
                    <a href="{{route('organizations')}}">
                        Organizations
                    </a>
                </p>
                <h1>
                    {{$data['organization']->name}}
                </h1>
                <p>
                    <a href="{{$data['organization']->url}}" title="{{$data['organization']->name}}" target="_blank">
                        <i class="fas fa-external-link-alt"></i>
                        {{$data['organization']->url}}
                    </a>
                </p>
                <p>{!! $data['organization']->description !!}</p>
            </div>
            <div class="col-12 col-12 border border-dark rounded-lg mb-3 pt-2">
                @if ($data['agreements']->count() > 0)
                    <h4>Agreements attached to {{$data['organization']->name}}</h4>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col"></th>
                                    <th scope="col">From</th>
                                    <th scope="col">Until</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data['agreements'] as $va)
                                    <tr>
                                        <td>
                                            @if(\Carbon\Carbon::parse($va->until)->isPast())
                                                <i>(Not current)</i>
                                            @endif
                                            <a title="View {{ $va->title }}" href="{{route('agreement_show', $va->id)}}">
                                                {{ $va->title }}
                                            </a>
                                        </td>
                                        <td>{{$va->from->format('F j Y')}}</td>
                                        <td>{{$va->until->format('F j Y')}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
