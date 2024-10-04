@extends('layouts.dashboard',  ['title' => ' <i class="fas fa-edit"></i>' . $data["action"] . ' Meeting Minutes' .
    ($data["action"] == 'Edit' ?  ' - ' . $data['meeting']->title : '') ])
@section('content')
    @include('admin.admin_partials.admin_tinymce')
<div class="container">
    <div class="row">
        <div class="col-12 col-md-6">
            <a href="{{ route('meetings_list') }}">
                <i class="far fa-arrow-alt-circle-left"></i>
                List of meetings
            </a>
        </div>
        @if($data['action'] == 'Edit')
            <div class="col-12 col-md-6 text-md-right">
                <a href="{{route('meeting', $data['meeting']->id)}}"
                   title="View {{$data['meeting']->title}}">
                    <i class="fas fa-eye"></i> View on website
                </a>
            </div>
        @endif
    </div>
    <form method="post" name="meeting" action="{{ url()->current() }}" enctype="multipart/form-data"
          class="needs-validation" novalidate>
        {!! csrf_field() !!}
        <div class="row">
            <div class="form-group">
                <div class="col-12 my-3">
                    <h4>Title</h4>
                </div>
                <div class="col-12 my-3">
                    <input type="text" class="form-control"  placeholder="Title" name="meeting[title]"
                           value="{{ old('meeting.title', $data['meeting']->title)}}" size="80" required/>
                </div>
            </div>
        </div>
        <div class="row my-3">
            <div class="form-group">
                <div class="col-12">
                    <h4><i class="fas fa-calendar-alt"></i> Date</h4>
                </div>
                <div class="col-12">
                    <input
                        type="text"
                        class="form-control"
                        placeholder="YYYY-MM-DD"
                        name="meeting[date]"
                        value="{{ old('meeting.date', \optional($data['meeting']->date)->toDateString())}}"
                        size="80"
                        data-provide="datepicker"
                        data-date-format="yyyy-mm-dd"
                        required />
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
                                <textarea name="meeting[description]" id="textarea" placeholder="Content" class="form-control text-black">
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
                        var textarea = @json($data['meeting']->description ?? '');
                        var textarea1 = @json($data['textarea1'] ?? '');
                    </script>
                    <script type="module" src="{{mix('js/ckeditor5/ck_main_admin.js')}}"></script>
                </div>
            </div>
        </div>
        <div class="col-12">
            <h4>Status</h4>
        </div>
        <div class="col-12">
            <label>
                <input name="meeting[live]" type="hidden" value="0" />
                <input name="meeting[live]" type="checkbox" value="1" {{ checked( old('meeting.live', $data['meeting']->live)) }} /> Check now to make Live
            </label>
            <p>ie.: Draft or Published.</p>
        </div>
        <div class="row my-5">
            <h4>Files</h4>
            <div class="col-12">
                <div class="form-group">
                    <label for="exampleInputFile">
                        <i class="fas fa-cloud-upload-alt fa-2x"></i>
                        Add File(s) To Meeting
                    </label>
                    <input type="file" id="inputFile" name="attachments[]" multiple />
                </div>
            </div>
        </div>
        @if ($data['action'] == 'Edit')
            @if(count($data['meeting']->attachments) > 0)
                <div class="col-12">
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th> # </th>
                                <th> File </th>
                                <th> Access Level </th>
                                <th> <i class="far fa-edit"></i> </th>
                                <th> Description </th>
                                <th> Created At </th>
                                <th> Updated At </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data['meeting']->attachments as $ma)
                                <tr>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="attachment[{{$ma->id}}][id]" value="{{$ma->id}}" />
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="{{route('attachment_download', [$data['meeting']->getAttachmentFolder(), $ma->id])}}" title="Download {{$ma->file_name}}">{{$ma->file_name}}</a>
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
                                        <a title="Edit page for {{ $ma->file_name }}" href="{{ route('admin_attachment_edit', $ma->id) }}"><i class="far fa-edit"></i></a>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control"  placeholder="Add a description for this file" name="attachment[{{$ma->id}}][description]" value="{{ old('attachments.description', $ma->description)}}" size="40"/>
                                    </td>
                                    <td>
                                        {{$ma->created_at}}
                                    </td>
                                    <td>
                                        {{$ma->updated_at}}
                                    </td>
                                </tr>
                            @empty
                                <td colspan="7">
                                    No attached files
                                </td>
                            @endforelse
                            <tr>
                                <td colspan="7">
                                    <i class="far fa-trash-alt"></i> Select checkbox to delete a file
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            @endif
        @endif
        <div class="row mb-lg-5">
            <div class="col-sm-12 col-md-6 mb-sm-5 mb-md-0">
                <i class="fas fa-edit fa-2x"></i>
                <input class="btn btn-outline-primary" type="submit" value="{{ $data['action'] }}" />
            </div>
    </form>
    @if ($data['action'] == 'Edit')
         <div class="col-sm-12 col-md-6 mt-sm-5 mt-md-0 text-md-end">
             <form name="delete" method="POST" action="{{route('meeting_destroy')}}">
                 {!! csrf_field() !!}
                 {!! method_field('DELETE') !!}
                <i class="far fa-trash-alt fa-2x"></i>
                <input type="hidden" name="id[]" value="{{ $data['meeting']->id }}">
                <input class="btn btn-outline-danger" type="submit" value="Delete Meeting">
            </form>
         </div>
    @endif
    </div>
</div>
@endsection
