@extends('layouts.jumbo')
@section('content')
<div class="container border border-dark rounded-lg mb-5" style="background: rgba(220,220,220,0.8);">
    <div class="row">
        <div class="col-12">
            <h1 class="display-4">
                Local 118 Committees
            </h1>
        </div>
    </div>
    <div class="row">
        @forelse ( $data['committees'] as $c )
            <div class="col-12 mt-1">
                <div class="col border border-dark rounded-lg p-3">
                    <h2>
                        <a href="{{ route('committee', $c->slug) }}">
                            {{ $c->name }}
                        </a>
                    </h2>
                    <p>{!! $c->description !!}</p>
                    <p>
                        {{$c->active_committee_members->count()}}
                        {{Str::plural('member', $c->active_committee_members->count())}}.
                    </p>
                </div>
            </div>
        @empty
            No committees created as of yet.
        @endforelse
    </div>
    <div class="row">
        <div class="col"></div>
        <div class="col">
            <div class="list-group">
                <ul class="pagination">
                    {{$data['committees']->links()}}
                </ul>
            </div>
        </div>
        <div class="col"></div>
    </div>
</div>
@endsection




