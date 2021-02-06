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
        <div class="row mt-lg-3">
            <div class="form-group">
                <div class="col-lg-2"><h4>Title</h4></div>
                <div class="col-lg-10">
                    <input type="text" class="form-control"  placeholder="Title" name="agreement[title]"
                           value="{{ old('agreement.title', $data['agreement']->title)}}" size="80" required/>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <div class="col-lg-2">
                    <h4>Description</h4>
                </div>
                <div class="col-lg-10">
                    <textarea name="agreement[description]" id="agreement-description"
                              placeholder="Information about the agreement, or pasted from the pdf."
                              class="form-control">{{old('agreement.description', $data['agreement']->description)}}
                    </textarea>
                </div>
            </div>
        </div>
        <div class="row mt-lg-3">
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
            <div class="col-md-6">
            </div>
            <div class="col-md-4">
                <div class="col-lg-2"><h4>Status</h4></div>
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
        <div class="row mt-lg-3">
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
        <div class="row mt-lg-3">
            @if ($data['action'] == 'Edit')
                @if(count($data['agreement']->attachments) > 0)
                    <div class="col-md-12">
                        <h2>Files</h2>
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
                                    <td>{{$attachment->access_level}}</td>
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
                                        {{ \optional($attachment->created_at)->toDateString() }}
                                    </td>
                                    <td>
                                        {{ \optional($attachment->updated_at)->toDateString() }}
                                    </td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="5">
                                    <i class="far fa-trash-alt"></i> Select checkbox to delete a file
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        </div>
                    </div>
                @endif
            @endif
        </div>
        <div class="row">
            <div class="col-6 w-100">
                <i class="fas fa-edit fa-2x"></i>
                <input class="btn btn-outline-primary" type="submit" value="{{ $data['action'] }}" />
            </div>
    </form>

        @if ($data['action'] == 'Edit')
             <div class="col-6 text-right">
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
