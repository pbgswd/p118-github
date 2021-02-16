@extends('layouts.jumbo')
@section('content')
<div class="jumbotron">
    <div class="container border border-dark rounded" style="background: rgba(220,220,220,0.8);">
        <div class="row">
            <div class="col-0 col-md-4"></div>
            <div class="col-12 col-md-4 text-center">
                <h1 class="text-center">Topics</h1>
            </div>
            <div class="col-0 col-md-4 text-right">
                @can('edit articles')
                    <a href="{{route('topics_list')}}">Admin</a>
                @endcan
            </div>
        </div>
        <div class="row m-0">
            @foreach ( $data['topics'] as $i )
                <div class="col-12 col-md-4 p-2">
                    <div class="col p-2 m-2 border border-dark rounded w-100 h-100">
                        <h5>
                            <a href="{{ route('topic_show', $i->slug) }}" title="{{$i->name}}">
                                {{ $i->name }}
                            </a>
                        </h5>
                        <p>
                            {!! $i->description !!}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    <div class="row">
        <div class="col-0 col-md-4"></div>
        <div class="col-12 col-md-4 text-center pt-5">
            <div class="list-group">
                <ul class="pagination">
                    {!! $data['topics']->links() !!}
                </ul>
            </div>
        </div>
        <div class="col-0 col-md-4"></div>
    </div>
</div>
@endsection




