@extends('layouts.dashboard',  ['title_icon' => ' <i class="fas fa-gavel"></i> <i class="fas fa-edit"></i>', 'title' =>
    $data["action"] . ' Policy ' . ($data["action"] == 'Edit' ? $data['policy']->title : '') ])
@section('content')
@include('admin.admin_partials.admin_tinymce')
<div class="container">
    <div class="row">
        <div class="col-12 col-md-4">
            <h3>
                <a href="{{ route('policies_list') }}">
                    <i class="far fa-arrow-alt-circle-left"></i>
                    List of Policies
                </a>
            </h3>
        </div>
        @if($data['action'] == 'Edit')
            <div class="col-12 col-md-4 text-md-right">
                <a href="{{route('policy_show_public', $data['policy']->id)}}"
                   title="View {{$data['policy']->title}}">
                    <i class="fas fa-eye"></i> View on website
                </a>
            </div>
            @if($data['existing_message'] === false)
                <div class="col-12 col-md-4 text-md-right">
                    <h4>
                        <a href="{{route('admin_policy_message', $data['policy']->id)}}">
                            <i class="far fa-envelope-open"></i>
                            Send as a message
                        </a>
                    </h4>
                </div>
            @endif
        @endif
    </div>
    <form method="post" name="policy" action="{{ url()->current() }}" enctype="multipart/form-data"
          class="needs-validation" novalidate>
        {!! csrf_field() !!}
        <div class="row mt-lg-3">
            <div class="form-group">
                <div class="col-lg-2"><h4>Title</h4></div>
                <div class="col-lg-10">
                    <input type="text" class="form-control"  placeholder="Title" name="policy[title]"
                           value="{{ old('policy.title', $data['policy']->title)}}" size="80" required/>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <div class="col-12 mt-5">
                    <h4>Description</h4>
                </div>
                <div class="col-12">
                    <div class="col-12 mb-4">
                        <div class=" col editor-container editor-container_classic-editor" id="editor-container">
                            <div class="editor-container__editor">
                    <textarea name="user_info[about]" id="textarea" placeholder="Content" class="form-control text-black">
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
                        var textarea = @json($data['policy']->description ?? '');
                        var textarea1 = @json($data['textarea1'] ?? '');
                    </script>
                    <script type="module" src="{{mix('js/admin/ckeditor5/ck_main_admin.js')}}"></script>
                </div>
            </div>
        </div>
        <div class="row mt-lg-3">
            <div class="col-md-6">
                <div class="form-group">
                    <h4>Start Date of policy</h4>
                        <input
                            type="text"
                            class="form-control"
                            placeholder="YYYY-MM-DD"
                            name="policy[date]"
                            value="{{ old('policy.date', \optional($data['policy']->date)->toDateString())}}"
                            size="10"
                            data-provide="datepicker"
                            data-date-format="yyyy-mm-dd"
                            required />
                </div>
            </div>
        </div>
        <div class="row mt-lg-3">
            <div class="col-12 col-md-2">
                <h4>Status</h4>
            </div>
            <div class="col-12 col-md-6 text-left">
                <label>
                     <input name="policy[live]" type="hidden" value="0" />
                     <input name="policy[live]" type="checkbox" value="1"
                         {{ checked( old('policy.live', $data['policy']->live)) }} />
                    Check now to make Live
                </label>
                <p>ie.: Draft or Published.</p>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12">
                <h2>Files</h2>
            </div>
        </div>
        <div class="row mb-5">
            <div class="col-12">
                <div class="form-group">
                    <label for="exampleInputFile">
                        <i class="fas fa-cloud-upload-alt fa-2x"></i>
                        Add File(s) To policy
                    </label>
                    <input type="file" id="inputFile" name="attachments[]" multiple />
                </div>
            </div>
        </div>
        <div class="row">
        @if ($data['action'] == 'Edit')
            @if(count($data['policy']->attachments) > 0)
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
                        @forelse ($data['policy']->attachments as $attachment)
                            <tr>
                                <td>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="attachment[{{$attachment->id}}][id]"
                                                   value="{{$attachment->id}}" />
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <a href="{{route('attachment_download', [$data['policy']->getAttachmentFolder(),
                                        $attachment->id])}}" title="Download {{$attachment->file_name}}">
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
                                    <a title="Edit page for {{ $attachment->file_name }}"
                                       href="{{ route('admin_attachment_edit', $attachment->id) }}">
                                        <i class="far fa-edit"></i>
                                    </a>
                                </td>
                                <td>
                                    <input type="text" class="form-control"
                                           placeholder="Add a description for this file"
                                           name="attachment[{{$attachment->id}}][description]"
                                           value="{{ old('attachments.description', $attachment->description)}}"
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
                                <td colspan="7">
                                    No files
                                </td>
                            </tr>
                        @endforelse
                        <tr>
                            <td colspan="7">
                                <i class="far fa-trash-alt"></i> Select checkbox to delete a file
                            </td>
                        </tr>
                    </tbody>
                </table>
            @endif
        @endif
    </div>
    <div class="row my-5">
        <div class="col-sm">
            <i class="fas fa-edit fa-2x"></i>
            <input class="btn btn-outline-primary" type="submit" value="{{ $data['action'] }}" />
        </div>
    </form>
        @if ($data['action'] == 'Edit')
             <div class="col-sm" style="float:right">
                 <form name="delete" method="POST" action="{{route('admin_policy_destroy')}}">
                     {!! csrf_field() !!}
                     {!! method_field('DELETE') !!}
                    <i class="far fa-trash-alt fa-2x"></i>
                    <input type="hidden" name="id[]" value="{{ $data['policy']->id }}">
                    <input class="btn btn-outline-danger" type="submit" value="Delete">
                </form>
             </div>
        @endif
    </div>
@endsection
