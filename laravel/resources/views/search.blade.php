@extends('layouts.jumbo')
@section('content')
<div class="jumbotron">
    <div class="container border border-dark rounded-lg pt-2" style="background: rgba(220,220,220,0.8);">
        <div class="row mb-3">
            <div class="col-12 pt-2">
                <h3 class="text-center">
                    {{ $data['results']->count() }}
                    Search  {{ Str::plural('Result', $data['results']->count()) }}
                    for "{{$data['search']}}"
                </h3>
            </div>
        </div>
        @if($data['results']->count() > 30)
            <div class="row">
                <div class="col-12 border border-dark rounded-lg p-2">
                    <h4>
                        {{ $data['results']->count() }} results from your search is a lot!
                        Consider adding more terms to your search to find what you are looking for.
                    </h4>
                </div>
            </div>
        @endif
        <div class="row">
            @forelse ( $data['results'] as $r )
                <div class="col-12 col-md-4 p-2">
                    <div class="col border border-dark rounded-lg w-100 h-100 p-2">
                        @if($r->searchable->info)
                            <a href="{{route($r->searchable->info['pub_route_list'])}}"
                               title="{{$r->searchable->info['name']}}">
                                {{$r->searchable->info['name']}}
                            </a>
                        @endif
                        <a href="{{$r->url}}" title="{{$r->title}}">
                             <h3>{{$r->title}}</h3>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-12 justify-content-around p-2">
                    <div class="col border border-dark rounded-lg p-2 text-center">
                        <h4>
                            No results! <br />
                            Sorry that didn't get you what you were looking for. <br />
                            You can always modify your search term and try another search.
                        </h4>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
