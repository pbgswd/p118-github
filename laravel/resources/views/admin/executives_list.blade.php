<?php
$executives = $data['executives'];
?>
@extends('layouts.dashboard',  ['title' => '<i class="fas fa-list"></i> Executive Members'])
@section('content')
<div class="container">
        <h3>
           <span class="badge badge-primary badge-pill">
               {!! $data['count']  !!}
           </span>
            executive {{Str::plural(' role', $data['count'])}}
            |
            <a href="{{ route('users_list') }}">
                Return to Members List <i class="far fa-arrow-alt-circle-left"></i>
            </a>
        </h3>
</div>
    @if($data['count'] < 1)
        No executive roles defined yet
    @else
<form name="delete" method="POST" action="{{route('admin_executive_destroy')}}">
    {!! csrf_field() !!}
    {!! method_field('DELETE') !!}
    <div class="form-group">
        <div class="table-responsive">
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th> @sortablelink('id','#') </th>
                        <th>Name</th>
                        <th> @sortablelink('title', 'Title') </th>
                        <th> @sortablelink('current', 'Current') </th>
                        <th> Edit </th>
                        <th> @sortablelink('start_date', 'Start of Term') </th>
                        <th> @sortablelink('end_date', 'End of Term') </th>
                        <th> @sortablelink('created_at', 'Created At') </th>
                        <th> @sortablelink('updated_at', 'Updated At') </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ( $executives as $e )
                        <tr>
                            <td>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="id[]" value="{{$e->id}}" />
                                    </label>
                                </div>
                            </td>
                            <td>
                                <a href="{{route('user_edit', $e->user->id)}}">{{$e->user->name}}</a>
                            </td>
                            <td>
                                {{ $e->title }}
                            </td>
                            <td>
                                {!! $e->current ? "<i class='fas fa-check'></i>" : "<i class='far fa-times-circle'></i>" !!}
                            </td>
                            <td>
                                <a href="{{ route('admin_executive_edit', $e->id) }}" title="Edit {{ $e->id }} ">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                            <td> {{ $e->start_date }} </td>
                            <td> {{ $e->end_date }} </td>
                            <td> {{ $e->created_at }} </td>
                            <td> {{ $e->updated_at }} </td>
                        </tr>
                    @endforeach
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
                     {{ $executives->links() }}
                </ul>
            </div>
        </div>
        <div class="col"></div>
    </div>
</form>
@endif
@endsection
