<?php
//dd($data);
$employment = $data['employment'];
?>
@extends('layouts.dashboard',  ['title' => '<i class="fas fa-list"></i> Employment postings'])
@section('content')
<div class="container">
        <h3>
           <span class="badge badge-primary badge-pill">
               {!! $data['count']  !!}
           </span>
            employment postings. | <a href="{{ route('admin_employment_create') }}">Create new Employment Posting <i class="far fa-arrow-alt-circle-right"></i> </a>
        </h3>
</div>

    @if(count($employment) < 1)
    No employment postings defined yet
    @else
<form name="delete" method="POST" action="{{route('admin_employment_destroy')}}">
    {!! csrf_field() !!}
    {!! method_field('DELETE') !!}

    <div class="form-group">
        <div class="table-responsive">
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th> @sortablelink('id','#') </th>
                        <th> @sortablelink('title', 'Title') </th>
                        <th>link/file</th>
                        <th> @sortablelink('live', 'Is Live?') </th>
                        <th> @sortablelink('status', 'Open/Closed') </th>
                        <th> Edit </th>
                        <th> @sortablelink('deadline', 'Deadline') </th>
                        <th> @sortablelink('created_at', 'Created At') </th>
                        <th> @sortablelink('updated_at', 'Updated At') </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ( $employment as $e )
                        <tr>
                            <td>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="id[]" value="{{$e->id}}" />
                                    </label>
                                </div>
                            </td>
                            <td>
                                <h4>
                                    <a title="{!!  $e->title !!}" href="{{route('admin_employment_edit', $e->id)}}">{{ $e->title }}</a>
                                </h4>
                            </td>
                            <td>
                                @foreach ($e->attachments as $ea)
                                    <a href="{{route('attachment_download', [$e->getAttachmentFolder(), $ea->id])}}" title="Download {{$ea->file_name}} {{$ea->description}}"><i class="fas fa-file-download fa-2x"></i></a>
                                @endforeach
                                @if ($e->url != '')
                                    <a href="{{$e->url}}" title="Open {{$e->title}} in new tab" target="_blank"><i class="fas fa-external-link-alt fa-2x"></i></a>
                                @endif
                            </td>
                            <td> {!! $e->live ? "<i class='fas fa-check'></i>" : "<i class='far fa-times-circle'></i>" !!} </td>
                            <td> {!! $e->jobstatus ? "<i class='fas fa-check'></i>" : "<i class='far fa-times-circle'></i>" !!} </td>
                            <td>
                                <a href="{{ route('admin_employment_edit', $e->id) }}" title="Edit {{ $e->title }} ">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                            <td> {{ $e->deadline }} </td>
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
    <div class="row">
        <div class="col">
            <i class="far fa-trash-alt fa-2x"></i>
            <input class="btn btn-outline-danger" type="submit" value="Delete Selected">
        </div>
        <div class="col-6">
            <div class="list-group">
                <ul class="pagination">
                     {{ $employment->links() }}
                </ul>
            </div>
        </div>
        <div class="col"></div>
    </div>



    <div class="row" style="margin-top:6em;"></div>
</form>
@endif
@endsection
