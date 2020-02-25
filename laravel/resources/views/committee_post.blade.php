<?php
$post = $data['committeepost'];
$c = $data['committeepost']->committee;
?>
@extends('layouts.jumbo')
@section('content')
<div class="jumbotron">
    <div class="container border border-dark rounded-lg p-lg-2" style="background: rgba(220,220,220,0.6);">
        <div class="row p-4">
            <div class="col-12">
               <h3>
                   <a href="{{route('committees')}}">Committees /</a>
                   <a href="{{ route('committee', $c->slug) }}">{{$c->name}} </a> /  Posts
               </h3>
            </div>
            <div class="col-12 border border-dark rounded">
                <h1 class="display-4">{{$post->title}}</h1>
                <h5>
                    By {{$post->creator->name}},
                    {{ \Carbon\Carbon::parse($post->updated_at)->format(' F j, Y') }}
                </h5>
                {!! $post->content !!}
                <br clear="all" />

                @hasanyrole('super-admin|admin')
                <h5><a href="{{route('committee_post_edit_form', [$c->slug, $post->slug])}}"><i class="far fa-edit"></i> Edit Post</a></h5>
                @endhasanyrole

            </div>
        </div>
        <div class="row mt-3 p-2">
            <div class="col-6">
                <h5>
                    <i class="far fa-comments"></i>
                    {{count($data['committeepost']->post_comments)}} {{Str::plural('Comment', count($data['committeepost']->post_comments))}} for {{$post->title}}
                </h5>
                <a href="#comment" title="Go to add my comment">
                    <i class="far fa-comment"></i> Add my comment to {{$post->title}}
                </a>
            </div>
            <div class="col-6">
                sort by latest first / first first.
            </div>
        </div>
        <div class="row  mt-3 p-4">
            @foreach($data['committeepost']->post_comments as $comment)
                <div class="col-12 border border-dark rounded mb-4">
                <a title="{{$comment->commentAuthor->name}}" href="{{route('member', $comment->user_id)}}">
                    {{$comment->commentAuthor->name}}
                </a>
                    {{ \Carbon\Carbon::parse($comment->created_at)->format(' F j, Y') }}
                    <br />
                     {!! $comment->content !!}
                    <a href="#" title="{{$post->slug}}/comment/{{$comment->id}}">
                        <i class="far fa-comment"></i> Add my comment to {{$post->title}}
                    </a>
                </div>
            @endforeach
        </div>
        <a name="comment"></a>
        <form class="form-horizontal" role="form" action="{{ route('committee_post_comment', [$c->slug, $post->slug]) }}" method="post">
            {!! csrf_field() !!}
            <div class="row mt-lg-3 p-2">
                <div class="col-12 pb-lg-3">
                    <div class="form-group">
                        <label for="content" class="control-label">
                            <h3><i class="far fa-comment"></i> Add my comment</h3>
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
