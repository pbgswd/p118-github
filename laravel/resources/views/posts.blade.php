@extends('layouts.jumbo')
@section('content')
    <div class="container border border-dark rounded-lg mt-3" style="background: rgba(220,220,220,0.8);">
        <div class="col-12 pt-2">
            <h1>Posts</h1>
        </div>
        <div class="row mb-2 mb-lg-3">
            @foreach ( $data['posts'] as $i )
                <div class="col-md-4 col-sm-12 justify-content-around p-2">
                    <div class="col border border-dark rounded-lg p-2">
                        <a href="{{ route('post_show', $i->slug) }}">
                            <h3>{{ $i->title }}</h3>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="d-flex justify-content-center">
            <div class="list-group">
                <ul class="pagination">
                    {!! $data['posts']->links() !!}
                </ul>
            </div>
        </div>
    </div>
@endsection




