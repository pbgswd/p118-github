 <?php
$meetings = $data['meetings'];
?>
@extends('layouts.dashboard',  ['title' => '<i class="far fa-folder-open"></i> List Meetings and Minutes'])
@section('content')
    <div class="container">
        <h3>
           <span class="badge badge-primary badge-pill">
              {{$data['count']}}
           </span>
           Meetings and Minutes. | <a href="{{ route('meeting_create') }}">Add new entry <i class="far fa-arrow-alt-circle-right"></i></a>
        </h3>
    </div>
@if (count($meetings) > 0)
    <form name="delete" method="POST" action="{{route('meeting_destroy')}}">
        {!! csrf_field() !!}
        {!! method_field('DELETE') !!}
        <div class="form-group">
            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                    <tr>
                        <th> @sortablelink('id','#') </th>
                        <th> @sortablelink('title', 'Title') </th>
                        <th> @sortablelink('id', 'Id') </th>
                        <th> @sortablelink('user_id', 'Added By') </th>
                        <th> Edit </th>
                        <th> @sortablelink('date', 'Date') </th>
                        <th> @sortablelink('created_at', 'Created At') </th>
                        <th> @sortablelink('updated_at', 'Updated At') </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ( $meetings as $a )
                        <tr>
                            <td>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="id[]" value="{{$a->id}}" />
                                    </label>
                                </div>
                            </td>
                            <td>
                                <h4>
                                    <a title="{{ $a->title }}" href="{{ route('meeting_edit', $a->id) }}">{{ $a->title }}</a>
                                </h4>
                            </td>
                            <td>
                                {{$a->id}}
                            </td>
                            <td> {{$a->user->name}} </td>
                            <td>
                                <a href="{{ route('meeting_edit', $a->id) }}" title="Edit {{ $a->title }} ">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                            <td> {{ $a->date->format('F j Y H:i:s') }} </td>
                            <td> {{ $a->created_at }} </td>
                            <td> {{ $a->updated_at }} </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="7">&nbsp;</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <i class="far fa-trash-alt fa-2x"></i>
                <input class="btn btn-outline-danger" type="submit" value="Delete Selected">
            </div>
            <div class="col-6">
                <div class="list-group">
                    <ul class="pagination">
                        {!! $meetings->links() !!}
                    </ul>
                </div>
            </div>
            <div class="col"></div>
        </div>
        <div class="row" style="margin-top:6em;"></div>
    </form>
@endif
    <div class="row" style="margin-top:30px;"></div>
@endsection
