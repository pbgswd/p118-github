<?php
$attachments = $data['attachments'];
?>
@extends('layouts.dashboard',  ['title' => '<i class="fas fa-paperclip"></i> <i class="far fa-image"></i> List Attachements and Images'])
@section('content')
    <div class="container">
        <h3>
           <span class="badge badge-primary badge-pill">
               {{$data['filecount']}}
           </span>
           Files. | <a href="{{ route('attachment_create') }}">Add new file <i class="far fa-arrow-alt-circle-right"></i> </a>
        </h3>
    </div>
@if (count($attachments) > 0)
    <form name="delete" method="POST" action="{{route('attachment_destroy')}}">
        {!! csrf_field() !!}
        {!! method_field('DELETE') !!}
        <div class="form-group">
            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                    <tr>
                        <th> @sortablelink('id','#') </th>
                        <th> @sortablelink('file_name', 'File Name') </th>
                        <th> @sortablelink('id', 'Id') </th>
                        <th> @sortablelink('user_id', 'Uploaded By') </th>
                        <th> Edit </th>
                        <th> @sortablelink('created_at', 'Created At') </th>
                        <th> @sortablelink('updated_at', 'Updated At') </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ( $attachments as $a )
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
                                    <a title="{{ $a->name }}" href="{{ route('attachment_edit', $a->id) }}">{{ $a->file_name }}</a>
                                </h4>
                            </td>
                            <td>
                                {{$a->id}}
                            </td>
                            <td> {{ $a->users->name }} </td>
                            <td>
                                <a href="{{ route('attachment_edit', $a->id) }}" title="Edit {{ $a->file_name }} ">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
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
                        {!! $attachments->links() !!}
                    </ul>
                </div>
            </div>
            <div class="col"></div>
        </div>
        <div class="row" style="margin-top:6em;"></div>
    </form>
@endif

@if (!empty($images))
    <h3>Files not in db </h3>
    @foreach ($images as $img)

    @endforeach
@endif
    <div class="row" style="margin-top:30px;"></div>
@endsection
