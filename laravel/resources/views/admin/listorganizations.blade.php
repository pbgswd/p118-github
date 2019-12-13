<?php
$organizations = $data['data'];
?>
@extends('layouts.dashboard',  ['title' => '<i class="fas fa-list"></i> List organizations'])
@section('content')
<div class="container">
        <h3>
           <span class="badge badge-primary badge-pill">
               {!! count($organizations['organizations'])  !!}
           </span>
            organizations. | <a href="{{ route('organization_create') }}">Create new organization <i class="far fa-arrow-alt-circle-right"></i> </a>
        </h3>
</div>

    @if(count($organizations['organizations']) < 1)
    No organizations
    @else
<form name="delete" method="POST" action="{{route('organization_destroy')}}">
    {!! csrf_field() !!}
    {!! method_field('DELETE') !!}

    <div class="form-group">
        <div class="table-responsive">
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th> @sortablelink('id','#') </th>
                        <th> @sortablelink('title', 'Title') </th>
                        <th> @sortablelink('access_level', 'Access Level') </th>
                        <th> @sortablelink('live', 'Is Live?') </th>
                        <th> @sortablelink('sort_order', 'Sort Order') </th>
                        <th> @sortablelink('in_menu', 'In Menu?') </th>
                        <th> Edit </th>
                        <th> @sortablelink('created_at', 'Created At') </th>
                        <th> @sortablelink('updated_at', 'Updated At') </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ( $organizations['organizations'] as $v )
                        <tr>
                            <td>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="id[]" value="{{$v->id}}" />
                                    </label>
                                </div>
                            </td>
                            <td>
                                <h4>
                                    <a title="{{ $v->name }}" href="{{ route('organization_edit', $v->slug) }}">{{ $v->name }}</a>
                                </h4>
                            </td>
                            <td> {{ $v->access_level }} </td>
                            <td> {!! $v->live ? "<i class='fas fa-check'></i>" : "<i class='far fa-times-circle'></i>" !!} </td>
                            <td> {{ $v->sort_order }} </td>
                            <td> {!! $v->in_menu ? '<i class="fas fa-check"></i>' : '<i class="far fa-times-circle"></i>' !!} </td>
                            <td>
                                <a href="{{ route('organization_edit', $v->slug) }}" title="Edit {{ $v->name }} ">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                            <td> {{ $v->created_at }} </td>
                            <td> {{ $v->updated_at }} </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="10">&nbsp;</td>
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
                     {{ $organizations['organizations']->links() }}
                </ul>
            </div>
        </div>
        <div class="col"></div>
    </div>



    <div class="row" style="margin-top:6em;"></div>
</form>
@endif
@endsection
