@extends('layouts.jumbo')
@section('content')
<div class="jumbotron">
    <div class="container border border-dark rounded-lg" style="background: rgba(220,220,220,0.8);">
        <div class="col">
            <h1 class="display-3">Posts</h1>
        </div>
        <div class="container">
            <!-- Example row of columns -->
            <div class="row">
                @foreach ( $data['posts'] as $i )
                    <div class="col-md-3 border border-dark rounded-lg mt-3 mr-3">
                        <h2>{{ $i->title }}</h2>
                        <p>{!! $i->description !!} </p>
                        <p>{{$i->access_level}}</p>
                        <p>
                            <a class="btn btn-secondary" href="{{ route('post_show', $i->slug) }}" role="button">View details &raquo;</a>
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="row">
            <div class="col"></div>
            <div class="col">
                <div class="list-group">
                    <ul class="pagination">
                        {!! $data['posts']->links() !!}
                    </ul>
                </div>
            </div>
            <div class="col"></div>
        </div>
    </div>
</div>
<div class="row" style="margin-top:6em;"></div>

@endsection




