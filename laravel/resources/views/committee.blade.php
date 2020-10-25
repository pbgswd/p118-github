<?php
/** @var TYPE_NAME $data */
$c = $data['committee'];
$execs = $data['executives'];
?>
@extends('layouts.jumbo')
@section('content')
<div class="jumbotron">
    <div class="container border border-dark rounded-lg p-4" style="background: rgba(220,220,220,0.8);">
        <div class="row">
            <div class="col-12">
                <h2>
                    <a href="{{route('committees')}}">Committees /</a>&nbsp;{{$c->name}}
                </h2>
            </div>
            <div class="col-12">
                <h2>{!! $c->description !!}</h2>
            </div>
            <div class="col-12 mb-4">
                <h4>
                    <i class="far fa-newspaper"></i> {{$c->postsCount}} {{Str::plural('Post', $c->postsCount ) }}
                    @if($data['isMember'] == 1)
                        | <i class="far fa-edit"></i><a href="{{route('committee_add_public_post', $c->slug)}}">
                            Add New Post
                        </a>
                    @endif
                </h4>
            </div>
            @foreach($c->posts as $p)
                <div class="col-12 border border-dark rounded-lg m-1">
                    <h3>
                        <a href="{{route('public_committee_post_show', [$c->slug, $p->slug])}}" title="{{$p->title}}">
                            {{$p->title}}
                        </a>
                    </h3>

                    {{ \Carbon\Carbon::parse($p->updated_at)->format(' F j, Y') }}
                </div>
            @endforeach
            @if($c->posts->count() > 5)
                <div class="row mt-lg-4">
                    <div class="col-3 text-center">
                        {!! $c->posts->links() !!}
                    </div>
                </div>
            @endif
        </div>
        <div class="row mt-3">
            <div class="col-12 mr-2 pt-lg-2 border border-dark rounded-lg">
                <h5>{{$c->name}} Executive</h5>
                <p>
                    @foreach ($execs as $exec)
                        <i class="fas fa-user-tie"></i> {{$exec->pivot->role}}:
                        <a href="{{route('member', $exec->id)}}">{{$exec->name}}
                        </a> <br />
                    @endforeach
                </p>
                <p>
                    <i class="far fa-envelope"></i>
                    Email:
                    <a href="mailto:{{$data['committee']->email}}?subject={{$data['committee']->name}} committee">
                        {{$data['committee']->email}}
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
