@extends('layouts.dashboard',  ['title_icon' => '<i class="fas fa-envelope-open-text"></i>', 'title' => ' Message Preview'])
@section('content')
    <div class="row m-4 mt-6 mb-6">
        <div class="col-12 mb-6">
            <h4><a href="{{route('admin_messages')}}">List Messages</a>
                | <a href="#sending" title="Top of page">
                    Jump to sending section <i class="fas fa-angle-down"></i>
                </a>
            </h4>
        </div>
    </div>
    <div class="row m-4 border border-1 border-black rounded p-4">
        <div class="col-12 mx-6">
                <p>Created by: {{$data['message']->user->name}}</p>
                <p>Created At: {{$data['message']->created_at->format('F j Y H:i:s') }}</p>
                <p>Last Updated At: {{ $data['message']->updated_at->format('F j Y H:i:s') }}</p>
        </div>
    </div>
    <div class="row mx-4 border border-1 border-black rounded p-4">
    <div class="col-12">
        <h3>Subject: </h3>
            {{$data['message']->subject}}
        </div>
        <div class="col-12 mt-5">
            <h3>Message</h3>
                {!! $data['message']->content !!}
        </div>
        <div class="col-12 mt-5">
            <h3><i class="fas fa-paperclip"></i> File Attachments</h3>
            <ul class="list-group">
            @forelse ($data['message']->attachments as $ma)
                <li class="list-group-item">
                    <i class="fas fa-paperclip"></i>
                    <a href="{{route('attachment_download', [$data['message']->getAttachmentFolder(), $ma->id])}}"
                       title="Download {{$ma->file_name}}" target="_blank">
                        {{$ma->file_name}}
                    </a>
                </li>
            @empty
                <li class="list-group-item">
                    No attachments
                </li>
            @endforelse
            </ul>
        </div>
    </div>
    <a name="sending"></a>
<div class="row row p-4 mt-5 border border-1 rounded">
    <div class="col-12 text-center mb-4">
        <h2>Sending</h2>
        <h3>Note: The content can no longer be modified after it has been sent out.</h3>
    </div>
    <div class="col-sm-12 col-md-3 mx-auto mr-2 p-4">
        <i class="fas fa-list fa-2x mx-2"></i>
        <a href="{{route('admin_messages')}}" class="btn btn-outline-info">Return to List</a>
    </div>
    <div class="col-sm-12 col-md-3 mx-auto mr-2 p-4">
        <i class="fas fa-edit fa-2x mx-2"></i>
        <a href="{{route('admin_message_edit', [$data['message']->id, $data['message']->slug])}}" class="btn btn-outline-primary">Return to Edit</a>
    </div>
    <div class="col-sm-12 col-md-3 mx-auto ml-3 p-4">
        <i class="fas fa-glasses fa-2x mx-2"></i>
        <a class="btn btn-outline-primary"
           href="{{route('admin_message_preview_strict', [$data['message']->id, $data['message']->slug])}}">
            Email Template Preview
        </a>
    </div>
    <div class="col-sm-12 col-md-3 mx-auto ml-3 p-4">
        <i class="far fa-paper-plane fa-2x mx-2"></i>
        <a href="{{route('admin_message_send', $data['message']->id)}}"
           class="btn btn-outline-danger">
            Send to mail queue
        </a>
    </div>
</div>
@endsection
