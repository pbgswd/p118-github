@extends('layouts.jumbo')
@section('content')
<div class="container border border-dark rounded-lg mb-5 mt-3" style="background: rgba(220,220,220,0.8);">
    <div class="row">
        <div class="col-12 mb-3 mt-3 text-center">
            <h1>
                Local 118 Committees
            </h1>
        </div>
    </div>
    <div class="row">
        @forelse ( $data['committees'] as $c )
            <div class="col-12 col-md-6 p-2">
                <div class="col border border-dark rounded-lg w-100 h-100 p-3">
                    <h3>
                        <a href="{{ route('committee', $c->slug) }}">
                            {{ $c->name }}
                        </a>
                    </h3>
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

    <div class="col-12 mt-3">
        <div class="d-flex justify-content-center">
            <div class="list-group">
                <ul class="pagination">
                    {{$data['committees']->links()}}
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection




