@extends('layouts.dashboard',  ['title_icon' => '<i class="fas fa-envelope-open-text"></i>', 'title' => $data['action'] .' Message'])
@section('content')
@include('admin.admin_partials.admin_tinymce')
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<form name="{{$data['action']}}" method="POST" action="{{url()->current()}}" enctype="multipart/form-data">
    {!! csrf_field() !!}
    <div class="row mt-6">
        <div class="col-12">
            <h4 class="mt-4">
                <a href="{{route('admin_messages')}}">List Messages</a>
                @if($data['action'] == 'Edit')
                        | <a href="#sending" title="Sending Section">
                            Jump to sending section <i class="fas fa-angle-down"></i>
                        </a>
                @endif
            </h4>
        </div>
    </div>
    <div class="col-12 mx-2">
        @if($data['action'] == 'Edit')
            <div class="col-12 border border-1 rounded p-4">
                <p>Created by: <a href="{{route('member', $data['message']->user->id)}}">
                        {{$data['message']->user->name}}</a>. |
                Created At: {{$data['message']->created_at->format('F j Y H:i:s') }}.  |
                    Last Updated At: {{ $data['message']->updated_at->format('F j Y H:i:s') }}
                </p>
                <p>
                    Source URL: <a href="{{$data['message']->source_url ?? ''}}">
                        {{$data['message']->source_url ?? ''}}
                    </a>
                </p>
            </div>
        @endif
        <div class="col-12 my-4">
            <h4 class="my-3">Select a topic, model, or committee for the message</h4>
            @if($data['action'] == 'Edit')
                Currently selected categories for this message are....(todo)
            @endif
        </div>
        <div class="col-12 my-4">
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <button class="nav-link {{$data['message']['section'] == 'topic' ? 'active' : '' }}" id="nav-topic-tab" data-bs-toggle="tab" data-bs-target="#nav-topic" type="button" role="tab" aria-controls="nav-topic" aria-selected="false">Topics</button>
                    <button class="nav-link {{$data['message']['section'] == 'model' ? 'active' : '' }}" id="nav-model-tab" data-bs-toggle="tab" data-bs-target="#nav-model" type="button" role="tab" aria-controls="nav-model" aria-selected="false">Content Sections</button>
                    <button class="nav-link {{$data['message']['section'] == 'committee' ? 'active' : ''}}" id="nav-committee-tab" data-bs-toggle="tab" data-bs-target="#nav-committee" type="button" role="tab" aria-controls="nav-committee" aria-selected="false">Committees</button>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade {{$data['message']['section'] == 'topic' ? 'show active' : '' }}
                p-4" id="nav-topic" role="tabpanel" aria-labelledby="nav-topic-tab" tabindex="0">
                    <select multiple size=10 class="form-select" name='source_type[topic][]' aria-label="Default select example">

                        @foreach($data['topic_subscription_options'] as $t)
                            <option value="topic {{$t['slug']}}" {{$t['slug'] == $data['message']['category']  ? 'selected' : ''}}>{{$t['name']}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="tab-pane fade {{$data['message']['section'] == 'model' ? 'show active' : '' }}
                 p-4" id="nav-model" role="tabpanel" aria-labelledby="nav-model-tab" tabindex="0">
                    <select multiple size=10 class="form-select" name='source_type[model][]' aria-label="Default select example">

                        @foreach($data['model_subscription_options'] as $m)
                            <option value="model {{$m['model']}}" {{$m['model'] == ucfirst($data['message']['category']) ? 'selected' : ''}}>{{$m['name']}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="tab-pane fade {{$data['message']['section'] == 'committee' ? 'show active' : '' }}
                 p-4" id="nav-committee" role="tabpanel" aria-labelledby="nav-committee-tab" tabindex="0">
                    <select multiple size=10 class="form-select" name='source_type[committee][]' aria-label="Default select example">

                        @foreach($data['committee_subscription_options'] as $comm)
                            <option value="committee {{$comm['slug']}}" {{$comm['slug'] == $data['message']['category'] ? 'selected' : ''}} >{{$comm['name']}}</option>
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
    <div class="row">
        <div class="form-group">
            <div class="col-12 mt-3">
                <h4>Message</h4>
            </div>
            <div class="col-12">
                <div class="col-12 mb-4">
                    <div class=" col editor-container editor-container_classic-editor" id="editor-container">
                        <div class="editor-container__editor">
                                <textarea name="message[content]" id="textarea" placeholder="Content" class="form-control text-black">
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
                    var textarea = @json($data['message']->content ?? '');
                    var textarea1 = @json($data['textarea1'] ?? '');
                </script>
                <script type="module" src="{{mix('js/admin/ckeditor5/ck_main_admin.js')}}"></script>
            </div>
        </div>
    </div>
    <div class="row m-4 border border-1 rounded">
        <div class="col-12 p-4">
            <h2>File Attachments</h2>
        </div>
        <div class="row mt-lg-2">
            <div class="col-12 p-4">
                <div class="form-group">
                    <label for="exampleInputFile">
                        <i class="fas fa-cloud-upload-alt fa-2x"></i>
                        Add File(s) To Message
                    </label>
                    <input type="file" id="inputFile" name="attachments[]" multiple />
                </div>
            </div>
        </div>
        <div class="row mt-lg-2">
            @if ($data['action'] == 'Edit')
                <div class="col-12">
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
        <div class="col-sm-12 col-md-6 mx-auto text-center">
            <i class="fas fa-edit fa-2x"></i>
            <input class="btn btn-outline-primary mx-2" type="submit" value="{{ $data['action'] }}" />
        </div>
</form>
    @if ($data['action'] == 'Edit')
        <div class="col-sm-12 col-md-6 mx-auto text-center">
            <form name="delete" method="POST" action="{{route('admin_message_destroy')}}">
                {!! csrf_field() !!}
                {!! method_field('DELETE') !!}
                <i class="far fa-trash-alt fa-2x"></i>
                <input type="hidden" name="id[]" value="{{ $data['message']->id }}">
                <input class="btn btn-outline-danger mx-2" type="submit" value="Delete">
            </form>
        </div>
    @endif
</div>


    @if ($data['action'] == 'Edit')
        <div class="row p-4 mt-5 border border-1 rounded">
            <a name="sending"></a>
            <div class="col-12 text-center mb-4">
                <h2>Sending</h2>
                <h3>Note: The content can no longer be modified after it has been sent out.</h3>
            </div>
            <div class="col-sm-12 col-md-3 mx-auto text-center">
                <i class="fas fa-glasses fa-2x"></i>
                <a href="{{route('admin_message_preview', [$data['message']->id, $data['message']->slug])}}"
                   class="btn btn-outline-info mx-2">
                    Preview before sending
                </a>
            </div>
            <div class="col-sm-12 col-md-3 mx-auto ml-3 text-center">
                <i class="far fa-paper-plane fa-2x mx-2"></i>
                <a href="{{route('admin_message_send', [$data['message']->id, $data['message']->slug])}}"
                   class="btn btn-outline-danger">
                    Send to mail queue
                </a>
            </div>
            <div class="col-sm-12 col-md-3 mx-auto ml-3 text-center">
                <i class="fas fa-glasses fa-2x mx-2"></i>
                <a class="btn btn-outline-primary"
                   href="{{route('admin_message_preview_strict', [$data['message']->id, $data['message']->slug])}}">
                    Email Template Preview
                </a>
            </div>
        </div>
    @endif
@endsection
