@extends('layouts.jumbo')
@section('content')
<div class="jumbotron">
    <div class="container border border-dark rounded-lg p-4" style="background: rgba(220,220,220,0.8);">
        <div class="row mb-lg-5">
            <div class="col-12">
                <h2>
                    <a href="{{route('committees')}}">Committees</a>&nbsp;<br />
                    {{$data['committee']->name}}
                </h2>
            </div>

            <!-- image -->

            <div class="col-12">
                <h4>
                    {!! $data['committee']->description !!}
                </h4>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-12 col-md-6">
                <h4>
                    <i class="far fa-newspaper"></i>
                    {{$data['posts']->count() + $data['sticky_posts']->count() }}
                    {{Str::plural('Post', $data['posts']->count() + $data['sticky_posts']->count())}}
                </h4>
            </div>
            <div class="col-12 col-md-6">
                @if($data['isMember'] == 1)
                    <h4>
                        <i class="far fa-edit"></i>
                        <a href="{{route('committee_add_public_post', $data['committee']->slug)}}">
                            Add New Post
                        </a>
                    </h4>
                @endif
            </div>
        </div>

        <div class="row border border-success rounded-lg p-2 mb-3">

            <div class="col-12 m-2">
                <h4>Sticky Posts</h4>
            </div>

            @forelse($data['sticky_posts'] as $sp)
                <div class="col-12 {{ $data['sticky_posts']->count() % 2 > 0 ? 'col-md-12' : 'col-md-6' }}">
                    <div class="border border-dark rounded-lg p-4 mb-2">
                    <h4>
                        <a href="{{route('public_committee_post_show', [$data['committee']->slug, $sp->slug])}}"
                           title="{{$sp->title}}">
                            {{$sp->title}}
                        </a>
                    </h4>
                    Posted by: {{$sp->creator->name}}
                    {{ \Carbon\Carbon::parse($sp->updated_at)->format(' F j, Y') }}
                </div>
                </div>
            @empty
            @endforelse
        </div>



        <div class="row">
            @forelse($data['posts'] as $p)
                <div class="col-12 border border-dark rounded-lg mt-1 p-4">
                    <h3>
                        <a href="{{route('public_committee_post_show', [$data['committee']->slug, $p->slug])}}"
                           title="{{$p->title}}">
                            {{$p->title}}
                        </a>
                    </h3>
                    Posted by: {{$p->creator->name}}
                    {{ \Carbon\Carbon::parse($p->updated_at)->format(' F j, Y') }}
                </div>
            @empty
                <div class="col-12 border border-dark rounded-lg m-1 p-lg-3">
                    <h4>No posts yet, but there will be soon!</h4>
                </div>
            @endforelse
            @if($data['posts']->count() > 5)
                <div class="d-flex justify-content-center">
                    <div class="list-group">
                        <ul class="pagination">
                        {!! $data['posts']->links() !!}
                        </ul>
                    </div>
                </div>
            @endif
        </div>
        <div class="row mt-3">
            <div class="col-12 border border-dark rounded-lg pt-2 pb-2">
                <h5>{{$data['committee']->name}} Executive</h5>
                <ul class="list-group">
                    @foreach ($data['executives'] as $exec)
                        <li class="list-group-item">
                            <i class="fas fa-user-tie"></i>
                            {{$exec->pivot->role}}:
                            <a href="{{route('member', $exec->id)}}">
                                {{$exec->name}}
                            </a>
                        </li>
                    @endforeach
                    <li class="list-group-item">
                        <i class="far fa-envelope"></i>
                        Email:
                        <a href="mailto:{{$data['committee']->email}}?subject={{$data['committee']->name}} committee">
                            {{$data['committee']->email}}
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
