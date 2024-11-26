@extends('layouts.dashboard',  ['title_icon' => '<i class="fas fa-list"></i>', 'title' => ' Messages'])
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
        {{ $data['total_messages'] . ' ' . Str::plural('message', $data['total_messages']) }}.
        | <a href="{{route('admin_message_create')}}">Create new Message</a>
        | <a href="{{route('messages')}}">View messages page on site</a>
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
        <th scope="col">Type</th>
        <th scope="col">Name</th>

        <th scope="col">Sent</th>
        <th scope="col">Created At</th>
        <th scope="col">Updated At</th>
    </tr>
    </thead>
    <tbody>
        @forelse($data['messages'] as $msg)
            <tr>
                <th scope="row">
                    @if($msg['sent'] != '1')
                        <input type="checkbox" name="id[]" value="{{$msg['id']}}">
                    @endif
                </th>
                <td class="text-break">
                    <i class="far fa-envelope-open"></i>
                    @if($msg['sent'] == '1')
                            <span class="text-secondary">
                                {{$msg['subject']}}
                            </span>
                    @else
                        <a href="{{route('admin_message_edit', $msg['id'])}}">
                            {{$msg['subject']}}
                        </a>
                    @endif
                    <br />
                    <a href="{{env('APP_URL')}}/{{$msg->messageMeta->source_url}}">URL</a>
                </td>
                <td class="text-break">
                    <a href="{{route('member', $msg['user_id'])}}">
                        <i class="far fa-user"></i>
                        {{$msg['user']->name}}</a>
                </td>
                <td>{{$msg->messageMeta->source_type}}</td>
                <td>{{$msg->messageMeta->source_type_name}}</td>
                <td>
                    {{$msg->state}}
                    <a href="{{route('admin_message_edit', $msg['id'])}}" title="Edit {{$msg['subject']}}">
                        <i class="fas fa-edit"></i><br /> Not yet. Edit
                    </a>
                </td>
                <td>{{ $msg->created_at->format('F j Y H:i:s') }}</td>
                <td>{{ $msg->updated_at->format('F j Y H:i:s') }}</td>
            </tr>
        @empty
            <tr>
                <th scope="row" colspan="9">No data yet</th>
            </tr>
        @endforelse
    </tbody>
</table>
    <div class="row my-5">
        <div class="col">
            <i class="far fa-trash-alt fa-2x"></i>
            <input class="btn btn-outline-danger" type="submit" value="Delete Selected">
        </div>
        <div class="col-6">
            <div class="list-group">
                <ul class="pagination">
                    {{ $data['messages']->links() }}
                </ul>
            </div>
        </div>
        <div class="col"></div>
    </div>
@endsection
