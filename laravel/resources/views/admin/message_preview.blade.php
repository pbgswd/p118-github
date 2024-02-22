@extends('layouts.dashboard')
@section('content')
    <div class="row m-4 mt-6 mb-6">
        <div class="col-12 mb-6">
            <h2>Preview Message | <a href="{{route('admin_messages')}}">List Messages</a></h2>
        </div>
    </div>
    <div class="row m-4 border border-1 border-black rounded p-4">
        <div class="col-12 mx-6">
                <p>Created by: {{$data['message']->user->name}}</p>
                <p>Created At: {{$data['message']->created_at->format('F j Y H:i:s') }}</p>
                <p>Last Updated At: {{ $data['message']->updated_at->format('F j Y H:i:s') }}</p>
        </div>
        <div class="col-12">
            <h4>Message Sending Priority</h4>
            {{$data['message']->priority}}
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
            <h3>File Attachments</h3>
            @forelse ($data['message']->attachments as $ma)
                {{$ma->file_name}}
            @empty
                No attachments
            @endforelse
        </div>
    </div>
</div>


<div class="row my-5">
    <div class="col-sm-12 col-md-4 border border-1 rounded mr-2 p-4">
        <i class="fas fa-edit fa-2x"></i>
        <a href="{{route('admin_message_edit', $data['message']->id)}}" class="btn btn-outline-primary">Return to Edit</a>
    </div>
        <div class="col-sm-12 col-md-4 ml-3 p-4 bg-body-secondary border border-1 rounded text-right">
            <i class="far fa-paper-plane fa-2x mx-2"></i>
        <a href="{{route('admin_message_send', $data['message']->id)}}" class="btn btn-outline-danger">Send to mail queue</a>
    </div>
</div>


@endsection
