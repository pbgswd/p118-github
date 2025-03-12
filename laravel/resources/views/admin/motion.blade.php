@extends('layouts.dashboard',  ['title_icon' => ' <i class="fas fa-edit"></i>', 'title' =>  $data["action"] .
    ' motion' .  ($data["action"] == 'Edit' ?  ' - ' . $data['motion']->title : '') ])
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 col-md-3">
            <a href="{{ route('admin_motions_list') }}">
                <i class="far fa-arrow-alt-circle-left"></i>
                List of Motions
            </a>
        </div>
        @if($data['action'] == 'Edit')
            <div class="col-12 col-md-3 text-md-right">
                <a href="{{route('motion', $data['motion']->id)}}"
                   title="View {{$data['motion']->title}}">
                    <i class="fas fa-eye"></i> View on website
                </a>
            </div>
        @endif
    </div>
    <div class="row mt-3">
        <div class="col-12">
            <h3>
                {{Auth::user()->name}} - {{$data['action']}} Motion
            </h3>
        </div>
    <form method="post" name="Motion" action="{{ url()->current() }}" enctype="multipart/form-data"
          class="needs-validation" novalidate>
        {!! csrf_field() !!}
        <div class="row">
            <div class="form-group">
                <div class="col-12 my-3">
                    <h4>Title</h4>
                </div>
                <div class="col-12 my-3">
                    <input type="text" class="form-control"  placeholder="Add a Title" name="motion[title]"
                           value="{{ old('motion.title', $data['motion']->title)}}" size="80" required/>
                </div>
            </div>
        </div>
        @if($data['action'] == 'Edit')
            <div class="row my-3">
                <div class="col-12">
                    <h4>
                        <i class="fas fa-calendar-alt"></i> Date
                            (Currently stored date, will be updated: {{$data['motion']->date->format('F d, Y')}})
                    </h4>
                </div>
            </div>
        @endif
        <div class="row">
            <div class="col-12 my-3">
                <h4>Type of submission</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-6 mb-2 text-center">
                <input type="radio" class="btn-check float-auto" name="motion[submission_type]"
                       value="Motion" id="option4" autocomplete="off"
                       @if($data['upcoming']->count() > 0 && (Carbon\Carbon::today()->diffInDays($data['upcoming'][0]->date)-10 > 0)
                            || $data['upcoming']->count() == 0)
                           required
                       @else
                           disabled
                    @endif
                      {{$data['motion']->submission_type == "Motion" ? 'checked' : ''}}
                >
                <label class="btn btn-outline-primary" for="option4">New Motion</label>
                <br />
                <div class="card text-bg-info text-white my-3 mx-auto h-80" style="max-width: 20rem;">
                    <div class="card-header">
                        <h4>For New Motions</h4>
                    </div>
                    <div class="card-body">
                        <p class="card-text">
                            @if($data['upcoming']->count() > 0)
                                The next General Meeting will be held
                                {{$data['upcoming'][0]->date->format('F j Y')}},
                                {{$data['upcoming'][0]->date->format('g:i:s A')}}, in
                                {{Carbon\Carbon::today()->diffInDays($data['upcoming'][0]->date)}}
                                {{Str::plural('day', Carbon\Carbon::today()->diffInDays($data['upcoming'][0]->date))}}.
                            @else
                                Your motion will be attached to the next meeting.
                            @endif
                        </p>
                        <h4 class="card-title">
                            <strong>Submit in time</strong>
                        </h4>
                        @if($data['upcoming']->count() > 0)
                            @if(Carbon\Carbon::today()->diffInDays($data['upcoming'][0]->date)-10 > 0)
                                <p class="card-text h4">
                                    {{Carbon\Carbon::today()->diffInDays($data['upcoming'][0]->date)-10}}
                                    {{Str::plural('day', (Carbon\Carbon::today()->diffInDays($data['upcoming'][0]->date)-10))}}
                                    remaining to submit new motions.
                                </p>
                            @else
                                <p class="card-text">
                                    Unable to submit new Motions with less than 10 days
                                    prior to Meeting date.
                                </p>
                            @endif
                        @endif
                        <p class="card-text">
                            <i class="fas fa-exclamation-triangle"></i>
                            General Meeting motions must be received by the Executive Committee at
                            least <u>10 days</u> prior to the meeting date.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-sm-12 col-md-6 mb-2 mx-auto text-center">
                <input type="radio" class="btn-check" name="motion[submission_type]"
                       value="New Business" id="option5" autocomplete="off"
                       @if($data['upcoming']->count() > 0 && Carbon\Carbon::today()->diffInHours($data['upcoming'][0]->date)-48 > 0
                             || $data['upcoming']->count() == 0)
                           required
                       @else
                           disabled
                    @endif
                    {{$data['motion']->submission_type == "New Business" ? 'checked' : ''}}
                >
                <label class="btn btn-outline-primary" for="option5">New Business</label>
                <div class="card text-bg-info text-white my-3 mx-auto h-80" style="max-width: 20rem;">
                    <div class="card-header"><h4>For New Business</h4></div>
                    <div class="card-body">
                        <p class="card-text">
                            @if($data['upcoming']->count() > 0)
                                @if(Carbon\Carbon::today()->diffInHours($data['upcoming'][0]->date->subDays(2)) > 48)
                                    New Business submissions allowed until
                                    {{$data['upcoming'][0]->date->subDays(2)->format('F j Y')}},
                                    {{$data['upcoming'][0]->date->format('g:i:s A')}}.
                                    @if(Carbon\Carbon::today()->diffInHours($data['upcoming'][0]->date->subDays(2)) < 73)
                                        {{Carbon\Carbon::today()->diffInHours($data['upcoming'][0]->date->subDays(2))}}
                                        {{Str::plural('hour', Carbon\Carbon::today()->diffInHours($data['upcoming'][0]->date->subDays(2)))}}
                                        remaining to submit new business.
                                    @endif
                                @else
                                    Unable to submit New Business with less than 48 hours
                                    prior to Meeting time.
                                @endif
                                <br />
                            @else
                                Your new business will be attached to the next meeting.
                            @endif
                        </p>
                        <h4 class="card-title">
                            <strong>Submit in time</strong>
                        </h4>
                        <p class="card-text">
                            <i class="fas fa-exclamation-triangle"></i>
                            New Business must be received by the Executive Committee at
                            least <u>48 hours</u> prior to the meeting start time.
                        </p>
                    </div>
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
                                <textarea name="motion[description]" id="textarea" placeholder="Content" class="form-control text-black">
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
                        var textarea = @json($data['motion']->description ?? '');
                        var textarea1 = @json($data['textarea1'] ?? '');
                    </script>
                    <script type="module" src="{{mix('js/admin/ckeditor5/ck_main_admin.js')}}"></script>
                </div>
            </div>
        </div>
        <div class="row my-5">
            <h4>Files</h4>
            <div class="col-12">
                <div class="form-group">
                    <label for="exampleInputFile">
                        <i class="fas fa-cloud-upload-alt fa-2x"></i>
                        Add File(s) To Motion
                    </label>
                    <input type="file" id="inputFile" name="attachments[]" multiple />
                </div>
            </div>
        </div>
        @if ($data['action'] == 'Edit')
            @if(count($data['motion']->attachments) > 0)
                <div class="col-12">
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th> # </th>
                                <th> File </th>
                                <th> <i class="far fa-edit"></i> </th>
                                <th> Description </th>
                                <th> Created At </th>
                                <th> Updated At </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data['motion']->attachments as $ma)
                                <tr>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="attachment[{{$ma->id}}][id]" value="{{$ma->id}}" />
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="{{route('attachment_download', [$data['motion']->getAttachmentFolder(), $ma->id])}}" title="Download {{$ma->file_name}}">{{$ma->file_name}}</a>
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
             <form name="delete" method="POST" action="{{route('admin_motion_destroy')}}">
                 {!! csrf_field() !!}
                 {!! method_field('DELETE') !!}
                <i class="far fa-trash-alt fa-2x"></i>
                <input type="hidden" name="id[]" value="{{ $data['motion']->id }}">
                <input class="btn btn-outline-danger" type="submit" value="Delete Motion">
            </form>
         </div>
    @endif
    </div>
</div>
@endsection
