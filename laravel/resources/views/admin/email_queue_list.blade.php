@extends('layouts.dashboard',  ['title' => '<i class="fas fa-list"></i> Employment postings'])
@section('content')
<div class="container">
        <h3>
            {!! $data['count']  !!} Emails in the Queue at present.
        </h3>
</div>
<div x-data="BoxSelect()">
    <form name="delete" method="POST" action="{{route('admin_email_queue_destroy')}}">
        {!! csrf_field() !!}
        {!! method_field('DELETE') !!}
        <div class="form-group">
            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th> @sortablelink('id','#') </th>
                            <th> @sortablelink('sender', 'Sender') </th>
                            <th> @sortablelink('recipient', 'Recipient') </th>
                            <th> @sortablelink('subject', 'Subject') </th>
                            <th> @sortablelink('message', 'Message') </th>
                            <th>Attachments
                            </th>
                            <th> @sortablelink('created_at', 'Created At') </th>
                            <th> @sortablelink('updated_at', 'Updated At') </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ( $data['email_queue'] as $eq )
                            <tr>
                                <td>
                                    <div class="checkbox mx-2">
                                        <label>
                                            <input type="checkbox" name="id[]" value="{{$eq->id}}" x-bind:checked="selectAllCheckBoxes" />
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    {{ $eq->sender }}
                                </td>
                                <td>
                                    {{$eq->recipient}}
                                </td>
                                <td>
                                    <a href="{{route('admin_email_queue_show', $eq->id)}}">
                                        {{$eq->subject}}
                                    </a>
                                </td>
                                <td>
                                    {!! Str::limit($eq->message, 30, ' ...') !!}
                                </td>
                                <td>
                                    attachments<br /> count
                                </td>
                                <td> {{ $eq->created_at->format('F j Y H:i:s') }} </td>
                                <td> {{ $eq->updated_at->format('F j Y H:i:s') }} </td>
                            </tr>
                            @if($loop->last)
                                <tr>
                                    <td colspan="9">
                                        <div class="input-group">
                                            <div class="input-group-text bg-info-subtle">
                                                <input type="checkbox" class="form-check-input mt-0" @click="selectAllCheckBoxes=!selectAllCheckBoxes"  aria-label="Checkbox for following text input">
                                            </div>
                                            <input type="text" class="form-control bg-info-subtle" value="Select / Deselect All" aria-label="Text input with checkbox">
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        @empty
                            <tr>
                                <td colspan="9" class="px-2">
                                    No messages in the queue present.
                                </td>
                            </tr>
                        @endforelse
                        <tr>
                            <td colspan="9">&nbsp;</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row mb-lg-5">
            <div class="col">
                <i class="far fa-trash-alt fa-2x"></i>
                <input class="btn btn-outline-danger" type="submit" value="Delete Selected">
            </div>
            <div class="col-6">
                <div class="list-group">
                    <ul class="pagination">
                         {{ $data['email_queue']->links() }}
                    </ul>
                </div>
            </div>
            <div class="col"></div>
        </div>
    </form>
</div>
<script>
    function BoxSelect() {
        return {
            selectAllCheckBoxes: false,
        };
    }
</script>
@endsection
