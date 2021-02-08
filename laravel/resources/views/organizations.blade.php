@extends('layouts.jumbo')
@section('content')
<div class="jumbotron">
    <div class="container border border-dark rounded-lg p-2" style="background: rgba(220,220,220,0.8);">
        <div class="col-12 text-center">
            <h1>Organizations</h1>
            <h4>Where we work</h4>
        </div>
        <div class="row p-3">
            @foreach ( $data['data']['organizations'] as $organization )
                <div class="col-12 col-md-4 mt-3 p-2">
                    <div class="border border-dark rounded-lg h-100 w-100 p-2">
                        <a href="{{ route('organization', $organization->slug) }}">
                            <h2>{{ $organization->name }}</h2>
                            <p>{!! $organization->summary !!}</p>
                        </a>
                    </div>
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




