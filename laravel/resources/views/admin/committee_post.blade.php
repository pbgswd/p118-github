@extends('layouts.dashboard',  ['title' => ' <i class="fas fa-edit"></i>' . $data["action"] . ' post ' .
        ($data["action"] == 'Edit' ? $data['post']->title : ' in ' . $data['post']['committee']->name) ])
@section('content')
    @include('admin.admin_partials.admin_tinymce')
<div class="container">
    <h3>
        <a href="{{route('admin_committee_show', $data['post']['committee']->slug)}}">
            <i class="far fa-arrow-alt-circle-left"></i>
            {{$data['post']['committee']->name}} Committee Page
        </a> |
        <a href="{{ route('committee_posts_list', $data['post']['committee']->slug) }}">
            <i class="far fa-arrow-alt-circle-left"></i>
            List of posts
        </a>
    </h3>
    <form method="post" name="post" action="{{ url()->current() }}" enctype="multipart/form-data"
          class="needs-validation" novalidate>
        {!! csrf_field() !!}
        <div class="row">
            <div class="form-group">
                <div class="col-lg-2">
                    <h4>Title</h4>
                </div>
                <div class="col-lg-10">
                    <input type="text" class="form-control"  placeholder="Title" name="post[title]"
                           value="{{ old('post.title', $data['post']->title)}}" size="80" required/>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <div class="col-lg-2">
                    <h4>Content</h4>
                </div>
                <div class="col-lg-10">
                    <textarea name="post[content]" id="post-content" placeholder="Content"
                              class="form-control">{{old('post.content', $data['post']->content)}}</textarea>
                </div>
            </div>
        </div>
        <div class="row mt-lg-3">
            <div class="col-md-4">
                <div class="col-lg-2">
                    <h4>Status</h4>
                </div>
                <div class="col-sm">
                    <label>
                        <input name="post[sticky]" type="hidden" value="0" />
                        <input name="post[sticky]" type="checkbox"
                               value="1" {{ checked(old('post.sticky',$data['post']->sticky)) }} />
                        Sticky (on top)?
                    </label>
                </div>
                <div class="col-sm">
                    <!--
                    <label>
                        <input name="post[allow_comments]" type="hidden" value="0" />
                        <input name="post[allow_comments]" type="checkbox"
                               value="1" {{ checked(old('post.allow_comments', $data['post']->allow_comments)) }} />
                        Allow Comments
                    </label>
                    -->
                </div>
                <div class="col-sm">
                    <label>
                         <input name="post[live]" type="hidden" value="0" />
                         <input name="post[live]" type="checkbox"
                                value="1" {{ checked( old('post.live', $data['post']->live)) }} /> Check now to make Live
                    </label>
                    <p>ie.: Draft or Published.</p>
                </div>
            </div>
        </div>
        <div class="row mt-lg-3">
            <div class="col-sm">
                <i class="fas fa-edit fa-2x"></i>
                <input class="btn btn-outline-primary" type="submit" value="{{ $data['action'] }}" />
            </div>
    </form>
            @if ($data['action'] == 'Edit')
                 <div class="col-sm" style="float:right">
                     <form name="delete" method="POST"
                           action="{{route('committee_post_destroy', $data['post']['committee']->slug  )}}">
                         {!! csrf_field() !!}
                         {!! method_field('DELETE') !!}
                        <i class="far fa-trash-alt fa-2x"></i>
                        <input type="hidden" name="id[]" value="{{ $data['post']->id }}">
                        <input class="btn btn-outline-danger" type="submit" value="Delete">
                    </form>
                 </div>
                <div class="row mt-lg-3 mb-lg-3">
                    Post added by {{$data['post']->creator->name}}
                </div>
            @endif
        </div>
<!--
    @if ($data['action'] == 'Edit')
        <div class="row mt-lg-5 mb-lg-5">
            <div class="col-12">
                <h2>
                    {{$data['post']->admin_post_comments->count()}} Post
                    {{Str::plural('Comment', $data['post']->admin_post_comments->count())}}.
                    <a href="{{route('admin_committee_post_comment', $data['post']->slug)}}">
                        <button type="button" class="btn btn-outline-success">Add New</button>
                    </a>
                </h2>
            </div>
        </div>
        @foreach ($data['post']->admin_post_comments as $pc)
            <div class="row border border-dark rounded pb-lg-3 pt-lg-2 mb-lg-3">
                <div class="col-md-3">
                    By: {{$pc->comment_author->name}}
                </div>
                <div class="col-md-3">
                    Created: {{ \Carbon\Carbon::parse($pc->created_at)->format(' F j, Y H:i:s') }}
                </div>
                <div class="col-md-3">
                    Last updated: {{ \Carbon\Carbon::parse($pc->updated_at)->format(' F j, Y H:i:s') }}
                </div>
                <div class="col-md-3">
                    Live status: {{$pc->live ? "Live" : 'Not Live'}}
                </div>
                <div class="col-12 p-lg-4">
                        {!! $pc->content !!}
                </div>
                <div class="col-12 p-lg-4">
                    <div class="col-6" style="float:left">
                        <a href="{{ route('admin_committee_post_comment_edit',
                                [$data['post']->slug, $pc->id])}}" title="Edit Comment">
                            <i class="fas fa-edit fa-2x"></i>
                            <button type="button" class="btn btn-outline-primary">Edit</button>
                        </a>
                    </div>
                    <div class="col-4" style="float:right">
                        <form name="delete" method="POST" action="{{route('committee_post_comment_destroy')}}">
                            {!! csrf_field() !!}
                            {!! method_field('DELETE') !!}
                            <i class="far fa-trash-alt fa-2x"></i>
                            <input type="hidden" name="id[]" value="{{$pc->id}}">
                            <input class="btn btn-outline-danger" type="submit" value="Delete">
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
    -->
@endsection
