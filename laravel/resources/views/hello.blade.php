@extends('layouts.jumbo')
@section('content')
<div class="container">
    <h1 class="display-3">{{config('app.name')}}</h1>
    <h2>{{$data['years']}} years, since {{$data['foundingYear']}}.</h2>
    <p><span class="dropcap">F</span>ounded in 1904,
IATSE Local 118 (International Alliance of Theatrical Stage Employees of the United States and Canada)
is the labour union supplying technicians, stagehands, artisans and craftspeople to the Greater Vancouver
        entertainment industry, including live theatre, rock and roll, trade shows, and conventions.
        Local 118 has a large, skilled and experienced workforce ready to meet the needs of your production. </p>
    <p><a class="btn btn-primary btn-lg" href="#" role="button">Learn more &raquo;</a></p>
</div>
@endsection
