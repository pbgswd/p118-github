@extends('layouts.dashboard',  ['title' => ' <i class="fas fa-edit"></i>' . $data["action"] . ' organization '
        . ($data["action"] == 'Edit' ? $data['organization']->name : '') ])
@section('content')
    @include('admin.admin_partials.admin_tinymce')
<div class="container">
    <div class="row">
        <div class="col-12 col-md-6">
            <h3>
                <a href="{{ route('organizations_list') }}">
                    <i class="far fa-arrow-alt-circle-left"></i>
                    List of organizations
                </a>
            </h3>
        </div>
        @if($data['action'] == 'Edit')
            <div class="col-12 col-md-6 text-md-right">
                <a href="{{route('organization', $data['organization']->slug)}}"
                   title="View {{$data['organization']->name}}">
                    <i class="fas fa-eye"></i> View on website
                </a>
            </div>
        @endif
    </div>
    <form method="post" name="organization" action="{{ url()->current()}}"
          enctype="multipart/form-data" class="needs-validation" novalidate>
        {!! csrf_field() !!}
        <div class="row mt-lg-3">
            <div class="form-group">
                <div class="col-12">
                    <h4>Name</h4>
                </div>
                <div class="col-12">
                    <input type="text" class="form-control"  placeholder="Name" name="organization[name]"
                           value="{{ old('organization.name', $data['organization']->name)}}" size="80" required/>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <div class="col-12">
                    <h4>Description</h4>
                </div>
                <div class="col-12">
                    <textarea name="organization[description]" id="organization-description"
                              placeholder="Summary content" class="form-control">
                        {{old('organization.description', $data['organization']->description)}}
                    </textarea>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12">
                <div class="form-group">
                    @if(!isset($data['organization']->image))
                        <label for="exampleInputFile">
                            <i class="fas fa-cloud-upload-alt fa-2x"></i>
                            Add Primary Image To organization
                        </label>
                        <input type="file" id="inputFile" name="image" />
                    @else
                        <input type="hidden" name="organization[image]" value="{{$data['organization']->image}}" />
                        <input type="hidden" name="organization[file_name]"
                               value="{{$data['organization']->file_name}}" />
                        <img src="{{ asset('storage/public/'. $data['organization']->image)}}"
                             class="rounded img-fluid" /><br />
                        {{$data['organization']->filesize}}<br />
                        <img src="{{ asset('storage/public/'. $data['organization']->thumb) }}"
                             class="rounded img-fluid" /><br />
                        {{$data['organization']->thumb_size}} (thumbnail)<br />
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
        <div class="row mt-lg-3">
            <div class="form-group">
                <div class="col-lg-8"><h4>organization Website Link</h4></div>
                <div class="col-lg-10">
                    <input type="text" class="form-control"
                           placeholder="Website Address - http://...." name="organization[url]"
                           value="{{ old('organization.url', $data['organization']->url)}}" size="80" />
                </div>
            </div>
        </div>
        <div class="row mt-lg-3">
            <div class="col-12 pt-3">
                <h4>Access Level</h4>
            </div>
            <div class="col-12 pt-3">
                <div class="form-group">
                    {{ select_options($data['access_levels'],
                        old('organization.access_level', $data['organization']->access_level),
                        ['name' => 'organization[access_level]', 'class' => 'form-control']) }}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <h4>Status</h4>
            </div>
            <div class="col-12">
                <label>
                     <input name="organization[live]" type="hidden" value="0" />
                     <input name="organization[live]" type="checkbox" value="1"
                         {{ checked( old('organization.live', $data['organization']->live)) }} />
                    Check now to make Live
                </label>
                <p>ie.: Draft or Published.</p>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12 text-center">
                <h3>Agreements for Organization</h3>
            </div>
        </div>
        <div class="row mt-5 mb-5 p-2">
            @if ($data['action'] == 'Edit')
                <div class="col-6">
                    <h4>Agreements attached to {{$data['organization']->name}}</h4>
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($data['organization']->member_agreements as $oa)
                            <tr>
                                <td>
                                    <input type="checkbox" name="id[]" value="{{$oa->id}}" />
                                </td>
                                <td>
                                    <a title="{{ $oa->title }}" href="{{ route('agreement_edit', $oa->id) }}">
                                        {{ $oa->title }}
                                    </a>
                                    @if(\Carbon\Carbon::parse($oa->until)->isPast())
                                        <i>(Not current)</i>
                                    @endif
                                </td>
                                <td>{{$oa->from->format('F j Y')}}</td>
                                <td>{{$oa->until->format('F j Y')}}</td>
                            </tr>
                        @empty
                            <td colspan="4">No agreements assigned yet</td>
                        @endforelse
                        @if($data['organization']->member_agreements->count() > 0)
                            <td> <i class="far fa-trash-alt fa"></i></td>
                            <td colspan="3">Check to remove</td>
                        @endif
                        </tbody>
                    </table>
                </div>
            @endif
            <div class="col-6">
                <div class="form-group">
                    <h4>
                        <label for="exampleFormControlSelect2">
                        List of all agreements not currently attached to this organization.
                        Select and submit to attach.</label>
                    </h4>
                    <select multiple class="form-control" name="all_agreements[]" id="agreements" size="20">
                        @foreach($data['all_agreements'] as $agr)
                            <option value="{{$agr->id}}">{{$agr->title}}</option>
                        @endforeach
                            <option value=""></option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row mt-lg-3">
            <div class="col">
                <i class="fas fa-edit fa-2x"></i>
                <input class="btn btn-outline-primary" type="submit" value="{{ $data['action'] }}" />
            </div>
    </form>
    <div class="col"> &nbsp;</div>
    @if ($data['action'] == 'Edit')
         <div class="col text-right">
             <form name="delete" method="POST" action="{{route('organization_destroy')}}">
                 {!! csrf_field() !!}
                 {!! method_field('DELETE') !!}
                <i class="far fa-trash-alt fa-2x"></i>
                <input type="hidden" name="id[]" value="{{ $data['organization']->id }}">
                <input class="btn btn-outline-danger" type="submit" value="Delete">
            </form>
         </div>
    @endif
</div>
@endsection
