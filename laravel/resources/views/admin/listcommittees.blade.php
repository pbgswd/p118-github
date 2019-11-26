<?php
$committees = $data['committees'];
?>
@extends('layouts.dashboard',  ['title' => '<i class="fas fa-list"></i> List Committees'])
@section('content')
    <div class="container">
            <h3>
               <span class="badge badge-primary badge-pill">
                   {!! count($committees)  !!}
               </span>
                Committees. | <a href="{{ route('committee_create') }}">Create new Committee <i class="far fa-arrow-alt-circle-right"></i> </a>
            </h3>
    </div>
    @if(count($committees) < 1)
        No committees yet.
    @else
        <form name="delete" method="POST" action="{{route('committee_destroy')}}">
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
                                <th> Created By </th>
                                <th> Edit </th>
                                <th> @sortablelink('created_at', 'Created At') </th>
                                <th> @sortablelink('updated_at', 'Updated At') </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ( $committees as $c )
                                <tr>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="id[]" value="{{$c->id}}" />
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <h4>
                                            <a title="{{ $c->name }}" href="{{ route('committee_show', $c->slug) }}">{{ $c->name }}</a>
                                        </h4>
                                    </td>
                                    <td> {{ $c->access_level }} </td>
                                    <td> {!! $c->live ? "<i class='fas fa-check'></i>" : "<i class='far fa-times-circle'></i>" !!} </td>
                                    <td> {{ $c->sort_order }} </td>
                                    <td> {!! $c->in_menu ? '<i class="fas fa-check"></i>' : '<i class="far fa-times-circle"></i>' !!} </td>
                                    <td>{{ $c->creator->name }}</td>
                                    <td>
                                        <a href="{{ route('committee_edit', $c->slug) }}" title="Edit {{ $c->name }} ">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td>
                                    <td> {{ $c->created_at }} </td>
                                    <td> {{ $c->updated_at }} </td>
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
                             {{$committees->links()}}
                        </ul>
                    </div>
                </div>
                <div class="col"></div>
            </div>
            <div class="row" style="margin-top:6em;"></div>
        </form>
    @endif
@endsection
