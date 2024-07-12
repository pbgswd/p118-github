@extends('layouts.jumbo')
@section('content')
    <div class="container border border-dark rounded mt-3 p-4" style="background: rgba(220,220,220,0.8);">
        <div class="row">
            <div class="col-12 col-md-6">
                <h6>
                    <a href="{{route('committees')}}">
                        Committees
                    </a>
                </h6>
            </div>
            @can(['manage committee'])
                <div class="col-12 col-md-6 text-end">
                    <a href="{{route('committee_edit', $data['committee']->slug)}}"
                       title="Edit {{$data['committee']->name}}">
                        <i class="fas fa-edit"></i> Admin Edit
                    </a>
                </div>
            @endcan
        </div>
        <div class="row mb-3">
            @if(null !== $data['committee']->image)
                <div class="col-12 mb-3 pt-2 text-center">
                    <img src="{{ asset('storage/committees/'.$data['committee']->image)}}"
                         class="border rounded img-fluid mb-2" />
                </div>
            @endif
            <div class="col-12 pt-2 text-center">
                <h1>
                    {{$data['committee']->name}}
                </h1>
            </div>
            <div class="col-12">
                <h4>
                    {!! $data['committee']->description !!}
                </h4>
            </div>
        </div>
        <div class="row my-3 border border-dark rounded p-2 pb-4 text-center d-flex justify-content-center">
            <div class="row">
                <div class="col-12 mt-2 d-flex justify-content-center">
                    <h4>{{$data['committee']->name}} Executive</h4>
                </div>
                <div class="col-12 d-flex justify-content-center">
                    <ul class="list-group list-group-horizontal-lg">
                        @forelse ($data['executives'] as $exec)
                            <li class="list-group-item">
                                <i class="fas fa-user-tie"></i>
                                {{$exec->pivot->role}}:
                                <a href="{{route('member', $exec->id)}}">
                                    {{$exec->name}}
                                </a>
                            </li>
                        @empty
                            <li class="list-group-item">
                                No Executives defined
                            </li>
                        @endforelse
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
            <div class="row">
                <div class="col-12 d-flex justify-content-center">
                    <h4 class="mt-3 text-center">Current Members</h4>
                </div>
                <div class="col-12 d-flex justify-content-center">
                    <ul class="list-group list-group-horizontal-lg">
                        @forelse($data['committee']->active_committee_members as $mbr)
                            <li class="list-group-item">
                                @if($mbr->user_info->show_profile == 1)
                                    <a title="{{$mbr->name}}" href="{{route('member', $mbr->id)}}">
                                        {{$mbr->name}}, {{$mbr->pivot->role}}
                                    </a>
                                @else
                                    {{$mbr->name}}, {{$mbr->pivot->role}}
                                @endif
                            </li>
                        @empty
                            <li class="list-group-item">
                                No members defined
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-12 col-md-6">
                <h4>
                    <i class="far fa-newspaper"></i>
                    {{$data['posts']->count() + $data['sticky_posts']->count() }}
                    {{Str::plural('Post', $data['posts']->count() + $data['sticky_posts']->count())}}
                </h4>
            </div>
            <div class="col-12 col-md-6 text-md-right">
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
        <div class="row mb-3">
            <div class="col-12 {{ $data['sticky_posts']->count() % 2 > 0 ? 'col-md-12' : 'col-md-6' }}">
                @forelse($data['sticky_posts'] as $sp)
                    <div class="border border-dark rounded p-2 mb-1 bg-light">
                        <h6 class="text-body-tertiary">Sticky Post</h6>
                        <h4>
                            <a href="{{route('public_committee_post_show', [$data['committee']->slug, $sp->slug])}}"
                               title="{{$sp->title}}">
                                {{$sp->title}}
                            </a>
                        </h4>
                        {{ \Carbon\Carbon::parse($sp->updated_at)->format(' F j, Y') }}
                    </div>
                @empty
                @endforelse
            </div>
        </div>
        <div class="row">
                @forelse($data['posts'] as $p)
                    <div class="col-12 p-2 mb-2">
                        <h3>
                            <a href="{{route('public_committee_post_show', [$data['committee']->slug, $p->slug])}}"
                               title="{{$p->title}}">
                                {{$p->title}}
                            </a>
                        </h3>
                        {{ \Carbon\Carbon::parse($p->updated_at)->format(' F j, Y') }}
                    </div>
                @empty
                    <p class="text-secondary">
                        No posts yet, but there will be soon!
                    </p>
                @endforelse
        </div>
        <div class="row">
            <div class="col-12">
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
        </div>
    </div>
@endsection
