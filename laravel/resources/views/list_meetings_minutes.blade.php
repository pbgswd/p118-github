`@extends('layouts.jumbo',  ['title' => '<i class="fas fa-list"></i> List Meetings'])
@section('content')
        <div class="container border border-dark rounded mt-3" style="background: rgba(220,220,220,0.8);">
            <div class="row d-flex justify-content-around mb-2 mb-md-3">
                <div class="col-12 mt-3 text-center">
                    <h1>Meetings</h1>
                    <h2>Minutes, Documents, Motions, New Business</h2>
                </div>
            </div>

            @if($data['year'] == '')
                <div class="row d-flex justify-content-around mb-2 mb-md-3">
                    <div class="col-12 text-center">
                        <h3>Upcoming Meetings</h3>
                    </div>
                    <div class="col-12 d-flex">
                        <table class="table-responsive mx-auto border border-dark rounded bg-light p-2">
                        @forelse($data['upcoming'] as $upcoming)
                            <tr>
                                <td class="p-2">
                                    <span class="badge bg-primary text-sm">
                                        {{$upcoming->meeting_type}}
                                        Meeting </span>
                                </td>
                                <td class="px-2 text-left">
                                    <a title="{{ $upcoming->title }}" href="{{route('meeting', $upcoming->id)}}">
                                    {{ $upcoming->title }}
                                        <i class="far fa-calendar-alt"></i>
                                        {{ $upcoming->date->format('F j Y') }},
                                        <i class="far fa-clock"></i>
                                        {{$upcoming->date->format('g:i:s A')}}
                                    </a>

                                    In {{Carbon\Carbon::today()->diffInDays($upcoming->date)}} days.

                                    @if((Carbon\Carbon::today()->diffInDays($upcoming->date)) > 10)
                                        {{(Carbon\Carbon::today()->diffInDays($upcoming->date))-10}}
                                    {{Str::plural('day', Carbon\Carbon::today()->diffInDays($upcoming->date)-10)}}
                                        remaining for new motions.
                                    @else
                                        <span class="badge bg-warning text-dark">Motions closed</span>
                                    @endif
                                    {{$upcoming->motions->count()}} {{Str::plural('motion', $upcoming->motions->count())}}
                                    submitted.
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td>
                                    <div class="col-12 text-center px-2">
                                        No new meetings scheduled right now. Check back for updates.
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                        </table>
                    </div>
                </div>

            <!-- create a template for this chunk of code -->

                <div class="row d-flex mx-auto text-center align-content-center">
                    <div class="col-12 mb-2 d-flex mx-auto text-center align-content-center">
                        <button class="btn btn-outline-primary mx-auto" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseExample" aria-expanded="true" aria-controls="collapseExample">
                           <h2>Propose a New Motion or New Business for the next General Meeting
                               <i class="bi bi-chevron-double-down"></i>
                           </h2>
                        </button>
                    </div>
                    <div class="col-12">
                        <div class="collapse" id="collapseExample">
                            <div class="card card-body clearfix">
                                <div class="row">
                                    <div class="col-12 my-4">
                                        <h4>
                                            @if($data['upcoming']->count() > 0)
                                                The next General Meeting will be on
                                                {{$upcoming->date->format('F j Y')}},
                                                {{$upcoming->date->format('g:i:s A')}},
                                                in {{Carbon\Carbon::today()->diffInDays($upcoming->date)}} days.
                                            @else
                                                Your submission will be attached to the next scheduled meeting.
                                            @endif
                                        </h4>
                                    </div>
                                </div>

                                <form method="post" action="{{route('motion_create')}}"  enctype="multipart/form-data">
                                    @csrf
                                    <div class="row mb-2">
                                        <h4>Submitted by: {{Auth::user()->name}}</h4>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <div class="input-group mb-3">
                                                <span class="input-group-text" id="inputGroup-sizing-default">Title</span>
                                                <input type="text"  name="motion[title]" class="form-control"
                                                       aria-label="Sizing example input"
                                                       aria-describedby="inputGroup-sizing-default"
                                                       placeholder="Provide a title" required>
                                            </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <h4>Type of submission</h4>
                                        </div>
                                        <div class="col-sm-12 col-md-6 mb-2 float-end">
                                            <input type="radio" class="btn-check float-end" name="motion[submission_type]"
                                                   value="Motion" id="option4" autocomplete="off"
                                                   @if($data['upcoming']->count() > 0 &&
                                                        (Carbon\Carbon::today()->diffInDays($upcoming->date)-10 > 0) ||
                                                        $data['upcoming']->count() == 0)
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
                                        <div class="col-sm-12 col-md-6 mb-2">
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
                                    <div class="row mt-4">
                                        <div class="form-group">
                                            <div class="col-12 mt-3">
                                                <h4>Description</h4>
                                            </div>
                                            <div class="col-12">
                                                <div class="col-12 mb-4">
                                                    <div class=" col editor-container editor-container_classic-editor" id="editor-container">
                                                        <div class="editor-container__editor">

                                    <textarea name="motion[description]" id="textarea"  style="min-height: 300px;" placeholder="Provide some information" class="form-control text-black">
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
                                                <script type="module" src="{{mix('js/admin/ckeditor5/ck_main_admin.js')}}"></script>
                                            </div>
                                        </div>
                                    </div>
                                        <!-- begin file attachments -->
                                    <div class="row my-3">
                                        <div class="col-12">
                                            <div class="form-group float-start mb-3">
                                                <label for="exampleInputFile">
                                                    <h4>
                                                        <i class="fas fa-cloud-upload-alt fa-2x"></i>
                                                        Add File(s) To your motion or new business.
                                                    </h4>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="input-group mb-3">
                                                <label class="input-group-text" for="inputGroupFile01">Attach files</label>
                                                <input type="file" id="inputFile" name="attachments[]" class="form-control" id="inputGroupFile01" multiple>
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

                                        <!-- end file attachments -->
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <button class="btn btn-primary" type="submit">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end create a template for this chunk of code -->
                @if($data['newmotions']->count() > 0)
                    <div class="row d-flex mx-auto">
                        <div class="col border border-dark rounded pb-2 m-2 mb-3 mb-md-3">
                            <div class="col-12 m-3 text-center">
                                <h4>Submissions for next General Meeting</h4>
                            </div>
                            <table class="table-responsive mx-auto bg-light p-2 my-2">
                                @foreach($data['newmotions'] as $newmotion)
                                    <tr>
                                        <td class="p-2">
                                            <span class="badge bg-primary text-sm">{{$newmotion->submission_type}}</span>
                                        </td>
                                        <td class="px-2">
                                            <a href="{{route('member', $newmotion->user->id)}}" title="{{$newmotion->user->name}}">
                                                <i class="far fa-user"></i> {{$newmotion->user->name}}
                                            </a>
                                            <a title="{{ $newmotion->title }}" href="{{route('motion', $newmotion->id)}}">
                                                <i class="far fa-file-alt"></i> {{ $newmotion->title }}
                                            </a>
                                        </td>
                                        <td>
                                            {{ $newmotion->created_at->format('M j Y, g:i:s A') }}
                                        </td>
                                            <td class="p-2 float-end">
                                                @if($newmotion->updated_at > $newmotion->created_at)
                                                    Updated: {{$newmotion->updated_at->format('M j Y, g:i:s A')}}
                                                @endif
                                            </td>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                @endif
            @endif
            <div class="row d-flex justify-content-around mb-2 mb-md-3">
                <form method="post" action="{{route('post_year')}}">
                    @csrf
                    <div class="row justify-content-around border border-dark rounded pb-2 m-2 mb-3 mb-md-3">
                        <div class="row">
                            <div class="col-12 pt-2">
                                <h5>
                                    @if($data['year'] == '')
                                       View Meetings By Year
                                    @else
                                        {{ $data['count'] }} {{ Str::plural('Meeting', $data['count']) }} for {{$data['year']}}
                                    @endif
                                </h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-md-12 mb-2">
                                <select class="custom-select" name="year" id="validationDefault04" required>
                                    @if($data['year'] == '')
                                        <option selected disabled value="">Choose Year</option>
                                    @else
                                        <option selected value="{{$data['year']}}">{{$data['year']}}</option>
                                    @endif
                                    @foreach($data['years'] as $year)
                                        <option value="{{$year->year}}">{{$year->year}}</option>
                                    @endforeach
                                </select>
                                <button class="btn btn-outline-primary" type="submit">Submit</button>
                            </div>
                        </div>
                        @if($data['year'] != '')
                            <div class="row">
                                <div class="col-12 text-sm-center text-lg-start">
                                    <h5>
                                        <a href="{{route('list_meetings')}}">List all Meetings</a>
                                    </h5>
                                </div>
                            </div>
                        @endif
                    </div>
                </form>
            <div class="col-12 mt-3">
                <h4>
                    @if($data['year'] =='')
                        Most recent {{$data['pagination']}}
                        of {{ $data['count'] }} {{ Str::plural('Meeting', $data['count']) }}
                    @endif
                </h4>
            </div>
                <div class="col-12 mx-2">
                    <div class="table-responsive border border-dark rounded bg-light">
                    <table class="table">
                        <thead>
                            <tr>
                                <th> @sortablelink('title', 'Title') </th>
                                <th> @sortablelink('meeting_type', 'Type') </th>
                                <th> @sortablelink('date', 'Date') </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ( $data['meetings'] as $a )
                                <tr>
                                    <td>
                                        <h5>
                                            <a title="{{ $a->title }}" href="{{route('meeting', $a->id)}}">
                                                {{ $a->title }}
                                            </a>
                                            @if($a->date > now())
                                                <span class="badge bg-warning text-dark">Upcoming</span>
                                                In {{ Carbon\Carbon::today()->diffInDays($a->date)  }} days.
                                            @endif
                                        </h5>
                                    </td>
                                    <td> {{ $a->meeting_type }} </td>
                                    <td>
                                        {{$a->date->format('F j Y')}}
                                        @if($a->date > now())
                                            {{$a->date->format('g:i:s A')}}
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                    <div class="{{$data['year'] == '' ? 'd-none d-md-block' : ''}}">
                </div>
                <div class="d-flex justify-content-center mt-3">
                    <div class="list-group">
                        <ul class="pagination">
                            {!! $data['meetings']->links() !!}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
@endsection
