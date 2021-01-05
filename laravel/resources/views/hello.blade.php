@extends('layouts.jumbo')
@section('content')
<div class="container">
    <div class="row" style="background: #fff;">
        <div class="col-12 mb-lg-1">
            <img src="/storage/public/64tsEl26mhTFapH4Rco0QidSjj5yMx9s0cJfePq8.png"
                 style="padding:1em; display: block; margin-left: auto; margin-right: auto;" alt="{{env('APP_NAME')}}" />
        </div>
    </div>
    <div class="row">
        <div class="col-12 mb-lg-1 border border-dark rounded-lg
        bg-secondary text-white mx-auto" style="height:300px;">
        </div>
    </div>
    <div class="row border border-dark rounded-lg mt-2 pl-4 pt-2 mb-2">
        <h3>
            <a href="{{route('topic_show', 'news')}}" title="news and highlights">
                <i class="far fa-newspaper"></i> News & Highlights
            </a>
        </h3>
    </div>
    <div class="row mt-2 mb-lg-4">
        <div class="col-6 m-0" style="display: flex;">
            <div class="col-12 border border-dark rounded-lg pt-2 pb-3">
                @if($data['news']['posts']->count() > 0)
                    <h3>
                        <a href="{{route('posts')}}">Posts</a>
                    </h3>
                    <ul class="list-group p-0 m-0">
                        @forelse($data['news']['posts'] as $post)
                            <li class="list-group-item pr-1 m-0">
                                <a href="{{route('post_show', $post->slug)}}"
                                    title="{{$post->title}}">
                                    {{$post->title}}
                                </a>
                                {{$post->created_at->format('M j Y')}}
                            </li>
                            @empty
                            No posts yet
                        @endforelse
                    </ul>
                @endif
            </div>
        </div>
        <div class="col-6">
            <div class="col-12 border border-dark rounded-lg pt-2 pb-3">
            @if($data['news']['pages']->count() > 0)
                <h3>
                    <a href="{{route('pages')}}">Pages</a>
                </h3>
                <ul class="list-group p-0 m-0">
                    @forelse($data['news']['pages'] as $page)
                        <li class="list-group-item pr-1 m-0">
                            <a href="{{route('page_show', $page->slug)}}"
                                title="{{$page->title}}">
                                {{$page->title}}
                            </a>
                            {{$page->created_at->format('M j Y')}}
                        </li>
                    @empty
                        No pages yet
                    @endforelse
                </ul>
            @endif
            </div>
        </div>
    </div>
    <div class="row mt-lg-4">
        <div class="col-12 border border-dark rounded-lg p-lg-4">
            @if($data['birthday'] != '')
                <h2>
                    <i class="fas fa-birthday-cake"></i> {{ $data['birthday'] }}
                </h2>
            @endif
                <h3>
                    {{$data['years']}} years, since {{$data['foundingYear']}}.
                </h3>
            <p>
                <span class="dropcap">F</span>ounded on September 13, 1904,
                IATSE Local 118 (International Alliance of Theatrical Stage Employees of the United States and Canada)
                is the labour union supplying technicians, stagehands, artisans and craftspeople to the Greater
                Vancouver entertainment industry, including live theatre, rock and roll, trade shows, and conventions.
                Local 118 has a large, skilled and experienced workforce ready to meet the needs of your production.
            </p>
            <p>
                <a class="btn btn-primary btn-lg" href="/page/history" role="button">
                    Learn more &raquo;
                </a>
            </p>
        </div>
    </div>
</div>
@endsection
