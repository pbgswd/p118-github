@extends('layouts.jumbo')
@section('content')
<div class="jumbotron">
    <div class="container border border-dark rounded-lg pt-2" style="background: rgba(220,220,220,0.8);">
        <div class="row mb-3">
            <div class="col-12 col-md-10 pt-2">
                <h3>
                    {{ $data['results']->count() }}
                    Search  {{ Str::plural('Result', $data['results']->count()) }}
                    for "{{$data['search']}}"
                </h3>
            </div>
            <div class="col-12 col-md-2">
                <a href="#search" class="btn btn-primary btn-lg active" title="search"
                   role="button" aria-pressed="true">
                    <i class="fas fa-search"></i>
                    Another Search
                </a>
            </div>
        </div>
        <div class="row">
            @if($data['results']->count() < 1)
                <div class="col-12 border border-dark rounded-lg p-2">
                    <h4>
                        Sorry that didn't get you what you were looking for.
                        You can always modify your search term and try another search.
                    </h4>
                </div>
            @endif
            @if($data['results']->count() > 30)
                <div class="col-12 border border-dark rounded-lg p-2">
                    <h4>
                        {{ $data['results']->count() }} results from your search is a lot!
                        Consider adding more terms to your search to find what you are looking for.
                    </h4>
                </div>
            @endif
        </div>
        <div class="row">
            @forelse ( $data['results'] as $r )
                <div class="col-12 col-md-4 p-2">
                    <div class="col border border-dark rounded-lg w-100 h-100 p-2">
                        <a href="{{$r->url}}" title="{{$r->title}}">
                             <h3>{{$r->title}}</h3>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-12 justify-content-around p-2">
                    <div class="col border border-dark rounded-lg p-2">
                         No results!
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection




