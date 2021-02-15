@extends('layouts.dashboard',  ['title' => ' <i class="fas fa-edit"></i>' . $data["action"] . ' post ' .
        ($data["action"] == 'Edit' ? $data['post']->title : ' in ' . $data['post']['committee']->name) ])
@section('content')
    @include('admin.admin_partials.admin_tinymce')
<div class="container">
    <div class="row mb-5">
        <div class="col-12 col-md-6">
            <h4>
                <a href="{{route('admin_committee_show', $data['post']['committee']->slug)}}">
                    <i class="far fa-arrow-alt-circle-left"></i>
                    {{$data['post']['committee']->name}} Page
                </a> |
                <a href="{{ route('committee_posts_list', $data['post']['committee']->slug) }}">
                    <i class="far fa-arrow-alt-circle-left"></i>
                    List of posts
                </a>
            </h4>
        </div>
        @if($data['action'] == 'Edit')
            <div class="col-12 col-md-6 text-md-right">
                <a href="{{route('public_committee_post_show',
                    [$data['post']['committee']->slug, $data['post']->slug])}}"
                    title="View {{$data['post']->title}}">
                    <i class="fas fa-eye"></i> View on website
                </a>
            </div>
        @endif
    </div>

    <form method="post" name="post" action="{{ url()->current() }}" enctype="multipart/form-data"
          class="needs-validation" novalidate>
        {!! csrf_field() !!}
        <input type="hidden" name="post[access_level]" value="members" />
        <div class="row mt-3">
            <div class="form-group">
                <div class="col-12">
                    <h4>Title</h4>
                </div>
                <div class="col-12">
                    <input type="text" class="form-control"  placeholder="Title" name="post[title]"
                           value="{{ old('post.title', $data['post']->title)}}" size="80" required/>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="form-group">
                <div class="col-12">
                    <h4>Content</h4>
                </div>
                <div class="col-12">
                    <textarea name="post[content]" id="post-content" placeholder="Content"
                              class="form-control">{{old('post.content', $data['post']->content)}}</textarea>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12">
                <h4>Status</h4>
            </div>
            <div class="col-12">
                <label>
                    <input name="post[sticky]" type="hidden" value="0" />
                    <input name="post[sticky]" type="checkbox"
                           value="1" {{ checked(old('post.sticky',$data['post']->sticky)) }} />
                    Sticky (on top)?
                </label>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12">
                <div class="form-group">
                    <label for="exampleInputFile">
                        <i class="fas fa-cloud-upload-alt fa-2x"></i>
                        Attach files to this post
                    </label>
                    <input type="file" id="inputFile" name="attachments[]" multiple />
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12">
                <label>
                     <input name="post[live]" type="hidden" value="0" />
                     <input name="post[live]" type="checkbox"
                            value="1" {{ checked( old('post.live', $data['post']->live)) }} />
                    Check now to make Live
                </label>
                <p>ie.: Draft or Published.</p>
            </div>
        </div>

        <div class="row mt-3">

            @if( $data['action'] == 'Edit' && count($data['post']->attachments) > 0)
                <div class="col-md-12">
                    <h2>Files</h2>
                    <table class="table table-striped table-sm">
                        <thead>
                        <tr>
                            <th> # </th>
                            <th> File </th>
                            <th> Access Level </th>
                            <th> <i class="fas fa-edit"></i> </th>
                            <th> Description </th>
                            <th> Created At </th>
                            <th> Updated At </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($data['post']->attachments as $pa)
                            <tr>
                                <td>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="attachment[{{$pa->id}}][id]"
                                                   value="{{$pa->id}}" />
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <a href="{{route('attachment_download', [$data['post']->getAttachmentFolder(), $pa->id])}}"
                                       title="Download {{$pa->file_name}}">{{$pa->file_name}}</a>
                                </td>
                                <td>
                                    {{$data['post']->access_level}}
                                </td>
                                <td>
                                    <a href="{{route('admin_attachment_edit', $pa->id)}}"
                                       title="edit access level and description for {{$pa->file_name}} on Attachment
                                       page">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                                <td>
                                    <input type="text" class="form-control"
                                           placeholder="Add a description for this file"
                                           name="attachment[{{$pa->id}}][description]"
                                           value="{{ old('attachments.description', $pa->description)}}" size="40"/>
                                </td>
                                <td>
                                    {{$pa->created_at}}
                                </td>
                                <td>
                                    {{$pa->updated_at}}
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="7">
                                <i class="far fa-trash-alt"></i>
                                Select checkbox to delete a file
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <div class="row mt-3">
            <div class="col">
                <i class="fas fa-edit fa-2x"></i>
                <input class="btn btn-outline-primary" type="submit" value="{{ $data['action'] }}" />
            </div>
    </form>
            @if ($data['action'] == 'Edit')
                 <div class="col text-md-right">
                     <form name="delete" method="POST"
                           action="{{route('committee_post_destroy', $data['post']['committee']->slug  )}}">
                         {!! csrf_field() !!}
                         {!! method_field('DELETE') !!}
                        <i class="far fa-trash-alt fa-2x"></i>
                        <input type="hidden" name="id[]" value="{{ $data['post']->id }}">
                        <input class="btn btn-outline-danger" type="submit" value="Delete">
                    </form>
                 </div>
            @endif
        </div>

    @if ($data['action'] == 'Edit')
    <div class="row mt-3 mb-3">
        Post added by {{$data['post']->creator->name}}
    </div>
    @endif
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
