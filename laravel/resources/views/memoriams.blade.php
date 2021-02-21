@extends('layouts.jumbo')
@section('content')
<div class="jumbotron">
    <div class="container border border-dark rounded" style="background: rgba(220,220,220,0.8);">
        <div class="col-12 text-center">
            <h1>In Memoriam</h1>
        </div>
        <div class="row mb-3">
            @foreach ( $data['memoriam'] as $memoriam )
                <div class="col-md-4 col-12 p-2">
                    <div class="col border border-dark rounded h-100 w-100 p-2 text-center d-flex align-items-center
                        justify-content-center">
                        <a href="{{ route('memoriam', $memoriam->slug) }}">
                            @if($memoriam->image)
                                <img src="{{asset('storage/' . $data['folder'] .'/'. $data['tn_prefix'].$memoriam->image)}}"
                                     class="img-fluid rounded" title="{{$memoriam->name}}"/>
                            @endif
                            <h3>{{ $memoriam->title }}</h3>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="d-flex justify-content-center">
            <div class="list-group">
                <ul class="pagination">
                    {!! $data['memoriam']->links() !!}
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection




