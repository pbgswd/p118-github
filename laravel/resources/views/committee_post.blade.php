<?php
$post = $data;
$c = $data->committee;
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
            <h5>Comments for {{$post->title}}</h5>
        </div>
        <div class="row" style="margin-top:3em;">

            <form class="form-horizontal" role="form" action="" method="post">
                {!! csrf_field() !!}
                <div class="form-group">
                    <label for="mail_body"  class="col-sm-2 control-label">Message</label>
                    <div class="col-sm-10">
                        <textarea name="mail_body" form-control input-lg" rows="3" cols="100">{{old('mail_body')}}</textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <button
                            class="btn btn-primary g-recaptcha"
                            data-sitekey="6LcxikAUAAAAAAvZhKMlu3bH9dndScyhJk5d4NoF"
                            data-callback=""
                            name="submit">
                            Send
                        </button>
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




