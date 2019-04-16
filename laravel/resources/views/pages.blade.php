@extends('layouts.jumbo')
@section('content')
<div class="jumbotron">
    <div class="container">
        <h1 class="display-3">Pages</h1>
        <h2>asd</h2>
        <p>asdfasfd </p>
        <p><a class="btn btn-primary btn-lg" href="#" role="button">Learn more &raquo;</a></p>
    </div>

    <div class="container">
        <!-- Example row of columns -->
        <div class="row">
            @foreach ( $data['pages'] as $i )
                <div class="col-md-4">
                    <h2>{{ $i->title }}</h2>
                    <p>{!! $i->description !!} </p>
                    <p>
                        <a class="btn btn-secondary" href="{{ route('page_show', $i->slug) }}" role="button">View details &raquo;</a></p>
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
                {!! $data['pages']->links() !!}
            </ul>
        </div>
    </div>
    <div class="col"></div>
</div>


<div class="row" style="margin-top:6em;"></div>

@endsection




