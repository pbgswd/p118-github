@extends('layouts.dashboard', ['title' => '<i class="fas fa-search"></i> '. $data['title'] ])
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
        @foreach($data['models'] as $model)
            @if($model['results']->count() > 0)
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
                </div>
            @endif
        @endforeach
    </div>
@endsection
