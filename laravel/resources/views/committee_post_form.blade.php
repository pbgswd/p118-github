@extends('layouts.jumbo',  ['title' => ' <i class="fas fa-edit"></i>' . $data["action"] . 'post' ])
@section('content')
@include('admin.admin_partials.admin_tinymce')
<div class="container border border-dark rounded-lg mt-3 mb-3" style="background: rgba(220,220,220,0.8);">
    <div class="row mt-3 mb-3">
        <div class="col-12">
            <h6>
                <a href="{{ route('committee', $data['post']['committee']->slug) }}">
                    {{$data['post']['committee']->name}}
                </a>
            </h6>
        </div>
        <div class="col-12">
            <h3>
                {{$data['action']}} Post
                @if($data['action'] == "Edit")
                    <a href="{{route('public_committee_post_show',
                        [$data['post']['committee']->slug, $data['post']->slug])}}">
                        {{$data['post']->title}}
                    </a>
                @endif
            </h3>
        </div>
    </div>
    <div class="row mt-3 mb-3">
        <div class="col-12">
            <form method="post" name="post" action="{{ url()->current() }}" enctype="multipart/form-data"
                  class="needs-validation" novalidate>
                {!! csrf_field() !!}
                <input type="hidden" name="post[access_level]" value="members" />
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="inputGroup-sizing-default">Title</span>
                        <input type="text" class="form-control"  placeholder="Title" name="post[title]"
                               value="{{ old('post.title', $data['post']->title)}}" size="80" required/>
                    </div>

                    <label for="post-content" class="control-label">
                        <h4>Content</h4>
                    </label>

                <div class="col-12 mb-3 input-group">
                    <textarea name="post[content]" id="post-content" placeholder="Content" class="form-control">
                        {{old('post.content', $data['post']->content)}}
                    </textarea>
                </div>

                    <div class="row mt-5">
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

                <div class="row mt-5 mb-5">

                    @if( $data['action'] == 'Edit' && count($data['post']->attachments) > 0)
                        <div class="col-12">
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




                <div class="row d-flex justify-content-between">
                    <div class="col-md-6 col-sm-12 mb-lg-3">
                        <i class="fas fa-edit fa-2x"></i>
                        <input class="btn btn-primary" type="submit" value="{{ $data['action'] }}" />
                    </div>
            </form>
                @if ($data['action'] == 'Edit')
                    <div class="col-md-6 col-sm-12 mb-lg-3 text-md-left">
                         @can('manage committee')
                             <form name="delete" method="POST" action="{{route('public_committee_post_destroy',
                                [$data['post']['committee']->slug, $data['post']->slug])}}">
                                 {!! csrf_field() !!}
                                 {!! method_field('DELETE') !!}
                                <i class="far fa-trash-alt fa-2x"></i>
                                <input type="hidden" name="id[]" value="{{ $data['post']->id }}">
                                <input class="btn btn-outline-danger" type="submit" value="Delete">
                            </form>
                         @endcan
                     </div>
                @endif
            </div>
        </div>
    </div>
    @if ( $data['action'] == 'Edit')
        <div class="row mt-3 mb-3">
            Post added by {{$data['post']->creator->name}}
        </div>
    @endif
</div>
@endsection
