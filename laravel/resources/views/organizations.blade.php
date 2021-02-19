@extends('layouts.jumbo')
@section('content')
<div class="jumbotron">
    <div class="container border border-dark rounded-lg p-2" style="background: rgba(220,220,220,0.8);">
        <div class="col-12 text-center">
            <h1>Organizations</h1>
            <h4>Where we work</h4>
        </div>
        <div class="row p-3">
            @foreach ( $data['organizations'] as $organization )
                <div class="col-12 col-md-4 mt-3 p-2">
                    <div class="border border-dark rounded-lg h-100 w-100 p-2 text-center d-flex align-items-center justify-content-center">
                        <a href="{{ route('organization', $organization->slug) }}" class="">
                            @if($organization->image)
                                <img src="{{asset('storage/public/'. $data['tn_prefix'].$organization->image)}}"
                                     class="img-fluid rounded" title="{{$organization->name}}"/> <br />
                            @endif
                            <h2>{{ $organization->name }}</h2>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="d-flex justify-content-center">
            <div class="list-group">
                <ul class="pagination">
                    {!! $data['organizations']->links() !!}
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection




