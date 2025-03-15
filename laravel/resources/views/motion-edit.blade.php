@extends('layouts.jumbo')
@section('content')

<div class="jumbotron">
    <div class="container border border-dark rounded" style="background: rgba(220,220,220,0.8);">
        <div class="row">
            <div class="col-sm-12 col-md-6 text-start">

            <a href="{{route('list_meetings')}}" title="List Meetings">
                <i class="far fa-arrow-alt-circle-left"></i>
                Meetings
            </a>
            </div>
            <div class="col-sm-12 col-md-6 text-end">
                <h4>
                    @can(['edit articles'])
                        <div class="badge bg-primary-outline">
                            <a href="{{route('admin_motion_edit', $data['motion']->id)}}">Admin Edit</a>
                        </div>
                    @endcan
                </h4>
            </div>
        </div>
        <div class="row">
            <div class="col-12 mt-3 mx-auto text-center">
                <h1 class="text-center">
                 Edit  Proposed   {{$data['motion']->submission_type}}
                </h1>
                <h2>
                    Submitted by
                    <a href="{{route('member', $data['motion']->user->id)}}" title="{{$data['motion']->user->name}}">
                        {{$data['motion']->user->name}}</a>,
                    {{$data['motion']->date->format('F j, Y')}}
                </h2>
            </div>
        </div>
        <div class="row">
            <div class="col-12 text-center">
                <h3>
                    @if(!is_null($data['motion']->meeting_id))
                        <div class="badge bg-primary text-sm">
                            {{$data['motion']->meeting->meeting_type}}
                            Meeting
                        </div>
                        <a href="{{route('meeting', $data['motion']->meeting->id)}}">
                            {{$data['motion']->meeting->title}}
                            {{$data['motion']->meeting->date->format('F j, Y')}}
                        </a>
                    @else
                        For the next General meeting to be scheduled
                    @endif
                </h3>
            </div>
        </div>

        <form method="post" name="Motion" action="{{ url()->current() }}" enctype="multipart/form-data"
              class="needs-validation" novalidate>
            {!! csrf_field() !!}

        <div class="row my-3">
            <div class="col-12">
                <div class="input-group mb-3">
                    <span class="input-group-text" id="inputGroup-sizing-default">Title</span>
                    <input type="text" name="motion[title]" class="form-control"
                           aria-label="Sizing example input"
                           aria-describedby="inputGroup-sizing-default"
                           placeholder="Provide a title"
                           size="40"
                           width="50"
                           value="{{$data['motion']->title}}"
                           required>
                </div>
            </div>
        </div>


        <div class="row mb-3">
            <div class="col-12 text-center">
                <h4>Type of submission</h4>
            </div>
            <div class="col-sm-12 col-md-6 mb-2 text-center">
                <input type="radio" class="btn-check float-end" name="motion[submission_type]"
                       value="Motion" id="option4" autocomplete="off"
                       @if($data['upcoming']->count() > 0 && (Carbon\Carbon::today()->diffInDays($upcoming->date)-10 > 0)
                            || $data['upcoming']->count() == 0)
                           required
                       @else
                           disabled
                    @endif
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
                                {{$upcoming->date->format('F j Y')}},
                                {{$upcoming->date->format('g:i:s A')}}, in
                                {{Carbon\Carbon::today()->diffInDays($upcoming->date)}}
                                {{Str::plural('day', Carbon\Carbon::today()->diffInDays($upcoming->date))}}.
                            @else
                                Your motion will be attached to the next meeting.
                            @endif
                        </p>
                        <h4 class="card-title">
                            <strong>Submit in time</strong>
                        </h4>

                        @if($data['upcoming']->count() > 0)
                            @if(Carbon\Carbon::today()->diffInDays($upcoming->date)-10 > 0)
                                <p class="card-text h4">
                                    {{Carbon\Carbon::today()->diffInDays($upcoming->date)-10}}
                                    {{Str::plural('day', (Carbon\Carbon::today()->diffInDays($upcoming->date)-10))}}
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
            <div class="col-sm-12 col-md-6 mb-2 text-center">
                <input type="radio" class="btn-check float-end" name="motion[submission_type]"
                       value="New Business" id="option5" autocomplete="off"
                       @if($data['upcoming']->count() > 0 && Carbon\Carbon::today()->diffInHours($upcoming->date)-48 > 0
                             || $data['upcoming']->count() == 0)
                           required
                       @else
                           disabled
                    @endif
                >
                <label class="btn btn-outline-primary" for="option5">New Business</label>
                <div class="card text-bg-info text-white my-3 mx-auto h-80" style="max-width: 20rem;">
                    <div class="card-header"><h4>For New Business</h4></div>
                    <div class="card-body">
                        <p class="card-text">
                            @if($data['upcoming']->count() > 0)
                                @if(Carbon\Carbon::today()->diffInHours($upcoming->date->subDays(2)) > 48)
                                    New Business submissions allowed until
                                    {{$upcoming->date->subDays(2)->format('F j Y')}},
                                    {{$upcoming->date->format('g:i:s A')}}.
                                    @if(Carbon\Carbon::today()->diffInHours($upcoming->date->subDays(2)) < 73)
                                        {{Carbon\Carbon::today()->diffInHours($upcoming->date->subDays(2))}}
                                        {{Str::plural('hour', Carbon\Carbon::today()->diffInHours($upcoming->date->subDays(2)))}}
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
        <div class="row my-4 text-center">
            <div class="form-group">
                    <div class="col-12 mb-4">
                        <div class="col input-group editor-container editor-container_classic-editor" id="editor-container">
                            <span class="input-group-text">Description</span>
                            <div class="editor-container__editor">
                                <textarea name="faq[description]" id="textarea" placeholder="Content" class="form-control text-black">
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
                        var textarea = @json($data['motion']->description ?? '');
                        var textarea1 = @json("asdfasdfasdf" ?? '');
                        var textarea2 = @json("asdfasdfasdf22222222222" ?? '');
                    </script>
                    <script type="module" src="{{mix('js/admin/ckeditor5/ck_main_admin.js')}}"></script>
                </div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-12 text-left">
                <h3>Attached files</h3>
            </div>
            <div class="col-12 mb-6">
                <ul class="list-group mb-6">
                    @forelse($data['motion']->attachments as $ma)
                        <li class="list-group-item h5">
                            <a href="{{route('attachment_download', [$data['motion']->getAttachmentFolder(), $ma->id])}}" title="Download {{$ma->file_name}}">{{$ma->file_name}}</a>
                            {{$ma->description}}
                        </li>
                    @empty
                        <li class="list-group-item">
                            No attached files
                        </li>
                    @endforelse
                </ul>
            </div>
        </div>
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

@endsection




