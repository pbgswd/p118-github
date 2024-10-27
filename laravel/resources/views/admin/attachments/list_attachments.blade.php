@extends('layouts.dashboard',  ['title_icon' => '<i class="fas fa-paperclip"></i> <i class="far fa-image"></i>',
    'title' => ' List Attachements and Images'])
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h3>
                   <span class="badge badge-primary badge-pill">
                       {{$data['filecount']}}
                   </span>
                   Files. | <a href="{{ route('attachment_create') }}">Add new file
                        <i class="far fa-arrow-alt-circle-right"></i>
                    </a>
                </h3>
            </div>
        </div>
        @include('admin.admin_partials.attachment_search_form')

@if (count($data['attachments']) > 0)
    <form name="delete" method="POST" action="{{route('attachment_destroy')}}">
        {!! csrf_field() !!}
        {!! method_field('DELETE') !!}
        <div class="row">
            <div class="form-group">
                <div class="table-responsive">
                    <table class="table table-striped ">
                        <thead>
                        <tr>
                            <th> </th>
                            <th> @sortablelink('file_name', 'File Name') </th>
                            <th> @sortablelink('access_level', 'Access Level') </th>
                            <th> @sortablelink('id', 'Id') </th>
                            <th> @sortablelink('user_id', 'Uploaded By') </th>
                            <th> Edit </th>
                            <th> @sortablelink('created_at', 'Created At') </th>
                            <th> @sortablelink('updated_at', 'Updated At') </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ( $data['attachments'] as $a )
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
                                        <a title="{{ $a->name }}" href="{{ route('admin_attachment_edit', $a->id) }}">{{ $a->file_name }}</a>
                                    </h4>
                                </td>
                                <td>
                                    {{$a->access_level}}
                                </td>
                                <td>
                                    {{$a->id}}
                                </td>
                                <td> {{ $a->user->name }} </td>
                                <td>
                                    <a href="{{ route('admin_attachment_edit', $a->id) }}" title="Edit {{ $a->file_name }} ">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                                <td> {{ $a->created_at->format('F j Y H:i:s') }} </td>
                                <td> {{ $a->updated_at->format('F j Y H:i:s') }} </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
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
                        {!! $data['attachments']->links() !!}
                    </ul>
                </div>
            </div>
            <div class="col"></div>
        </div>
        <div class="row mt-lg-5"></div>
    </form>
@endif

@if (!empty($images))
    <h3>Files not in db </h3>
    @foreach ($images as $img)

    @endforeach
@endif
    <div class="row mt-lg-5"></div>
@endsection
