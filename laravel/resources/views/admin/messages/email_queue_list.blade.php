@extends('layouts.dashboard',  ['title_icon' => '<i class="far fa-paper-plane"></i> ', 'title' => 'List of messages in email queue'])
@section('content')
<div class="container">
    <div class="row" style="margin-top: 3rem;">
        <div class="col-sm-12 col-md-6 mt-6">
            <h3>
                <a href="{{route('admin_messages')}}"><< Messages</a>
            </h3>
        </div>
        <div class="col-sm-12 col-md-6 mt-6">
            <h3>
                {{$data['count']}} {{ Str::plural('message', $data['count']) }} in the email queue currently.
            </h3>
        </div>
    </div>
</div>
<div x-data="BoxSelect()" class="mt-6" style="margin-top: 3rem;">
    <form name="delete" method="POST" action="{{route('admin_email_queue_destroy')}}">
        {!! csrf_field() !!}
        {!! method_field('DELETE') !!}
        <div class="form-group">
            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th> @sortablelink('id','Id') </th>
                            <th> @sortablelink('subject', 'Subject') </th>
                            <th> @sortablelink('count', 'Count') </th>
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
                                    <a href="{{route('admin_email_queue_show', $eq->id)}}">
                                        {{$eq->subject}}
                                    </a>
                                </td>
                                <td> {{ $eq->count }} </td>
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
                                <td colspan="5" class="px-2">
                                    No messages in the queue at present.
                                </td>
                            </tr>
                        @endforelse
                        <tr>
                            <td colspan="5">&nbsp;</td>
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
