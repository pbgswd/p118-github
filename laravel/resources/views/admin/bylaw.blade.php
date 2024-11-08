@extends('layouts.dashboard',  ['title_icon' => ' <i class="fas fa-gavel"></i>', 'title' => $data["action"] .
    ' By-law ' . ($data["action"] == 'Edit' ? $data['bylaw']->title : '') ])
@section('content')
    @include('admin.admin_partials.admin_tinymce')
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-6">
                <h3>
                    <a href="{{ route('admin_bylaws_list') }}"> <i class="far fa-arrow-alt-circle-left"></i>
                        List of By-laws
                    </a>
                </h3>
            </div>
            @if($data['action'] == 'Edit')
                <a href="{{route('bylaw_show', $data['bylaw']->id)}}"
                   title="View {{$data['bylaw']->title}}">
                    <i class="fas fa-eye"></i>
                    View on website
                </a>
            @endif
        </div>
    <form method="post" name="bylaw" action="{{ url()->current() }}"
          enctype="multipart/form-data" class="needs-validation" novalidate>
        {!! csrf_field() !!}
        <div class="row my-3">
            <div class="form-group">
                <div class="col-l2">
                    <h4>Title</h4>
                </div>
                <div class="col-12">
                    <input type="text" class="form-control"
                           placeholder="Title" name="bylaw[title]"
                           value="{{ old('bylaw.title', $data['bylaw']->title)}}" size="80" required/>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <div class="col-12 mt-3">
                    <h4>Content</h4>
                </div>
                <div class="col-12">
                    <div class="col-12 mb-4">
                        <div class=" col editor-container editor-container_classic-editor" id="editor-container">
                            <div class="editor-container__editor">
                                <textarea name="bylaw[description]" id="textarea" placeholder="Content"
                                          class="form-control text-black">
                                </textarea>
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
                        var textarea = @json( $data['bylaw']->description ?? '');
                        var textarea1 = @json($data['textarea1'] ?? '');
                    </script>
                    <script type="module" src="{{mix('js/admin/ckeditor5/ck_main_admin.js')}}"></script>
                </div>
            </div>
        </div>
        <div class="row my-3">
            <div class="col-md-6">
                <div class="form-group">
                    <h4>Start Date of by-law</h4>
                        <input
                            type="text"
                            class="form-control"
                            placeholder="YYYY-MM-DD"
                            name="bylaw[date]"
                            value="{{ old('bylaw.date', \optional($data['bylaw']->date)->toDateString())}}"
                            size="10"
                            data-provide="datepicker"
                            data-date-format="yyyy-mm-dd"
                            required />
                </div>
            </div>
        </div>
        <div class="row my-3">
            <div class="col-md-4">
                <div class="col-lg-2">
                    <h4>Status</h4>
                </div>
                <div class="col-sm">
                    <label>
                         <input name="bylaw[live]" type="hidden" value="0" />
                         <input name="bylaw[live]" type="checkbox" value="1"
                             {{ checked( old('bylaw.live', $data['bylaw']->live)) }} /> Check now to make Live
                    </label>
                    <p>ie.: Draft or Published.</p>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12 align-middle">
                <h4>Access Level for content</h4>
            </div>
            <div class="col-12">
                <div class="form-group">
                    {{ select_options($data['access_levels'], old('post.access_level', $data['bylaw']->access_level),
                        ['name' => 'bylaw[access_level]', 'class' => 'form-control']) }}
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <h2>Files</h2>
            <div class="col-12">
                <div class="form-group">
                    <label for="exampleInputFile">
                        <i class="fas fa-cloud-upload-alt fa-2x"></i>
                        Add File(s) To bylaw
                    </label>
                    <input type="file" id="inputFile" name="attachments[]" multiple />
                </div>
            </div>
        </div>
        <div class="row mt-3">
            @if ($data['action'] == 'Edit')
                    <div class="col-12">
                        <table class="table table-striped table-sm">
                            <thead>
                            <tr>
                                <th> # </th>
                                <th> File </th>
                                <th> Access Level </th>
                                <th> <i class="far fa-edit"></i></th>
                                <th> Description </th>
                                <th> Created At </th>
                                <th> Updated At </th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($data['bylaw']->attachments as $attachment)
                                <tr>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox"
                                                       name="attachment[id]"
                                                       value="{{$attachment->id}}" />
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="{{route('attachment_download', [
                                            $data['bylaw']->getAttachmentFolder(), $attachment->id])}}"
                                           title="Download {{$attachment['file_name']}}">
                                            {{$attachment->file_name}}
                                        </a>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            {{ select_options($data['access_levels'],
                                                old('attachment.access_level', $attachment->access_level),
                                                ['name' => 'attachment['.$attachment->id.'][access_level]',
                                                'class' => 'form-control']) }}
                                        </div>
                                    </td>
                                    <td>
                                        <a title="Edit page for {{$attachment->file_name }}"
                                           href="{{ route('admin_attachment_edit', $attachment->id) }}">
                                            <i class="far fa-edit"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control"
                                               placeholder="Add a description for this file"
                                               name="attachment[{{$attachment->id}}][description]"
                                               value="{{ old('attachments.description'
                                                            , $attachment->description)}}"
                                               size="40"/>
                                    </td>
                                    <td>
                                        {{$attachment->created_at}}
                                    </td>
                                    <td>
                                        {{$attachment->updated_at}}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">
                                        No files
                                    </td>
                                </tr>
                            @endforelse
                            @if(count($data['bylaw']->attachments) > 0)
                                <tr>
                                    <td colspan="7">
                                        <i class="far fa-trash-alt"></i> Select checkbox to delete a file
                                    </td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
            @endif
        </div>
        <div class="row my-5">
            <div class="col-sm">
                <i class="fas fa-edit fa-2x"></i>
                <input class="btn btn-outline-primary" type="submit" value="{{ $data['action'] }}" />
            </div>
    </form>

    @if ($data['action'] == 'Edit')
         <div class="col-sm text-md-end">
             <form name="delete" method="POST" action="{{route('admin_bylaw_destroy')}}">
                 {!! csrf_field() !!}
                 {!! method_field('DELETE') !!}
                <i class="far fa-trash-alt fa-2x"></i>
                <input type="hidden" name="id[]" value="{{ $data['bylaw']->id }}">
                <input class="btn btn-outline-danger" type="submit" value="Delete">
            </form>
         </div>
    @endif
    </div>
@endsection
