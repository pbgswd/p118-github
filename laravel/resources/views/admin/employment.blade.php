@extends('layouts.dashboard',  ['title_icon' => ' <i class="fas fa-edit"></i>', 'title' => $data["action"] .
    ' Employment Posting ' . ($data["action"] == 'Edit' ? $data['employment']->title : '') ])
@section('content')
    @include('admin.admin_partials.admin_tinymce')
<div class="container">
    <div class="row">
        <div class="col-12 col-md-3">
            <h3>
                <a href="{{ route('admin_employment_list') }}">
                    <i class="far fa-arrow-alt-circle-left"></i> List of employment postings
                </a>
            </h3>
        </div>
        @if($data['action'] == 'Edit')
            <div class="col-12 col-md-3 text-md-right">
                <a href="{{route('job_view', $data['employment']->id)}}"
                   title="View {{$data['employment']->title}}">
                    <i class="fas fa-eye"></i> View on website
                </a>
            </div>
            @if($data['existing_message'] === false)
                <div class="col-12 col-md-3 text-md-right">
                    <h4>
                        <a href="{{route('admin_employment_message', $data['employment']->id)}}">
                            <i class="far fa-envelope-open"></i>
                            Send as a message
                        </a>
                    </h4>
                </div>
            @endif
            <div class="col-12 col-md-3 text-md-right">
                <h4>
                    <a href="{{route('admin_employment_feature', $data['employment']->id)}}">
                        <i class="far fa-envelope-open"></i>
                        Send to Features
                    </a>
                </h4>
            </div>
        @endif
    </div>

    <form method="post" name="employment" action="{{ url()->current() }}" enctype="multipart/form-data"
          class="needs-validation" novalidate>
        {!! csrf_field() !!}

        <div class="row my-3">
            <div class="form-group">
                <div class="col-lg-2">
                    <h4>Title</h4>
                </div>
                <div class="col-lg-10">
                    <input type="text" class="form-control"  placeholder="Title" name="employment[title]"
                           value="{{ old('employment.title', $data['employment']->title)}}" size="80" required/>
                </div>
            </div>
        </div>
        <div class="row my-3">
            <div class="form-group">
                <div class="col-lg-8">
                    <h4>
                        <i class="fas fa-calendar-alt"></i>
                        Date of deadline
                    </h4>
                </div>
                <div class="col-lg-10">
                    <input
                        type='date'
                        name="employment[deadline]"
                        class="form-control"
                        placeholder="YYYY-MM-DD"
                        id="pdate"
                        data-provide="datepicker"
                        data-date-format="yyyy-mm-dd"
                        data-date-startDate="-3d"
                        style='width: 300px;'
                        value="{{ old('employment.date', (
                            $data['employment']->deadline != null ?
                            $data['employment']->deadline->toDateString() :
                             \Carbon\Carbon::now()->format('Y-m-d')) )}}"
                    >
                </div>
            </div>
            @if ($data['action'] == 'Edit')
                <div class="col-12 my-4">
                    <h4>
                        Status: {!! $data['employment']->status ? "<i class='fas fa-check'></i> Open" :
                            "<i class='far fa-times-circle'></i> Closed" !!}
                    </h4>
                </div>
            @endif
        </div>
        <div class="row">
            <div class="form-group">
                <div class="col-12 mt-3">
                    <h4>Description</h4>
                </div>
                <div class="col-12">
                    <div class="col-12 mb-4">
                        <div class=" col editor-container editor-container_classic-editor" id="editor-container">
                            <div class="editor-container__editor">
                                <textarea name="employment[description]" id="textarea" placeholder="Content" class="form-control text-black">
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
                        var textarea = @json($data['employment']->description ?? '');
                        var textarea1 = @json($data['textarea1'] ?? '');
                    </script>
                    <script type="module" src="{{mix('js/admin/ckeditor5/ck_main_admin.js')}}"></script>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <div class="col-lg-2"><h4>Url</h4></div>
                <div class="col-lg-10">
                    <input type="text" class="form-control"  placeholder="https://....." name="employment[url]"
                           value="{{ old('employment.url', $data['employment']->url)}}" size="80" />
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-12">
                <h4>Live on website</h4>
            </div>
            <div class="col-12">
                <label>
                    <input name="employment[live]" type="hidden" value="0" />
                    <input name="employment[live]" type="checkbox" value="1"
                        {{ checked( old('employment.live', $data['employment']->live)) }} />
                    Check now to make Live
                </label>
                <p>ie.: Draft or Published.</p>
            </div>
        </div>
        <div class="row mt-lg-2">
            <h2>Files</h2>
            <div class="col-12 my-4">
                <div class="form-group">
                    <label for="exampleInputFile">
                        <i class="fas fa-cloud-upload-alt fa-2x"></i>
                        Add File(s) To Employment Posting
                    </label>
                    <input type="file" id="inputFile" name="attachments[]" multiple />
                </div>
            </div>
        @if ($data['action'] == 'Edit')
                <div class="col-12 mt-3">
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th> # </th>
                                <th> File </th>
                                <th> Access Level </th>
                                <th> Description </th>
                                <th> Edit </th>
                                <th> Created At </th>
                                <th> Updated At </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data['employment']->attachments as $ma)
                                <tr>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="attachment[{{$ma->id}}][id]"
                                                       value="{{$ma->id}}" />
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="{{route('attachment_download',
                                            [$data['employment']->getAttachmentFolder(), $ma->id])}}"
                                           title="Download {{$ma->file_name}}">{{$ma->file_name}}
                                        </a>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            {{ select_options($data['access_levels'],
                                                old('attachment.access_level', $ma->access_level),
                                                ['name' => 'attachment['.$ma->id.'][access_level]',
                                                'class' => 'form-control']) }}
                                        </div>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control"
                                               placeholder="Add a description for this file"
                                               name="attachment[{{$ma->id}}][description]"
                                               value="{{ old('attachments.description', $ma->description)}}"
                                               size="40"/>
                                    </td>
                                    <td>
                                        <a title="{{ $ma->name }}" href="{{ route('admin_attachment_edit', $ma->id) }}">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td>
                                    <td>
                                       {{$ma->created_at}}
                                    </td>
                                    <td>
                                        {{$ma->updated_at}}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7"> No files </td>
                                </tr>
                            @endforelse
                            @if(count($data['employment']->attachments) > 0)
                            <tr>
                                <td colspan="5">
                                    <i class="far fa-trash-alt"></i> Select checkbox to delete a file
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
        @endif
        </div>
        <div class="row mt-lg-3">
            <div class="col-sm">
                <i class="fas fa-edit fa-2x"></i>
                <input class="btn btn-outline-primary" type="submit" value="{{ $data['action'] }}" />
            </div>
    </form>

    @if ($data['action'] == 'Edit')
         <div class="col-sm" style="float:right">
             <form name="delete" method="POST" action="{{route('admin_employment_destroy')}}">
                 {!! csrf_field() !!}
                 {!! method_field('DELETE') !!}
                <i class="far fa-trash-alt fa-2x"></i>
                <input type="hidden" name="id[]" value="{{ $data['employment']->id }}">
                <input class="btn btn-outline-danger" type="submit" value="Delete Employment Posting">
            </form>
         </div>
    @endif
</div>
@endsection
