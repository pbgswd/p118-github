@extends('layouts.jumbo')
@section('content')
<div class="container">
    <div class="row"  style="background: #fff;">
        <div class="col-12 mb-lg-1">
            <img src="/storage/public/64tsEl26mhTFapH4Rco0QidSjj5yMx9s0cJfePq8.png"
                 style="padding:1em; display: block; margin-left: auto; margin-right: auto;" />
        </div>
    </div>

    <div class="row"  style="background: #fff;">
        <div class="col-12 mb-lg-1 border border-dark rounded-lg" style="height:300px;">
            <h1>Carousel</h1>
        </div>
    </div>
    <div class="row mb-2 mt-lg-5">
        <div class="w-50 col-6 border border-dark rounded-lg pt-2">
            <h1><i class="far fa-newspaper"></i> News & Highlights</h1>
            @if($data['news']['posts']->count() > 0)
                <h3><a href="{{route('posts')}}">Posts</a></h3>
                <ul>
                    @foreach($data['news']['posts'] as $post)
                        <li>
                            <a href="{{route('post_show', $post->slug)}}"
                                title="{{$post->title}}">
                                {{$post->title}}
                            </a>
                            {{$post->updated_at->format('M j Y')}}
                        </li>
                    @endforeach
                </ul>
            @endif
            @if($data['news']['pages']->count() > 0)
                <h3><a href="{{route('pages')}}">Pages</a></h3>
                <ul>
                    @foreach($data['news']['pages'] as $page)
                        <li>
                            <a href="{{route('page_show', $page->slug)}}"
                                title="{{$page->title}}">
                                {{$page->title}}
                            </a>
                            {{$page->updated_at->format('M j Y')}}
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
        <div class="w-50 col-6">
            <div class="col-12 border border-dark rounded-lg mb-lg-1 pt-2">
                <h1><i class="far fa-calendar-alt"></i> Upcoming Shows</h1>
                <ul>
                    <li>Show</li>
                    <li>Show</li>
                    <li>Show</li>
                    <li>Show</li>
                    <li>Show</li>
                </ul>
            </div>

            <div class="col-12 border border-dark rounded-lg">
                <h2>
                    <i class="fas fa-hashtag"></i> Social Media
                </h2>
                <div class="row">
                    <div class="col-6 border border-dark rounded-lg">
                        <ul>
                            <li>
                                <a href="https://twitter.com/IATSE_118" target="_blank" title="IATSE Local 118">
                                    <i class="fab fa-twitter"></i>
                                    @IATSE_118
                                </a>
                            </li>
                            <li>
                                <a href="https://twitter.com/IATSECANADA" target="_blank" title="IATSE Canada">
                                    <i class="fab fa-twitter"></i>
                                    @IATSECANADA
                                </a>
                            </li>
                            <li>
                                <a href="https://twitter.com/IATSEYWC" target="_blank" title="IATSE Young Workers">
                                    <i class="fab fa-twitter"></i>
                                    @IATSEYWC
                                </a>
                            </li>
                            <li>
                                <a href="https://twitter.com/IATSE" target="_blank" title="IATSE">
                                    <i class="fab fa-twitter"></i>
                                    @IATSE
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-6 border border-dark rounded-lg">
                        2
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 border border-dark rounded-lg">
                        3
                    </div>
                    <div class="col-6 border border-dark rounded-lg">
                        4
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-lg-5" style="background: rgba(220,220,220,0.8);">
        <div class="col-12 border border-dark rounded-lg p-lg-4">
            @if($data['birthday'] != '')
                <h2> <i class="fas fa-birthday-cake"></i> {{ $data['birthday'] }}</h2>
            @endif
            <h3>{{$data['years']}} years, since {{$data['foundingYear']}}.</h3>

            <p>
                <span class="dropcap">F</span>ounded on September 13, 1904,
                IATSE Local 118 (International Alliance of Theatrical Stage Employees of the United States and Canada)
                is the labour union supplying technicians, stagehands, artisans and craftspeople to the Greater Vancouver
                entertainment industry, including live theatre, rock and roll, trade shows, and conventions.
                Local 118 has a large, skilled and experienced workforce ready to meet the needs of your production.
            </p>
            <p>
                <a class="btn btn-primary btn-lg" href="/page/history" role="button">Learn more &raquo;</a>
            </p>
        </div>
    </div>
</div>
@endsection
