@extends('layouts.dashboard')
@section('content')
@include('admin.admin_partials.admin_tinymce')
<form name="{{$data['action']}}" method="POST" action="{{url()->current()}}" enctype="multipart/form-data">
    {!! csrf_field() !!}
    <div class="row mt-6 mb-6">
        <div class="col-12 mb-6">
            <h2>{{$data['action']}} Message | <a href="{{route('admin_messages')}}">List Messages</a></h2>
        </div>
    </div>
    <div x-data="{subject: {{@json_encode($data['message']->subject ?: '')}} }" class="row mt-5 ">
        <div class="col-12 mx-6 ">
            <h2 x-text="subject" class="mb-5"></h2>
            @if($data['action'] == 'Edit')
                <div class="col-12 border border-1 rounded p-4">
                    <p>Created by: <a href="{{route('member', $data['message']->user->id)}}">
                            {{$data['message']->user->name}}</a>. |
                    Created At: {{$data['message']->created_at->format('F j Y H:i:s') }}.  | Last Updated At: {{ $data['message']->updated_at->format('F j Y H:i:s') }}</p>
                    <p>URL: <a href="{{$data['message']['url']}}">{{$data['message']['url']}}</a></p>
                </div>
            @endif
            <div class="col-12 my-4">
                <h3 class="my-3">Select a topic, model, or committee for the message</h3>
                <p>currently: {{$data['message']['type']}},  {{$data['message']['name']}}</p>
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <button class="nav-link @if($data['action'] == 'Edit') {{$data['message']['type'] == 'topic' ? 'active' : '' }} @endif" id="nav-topic-tab" data-bs-toggle="tab" data-bs-target="#nav-topic" type="button" role="tab" aria-controls="nav-topic" aria-selected="false">Topic</button>
                        <button class="nav-link @if($data['action'] == 'Edit') {{$data['message']['type'] == 'model' ? 'active' : '' }} @endif" id="nav-model-tab" data-bs-toggle="tab" data-bs-target="#nav-model" type="button" role="tab" aria-controls="nav-model" aria-selected="false">Model</button>
                        <button class="nav-link @if($data['action'] == 'Edit') {{$data['message']['type'] == 'committee' ? 'active' : ''}} @endif" id="nav-committee-tab" data-bs-toggle="tab" data-bs-target="#nav-committee" type="button" role="tab" aria-controls="nav-committee" aria-selected="false">Committee</button>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade @if($data['action'] == 'Edit') {{$data['message']['type'] == 'topic' ? 'show active' : '' }} @endif
                    p-4" id="nav-topic" role="tabpanel" aria-labelledby="nav-topic-tab" tabindex="0">
                        <select class="form-select" name='name' aria-label="Default select example">
                            @if($data['action'] == 'Create' OR $data['message']['type'] != 'topic')<option>Select A Topic</option>@endif
                            @foreach($data['topic_subscription_options'] as $t)
                                <option value="{{$t['slug']}}" @if($data['action'] == 'Edit') {{$t['slug'] == 'nothing yet' ? 'selected' : ''}}@endif >{{$t['name']}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="tab-pane fade @if($data['action'] == 'Edit') {{$data['message']['type'] == 'model' ? 'show active' : '' }} @endif
                     p-4" id="nav-model" role="tabpanel" aria-labelledby="nav-model-tab" tabindex="0">
                        <select class="form-select" name='name' aria-label="Default select example">
                            @if($data['action'] == 'Create' OR $data['message']['type'] != 'model')<option>Select A Content Type</option>@endif
                            @foreach($data['model_subscription_options'] as $m)
                                <option value="{{$m['model']}}" @if($data['action'] == 'Edit'){{$m['model'] == $data['message']['name'] ? 'selected' : ''}}@endif >{{$m['name']}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="tab-pane fade @if($data['action'] == 'Edit') {{$data['message']['type'] == 'committee' ? 'show active' : '' }} @endif
                     p-4" id="nav-committee" role="tabpanel" aria-labelledby="nav-committee-tab" tabindex="0">
                        <select class="form-select" name='name' aria-label="Default select example">
                            @if($data['action'] == 'Create' OR $data['message']['type'] != 'committee')<option>Select A Committee</option>@endif
                            @foreach($data['committee_subscription_options'] as $comm)
                                <option value="{{$comm['slug']}}" @if($data['action'] == 'Edit'){{$comm['slug'] == $data['message']['name'] ? 'selected' : ''}}@endif >{{$comm['name']}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-12 my-4">
                <h3>Subject</h3>
                <input x-model="subject" type="text" name="message[subject]" value="{{ old('message.subject', $data['message']->subject)}}" size="60" required />
            </div>
        </div>
    </div>
    <div class="row my-5">
        <div class="col-12">
            <h3>Message</h3>
            <textarea name="message[content]">
                {{old('message.content', $data['message']->content)}}
            </textarea>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <h4>Message Sending Priority</h4>
            <p>Send out based on the schedule based on user preferences, OR send to all immediately.</p>
        </div>
        <div class="col-12">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="message[priority]" id="inlineRadio1" value="regular" {{ old('message.priority', $data['message']->priority == 'regular' ? 'checked' : '')}}>
                <label class="form-check-label" for="inlineRadio1">Regular</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="message[priority]" id="inlineRadio2" value="now" {{ old('message.priority', $data['message']->priority == 'now' ? 'checked' : '')}}>
                <label class="form-check-label" for="inlineRadio2">Now</label>
            </div>
        </div>
    </div>
    <div class="row m-4 border border-1 rounded">
        <div class="col-12 p-4">
            <h2>File Attachment</h2>
        </div>
        <div class="row mt-lg-2">
            <div class="col-md-6 p-4">
                <div class="form-group">
                    <label for="exampleInputFile">
                        <i class="fas fa-cloud-upload-alt fa-2x"></i>
                        Add File(s) To Employment Posting
                    </label>
                    <input type="file" id="inputFile" name="attachments[]" multiple />
                </div>
            </div>
            @if ($data['action'] == 'Edit')
                <div class="col-md-12">
                    <h2>Files</h2>
                    <table class="table table-striped table-sm">
                        <thead>
                        <tr>
                            <th> # </th>
                            <th> File </th>
                            <th> Description </th>
                            <th> Edit </th>
                            <th> Created At </th>
                            <th> Updated At </th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($data['message']->attachments as $ma)
                            <tr>
                                <td>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="attachment[{{$ma->id}}][id]"
                                                   value="{{$ma->id}}" />
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <a href="{{route('attachment_download',
                                            [$data['message']->getAttachmentFolder(), $ma->id])}}"
                                       title="Download {{$ma->file_name}}">{{$ma->file_name}}
                                    </a>
                                    <input type="hidden" name='attachment[{{$ma->id}}][access_level]' value='public'>
                                </td>
                                <td>
                                    <input type="text" class="form-control"
                                           placeholder="Add a description for this file"
                                           name="attachment[{{$ma->id}}][description]"
                                           value="{{ old('attachments.description', $ma->description)}}"
                                           size="40"/>
                                </td>
                                <td>
                                    <a title="{{ $ma->name }}" href="{{ route('admin_attachment_edit', $ma->id) }}">
                                        <i class="fas fa-edit"></i>
                                    </a>
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
                                <td colspan="7"> No files </td>
                            </tr>
                        @endforelse
                        @if(count($data['message']->attachments) > 0)
                            <tr>
                                <td colspan="7">
                                    <i class="far fa-trash-alt"></i> Select checkbox to delete a file
                                </td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <div class="row my-5">
        <div class="col-12">
            <i class="fas fa-edit fa-2x"></i>
            <input class="btn btn-outline-primary" type="submit" value="{{ $data['action'] }}" />
        </div>
    </div>
</form>
    @if ($data['action'] == 'Edit')
        <div class="row my-5">
            <div class="col-12">
                <i class="fas fa-edit fa-2x"></i>
                <a href="{{route('admin_message_preview', $data['message']->id)}}" class="btn btn-bd-primary">Preview before sending</a>
            </div>
        </div>
        <div class="row">
            <form name="delete" method="POST" action="{{route('admin_message_destroy')}}">
                {!! csrf_field() !!}
                {!! method_field('DELETE') !!}
                <i class="far fa-trash-alt fa-2x"></i>
                <input type="hidden" name="id[]" value="{{ $data['message']->id }}">
                <input class="btn btn-outline-danger" type="submit" value="Delete">
            </form>
        </div>
    @endif
@endsection
