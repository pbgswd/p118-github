@extends('layouts.dashboard', ['title_icon' => '<i class="fas fa-search"></i>', 'title' => $data['title'] ])
@section('content')
    <div class="container">
        <div class="row border border-dark rounded p-3 pt-4 mb-4 bg-body-secondary">
            <form name="adminsearch" method="post" action="/admin/search">
                @csrf
                <div class="input-group mb-3">
                    <button class="btn btn-outline-primary" type="submit" id="button-addon1">Search</button>
                    <input type="text" class="form-control bg-secondary-subtle" name="search"
                           placeholder="Admin Search" aria-label="Search" aria-describedby="button-addon1"
                            value="{{$data['search'] ?? ''}}" required
                    >
                </div>
            </form>
        </div>
        @if($data['count'] > 0)
            <div class="row">
                <div class="col-6 col-md-12 text-center">
                    <h5>Jump to results</h5>
                </div>
                <div class="d-block d-md-none col-6 mx-auto text-center">
                    <h5>
                        <a href="#all_results" title="Jump to All results">
                            All results
                        </a>
                    </h5>
                </div>
                @foreach($data['models'] as $model)
                    @if($model['results']->count() > 0)
                        <div class="col-12 col-md-3 mx-auto m-1 border border-primary rounded pt-1 text-center">
                            <p class="mx-auto">
                                <a href="#{{$model['name']}}" title="Jump to {{$model['name']}}" class="mx-auto">
                                    {{$model['name']}} <br />
                                    {{$model['results']->count() ?? 0}}
                                    {{Str::plural('Result', $model['results']->count() ?? 0 )}}
                                    <i class="fas fa-caret-down"></i>
                                </a>
                            </p>
                        </div>
                   @endif
                @endforeach
                </div>
            </div>
        @endif
        @if($data['count'] > 0)
            <div class="row">
                <div class="d-block d-md-none col-12 p-2">
                    <a id="all_results"></a>
                    <h5>All Results</h5>
                </div>
            </div>
            @foreach($data['models'] as $model)
                @if($model['results']->count() > 0)
                    <a id="{{$model['name']}}"></a>
                    <div class="row border border-primary rounded py-2 mt-2">
                        <h4> {{$model['name']}} - {{$model['results']->count() ?? 0}}
                            {{Str::plural('Result', $model['results']->count() ?? 0 )}}
                        </h4>
                        @foreach($model['results'] as $i)
                            <div class="col-12 my-1">
                                <h4>
                                    <a title="{{ $i->title }}" href="{{ $i->url }}">
                                        {{strip_tags($i->title)}}</a>
                                    <h6 class="text-secondary">Created: {{ $i->searchable->created_at->format('F j Y H:i:s') }}</h6>
                                </h4>
                            </div>
                        @endforeach
                        <p>
                            <a href="#top">
                                Back to top
                                <i class="fas fa-caret-up"></i>
                            </a>
                        </p>
                    </div>
                @endif
            @endforeach
        @endif
    </div>
@endsection
