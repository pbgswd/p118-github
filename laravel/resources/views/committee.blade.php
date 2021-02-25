@extends('layouts.jumbo')
@section('content')
    <div class="container border border-dark rounded-lg mt-3 p-4" style="background: rgba(220,220,220,0.8);">
        <div class="row">
            <div class="col-12 col-md-6">
                <h6>
                    <a href="{{route('committees')}}">
                        Committees
                    </a>
                </h6>
            </div>
            @can(['manage committee'])
                <div class="col-12 col-md-6 text-md-right">
                    <a href="{{route('committee_edit', $data['committee']->slug)}}"
                       title="Edit {{$data['committee']->name}}">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                </div>
            @endcan
        </div>
        <div class="row mb-lg-5">
            @if(null !== $data['committee']->image)
                <div class="col-12 mb-3 pt-2 text-center">
                    <img src="{{ asset('storage/committees/'.$data['committee']->image)}}"
                         class="border rounded-lg img-fluid mb-2" />
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
        <div class="row mb-4">
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
        <div class="row border rounded-lg p-2 mb-3 bg-light">
            <div class="col-12 m-2 text-secondary">
                <h4>Sticky Posts</h4>
            </div>
            <div class="col-12 {{ $data['sticky_posts']->count() % 2 > 0 ? 'col-md-12' : 'col-md-6' }}">
                @forelse($data['sticky_posts'] as $sp)
                    <div class="border border-dark rounded-lg p-4 mb-2 bg-light">
                        <h4>
                            <a href="{{route('public_committee_post_show', [$data['committee']->slug, $sp->slug])}}"
                               title="{{$sp->title}}">
                                {{$sp->title}}
                            </a>
                        </h4>
                        Posted by: {{$sp->creator->name}}
                        {{ \Carbon\Carbon::parse($sp->updated_at)->format(' F j, Y') }}
                    </div>
                @empty
                @endforelse
            </div>
        </div>

        <div class="row">
            <div class="col-12 border border-dark rounded-lg mt-1 p-4">
                @forelse($data['posts'] as $p)
                    <h3>
                        <a href="{{route('public_committee_post_show', [$data['committee']->slug, $p->slug])}}"
                           title="{{$p->title}}">
                            {{$p->title}}
                        </a>
                    </h3>
                    Posted by: {{$p->creator->name}}
                    {{ \Carbon\Carbon::parse($p->updated_at)->format(' F j, Y') }}
                @empty
                    <p class="text-secondary">
                        No posts yet, but there will be soon!
                    </p>
                @endforelse
            </div>
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
@endsection
