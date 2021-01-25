@extends('layouts.jumbo')
@section('content')
<div class="container border border-dark rounded-lg mb-1 mb-lg-3" style="background: rgba(220,220,220,0.8); padding:2em;">
    <div class="col-12">
        <h1>Topics</h1>
    </div>
    <div class="row mb-2 mb-lg-3">
        @foreach ( $data['topics'] as $i )
            <div class="col-md-4 col-sm-12 justify-content-around p-2">
                <div class="col border border-dark rounded-lg p-2">
                    <a class="" href="{{ route('topic_show', $i->slug) }}" title="{{ $i->name }}">
                        <h3>{{ $i->name }}</h3>
                        <p>{!! $i->description !!} </p>
                    </a>
                    <p>
                        <?php $tags = join(', ', $i->tagNames()); ?>
                        <i>Tags: {{$tags ?? ''}}</i>
                    </p>
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




