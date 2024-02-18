@extends('layouts.dashboard')
@section('content')
@include('admin.admin_partials.admin_tinymce')
<form name="{{$data['action']}}" method="POST" action="{{url()->current()}}">
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
                            {{$data['message']->user->name}}</a>
                    </p>
                    <p>Created At: {{$data['message']->created_at->format('F j Y H:i:s') }}</p>
                    <p>Last Updated At: {{ $data['message']->updated_at->format('F j Y H:i:s') }}</p>
                </div>
            @endif
            <div class="col-12 my-4">
                <h3>Subject</h3>
                <input x-model="subject" type="text" name="message[subject]" value="{{ old('message.subject', $data['message']->subject)}}" size="40" required />
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
    <div class="row m-4 border border-1 rounded">
        <div class="col-12">
            <h2>File Attachment</h2>

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
