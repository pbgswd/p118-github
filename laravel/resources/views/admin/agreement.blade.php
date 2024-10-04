@extends('layouts.dashboard',  ['title' => ' <i class="fas fa-edit"></i>' . $data["action"] .
    ' agreement ' . ($data["action"] == 'Edit' ? $data['agreement']->name : '') ])
@section('content')
 @include('admin.admin_partials.admin_tinymce')
<div class="container">
    <div class="row">
        <div class="col-12 col-md-6">
            <h3>
                <a href="{{ route('agreements_list') }}">
                    <i class="far fa-arrow-alt-circle-left"></i>
                    List of agreements
                </a>
            </h3>
        </div>
        @if($data['action'] == 'Edit')
            <div class="col-12 col-md-6 text-md-right">
                <a href="{{route('agreement_show', $data['agreement']->id)}}"
                   title="View {{$data['agreement']->title}}">
                    <i class="fas fa-eye"></i> View on website
                </a>
            </div>
        @endif
    </div>
    <form method="post" name="agreement" action="{{ url()->current() }}" enctype="multipart/form-data"
          class="needs-validation" novalidate>
        {!! csrf_field() !!}
        <div class="row mt-5">
            <div class="form-group">
                <div class="col-12">
                    <h4>Title of Agreement</h4>
                </div>
                <div class="col-12">
                    <input type="text" class="form-control"  placeholder="Title" name="agreement[title]"
                           value="{{ old('agreement.title', $data['agreement']->title)}}" size="80" required/>
                </div>
            </div>
        </div>
        @if($data['action'] == 'Edit')

            <div class="col-12 my-3">
                <h4>Venues and organizations associated with this agreement:</h4>
            </div>
            <div class="col-12 my-3">
                <h5>Venues</h5>
                @forelse($data['agreement']->venues as $venue)
                    {{$venue->name}}
                    <a href="{{route('venue', $venue->slug)}}">Public</a>
                    <a href="{{route('venue_edit', $venue->slug)}}">Admin</a>
                    @if(!$loop->last) | @endif
                    @if($loop->last)<br />@endif
                @empty
                    <i>None</i>
                @endforelse
            </div>
            <div class="col-12 my-12">
                <h5>Organizations</h5>
                @forelse($data['agreement']->organizations as $org)
                    {{$org->name}}
                    <a href="{{route('organization', $org->slug)}}">Public</a>
                    <a href="{{route('organization_edit', $org->slug)}}">Admin</a>
                    @if(!$loop->last) | @endif
                @empty
                    <i>None</i>
                @endforelse
            </div>
        @endif
        <div class="col-12 my-5">
            <div class="form-group">
                <label for="exampleFormControlSelect2">
                    <h5>
                        <i>Select Venues and Organizations to attach to this agreement
                            (CTRL + click for multiple select).
                        </i>
                    </h5>
                </label>
                <select multiple class="form-control" name="agreement[client][]" id="exampleFormControlSelect2"  size="30">
                    <option label="" value="">------------------------ Venues ---------------------</option>
                    @foreach($data['venues'] as $venue)
                        <option label="{{$venue->name}}" value="venue {{$venue->id}}"
                            @if($data['action'] == 'Edit' && in_array($venue->id, $data['ass_venues']))
                            selected="selected"
                            @endif
                        >
                            {{$venue->name}}
                        </option>
                    @endforeach
                    <option label="" value="">------------------------ Organizations ------------------------</option>
                    @foreach($data['orgs'] as $org)
                        <option label="{{$org->name}}" value="organization {{$org->id}}"
                            @if($data['action'] == 'Edit' && in_array($org->id, $data['ass_orgs']))
                                selected="selected"
                            @endif
                        >
                            {{$org->name}}{{$org->name}}
                        </option>
                    @endforeach
                </select>
            </div>
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
                                <textarea name="agreement[description]" id="textarea" placeholder="Content" class="form-control text-black">
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
                        var textarea = @json($data['agreement']->description ?? '');
                        var textarea1 = @json($data['textarea1'] ?? '');
                    </script>
                    <script type="module" src="{{mix('js/ckeditor5/ck_main_admin.js')}}"></script>
                </div>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-6">
                <div class="form-group">
                    <h4>Start Date of Agreement</h4>
                        <input
                            type="text"
                            class="form-control"
                            placeholder="YYYY-MM-DD"
                            name="agreement[from]"
                            value="{{ old('agreement.from', \optional($data['agreement']->from)->toDateString())}}"
                            size="10"
                            data-provide="datepicker"
                            data-date-format="yyyy-mm-dd"
                            required />
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <h4>End Date of Agreement</h4>
                        <input
                            type="text"
                            class="form-control"
                            placeholder="YYYY-MM-DD"
                            name="agreement[until]"
                            value="{{ old('agreement.until', \optional($data['agreement']->until)->toDateString())}}"
                            size="10"
                            data-provide="datepicker"
                            data-date-format="yyyy-mm-dd"
                            required />
                </div>
            </div>
        </div>
        <div class="row mt-lg-3">
            <div class="col-6">
                <h4>Access Level</h4>
                <div class="form-group">
                    {{ select_options($data['access_levels'],
                        old('agreement.access_level', $data['agreement']->access_level),
                        ['name' => 'agreement[access_level]', 'class' => 'form-control']) }}
                </div>
                <i class="fas fa-asterisk"></i>
                Note: you can update the Access Level to <i>public</i> after you have created the agreement.
            </div>
            <div class="col-6">
                <div class="col-lg-2">
                    <h4>Status</h4>
                </div>
                <div class="col-sm">
                    <label>
                         <input name="agreement[live]" type="hidden" value="0" />
                         <input name="agreement[live]" type="checkbox" value="1"
                                {{ checked(old('agreement.live', $data['agreement']->live)) }} />
                        Check now to make Live
                    </label>
                    <p>ie.: Draft or Published.</p>
                </div>
            </div>
        </div>
        <div class="row my-5">
            <h2>Files</h2>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="exampleInputFile">
                        <i class="fas fa-cloud-upload-alt fa-2x"></i>
                        Add files to agreement
                    </label>
                    <input type="file" id="inputFile" name="attachments[]" multiple />
                </div>
            </div>
        </div>
        @if ($data['action'] == 'Edit')
            @if(count($data['agreement']->attachments) > 0)
                <div class="row mt-lg-3">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th> # </th>
                                        <th> File </th>
                                        <th> Access Level</th>
                                        <th> <i class="far fa-edit"></i></th>
                                        <th> Description </th>
                                        <th> Created At </th>
                                        <th> Updated At </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data['agreement']->attachments as $attachment)
                                        <tr>
                                            <td>
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox"
                                                               name="attachment[{{$attachment->id}}][id]"
                                                               value="{{$attachment->id}}" />
                                                    </label>
                                                </div>
                                            </td>
                                            <td>
                                                <a href="{{route('attachment_download',
                                                            [$data['agreement']->getAttachmentFolder(),
                                                            $attachment->id])}}"
                                                    title="Download {{$attachment->file_name}}">
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
                                                   href="{{route('admin_attachment_edit', $attachment->id) }}">
                                                    <i class="far fa-edit"></i>
                                                </a>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control"
                                                       placeholder="Add a description for this file"
                                                       name="attachment[{{$attachment->id}}][description]"
                                                       value="{{ old('attachments.description',
                                                            $attachment->description)}}" size="40"/>
                                            </td>
                                            <td>
                                                {{ $attachment->created_at?->toDateString() }}
                                            </td>
                                            <td>
                                                {{ $attachment->updated_at?->toDateString() }}
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="7">
                                            <i class="far fa-trash-alt"></i> Select checkbox to delete a file
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
        @endif
        <div class="row p-2">
            <div class="col-12 col-md-6">
                <i class="fas fa-edit fa-2x"></i>
                <input class="btn btn-outline-primary" type="submit" value="{{ $data['action'] }}" />
            </div>
    </form>
        @if ($data['action'] == 'Edit')
             <div class="col-12 col-md-6 text-md-end">
                 <form name="delete" method="POST" action="{{route('agreement_destroy')}}">
                     {!! csrf_field() !!}
                     {!! method_field('DELETE') !!}
                    <i class="far fa-trash-alt fa-2x"></i>
                    <input type="hidden" name="id[]" value="{{ $data['agreement']->id }}">
                    <input class="btn btn-outline-danger" type="submit" value="Delete">
                </form>
             </div>
        @endif
    </div>
</div>
@endsection
