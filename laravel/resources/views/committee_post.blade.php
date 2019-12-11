<?php
//dd($data);
$post = $data['committeepost'];
$c = $data['committeepost']->committee;

?>
@extends('layouts.jumbo')
@section('content')
<div class="jumbotron">
    <div class="container border border-dark rounded-lg" style="background: rgba(220,220,220,0.6); padding: 2em">
        <div class="row">
               <h3>
                   <a href="{{ route('hello') }}">Home /</a>
                   <a href="{{route('committees')}}">Committees /</a>
                   <a href="{{ route('committee', $c->slug) }}">{{$c->name}} /</a>
                    {{$post->title}}
               </h3>
        </div>
        <div  class="col-12">
            <h1 class="display-4">{{$post->title}}</h1>
            <h5>By {{$post->creator->name}}, {{$post->updated_at}}</h5>
        </div>
        <div class="col-12">
            {!! $post->content !!}
        </div>
        <div class="row" style="margin-top:3em;">
            <div class="col-12">
                <h5><i class="far fa-comments"></i> {{count($data['committeepost']->committee_post_comments)}} Comments for {{$post->title}}</h5>
                <a href="#comment" title="Go to add my comment"><i class="far fa-comment"></i> Add my comment to {{$post->title}}</a>
            </div>
        </div>

        <div class="row" style="margin-top:3em;">
            <div class="col-12">
                 comments would go in here
            </div>
        </div>



        <div class="row" style="margin-top:3em;">
            <a name="comment"></a>
            <form class="form-horizontal" role="form" action="{{ route('committee_post_comment', [$c->slug, $post->slug]) }}" method="post">
                {!! csrf_field() !!}
                <div class="form-group">
                    <label for="content"  class="col-4 control-label"><i class="far fa-comment"></i> Add my comment</label>
                    <div class="col-8">
                        <textarea name="comment[content]" form-control input-lg" rows="3" cols="100">test content</textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <input class="btn btn-outline-primary" type="submit" value="{{ $data['action'] }}" />
                    </div>
                    <div class="col-6">
                        <button type="reset"
                                class="btn btn-info btn-reset"
                                name="Reset">
                            Reset
                        </button>
                    </div>
                </div>
            </form>
            <ul>
                <li>display form</li>
                <li>first to post a comment?</li>
                <li>count of commments</li>
                <li>list of commments by date</li>
                <li>comments on comments thread</li>
            </ul>
        </div>
    </div>
</div>
@endsection




