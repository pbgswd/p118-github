@extends('layouts.jumbo',  ['title' => '<i class="fas fa-scroll"></i> Messages'])
@section('content')
<div class="container border border-dark rounded p-2" style="background: rgba(220,220,220,0.8);">
    <div class="jumbotron-fluid text-center mb-6">
        <div class="row mb-2">
            <div class="col-12 my-3">
                <h1>
                    <i class="fas fa-scroll"></i>
                    Local 118 Messages
                </h1>
                @can('edit articles')
                    <div class="text-end">
                        <a href="{{route('admin_messages')}}" title="Admin Messages">
                            <i class="fas fa-edit"></i> Admin Messages
                        </a>
                    </div>
                @endcan
            </div>
            <div class="col-12 mb-6">
                <h3>
                   <span class="badge bg-primary">
                       {{ $data['count'] }} Messages
                   </span>
                </h3>
            </div>
        </div>
    </div>
    <div class="col-12 border border-dark rounded p-1 mt-6" style="background: rgba(220,220,220,0.8);">
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th> @sortablelink('subject', 'Subject') </th>
                    <th> @sortablelink('type', 'Type') </th>
                    <th> @sortablelink('name', 'Name') </th>
                    <th> @sortablelink('date', 'Date') </th>
                </tr>
                </thead>
                <tbody>
                @foreach ( $data['messages'] as $message )
                    <tr>
                        <td class="text-left text-wrap" style="width: 50%;">
                            <a title="{{ $message->subject }}" href="{{ route('message', $message->id) }}">{{ $message->subject }}</a>
                        </td>
                        <td>{{$message->messageMeta->source_type}}</td>
                        <td>{{$message->messageMeta->source_type_name}}</td>
                        <td>{{ $message->updated_at->format('F j Y') }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="4">&nbsp;</td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center">
            <div class="list-group">
                <ul class="pagination">
                    {{$data['messages']->links()}}
                </ul>
            </div>
        </div>
    </div>
@endsection
