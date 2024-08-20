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
                    Created At: {{$data['message']->created_at->format('F j Y H:i:s') }}.  |
                        Last Updated At: {{ $data['message']->updated_at->format('F j Y H:i:s') }}
                    </p>
                    <p>
                        URL: <a href="{{env('APP_URL')}}/{{$data['message']->messageMeta->source_url}}">
                            {{env('APP_URL')}}/{{$data['message']->messageMeta->source_url}}
                        </a>
                    </p>
                </div>
            @endif
            <div class="col-12 my-4">
                <h4 class="my-3">Select a topic, model, or committee for the message</h4>
                @if($data['action'] == 'Edit')
                    <p>Currently: {{$data['message_meta_data']['source_type']}},  {{$data['message_meta_data']['source_type_name']}}</p>
                @endif
            </div>
            <div class="col-12 my-4">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <button class="nav-link {{$data['message_meta_data']['source_type'] == 'topic' ? 'active' : '' }}" id="nav-topic-tab" data-bs-toggle="tab" data-bs-target="#nav-topic" type="button" role="tab" aria-controls="nav-topic" aria-selected="false">Topic</button>
                        <button class="nav-link {{$data['message_meta_data']['source_type'] == 'model' ? 'active' : '' }}" id="nav-model-tab" data-bs-toggle="tab" data-bs-target="#nav-model" type="button" role="tab" aria-controls="nav-model" aria-selected="false">Model</button>
                        <button class="nav-link {{$data['message_meta_data']['source_type'] == 'committee' ? 'active' : ''}}" id="nav-committee-tab" data-bs-toggle="tab" data-bs-target="#nav-committee" type="button" role="tab" aria-controls="nav-committee" aria-selected="false">Committee</button>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade {{$data['message_meta_data']['source_type'] == 'topic' ? 'show active' : '' }}
                    p-4" id="nav-topic" role="tabpanel" aria-labelledby="nav-topic-tab" tabindex="0">
                        <select class="form-select" name='topic_source_type_name' aria-label="Default select example">
                            @if($data['message_meta_data']['source_type'] != 'topic') <option value="">Select A Topic</option> @endif
                            @foreach($data['topic_subscription_options'] as $t)
                                <option value="{{$t['slug']}}"  {{$t['slug'] == $data['message_meta_data']['source_type_name'] ? 'selected' : ''}} >{{$t['name']}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="tab-pane fade {{$data['message_meta_data']['source_type'] == 'model' ? 'show active' : '' }}
                     p-4" id="nav-model" role="tabpanel" aria-labelledby="nav-model-tab" tabindex="0">
                        <select class="form-select" name='model_source_type_name' aria-label="Default select example">
                            @if($data['message_meta_data']['source_type'] != 'model')
                            <option value="">Select A Content Type  {{$data['message_meta_data']['source_type']}}   </option> @endif
                            @foreach($data['model_subscription_options'] as $m)
                                <option value="{{$m['model']}}" {{$m['model'] == ucfirst($data['message_meta_data']['source_type_name']) ? 'selected' : ''}} >{{$m['model']}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="tab-pane fade {{$data['message_meta_data']['source_type'] == 'committee' ? 'show active' : '' }}
                     p-4" id="nav-committee" role="tabpanel" aria-labelledby="nav-committee-tab" tabindex="0">
                        <select class="form-select" name='committee_source_type_name' aria-label="Default select example">
                            @if($data['message_meta_data']['source_type'] != 'committee') <option value="">Select A Committee</option> @endif
                            @foreach($data['committee_subscription_options'] as $comm)
                                <option value="{{$comm['slug']}}" {{$comm['slug'] == $data['message_meta_data']['source_type_name'] ? 'selected' : ''}} >{{$comm['name']}}</option>
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
                <input class="form-check-input" type="radio" name="message[message_sending][send_priority]" id="inlineRadio1"
                       value="normal" {{ old('message.message_sending.send_priority', $data['message_sending'] == 'normal' ? 'checked' : '')}}>
                <label class="form-check-label" for="inlineRadio1">Normal</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="message[message_sending][send_priority]" id="inlineRadio2"
                       value="now" {{ old('message.message_sending.send_priority', $data['message_sending'] == 'now' ? 'checked' : '')}}>
                <label class="form-check-label" for="inlineRadio2">Now</label>
            </div>
        </div>
    </div>
    <div class="row m-4 border border-1 rounded">
        <div class="col-12 p-4">
            <h2>File Attachments</h2>
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
                    <h2><i class="fas fa-paperclip"></i> Files</h2>
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
        <div class="col-sm-12 col-md-3 mx-auto text-center">
            <i class="fas fa-edit fa-2x"></i>
            <input class="btn btn-outline-primary mx-2" type="submit" value="{{ $data['action'] }}" />
        </div>
</form>
    @if ($data['action'] == 'Edit')
        <div class="col-sm-12 col-md-3 mx-auto text-center">
            <i class="fas fa-glasses fa-2x"></i>
            <a href="{{route('admin_message_preview', $data['message']->id)}}" class="btn btn-outline-info mx-2">Preview before sending</a>
        </div>
        <div class="col-sm-12 col-md-3 mx-auto text-center">
            <form name="delete" method="POST" action="{{route('admin_message_destroy')}}">
                {!! csrf_field() !!}
                {!! method_field('DELETE') !!}
                <i class="far fa-trash-alt fa-2x"></i>
                <input type="hidden" name="id[]" value="{{ $data['message']->id }}">
                <input class="btn btn-outline-danger mx-2" type="submit" value="Delete">
            </form>
        </div>
        <div class="row my-3">
            <div class="col-12 text-center" style="padding-top: 6em">
                <a class="btn btn-primary" href="{{route('admin_message_preview_strict',  $data['message']->id)}}">Email Template Preview</a>
            </div>
        </div>
    @endif
@endsection
