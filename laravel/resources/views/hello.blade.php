@extends('layouts.jumbo')
@section('content')
<div class="container">
    <div class="row border border-light rounded-lg p-lg-2 mb-2" style="background: rgba(220,220,220,0.8);">
        <div class="col-12 mb-lg-1">
            <h1>{{config('app.name')}}</h1>
        </div>
    </div>
    <div class="row border border-light rounded-lg p-lg-2 mb-2" style="background: #fff;">
        <div class="col-12 mb-lg-1">
            <h1>{{config('app.name')}}</h1>
        </div>
    </div>
    <div class="row border border-light rounded-lg p-lg-2" style="background: rgba(220,220,220,0.8);">
        <div class="col-12">
            @if($data['birthday'] != '')
                <h2> <i class="fas fa-birthday-cake"></i> {{ $data['birthday'] }}</h2>
            @endif
            <h3>{{$data['years']}} years, since {{$data['foundingYear']}}.</h3>
        </div>
        <div class="col-12">
            <p>
                <span class="dropcap">F</span>ounded on September 13, 1904,
                IATSE Local 118 (International Alliance of Theatrical Stage Employees of the United States and Canada)
                is the labour union supplying technicians, stagehands, artisans and craftspeople to the Greater Vancouver
                entertainment industry, including live theatre, rock and roll, trade shows, and conventions.
                Local 118 has a large, skilled and experienced workforce ready to meet the needs of your production.
            </p>
            <p>
                <a class="btn btn-primary btn-lg" href="/page/about-us" role="button">Learn more &raquo;</a>
            </p>
        </div>
    </div>
</div>
@endsection
