          <!-- create a template for this chunk of code -->
                <div class="row d-flex mx-auto text-center align-content-center">
                    <div class="col-12 mb-2 d-flex mx-auto text-center align-content-center">
                        <button class="btn btn-outline-primary mx-auto" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseExample" aria-expanded="true" aria-controls="collapseExample">
                           <h3>NEW: Propose a New Motion or New Business for the next General Meeting
                               <i class="bi bi-chevron-double-down"></i>
                           </h3>
                        </button>
                    </div>
                    <div class="col-12">
                        <div class="collapse" id="collapseExample">
                            <div class="card card-body clearfix">
                                <div class="row">
                                    <div class="col-12 my-4">
                                        <h6>
                                            Submit New Motions & New Business to the Executive by email, or
                                            <strong><u>by using this form which sends an email to the Executive,</u></strong>
                                            or by making a submission in writing.
                                        </h6>
                                        <h6 class="mb-4">Please note the submission deadlines for Motions are 10 days
                                            prior to the schedule meeting, and New Business for discussion will be
                                            accepted until 48 hours before the meeting.
                                        </h6>
                                        <h4>
                                            @if($data['upcoming']->count() > 0)
                                                The next General Meeting will be on
                                                {{$data['upcoming'][0]->date->format('F j Y')}},
                                                {{$data['upcoming'][0]->date->format('g:i:s A')}},
                                                @if(Carbon\Carbon::today()->diffInDays($data['upcoming'][0]->date) == 0)
                                                    TODAY.
                                                @else
                                                in {{ (int) Carbon\Carbon::today()->diffInDays($data['upcoming'][0]->date)}}
                                                {{Str::plural('day', (int) Carbon\Carbon::today()
                                                    ->diffInDays($data['upcoming'][0]->date))}}.
                                                @endif
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
                                                            ((int) Carbon\Carbon::today()->diffInDays($data['upcoming'][0]->date)-10 > 0) ||
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
                                                        <h4>New Motions</h4>
                                                    </div>
                                                    <div class="card-body">
                                                        <p class="card-text">
                                                            @if($data['upcoming']->count() > 0)
                                                                The next General Meeting will be held
                                                                {{$data['upcoming'][0]->date->format('F j Y')}},
                                                                {{$data['upcoming'][0]->date->format('g:i:s A')}},
                                                                @if((int) Carbon\Carbon::today()->diffInDays($data['upcoming'][0]->date) == 0)
                                                                    TODAY.
                                                                @else
                                                                    in {{(int) Carbon\Carbon::today()->diffInDays($data['upcoming'][0]->date)}}
                                                                    {{Str::plural('day', (int) Carbon\Carbon::today()->diffInDays($data['upcoming'][0]->date))}}.
                                                                @endif
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
                                                                    {{(int) Carbon\Carbon::today()->diffInDays($data['upcoming'][0]->date)-10}}
                                                                    {{Str::plural('day', ((int) Carbon\Carbon::today()->diffInDays($data['upcoming'][0]->date)-10))}}
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
                                                       @if($data['upcoming']->count() > 0 && (int) Carbon\Carbon::today()->diffInHours($data['upcoming'][0]->date)-48 > 0
                                                             || $data['upcoming']->count() == 0)
                                                               required
                                                           @else
                                                               disabled
                                                           @endif
                                                >
                                                <label class="btn btn-outline-primary" for="option5">New Business</label>
                                                <div class="card text-bg-info text-white my-3 mx-auto h-80" style="max-width: 20rem;">
                                                    <div class="card-header"><h4>New Business</h4></div>
                                                    <div class="card-body">
                                                        <p class="card-text">
                                                            ( For discussion only )<br />
                                                            @if($data['upcoming']->count() > 0)
                                                                @if(Carbon\Carbon::today()->diffInHours($data['upcoming'][0]->date->subDays(2)) > 48)
                                                                    New Business submissions allowed until
                                                                    {{$data['upcoming'][0]->date->subDays(2)->format('F j Y')}},
                                                                    {{$data['upcoming'][0]->date->format('g:i:s A')}}.
                                                                    @if(Carbon\Carbon::today()->diffInHours($data['upcoming'][0]->date->subDays(2)) < 73)
                                                                        {{Carbon\Carbon::today()->diffInHours($data['upcoming'][0]->date->subDays(2))}}
                                                                        {{Str::plural('hour', (int) Carbon\Carbon::today()->diffInHours($data['upcoming'][0]->date->subDays(2)))}}
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
                                                        var textarea = @json($data['motion']->description ?? '');
                                                        var textarea1 = @json($data['textarea1'] ?? '');
                                                    </script>
                                                    <script type="module" src="{{mix('js/ckeditor5/ck_main.js')}}"></script>
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
                                                                        <a href="{{route('attachment_download', [$data['motion']->getAttachmentFolder(), $ma->id])}}"
                                                                           title="Download {{$ma->file_name}}">{{$ma->file_name}}</a>
                                                                    </td>
                                                                    <td>
                                                                        <a title="Edit page for {{ $ma->file_name }}"
                                                                           href="{{ route('admin_attachment_edit', $ma->id) }}"><i class="far fa-edit"></i></a>
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" class="form-control"
                                                                               placeholder="Add a description for this file"
                                                                               name="attachment[{{$ma->id}}][description]"
                                                                               value="{{ old('attachments.description', $ma->description)}}" size="40"/>
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
                                                                    <td colspan="7">
                                                                        No attached files
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
                                                    </div>
                                                @endif
                                            @endif
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <button class="btn btn-outline-primary" type="submit">Submit</button>
                                            </div>
                                            <div class="col-12">
                                                Submissions will be reviewed for appropriate and complete information.
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end create a template for this chunk of code -->

