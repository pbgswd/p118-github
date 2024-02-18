@extends('layouts.dashboard')
@section('content')

<div class="row">
    <div class="mx-6">
        <h1>Messages Page</h1>
    </div>
</div>
<div class="row">
    <div class="col-12 mx-6">
        <div class="card text-bg-info mb-3" style="max-width: 540px;">
            <div class="card-header">How it works</div>
            <div class="card-body">
                <h5 class="card-title">Send messages to the general membership. </h5>
                <ul class="card-text">
                    <li>Send to all members in the website database</li>
                    <li>Replaces what MailChimp is used for</li>
                    <li>Members must be non suspended</li>
                    <li>Members can manage their email preferences on their profile:
                        receive immediately, daily, weekly, unsubscribe</li>
                    <li>Messages can be previewed before sending</li>
                    <li>Messages to go out are put in a mail queue and sent out in batches</li>
                    <li>Messages will be a content type that can be viewed on the website</li>
                    <li>After messages are sent, they are 'read-only'. No editing. </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="row">
    {{ $data['total_messages'] . ' ' . Str::plural('messages', $data['total_messages']) }} in total.
    | <a href="{{route('admin_message_create')}}">Create Message</a>
    <form name="delete" method="POST" action="{{route('admin_message_destroy')}}">
    {!! csrf_field() !!}
    {!! method_field('DELETE') !!}
</div>


<table class="table table-striped">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">Subject</th>
        <th scope="col">Author</th>
        <th scope="col">Priority</th>
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
                </td>
                <td class="text-break">
                    <a href="{{route('member', $msg['user_id'])}}">
                        <i class="far fa-user"></i>
                        {{$msg['user']->name}}</a>
                </td>
                <td class="align-content-center">
                    @if($msg['priority'] == 'now')
                        <i class="fas fa-exclamation-triangle text-danger"></i>
                    @else
                        <i class="fas fa-check-circle text-success"></i>
                    @endif
                        <br />
                        {{$msg['priority']}}
                </td>
                <td>
                    @if($msg['sent'] == '1')
                        <span class="text-secondary">
                            <i class="far fa-check-circle"></i>
                            <br />
                            Sent
                        </span>
                    @else
                        <a href="{{route('admin_message_edit', $msg['id'])}}" title="Edit {{$msg['subject']}}">
                            <i class="fas fa-edit"></i><br /> Edit
                        </a>
                    @endif
                </td>
                <td>{{ $msg->created_at->format('F j Y H:i:s') }}</td>
                <td>{{ $msg->updated_at->format('F j Y H:i:s') }}</td>
            </tr>
        @empty
            </tr>
                <th scope="row" colspan="7">No data yet</th>
            </tr>
        @endforelse


    </tbody>
</table>
    <div class="row mb-lg-5">
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
