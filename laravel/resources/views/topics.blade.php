@extends('layouts.jumbo')
@section('content')
    <div class="container border border-dark rounded mt-3 mb-3" style="background: rgba(220,220,220,0.8);">
        <div class="row">
            <div class="col-12 text-center">
                <h1>Topics</h1>
            </div>
        </div>
        <div class="row mb-2 mb-lg-3">
            @foreach ( $data['topics'] as $i )
                <div class="col-12 col-md-4 p-1">
                    <div class="col border border-dark rounded h-100 w-100 p-2 text-center d-flex align-items-center
                        justify-content-center">
                        <a href="{{ route('topic_show', $i->slug) }}" title="{{ $i->name }}">
                            <h3>{{ $i->name }}</h3>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="d-flex justify-content-center">
            <div class="list-group">
                <ul class="pagination">
                    {!! $data['topics']->links() !!}
                </ul>
            </div>
        </div>
    </div>
@endsection
