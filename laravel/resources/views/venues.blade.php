@extends('layouts.jumbo')
@section('content')
    <div class="container border border-dark rounded mt-3" style="background: rgba(220,220,220,0.8);">
        <div class="col-12 pt-2 text-center">
            <h1>Venues</h1>
            <h4>Where we work</h4>
        </div>
        <div class="row mb-3">
            @foreach ( $data['venues'] as $venue )
                <div class="col-md-4 col-12 p-2">
                    <div class="col border border-dark rounded h-100 w-100 p-2 text-center d-flex align-items-center
                        justify-content-center">
                        <a href="{{ route('venue', $venue->slug) }}">
                            @if($venue->image)
                                <img src="{{asset('storage/public/'. $data['tn_prefix'].$venue->image)}}"
                                     class="img-fluid rounded" title="{{$venue->name}}"/>
                            @endif
                            <h3>{{ $venue->name }}</h3>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="d-flex justify-content-center">
            <div class="list-group">
                <ul class="pagination">
                    {!! $data['venues']->links() !!}
                </ul>
            </div>
        </div>
    </div>
@endsection




