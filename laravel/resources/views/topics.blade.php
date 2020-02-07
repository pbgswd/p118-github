@extends('layouts.jumbo')
@section('content')
<div class="jumbotron">
    <div class="container border border-dark rounded-lg" style="background: rgba(220,220,220,0.6); padding:2em;">
        <div class="col-12">
            <h1 class="display-3">Topics</h1>
        </div>
        <div class="col-12">
            <a href="{{ route('hello') }}">Home /</a>
            <a href="{{route('topics')}}">Topics /</a>
            <h2>Information grouped by topic</h2>
        </div>
        <!-- Example row of columns -->
        <div class="row">
            @foreach ( $data['topics'] as $i )
                <div class="col-3 border border-dark rounded-lg mt-3 mr-3" style="margin: 1em;">
                    <h2>{{ $i->name }}</h2>
                    <p>{!! $i->description !!} </p>
                    <p>{{$i->access_level}}</p>
                    <p>
                        <a class="btn btn-secondary" href="{{ route('topic_show', $i->slug) }}" role="button">View details &raquo;</a>
                    </p>
                    <p>
                        <?php $tags = join(', ', $i->tagNames()); ?>
                        <b>Tags: {{$tags}}</b>
                    </p>
                </div>
            @endforeach
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
</div>

<div class="row" style="margin-top:6em;"></div>

@endsection




