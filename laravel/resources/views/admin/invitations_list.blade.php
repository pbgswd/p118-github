<?php
$invitations = $data['invitations'];
?>
@extends('layouts.dashboard',  ['title' => '<i class="fas fa-list"></i> Pending Invitations to website'])
@section('content')
<div class="container">
        <h3>
           <span class="badge badge-primary badge-pill">
             {{$data['count']}}  {{ Str::plural('Invitation', $data['count']) }} Pending
           </span>
            | <a href="{{ route('invite_new_user') }}">Create new invitation to website <i class="far fa-arrow-alt-circle-right"></i> </a>
        </h3>
</div>

    @if($data['count'] < 1)
    No invitations to the site presently.
    @else
<form name="delete" method="POST" action="{{route('invited_user_destroy')}}">
    {!! csrf_field() !!}
    {!! method_field('DELETE') !!}

    <div class="form-group">
        <div class="table-responsive">
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th> @sortablelink('id','#') </th>
                        <th> @sortablelink('name', 'Name') </th>
                        <th> Email </th>
                        <th> Role </th>
                        <th> Edit </th>
                        <th> Added by </th>
                        <th> @sortablelink('created_at', 'Created At') </th>
                        <th> @sortablelink('updated_at', 'Updated At') </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ( $invitations as $i )
                        <tr>
                            <td>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="id[]" value="{{$i->id}}" />
                                    </label>
                                </div>
                            </td>
                            <td>
                                <h4>
                                    {{ $i->name }}
                                </h4>
                            </td>
                            <td>
                                {{$i->email}}
                            </td>
                            <td>
                                {{$i->role}}
                            </td>
                           <td>
                                <a href="{{ route('invited_user_edit', $i->id) }}" title="Edit {{ $i->name }} ">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                            <td>
                                {{$i->user->name}}
                            </td>
                            <td> {{ $i->created_at }} </td>
                            <td> {{ $i->updated_at }} </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="8">&nbsp;</td>
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
                     {{ $invitations->links() }}
                </ul>
            </div>
        </div>
        <div class="col"></div>
    </div>



    <div class="row" style="margin-top:6em;"></div>
</form>
@endif
@endsection
