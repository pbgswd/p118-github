@extends('layouts.jumbo')
@section('content')
<div class="jumbotron">
    <div class="container border border-dark rounded-lg" style="background: rgba(220,220,220,0.6);">
        <div class="col">
            <h1 class="display-3">Pages</h1>
        </div>

            <!-- Example row of columns -->
            <div class="row">
                @foreach ( $data['pages'] as $i )
                    <div class="col-md-4 border border-dark rounded-lg mt-3 mr-3 pt-2">
                        <h4>{{ $i->title }}</h4>
                        <p>{!! $i->description !!} </p>
                        <p>{{$i->access_level}}</p>
                        <p>
                            <a class="btn btn-secondary" href="{{ route('page_show', $i->slug) }}" role="button">View details &raquo;</a>
                        </p>
                    </div>
                @endforeach
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
    </div>
</div>
<div class="row mt-lg-5"></div>

@endsection




