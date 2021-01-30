@extends('layouts.jumbo')
@section('content')
    <div class="container border border-dark rounded mt-3 mb-2 mb-lg-3" style="background: rgba(220,220,220,0.8);">
        <div class="col-12">
            <h1>Pages</h1>
        </div>
        <div class="row mb-2 mb-lg-3">
            @foreach ( $data['pages'] as $i )
                <div class="col-12 col-md-4 p-2">
                    <div class="col border border-dark rounded-lg  w-100 h-100 p-2">
                        <a href="{{ route('page_show', $i->slug) }}">
                            <h4>{{ $i->title }}</h4>
                            <p>{!! $i->description !!} </p>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="d-flex justify-content-center">
            <div class="list-group">
                <ul class="pagination">
                    {!! $data['pages']->links() !!}
                </ul>
            </div>
        </div>
    </div>
@endsection




