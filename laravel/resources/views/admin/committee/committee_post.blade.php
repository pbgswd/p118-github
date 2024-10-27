@extends('layouts.dashboard',  ['title_icon' => ' <i class="fas fa-edit"></i>', 'title' => $data["action"] . ' post ' .
        ($data["action"] == 'Edit' ? $data['post']->title : ' in ' . $data['committee']->name) ])
@section('content')
    @include('admin.admin_partials.admin_tinymce')
<div class="container">
    <div class="row mb-5">
        <div class="col-12 col-md-6">
            <h4>
                <a href="{{route('admin_committee_show', $data['committee']->slug)}}">
                    <i class="far fa-arrow-alt-circle-left"></i>
                    {{$data['committee']->name}} Page
                </a> |
                <a href="{{ route('committee_posts_list', $data['committee']->slug) }}">
                    <i class="far fa-arrow-alt-circle-left"></i>
                    List of posts
                </a>
            </h4>
        </div>
        @if($data['action'] == 'Edit')
            <div class="col-12 col-md-6 text-md-right">
                <a href="{{route('public_committee_post_show',
                    [$data['committee']->slug, $data['post']->slug])}}"
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

                    <h5 class="mt-3">Strongly recommended title format</h5>
                    <p>
                        <i>The format for post title should be like this:</i>
                        <br /><kbd>committeeItem - Month year</kbd>
                        <i>or</i> <kbd>YWC Meeting Minutes - March 11th - 2021</kbd>
                        <i>or</i> <kbd>YWC Report - May 2020</kbd>.
                    </p>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="form-group">
                <div class="col-12">
                    <h4>Content</h4>
                </div>
                <div class="col-12">
                    <div class="col-12 mb-4">
                        <div class="editor-container editor-container_classic-editor" id="editor-container">
                            <div class="editor-container__editor">
                                <textarea name="post[content]" id="textarea" placeholder="Content" class="form-control text-black">
                                </textarea>
                                <p class="muted">Please post the content of attached PDFs in the Content field.</p>
                            </div>
                        </div>
                    </div>
                    <script type="importmap">
                        {
                            "imports": {
                                "ckeditor5": "/js/ckeditor5/ckeditor5.js",
                                "ckeditor5/": "/js/ckeditor5/"
                            }
                        }
                    </script>
                    <script>
                        var textarea = @json($data['post']->content ?? '');
                        var textarea1 = @json($data['textarea1'] ?? '');
                    </script>
                    <script type="module" src="{{mix('js/ckeditor5/ck_main_admin.js')}}"></script>
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
        <div class="row mt-5">
            <div class="col-12">
                <h4>Files</h4>
                <div class="form-group">
                    <label for="exampleInputFile">
                        <i class="fas fa-cloud-upload-alt fa-2x"></i>
                        Attach files to this post
                    </label>
                    <input type="file" id="inputFile" name="attachments[]" multiple />
                </div>
            </div>
            <div class="col-12">
                <h5>Strongly recommended attachment file names</h5>
                <p>
                    <i>Use the date and title in the file name, like this:</i>
                    <kbd>itemcommittee_ddmmyyyy.pdf</kbd>
                    <i>or</i>
                    <kbd>ReportOrganizing_01032020.pdf</kbd>.
                </p>
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

            @if( $data['action'] == 'Edit')
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
                        @forelse ($data['post']->attachments as $pa)
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
                                    <div class="form-group">
                                        {{ select_options($data['access_levels'],
                                            old('attachment.access_level', $pa->access_level),
                                            ['name' => 'attachment['.$pa->id.'][access_level]',
                                            'class' => 'form-control']) }}
                                    </div>
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
                        @empty
                                <tr>
                                    <td colspan="7">
                                        No Files
                                    </td>
                                </tr>
                        @endforelse
                        @if(count($data['post']->attachments) > 0)
                            <tr>
                                <td colspan="7">
                                    <i class="far fa-trash-alt"></i>
                                    Select checkbox to delete a file
                                </td>
                            </tr>
                        @endif
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
                           action="{{route('committee_post_destroy', $data['committee']->slug)}}">
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
        Post originally added by
        {{ $data['post']->creator->name ?? $data['post']->author_name ?? 'a deleted member'}}.
    </div>
    @endif
@endsection
