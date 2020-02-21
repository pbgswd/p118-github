<?php
$post = $data['committeepost'];
$c = $data['committeepost']->committee;
?>
@extends('layouts.jumbo')
@section('content')
<div class="jumbotron">
    <div class="container border border-dark rounded-lg p-lg-2" style="background: rgba(220,220,220,0.6);">
        <div class="row">
               <h3>
                   <a href="{{ route('hello') }}">Home /</a>
                   <a href="{{route('committees')}}">Committees /</a>
                   <a href="{{ route('committee', $c->slug) }}">{{$c->name}} /</a>
                    {{$post->title}}
               </h3>
        </div>
        <div class="col-12 border border-dark rounded">
            <h1 class="display-4">{{$post->title}}</h1>
            <h5>
                By {{$post->creator->name}},
                {{ \Carbon\Carbon::parse($post->updated_at)->format(' F j, Y') }}
            </h5>
            {!! $post->content !!}
        </div>
        <div class="row" style="margin-top:3em;">
            <div class="col-6">
                <h5>
                    <i class="far fa-comments"></i>
                    {{count($data['committeepost']->post_comments)}} Comments for {{$post->title}}
                </h5>
                <a href="#comment" title="Go to add my comment">
                    <i class="far fa-comment"></i> Add my comment to {{$post->title}}
                </a>
            </div>
            <div class="col-6">
                sort by latest first / first first.
            </div>
        </div>
        <div class="row" style="margin-top:3em; padding-top: 1em;">
            @foreach($data['committeepost']->post_comments as $comment)
                <div class="col-12 border border-dark rounded" style="margin-bottom: 1rem;">
                <a title="{{$comment->commentAuthor->name}}" href="{{route('member', $comment->user_id)}}">
                    {{$comment->commentAuthor->name}}
                </a> {{$comment->created_at}} <br />
                     {!! $comment->content !!}
                    <a href="#" title="{{$post->slug}}/comment/{{$comment->id}}">
                        <i class="far fa-comment"></i> Add my comment to {{$comment->commentAuthor->name}}
                    </a>
                </div>
            @endforeach
        </div>
        <a name="comment"></a>
        <form class="form-horizontal" role="form" action="{{ route('committee_post_comment', [$c->slug, $post->slug]) }}" method="post">
            {!! csrf_field() !!}
            <div class="row" style="margin-top:3em;">
                <div class="col-12" style="padding-bottom: 3rem;">
                    <div class="form-group">
                        <label for="content" class="control-label">
                            <i class="far fa-comment"></i> Add my comment
                        </label>
                        <textarea name="comment[content]" class="form-control input-lg" rows="3" cols="100" placeholder="Your comments"></textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-2">
                </div>
                <div class="col-4">
                    <input class="btn btn-primary" type="submit" value="{{ $data['action'] }}" />
                </div>
                <div class="col-4">
                    <button type="reset"
                            class="btn btn-outline-primary btn-reset"
                            name="Reset">
                        Reset
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection




