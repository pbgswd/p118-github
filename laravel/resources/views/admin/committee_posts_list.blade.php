<?php
$posts = $data['data'];
$committee = $data['data']['committee'];
?>
@extends('layouts.dashboard',  ['title' => '<i class="fas fa-list"></i> List Posts for ' . $committee->name])
@section('content')
    <div class="container">
            <h3>
               <span class="badge badge-primary badge-pill">
                   {!! count($posts['posts'])  !!}
               </span>
               Posts.
            </h3>
    </div>
    @if(count($posts['posts']) < 1)
        No posts yet.   <a href="{{route('committee_post', $committee->slug)}}">Add New Post</a>
    @else
        <form name="delete" method="POST" action="{{route('committee_post_destroy', $committee->slug)}}">
            {!! csrf_field() !!}
            {!! method_field('DELETE') !!}
            <div class="form-group">
                <div class="table-responsive">
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th> @sortablelink('id','#') </th>
                                <th> @sortablelink('title', 'Title') </th>
                                <th> @sortablelink('live', 'Is Live?') </th>
                                <th> @sortablelink('sticky', 'Sticky') </th>
                                <th> Edit </th>
                                <th> @sortablelink('created_at', 'Created At') </th>
                                <th> @sortablelink('updated_at', 'Updated At') </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ( $posts['posts'] as $p )
                                <tr>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="id[]" value="{{$p->id}}" />
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <h4>
                                            <a title="{{ $p->title}}" href="{{ route('committee_post_edit',[$committee->slug, $p->slug]) }}">{{ $p->title}}</a>
                                        </h4>
                                    </td>
                                    <td> {!! $p->live ? "<i class='fas fa-check'></i>" : "<i class='far fa-times-circle'></i>" !!} </td>
                                    <td> {!! $p->sticky ? '<i class="fas fa-check"></i>' : '<i class="far fa-times-circle"></i>' !!} </td>
                                    <td>
                                        <a href="{{ route('committee_post_edit',[$committee->slug, $p->slug]) }}" title="Edit {{ $p->title }}">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td>
                                    <td> {{ $p->created_at }} </td>
                                    <td> {{ $p->updated_at }} </td>
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
                             {{ $posts['posts']->links() }}
                        </ul>
                    </div>
                </div>
                <div class="col"></div>
            </div>
            <div class="row" style="margin-top:6em;"></div>
        </form>
    @endif
@endsection
