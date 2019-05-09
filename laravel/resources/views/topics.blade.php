@extends('layouts.jumbo')
@section('content')
<div class="jumbotron">
    <div class="container">
        <h1 class="display-3">Topics</h1>
        <h2>asd</h2>
        <p>asdfasfd </p>
        <p><a class="btn btn-primary btn-lg" href="#" role="button">Learn more &raquo;</a></p>
    </div>

    <div class="container">
        <!-- Example row of columns -->
        <div class="row">
            @foreach ( $data['topics'] as $i )
                <div class="col-md-4 border border-dark rounded-lg mt-3 mr-3">
                    <h2>{{ $i->name }}</h2>
                    <p>{!! $i->description !!} </p>
                    <p>
                        <a class="btn btn-secondary" href="{{ route('topic_show', $i->slug) }}" role="button">View details &raquo;</a></p>
                </div>
            @endforeach
        </div>
    </div>
</div>

<div class="row">
    <div class="col"></div>
    <div class="col">
        <div class="list-group">
            <ul class="pagination">
                {!! $data['topics']->links() !!}
            </ul>
        </div>
    </div>
    <div class="col"></div>
</div>


<div class="row" style="margin-top:6em;"></div>

@endsection




