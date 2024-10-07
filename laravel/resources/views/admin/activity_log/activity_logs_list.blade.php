@extends('layouts.dashboard',  ['title_icon' => '<i class="fas fa-tachometer-alt"></i></i>', 'title' => 'Activity Log'])
@section('content')
<form name="delete" method="POST" action="{{route('admin_activity_log_destroy')}}">
{!! csrf_field() !!}
{!! method_field('DELETE') !!}
<table class="table table-striped">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Activity</th>
            <th scope="col">ip</th>
            <th scope="col">User Agent</th>
            <th scope="col">Model</th>
            <th scope="col">Created At</th>
        </tr>
    </thead>
    <tbody>
        @forelse($data['activities'] as $activity)
            <tr>
                <th scope="row">
                    <input type="checkbox" name="id[]" value="{{$activity['id']}}">
                </th>
                <td>{{$activity->activity}}</td>
                <td>{{$activity->ip_address}}</td>
                <td>{{$activity->user_agent}}</td>
                <td>{{$activity->model}}</td>
                <td>{{ $activity->created_at->format('F j Y H:i:s') }}</td>
            </tr>
        @empty
            <tr>
                <th scope="row" colspan="8">No data yet</th>
            </tr>
        @endforelse
    </tbody>
</table>
    <div class="row my-5">
        <div class="col">
            <i class="far fa-trash-alt fa-2x"></i>
            <input class="btn btn-outline-danger" type="submit" value="Delete Selected">
        </div>
        <div class="col">
            <div class="list-group">
                <ul class="pagination">
                    {{ $data['activities']->links() }}
                </ul>
            </div>
        </div>
    </div>
@endsection
