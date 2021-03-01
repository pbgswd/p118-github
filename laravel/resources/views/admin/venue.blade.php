@extends('layouts.dashboard',  ['title' => ' <i class="fas fa-edit"></i>' . $data["action"]
. ' Venue ' . ($data["action"] == 'Edit' ? $data['venue']->name : '') ])
@section('content')
    @include('admin.admin_partials.admin_tinymce')
<div class="container">
    <div class="row">
        <div class="col-12 col-md-6">
            <h3>
                <a href="{{ route('venues_list') }}">
                    <i class="far fa-arrow-alt-circle-left"></i>
                    List of venues
                </a>
            </h3>
        </div>
        @if($data['action'] == 'Edit')
            <div class="col-12 col-md-6 text-md-right">
                <a href="{{route('venue', $data['venue']->slug)}}"
                   title="View {{$data['venue']->name}}">
                    <i class="fas fa-eye"></i> View on website
                </a>
            </div>
        @endif
    </div>

    <form method="post" name="venue" action="{{ url()->current() }}"
          enctype="multipart/form-data" class="needs-validation" novalidate>
        {!! csrf_field() !!}
        <div class="row mt-lg-3">
            <div class="form-group">
                <div class="col-lg-2"><h4>Name</h4></div>
                <div class="col-lg-10">
                    <input type="text" class="form-control"
                           placeholder="Name" name="venue[name]"
                           value="{{ old('venue.name', $data['venue']->name)}}" size="80" required/>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <div class="col-lg-2">
                    <h4>Description</h4>
                </div>
                <div class="col-lg-10">
                    <textarea name="venue[description]" id="venue-description"
                              placeholder="Summary content" class="form-control">
                        {{old('venue.description', $data['venue']->description)}}
                    </textarea>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12">
                <div class="form-group">
                    @if(!isset($data['venue']->image))
                        <label for="exampleInputFile">
                            <i class="fas fa-cloud-upload-alt fa-2x"></i>
                            Add Primary Image To venue
                        </label>
                        <input type="file" id="inputFile" name="image" />
                    @else
                        <input type="hidden" name="venue[image]" value="{{$data['venue']->image}}" />
                        <input type="hidden" name="venue[file_name]" value="{{$data['venue']->file_name}}" />
                        <img src="{{ asset('storage/public/'. $data['venue']->image)}}"
                             class="rounded img-fluid" /><br />
                        {{$data['venue']->filesize}}<br />
                        <img src="{{ asset('storage/public/'. $data['venue']->thumb) }}"
                             class="rounded img-fluid" /><br />
                        {{$data['venue']->thumb_size}} (thumbnail)<br />
                        <h5>
                            {{$data['filesize'] ?? ''}}
                        </h5>
                        <label for="exampleInputFile">
                            <i class="far fa-trash-alt"></i>
                            Delete Image
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <input name="delete_image" type="checkbox" value="1" />
                                </div>
                                <input type="text" class="form-control" aria-label="Text input with checkbox"
                                       value="Check to delete image." size="40" readonly>
                            </div>

                        </label>
                    @endif
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="form-group">
                <div class="col-12">
                    <h4>Venue Website Link</h4>
                </div>
                <div class="col-12">
                    <input type="text" class="form-control"
                           placeholder="Website Address - http://...." name="venue[url]"
                           value="{{ old('venue.url', $data['venue']->url)}}" size="80" />
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12 pt-3">
                <h4>Access Level</h4>
            </div>
            <div class="col-12 pt-3">
                <div class="form-group">
                    {{ select_options($data['access_levels'],
                        old('venue.access_level', $data['venue']->access_level),
                        ['name' => 'venue[access_level]', 'class' => 'form-control']) }}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <h4>Status</h4>
            </div>
            <div class="col-12">
                <label>
                    <input name="venue[live]" type="hidden" value="0" />
                    <input name="venue[live]" type="checkbox" value="1"
                    {{ checked( old('venue.live', $data['venue']->live)) }} />
                    Check now to make Live
                </label>
                <p>ie.: Draft or Published.</p>
            </div>
        </div>
        <div class="row border border-dark rounded mt-5 mb-5 pt-2 pb-2">
        @if ($data['action'] == 'Edit')
            <div class="col-12 col-md-6 pt-2">
                <h5>Agreements attached to {{$data['venue']->name}}</h5>
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">From</th>
                        <th scope="col">Until</th>
                    </tr>
                    </thead>
                    <tbody>
                        @forelse($data['venue']->member_agreements as $va)
                            <tr>
                                <th scope="row">
                                    <input type="checkbox" name="id[]" value="{{$va->id}}" />
                                </th>
                                <td>
                                    <a title="{{$va->title}}" href="{{route('agreement_edit', $va->id)}}">
                                        {{$va->title}}
                                    </a>
                                    @if(\Carbon\Carbon::parse($va->until)->isPast())
                                        <i>(Not current)</i>
                                    @endif
                                </td>
                                <td>{{$va->from->format('F j Y')}}</td>
                                <td>{{$va->until->format('F j Y')}}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">No agreements associated</td>
                            </tr>
                        @endforelse
                        @if($data['venue']->member_agreements->count() > 0)
                            <tr>
                                <td> <i class="far fa-trash-alt fa"></i></td>
                                <td colspan="3">Check to remove from Venue</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        @endif
            <div class="col-12 col-md-6 pt-2">
                <div class="form-group">
                    <h5>
                    <label for="exampleFormControlSelect2">List of all agreements not currently attached to
                        {{$data['venue']->name}}. Select and submit to attach to venue</label>
                    </h5>
                    <select multiple class="form-control" name="all_agreements[]" id="agreements" size="20">
                        @foreach($data['all_agreements'] as $agr)
                            <option value="{{$agr->id}}">{{$agr->title}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="row mt-lg-3">
            <div class="col-12">
                <h4>Attachments</h4>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <label for="exampleInputFile">
                        <i class="fas fa-cloud-upload-alt fa-2x"></i>
                        Add File(s) To this Venue
                    </label>
                    <input type="file" id="inputFile" name="attachments[]" multiple />
                </div>
            </div>
        </div>

        @if ($data['action'] == 'Edit')
            <div class="col-12 pb-2 m-2">
                <h5>{{$data['venue']->attachments->count()}}
                    {{Str::plural('File', $data['venue']->attachments->count())}}
                </h5>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th> # </th>
                            <th> File </th>
                            <th>Access level</th>
                            <th>Edit</th>
                            <th> Description </th>
                            <th> Created At </th>
                            <th> Updated At </th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($data['venue']->attachments as $ta)
                            <tr>
                                <td>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="attachment[{{$ta->id}}][id]"
                                                   value="{{$ta->id}}" />
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <a href="{{route('attachment_download', [$data['venue']->getAttachmentFolder(),
                                            $ta->id])}}"
                                       title="Download {{$ta->file_name}}">
                                        {{$ta->file_name}}
                                    </a>
                                </td>
                                <td>
                                    {{$ta->access_level}}
                                </td>
                                <td>
                                    <a title="{{ $ta->name }}" href="{{ route('admin_attachment_edit', $ta->id) }}">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                                <td>
                                    <input type="text" class="form-control"
                                           placeholder="Add a description for this file"
                                           name="attachment[{{$ta->id}}][description]"
                                           value="{{ old('attachments.description', $ta->description)}}" size="40"/>
                                </td>
                                <td>
                                    {{$ta->created_at}}
                                </td>
                                <td>
                                    {{$ta->updated_at}}
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7">No files attached</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="col-12 mt-2">
                    <i class="far fa-trash-alt"></i>
                    Select checkbox to delete file.
                </div>
            </div>
        @endif
        <div class="row mt-lg-3">
            <div class="col-sm">
                <i class="fas fa-edit fa-2x"></i>
                <input class="btn btn-outline-primary" type="submit" value="{{ $data['action'] }}" />
            </div>
    </form>
    <div class="col-sm"> &nbsp;</div>
    @if ($data['action'] == 'Edit')
         <div class="col-sm" style="float:right">
             <form name="delete" method="POST" action="{{route('venue_destroy')}}">
                 {!! csrf_field() !!}
                 {!! method_field('DELETE') !!}
                <i class="far fa-trash-alt fa-2x"></i>
                <input type="hidden" name="id[]" value="{{ $data['venue']->id }}">
                <input class="btn btn-outline-danger" type="submit" value="Delete">
            </form>
         </div>
    @endif
    <div class="row mt-lg-5"> &nbsp;</div>
</div>
@endsection
