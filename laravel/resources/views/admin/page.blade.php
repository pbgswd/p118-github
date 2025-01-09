@extends('layouts.dashboard',  ['title_icon' => ' <i class="fas fa-edit"></i>', 'title' => $data["action"] . ' Page ' .
    ($data["action"] == 'Edit' ? $data['page']->title : '') ])
@section('content')
    @include('admin.admin_partials.admin_tinymce')
<div class="container">
    <div class="row">
        <div class="col-12 col-md-3">
            <h3>
                <a href="{{ route('pages_list') }}">
                    <i class="far fa-arrow-alt-circle-left"></i>
                    List of pages
                </a>
            </h3>
        </div>
        @if ($data['action'] == 'Edit')
            <div class="col-12 col-md-3 text-md-right">
                <a href="{{route('page_show', $data['page']->slug)}}"
                   title="View {{$data['page']->title}}">
                    <i class="fas fa-eye"></i> View on website
                </a>
            </div>
            @if($data['existing_message'] === false)
                <div class="col-12 col-md-3 text-md-right">
                    <h4>
                        <a href="{{route('admin_page_message', $data['page']->slug)}}">
                            <i class="far fa-envelope-open"></i>
                            Send as a message
                        </a>
                    </h4>
                </div>
            @endif
            <div class="col-12 col-md-3 text-md-right">
                <h4>
                    <a href="{{route('admin_page_feature', $data['page']->slug)}}">
                        <i class="far fa-envelope-open"></i>
                        Send to Features
                    </a>
                </h4>
            </div>
        @endif
    </div>
    <form method="post" name="page" action="{{ url()->current() }}" enctype="multipart/form-data"
          class="needs-validation" novalidate>
        {!! csrf_field() !!}
        <div class="row mt-4">
            <div class="form-group">
                <div class="col-lg-2"><h4>Title</h4></div>
                <div class="col-lg-10">
                    <input type="text" class="form-control"  placeholder="Title" name="page[title]"
                           value="{{ old('page.title', $data['page']->title)}}" size="80" required/>
                </div>
            </div>
        </div>
        @include('layouts.admin-select-topics')
        <div class="row mt-4">
            <div class="form-group">
                <h4>Content</h4>
                <div class="editor-container editor-container_classic-editor" id="editor-container">
                    <div class="editor-container__editor">
                            <textarea name="page[content]" id="textarea" placeholder="Content"
                                      class="form-control text-black">
                            </textarea>
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
                    var textarea = @json($data['page']->content ?? '');
                    var textarea1 = @json($data['textarea1'] ?? '');
                </script>
                <script type="module" src="{{mix('js/admin/ckeditor5/ck_main_admin.js')}}"></script>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-12 col-md-3">
                <h4>Access Level</h4>
            </div>
            <div class="col-12 col-md-6 text-left">
                <p>Access Level for content:</p>
                <div class="form-group">
                            {{ select_options($data['access_levels'],
                                old('page.access_level', $data['page']->access_level),
                                ['name' => 'page[access_level]', 'class' => 'form-control']) }}
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12">
                <h4>Status</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-3">
                <label>
                    <input name="page[front_page]" type="hidden" value="0" />
                    <input name="page[front_page]" type="checkbox" value="1"
                        {{ checked(old('page.front_page',$data['page']->front_page)) }} />
                    Front Page
                </label>
            </div>
            <div class="col-12 col-md-3">
                <label>
                    <input name="page[landing_page]" type="hidden" value="0" />
                    <input name="page[landing_page]" type="checkbox" value="1"
                        {{ checked(old('page.landing_page', $data['page']->landing_page)) }} />
                    Landing Page
                </label>
            </div>
            <div class="col-12 col-md-3">
                <label>
                     <input name="page[live]" type="hidden" value="0" />
                     <input name="page[live]" type="checkbox" value="1"
                         {{ checked( old('page.live', $data['page']->live)) }} />
                    Check now to make Live
                </label>
                <p>ie.: Draft or Published.</p>
            </div>

        </div>
        <div class="row mt-5">
            <h2>Files</h2>
            <div class="col-12">
                <div class="form-group">
                    <label for="exampleInputFile">
                        <i class="fas fa-cloud-upload-alt fa-2x"></i>
                        Add File(s) To Page
                    </label>
                    <input type="file" id="inputFile" name="attachments[]" multiple />
                </div>
            </div>
            @if( $data['action'] == 'Edit')
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
                    @forelse ($data['page']->attachments as $pa)
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
                                <a href="{{route('attachment_download', [$data['page']->getAttachmentFolder(), $pa->id])}}"
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
                    @if(count($data['page']->attachments) > 0)
                        <tr>
                            <td colspan="7">
                                <i class="far fa-trash-alt"></i>
                                Select checkbox to delete a file
                            </td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            @endif
        </div>
        <div class="row mt-5">
            <div class="col">
                <i class="fas fa-edit fa-2x"></i>
                <input class="btn btn-outline-primary" type="submit" value="{{ $data['action'] }}" />
            </div>
    </form>
        @if ($data['action'] == 'Edit')
             <div class="col text-right">
                 <form name="delete" method="POST" action="{{route('page_destroy')}}">
                     {!! csrf_field() !!}
                     {!! method_field('DELETE') !!}
                    <i class="far fa-trash-alt fa-2x"></i>
                    <input type="hidden" name="id[]" value="{{ $data['page']->id }}">
                    <input class="btn btn-outline-danger" type="submit" value="Delete">
                </form>
             </div>
        @endif
    </div>
    @if($data['action'] == 'Edit')
        <div class="row mt-lg-3 mb-lg-5">
            Page added by
            <a href="{{route('user_edit', $data['page']->user->id)}}">
                {{$data['page']->user->name}}
            </a>
        </div>
    @endif
@endsection
