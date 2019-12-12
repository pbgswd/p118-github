<?php
//dd($data);
$agreements = $data['data'];
?>
@extends('layouts.dashboard',  ['title' => '<i class="fas fa-list"></i> List agreements'])
@section('content')
<div class="container">
        <h3>
           <span class="badge badge-primary badge-pill">
               {!! count($agreements['agreements'])  !!}
           </span>
            agreements. | <a href="{{ route('agreement_create') }}">Create new agreement <i class="far fa-arrow-alt-circle-right"></i> </a>
        </h3>
</div>

    @if(count($agreements['agreements']) < 1)
    No agreements defined yet
    @else
<form name="delete" method="POST" action="{{route('agreement_destroy')}}">
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
                        <th> Edit </th>
                        <th> @sortablelink('created_at', 'Created At') </th>
                        <th> @sortablelink('updated_at', 'Updated At') </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ( $agreements['agreements'] as $a )
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
                                    <a title="{{ $a->name }}" href="{{ route('agreement_edit', $a->slug) }}">{{ $a->name }}</a>
                                </h4>
                            </td>
                            <td> {{ $a->access_level }} </td>
                            <td> {!! $a->live ? "<i class='fas fa-check'></i>" : "<i class='far fa-times-circle'></i>" !!} </td>
                            <td> {{ $a->sort_order }} </td>
                            <td>
                                <a href="{{ route('agreement_edit', $a->slug) }}" title="Edit {{ $a->name }} ">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                            <td> {{ $a->created_at }} </td>
                            <td> {{ $a->updated_at }} </td>
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
                     {{ $agreements['agreements']->links() }}
                </ul>
            </div>
        </div>
        <div class="col"></div>
    </div>



    <div class="row" style="margin-top:6em;"></div>
</form>
@endif
@endsection
