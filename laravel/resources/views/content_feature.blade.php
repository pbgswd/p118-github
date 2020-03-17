<?php
$topics = $data['topics'];
$pages = $data['pages'];
$posts = $data['posts'];

?>
<div class="row border border-dark rounded-lg mt-3 pt-3" style="background: rgba(220,220,220,0.6);">

    <div class="col-md-4">
        <div class="col-12">
            <h4><a href="{{route('topics')}}">Topics</a></h4>
        </div>
        @foreach ($topics as $t)
            <div class="col-12 border border-dark rounded-lg mb-2">
            <h3>{{ $t->name }}</h3>
                {!! $t->description !!}
                {!!  substr($t->content, 0, 70)  !!}
                <p>
                    <a class="btn btn-secondary" href="{{ route('topic_show', $t->slug) }}" role="button">View details &raquo;</a>
                </p>
            </div>
        @endforeach
        <div class="col-12">
            <h4><a href="{{route('topics')}}">Topics</a></h4>
        </div>
    </div>

    <div class="col-md-4">
        <div class="col-12">
            <a href="{{route('posts')}}"><h4>Posts</h4><a/>
        </div>
        @foreach ($posts as $post)
            <div class="col-12 border border-dark rounded-lg mb-2">
                <h3>{{ $post->title }}</h3>
                {!! $post->description !!}
                <p>
                    <a class="btn btn-secondary" href="{{ route('post_show', $post->slug) }}" role="button">View details &raquo;</a>
                </p>
            </div>
        @endforeach
        <div class="col-12">
            <a href="{{route('posts')}}"><h4>Posts</h4></a>
        </div>
    </div>

    <div class="col-md-4">
        <div class="col-12">
            <h4><a href="{{route('pages')}}">Pages</a></h4>
        </div>
        @foreach ($pages as $page)
            <div class="col-12 border border-dark rounded-lg mb-2">
                <h3>{{ $page->title }}</h3>
                 {!! $page->description !!}
                <p>
                    <a class="btn btn-secondary" href="{{ route('post_show', $page->slug) }}" role="button">View details &raquo;</a>
                </p>
            </div>
        @endforeach
        <div class="col-12">
            <h4><a href="{{route('pages')}}">Pages</a></h4>
        </div>
    </div>
</div>

