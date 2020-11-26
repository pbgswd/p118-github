@extends('layouts.jumbo')
@section('content')
<div class="jumbotron">
    <div class="container border border-dark rounded-lg p-4" style="background: rgba(220,220,220,0.8);">
        <div class="row mb-lg-5">
            <div class="col-12">
                <h2>
                    <a href="{{route('committees')}}">Committees /</a>&nbsp;
                    {{$data['committee']->name}}
                </h2>
            </div>

            <!-- image -->

            <div class="col-12">
                <h2>
                    {!! $data['committee']->description !!}
                </h2>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <h4>
                    <i class="far fa-newspaper"></i>
                    {{$data['posts']->count()}}
                    {{Str::plural('Post', $data['posts']->count()) }}
                </h4>
            </div>
            <div class="col-6 mb-4">
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
        <div class="row">
            @forelse($data['sticky_posts'] as $p)
                <div class="col-6 border border-dark rounded-lg p-4">
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
                <div class="row mt-lg-4">
                    <div class="col-3 text-center">
                        {!! $data['posts']->links() !!}
                    </div>
                </div>
            @endif
        </div>
        <div class="row mt-3">
            <div class="col-12 m-1 p-4 border border-dark rounded-lg">
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
