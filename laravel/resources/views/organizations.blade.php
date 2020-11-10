@extends('layouts.jumbo')
@section('content')
<div class="jumbotron">
    <div class="container border border-dark rounded-lg p-lg-2" style="background: rgba(220,220,220,0.8);">
        <div class="col-12">
            <h1 class="display-3">Organizations</h1>
        </div>
        <div class="col-12">
            <a href="{{ route('hello') }}">Home /</a>
            <a href="{{route('organizations')}}">organizations /</a>
            <h2>Where we work</h2>
        </div>
        <!-- Example row of columns -->
        <div class="row p-3">
            @foreach ( $data['data']['organizations'] as $organization )
                <div class="col-3 border border-dark rounded-lg mt-3 mr-3">
                    <h2>{{ $organization->name }}</h2>
                    <p>{!! $organization->summary !!} </p>
                    <p>
                        <a class="btn btn-secondary"
                           href="{{ route('organization', $organization->slug) }}" role="button">
                            View details
                        </a>
                    </p>
                </div>
            @endforeach
        </div>
    <div class="row mb-lg-5">
        <div class="col"></div>
        <div class="col">
            <div class="list-group">
                <ul class="pagination">
                    {!! $data['data']['organizations']->links() !!}
                </ul>
            </div>
        </div>
        <div class="col"></div>
    </div>
</div>
@endsection




