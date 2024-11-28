@extends('layouts.dashboard',  ['title_icon' => '<i class="fas fa-envelope-open-text"></i>>', 'title' => ' Messages'])
@section('content')
<div class="row">
    <div class="mx-6">
        <h1>Messages</h1>
        <h5>Send messages to the general membership. </h5>
    </div>
</div>
<div class="row row-cols-2">
    <div class="col mx-6">
        <ul>
            <li>Send to all members in the website database</li>
            <li>Replaces what MailChimp is used for</li>
            <li>Members must be non suspended</li>
            <li>Members can manage their email preferences on their profile:
            receive immediately, daily, weekly, unsubscribe</li>
        </ul>
    </div>
    <div class="col mx-6">
        <ul>
            <li>Messages can be previewed before sending</li>
            <li>Messages to go out are put in a mail queue and sent out in batches</li>
            <li>Messages will be a content type that can be viewed on the website</li>
            <li>After messages are sent, they are 'read-only'. No editing. </li>
            <li><a href="{{route('admin_email_queue_list')}}">List of mail queue</a></li>
        </ul>
    </div>
</div>
<div class="row" style="margin-bottom: 3rem; margin-top: 3rem;">
    <div class="col-12">
        <ul class="list-group list-group-horizontal">
            <li class="list-group-item flex-fill">
                {{ $data['total_messages'] . ' ' . Str::plural('message', $data['total_messages']) }} in total.
            </li>
            <li class="list-group-item flex-fill">
                {{ $data['total_emails_sent'] . ' ' . Str::plural('email', $data['total_emails_sent']) }}
                have been sent to the membership.
            </li>
            <li class="list-group-item flex-fill">
                {{ $data['not_sent'] . ' ' . Str::plural('message', $data['not_sent']) }} not yet sent.
            </li>
            <li class="list-group-item flex-fill">
                {{ $data['sending'] . ' ' . Str::plural('message', $data['sending']) }} being sent now.
            </li>
            <li class="list-group-item flex-fill">
                {{ $data['sent'] . ' ' . Str::plural('message', $data['sent']) }} sent.
            </li>
        </ul>
    </div>
    <div class="col-12 mt-3">
        <a href="{{route('admin_message_create')}}">Create new Message</a>
        | <a href="{{route('messages')}}">View messages page on website</a>
    </div>
</div>
    <form name="delete" method="POST" action="{{route('admin_message_destroy')}}">
    {!! csrf_field() !!}
    {!! method_field('DELETE') !!}
<table class="table table-striped">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Subject</th>
            <th scope="col">Author</th>
            <th scope="col"> @sortablelink('section','Section')</th>
            <th scope="col"> @sortablelink('category','Category')</th>
            <th scope="col"> @sortablelink('state','State')</th>
            <th scope="col"> @sortablelink('count','Count')</th>
            <th scope="col"> Edit</th>
            <th scope="col"> @sortablelink('created_at', 'Created At') </th>
            <th scope="col"> @sortablelink('updated_at', 'Updated At') </th>
        </tr>
    </thead>
    <tbody>
        @forelse($data['messages'] as $msg)
            <tr>
                <th scope="row">
                    @if($msg['state'] == 'not_sent')
                        <input type="checkbox" name="id[]" value="{{$msg['id']}}">
                    @endif
                </th>
                <td class="text-break">
                    <i class="far fa-envelope-open"></i>
                    @if($msg['state'] == 'not_sent')
                        <a href="{{route('admin_message_edit', [$msg['id'], $msg['slug']])}}"
                            title="Edit {{$msg['subject']}}">
                            {{$msg['subject']}}
                        </a>
                    @else
                        <span class="text-secondary"
                              title="The message cannot no longer be modified because it has been sent out.">
                            {{$msg['subject']}}
                        </span>
                    @endif
                </td>
                <td class="text-break">
                    <a href="{{route('member', $msg['user_id'])}}" class="text-break">
                        {{$msg['user']->name}}</a>
                </td>
                <td>{{$msg->section}}</td>
                <td>{{$msg->category}}</td>
                <td>{{$msg->state}}</td>
                <td>{{$msg->count}}</td>
                <td>
                    @if($msg->state == 'not_sent')
                        <a href="{{route('admin_message_edit', [$msg['id'], $msg['slug']])}}"
                           title="Edit {{$msg['subject']}}">
                            <i class="fas fa-edit"></i>
                        </a>
                    @endif
                    @if($msg->state == 'sending')
                            <i class="far fa-paper-plane" style="color:orange;"
                               title="The message cannot no longer be modified because it is now being sent out."
                            ></i>
                    @endif
                    @if($msg->state == 'sent')
                        <i class="fas fa-lock" style="color:red;"
                           title="The message cannot no longer be modified because it has been sent out.">
                        </i>
                    @endif
                </td>
                <td>{{ $msg->created_at->format('F j Y H:i:s') }}</td>
                <td>{{ $msg->updated_at->format('F j Y H:i:s') }}</td>
            </tr>
        @empty
            <tr>
                <th scope="row" colspan="11">No data yet</th>
            </tr>
        @endforelse
    </tbody>
</table>
    <div class="row my-5">
        <div class="col-12">
            <i class="far fa-trash-alt fa-2x"></i>
            <input class="btn btn-outline-danger" type="submit" value="Delete Selected">
        </div>
    </div>
    </form>
    <div class="row">
        <div class="col-12 mt-3 text-center d-flex justify-content-center">
            <div class="list-group">
                <ul class="pagination text-center">
                    {{ $data['messages']->links() }}
                </ul>
            </div>
        </div>
    </div>
@endsection
