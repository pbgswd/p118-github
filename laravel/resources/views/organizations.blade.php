@extends('layouts.jumbo')
@section('content')
<div class="jumbotron">
    <div class="container border border-dark rounded-lg p-lg-2" style="background: rgba(220,220,220,0.8);">
        <div class="col-12">
            <h1>Organizations</h1>
        </div>
        <div class="col-12">
            <h4>Where we work</h4>
        </div>
        <div class="row p-3">
            @foreach ( $data['data']['organizations'] as $organization )
                <div class="col-12 col-sm-12 col-md-3 border border-dark rounded-lg mt-3 mr-3">
                    <a href="{{ route('organization', $organization->slug) }}">
                        <h2>{{ $organization->name }}</h2>
                        <p>{!! $organization->summary !!}</p>
                    </a>
                </div>
            @endforeach
        </div>
        <div class="d-flex justify-content-center">
            <div class="list-group">
                <ul class="pagination">
                    {!! $data['data']['organizations']->links() !!}
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection




