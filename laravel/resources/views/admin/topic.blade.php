@extends('layouts.dashboard',  ['title' => ' <i class="fas fa-edit"></i>' . $data["action"] . ' Topic '
    . ($data["action"] == 'Edit' ? $data['topic']->name : '') ])
@section('content')
    @include('admin.admin_partials.admin_tinymce')
<div class="container">
    <div class="row">
        <div class="col-12 col-md-6">
            <h3>
                <a href="{{ route('topics_list') }}">
                    <i class="far fa-arrow-alt-circle-left"></i>
                    List of topics
                </a>
            </h3>
        </div>
        @if ($data['action'] == 'Edit')
            <div class="col-12 col-md-6 text-md-right">
                <a href="{{route('topic_show', $data['topic']->slug)}}"
                   title="View {{$data['topic']->title}}">
                    <i class="fas fa-eye"></i> View on website
                </a>
            </div>
        @endif
    </div>

    <form method="post" name="topic" action="{{ url()->current() }}" enctype="multipart/form-data"
          class="needs-validation" novalidate>
        {!! csrf_field() !!}
        <div class="row mt-lg-3">
            <div class="form-group">
                <div class="col-lg-2">
                    <h4>Title</h4>
                </div>
                <div class="col-lg-10">
                    <input type="text" class="form-control"  placeholder="Title" name="topic[name]"
                           value="{{ old('topic.name', $data['topic']->name)}}" size="80" required/>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <div class="col-lg-2">
                    <h4>Summary</h4>
                </div>
                <div class="col-lg-10">
                    <textarea name="topic[description]" id="topic-description" placeholder="Summary content"
                              class="form-control">{{old('topic.description', $data['topic']->description)}}</textarea>
                </div>
            </div>
        </div>
        <div class="row mt-lg-3">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-6 col-sm-3 align-middle">
                        <h4>
                            Access Level for content
                        </h4>
                    </div>
                    <div class="col-6 col-sm-3">
                        <div class="form-group">
                            {{ select_options($data['access_levels'], old('topic.access_level', $data['topic']->access_level),
                                ['name' => 'topic[access_level]', 'class' => 'form-control']) }}
                        </div>
                    </div>
                    <div class="col-6 col-sm-3"></div>
                    <div class="col-6 col-sm-3"></div>
                    <!-- Force next columns to break to new line -->
                    <div class="w-100"></div>
                    <div class="col-12">&nbsp;</div>
                    <div class="col-6 col-sm-3">
                        <h4>Sort Order</h4>
                    </div>
                    <div class="col-6 col-sm-3">
                        <input type="text" class="form-control"  id="validationCustom02" placeholder="e.g.: 1000, 2000"
                               name="topic[sort_order]" value="{{old('topic.sort_order',$data['topic']->sort_order)}}"
                               size="30" required/>
                        <p>e.g.: 1000, 2000</p>
                    </div>
                    <div class="invalid-feedback">
                        Please add a numeric sort order {{ @$errors->get('topic.sort_order')[0] }}
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="col-lg-2">
                    <h4>Status</h4>
                </div>
                <div class="col-sm">
                    <label>
                        <input name="topic[front_page]" type="hidden" value="0" />
                        <input name="topic[front_page]" type="checkbox" value="1"
                            {{ checked(old('topic.front_page',$data['topic']->front_page)) }} /> Front Page
                    </label>
                </div>
                <div class="col-sm">
                    <label>
                        <input name="topic[landing_page]" type="hidden" value="0" />
                        <input name="topic[landing_page]" type="checkbox" value="1"
                            {{ checked(old('topic.landing_page', $data['topic']->landing_page)) }} />
                        Landing Page
                    </label>
                </div>
                <div class="col-sm">
                    <label>
                         <input name="topic[live]" type="hidden" value="0" />
                         <input name="topic[live]" type="checkbox" value="1"
                             {{ checked( old('topic.live', $data['topic']->live)) }} />
                        Check now to make Live
                    </label>
                    <p>ie.: Draft or Published.</p>
                </div>
            </div>
        </div>
        <div class="row mt-lg-3">
            <div class="form-group">
                <div class="col-lg-2">
                    <h4>Tags</h4>
                </div>
                <div class="col-lg-10">
                    <label>
                        <input type="text" name="tags"
                               value="<?php echo htmlentities(old('tags', join(', ', $data['topic']->tagNames()))); ?>"
                               size="40" />
                        <br />Add tags related to topic, comma separated.
                    </label>
                </div>
            </div>
        </div>
        <div class="row mt-lg-3">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="exampleInputFile">
                        <i class="fas fa-cloud-upload-alt fa-2x"></i>
                        Add File(s) To this topic
                    </label>
                    <input type="file" id="inputFile" name="attachments[]" multiple />
                </div>
            </div>
        </div>
        @if ($data['action'] == 'Edit')
            @if(count($data['topic']->attachments) > 0)
                <div class="col-md-12 pb-2 m-2">
                    <h5>Files</h5>
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
                                @forelse ($data['topic']->attachments as $ta)
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
                                            <a href="{{route('attachment_download', [$data['topic']->getAttachmentFolder(),
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
                                    <tr><td colspan="7">No files</td></tr>
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
        @endif
        <div class="row mt-5 mb-5">
            @if ($data['action'] == 'Edit')
                Added by: &nbsp;<a href="{{route('member', $data['topic']->user->id)}}" target="_blank">
                    {{$data['topic']->user->name }}
                </a>
            @endif
        </div>
        <div class="row mt-3">
            <div class="col-sm">
                <i class="fas fa-edit fa-2x"></i>
                <input class="btn btn-outline-primary" type="submit" value="{{ $data['action'] }}" />
            </div>
    </form>
    <div class="col-sm"> &nbsp;</div>
    @if ($data['action'] == 'Edit')
         <div class="col-sm" style="float:right">
             <form name="delete" method="POST" action="{{route('topic_destroy')}}">
                 {!! csrf_field() !!}
                 {!! method_field('DELETE') !!}
                <i class="far fa-trash-alt fa-2x"></i>
                <input type="hidden" name="id[]" value="{{ $data['topic']->id }}">
                <input class="btn btn-outline-danger" type="submit" value="Delete">
            </form>
         </div>
    @endif
    <div class="row mt-lg-5"> &nbsp;</div>
</div>
@endsection
