@extends('layouts.dashboard',  ['title' => ' <i class="fas fa-edit"></i>' . $data["action"]
     . ' post ' . ($data["action"] == 'Edit' ? $data['post']->name : '') ])
@section('content')
    @include('admin.admin_partials.admin_tinymce')
<div class="container">
    <div class="row my-4">
        <div class="col-12 col-md-4">
            <h4>
                <a href="{{ route('posts_list') }}">
                    <i class="far fa-arrow-alt-circle-left"></i>
                    List of posts
                </a>
            </h4>
        </div>
        @if ($data['action'] == 'Edit')
            <div class="col-12 col-md-4 text-md-right">
                <h4>
                    <a href="{{route('post_show', $data['post']->slug)}}"
                       title="View {{$data['post']->title}}">
                        <i class="fas fa-eye"></i> View on website
                    </a>
                </h4>

            </div>
            <div class="col-12 col-md-4 text-md-right">
                <h4>
                    <a href="{{route('admin_post_message', $data['post']->slug)}}">
                        <i class="far fa-envelope-open"></i>
                        Send to message
                    </a>
                </h4>

            </div>
        @endif
    </div>
    <form method="post" name="post" action="{{url()->current()}}" enctype="multipart/form-data"
          class="needs-validation" novalidate>
        {!! csrf_field() !!}
        <div class="row">
            <div class="col-12 mt-2">
                <h4>Title</h4>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <input type="text" class="form-control"  placeholder="Title" name="post[title]"
                           value="{{ old('post.title', $data['post']->title)}}" size="80" required/>
                </div>
            </div>
            <div class="col-12 col-md-6 font-weight-bold mt-2">
                @foreach($data['topics'] as $topic)
                    {{ in_array($topic->id, $data['assignedTopics']) ? $topic->name . " | " : '' }}
                @endforeach
            </div>
            @include('layouts.admin-select-topics')
            <div class="col-12 mt-4">
                <h4>Content</h4>
            </div>
            <div class="input-group mb-4">
                <textarea name="post[content]" id="post-content" placeholder="Content" class="form-control">
                    {{old('post.content', $data['post']->content)}}
                </textarea>
            </div>
        </div>
        <div class="row mt-3 mb-2 pb-2 pt-2">
            <div class="col-12 col-md-4 text-md-right">
                <h4>Access Level for content</h4>
            </div>
            <div class="col-12 col-md-5 text-left">
                <div class="form-group">
                    {{ select_options($data['access_levels'], old('post.access_level',
                        $data['post']->access_level), ['name' => 'post[access_level]',
                        'class' => 'form-control']) }}
                </div>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-12 col-md-4 text-md-right">
                <h4>Status</h4>
            </div>
            <div class="col-12 col-md-6">
            <div class="d-flex flex-row pl-2 pr-2 mr-2">
                <div class="p-2">
                    <label>
                        <input name="post[front_page]" type="hidden" value="0" />
                        <input name="post[front_page]" type="checkbox" value="1"
                            {{ checked(old('post.front_page',$data['post']->front_page)) }} /> Front Page
                    </label>
                </div>
                <div class="p-2">
                    <label>
                        <input name="post[landing_page]" type="hidden" value="0" />
                        <input name="post[landing_page]" type="checkbox" value="1"
                            {{ checked(old('post.landing_page', $data['post']->landing_page)) }} />
                        Landing Page
                    </label>
                </div>
                <div class="p-2">
                    <label>
                         <input name="post[live]" type="hidden" value="0" />
                         <input name="post[live]" type="checkbox" value="1"
                             {{ checked( old('post.live', $data['post']->live)) }} /> Check now to make Live
                    </label>
                    <p>ie.: Draft or Published.</p>
                </div>
            </div>
        </div>
        </div>

        <div class="row mt-3 mb-3">
            <div class="col-12">
                <div class="form-group">
                    <label for="exampleInputFile">
                        <i class="fas fa-cloud-upload-alt fa-2x"></i>
                        Add File(s) To Page
                    </label>
                    <input type="file" id="inputFile" name="attachments[]" multiple />
                </div>
            </div>
        </div>
        @if ($data['action'] == 'Edit')
            @if(count($data['post']->attachments) > 0)
                <div class="col-md-12">
                    <h2>Files</h2>
                    <div class="table-responsive">
                        <table class="table table-striped table-sm">
                            <thead>
                            <tr>
                                <th> # </th>
                                <th> File </th>
                                <th> Access Level</th>
                                <th> </th>
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
                                        <a href="{{route('attachment_download',
                                            [$data['post']->getAttachmentFolder(), $pa->id])}}"
                                            title="Download {{$pa->file_name}}">
                                            {{$pa->file_name}}
                                        </a>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            {{ select_options($data['access_levels'],
                                                old('attachment.access_level', $pa->access_level),
                                                ['name' => 'attachment['.$pa->id.'][access_level]',
                                                'class' => 'form-control']) }}
                                        </div>
                                    </td>
                                    <td>
                                        <a title="edit access_level, description for {{ $pa->file_name }}"
                                           href="{{ route('admin_attachment_edit', $pa->id) }}">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control"
                                               placeholder="Add a description for this file"
                                               name="attachment[{{$pa->id}}][description]"
                                               value="{{ old('attachments.description', $pa->description)}}"
                                               size="40"/>
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
                                <td colspan="5">
                                    <i class="far fa-trash-alt"></i>
                                    Select checkbox to delete a file
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        @endif
        <div class="row m-0 mt-5 mb-5 p-0 pb-0">
            <div class="col text-left">
                <i class="fas fa-edit fa-2x"></i>
                <input class="btn btn-outline-primary" type="submit" value="{{ $data['action'] }}" />
            </div>
    </form>
            @if ($data['action'] == 'Edit')
                 <div class="col text-right">
                     <form name="delete" method="POST" action="{{route('post_destroy')}}">
                         {!! csrf_field() !!}
                         {!! method_field('DELETE') !!}
                        <i class="far fa-trash-alt fa-2x"></i>
                        <input type="hidden" name="id[]" value="{{ $data['post']->id }}">
                        <input class="btn btn-outline-danger" type="submit" value="Delete">
                    </form>
                 </div>
            @endif
        </div>
            @if ( $data['action'] == 'Edit')
                <div class="row mt-5 mb-3 pt-2 text-left"> &nbsp;
                    Post added by {{$data['post']->user->name}}
                </div>
            @endif
        </div>
@endsection
