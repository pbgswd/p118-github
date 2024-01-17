@extends('layouts.dashboard',  ['title' => ' <i class="fas fa-edit"></i>' . $data["action"] . ' committee ' .
($data["action"] == 'Edit' ? $data['committee']->name : '') ])
@section('content')
    @include('admin.admin_partials.admin_tinymce')
    <div class="container">
        <div class="row">
            <div class="col border border-dark rounded mr-3 p-2">
                <h5>
                    <a href="{{ route('committees_list') }}">
                        <i class="far fa-arrow-alt-circle-left"></i>
                        List of committees
                    </a>
                </h5>
            </div>
            @if ($data['action'] == 'Edit')
                <div class="col border border-dark rounded mr-3 p-2">
                    <h5>
                        View
                        <a title="{{ $data['committee']->name }}"
                           href="{{ route('admin_committee_show', $data['committee']->slug) }}">
                            {{ $data['committee']->name }}
                        </a>
                    </h5>
                </div>
            @endif
        </div>
        @if ($data['action'] == 'Edit')
            <div class="row mb-3">
                <div class="col border border-dark rounded mt-3 mr-3 p-2">
                    <h5>
                        <i class="fas fa-users"></i>
                        Membership in {{ $data['committee']->name }}
                    </h5>
                    <h5>
                        {{$data['committee']->active_committee_members->count()}} Active
                        {{Str::plural('Member', $data['committee']->active_committee_members->count())}}.
                    </h5>
                    <h5>
                        <a href="{{route('admin-list-committee-members', $data['committee']->slug)}}">
                            Add, manage committee membership.
                        </a>
                    </h5>
                </div>
                <div class="l border border-dark rounded mt-3 mr-3 p-2">
                    <h5>
                        <a href="{{route('committee_posts_list', $data['committee']->slug)}}">
                            <i class="far fa-folder-open"></i>
                             {{$data['committee']->posts->count()}}
                            {{Str::plural('post', $data['committee']->posts->count())}}
                                in {{ $data['committee']->name }}
                        </a>
                    </h5>
                    <h5>
                        <a href="{{route('admin_committee_post', $data['committee']->slug)}}">
                            <i class="fas fa-edit"></i>
                            Add New Post
                        </a>
                    </h5>
                </div>
            </div>
        @endif
        <form method="post" name="committee" action="{{ url()->current() }}" enctype="multipart/form-data"
            class="needs-validation" novalidate>
            @csrf
            <div class="row mt-5">
                <div class="form-group">
                    <div class="col-lg-2"><h5>Name</h5></div>
                    <div class="col-lg-10">
                        <input type="text" class="form-control"  placeholder="Name" name="committee[name]"
                               value="{{ old('committee.name', $data['committee']->name)}}" size="80" required/>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="form-group">
                    <div class="col-12">
                        <h5>Description</h5>
                    </div>
                    <div class="col-12">
                        <textarea name="committee[description]" id="committee-description"
                                  placeholder="Summary content" class="form-control">
                            {{old('committee.description', $data['committee']->description)}}
                        </textarea>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="form-group">
                    <div class="col-12 col-md-4">
                        <h5>Primary Committee Email</h5>
                    </div>
                    <div class="col-12 col-md-8">
                        <input type="text" class="form-control"  placeholder="Email" name="committee[email]"
                               value="{{ old('committee.email', $data['committee']->email)}}" size="80" required/>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12 mb-3">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                            <input name="committee[live]" type="hidden" value="0" />
                            <input name="committee[live]" type="checkbox" value="1"
                                {{ checked( old('committee.live', $data['committee']->live)) }} />
                            </div>
                        </div>
                        <input type="text" class="form-control font-weight-bold"
                               aria-label="Text input with checkbox"
                               value="Check to make this committee live." size="80" readonly>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                @if(null !== $data['committee']->image)
                    <div class="col-12 mt-3 mb-3">
                        <img src="{{ asset('storage/committees/'.$data['committee']->image)}}"
                             class="border rounded img-fluid mb-2" />
                    </div>
                    <div class="col-12 mt-3 mb-5">
                        <h4 class="mb-3">
                            Currently: {{$data['committee']->file_name}}.
                            Size: {{$data['file_info']['file_size']}}.
                            Width: {{$data['file_info']['dimensions'][0]}}
                            Height: {{$data['file_info']['dimensions'][1]}}
                        </h4>
                    </div>
                    <div class="col-12 mt-2 mb-5">
                        <div class="input-group mb-3 col-12">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <input name="committee[delete_image]" type="checkbox" value="1" />
                                </div>
                            </div>
                            <input type="text" class="form-control font-weight-bold"
                                   aria-label="Text input with checkbox"
                                   value="Check to delete image." size="40" readonly>
                        </div>
                    </div>
                @else
                    <div class="col-12 mt-3">
                        <div class="form-group">
                            <label for="exampleInputFile">
                                <i class="fas fa-cloud-upload-alt fa-2x"></i>
                                Add banner
                            </label>
                            <input type="file" id="inputFile" name="committee[image]" />
                        </div>
                    </div>
                    <div class="col-12">
                        <h4>Maximum image dimensions: 1440px wide, 200px tall. </h4>
                        <h4>Maximum file size: 400kb.</h4>
                    </div>
                @endif
            </div>
            <div class="row mt-lg-5 mb-lg-5">
                <div class="col-sm">
                    <i class="fas fa-edit fa-2x"></i>
                    <input class="btn btn-outline-primary" type="submit" value="{{ $data['action'] }}" />
                </div>
        </form>
                <div class="col-sm"> &nbsp;</div>
                @if ($data['action'] == 'Edit')
                    @can('delete committee')
                        <div class="col-sm" style="float:right">
                            <form name="delete" method="POST" action="{{route('committee_destroy')}}">
                                {!! csrf_field() !!}
                                {!! method_field('DELETE') !!}
                                <i class="far fa-trash-alt fa-2x"></i>
                                <input type="hidden" name="id[]" value="{{ $data['committee']->id }}">
                                <input class="btn btn-outline-danger" type="submit" value="Delete">
                            </form>
                        </div>
                    @endcan
                @endif
            </div>
        </div>
@endsection
