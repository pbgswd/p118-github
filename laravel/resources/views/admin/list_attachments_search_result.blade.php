@extends('layouts.dashboard',  ['title' => '<i class="fas fa-paperclip"></i> <i class="far fa-image"></i>
                                    Search result for Attachements and Images'])
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h3>
                    <a href="{{ route('attachments_list') }}">
                        <i class="far fa-arrow-alt-circle-left"></i>
                    </a>
                    <span class="badge badge-primary badge-pill">
                       {{ $data['results']->count() }} Search Results for "{{$data['search']}}"
                    </span>
                    | <a href="{{ route('attachment_create') }}">Add new file
                        <i class="far fa-arrow-alt-circle-right"></i>
                    </a>
                </h3>
            </div>
        </div>
        @include('admin.admin_partials.attachment_search_form')
    </div>
    @if ($data['results']->count() > 0)
        <form name="delete" method="POST" action="{{ route('attachment_destroy') }}">
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
                            @foreach ( $data['results'] as $a )
                                <tr>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="id[]" value="{{ $a->searchable->id }}" />
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        {{$a->searchable->description}}<br />
                                        <a href="{{ route('admin_attachment_edit', $a->searchable->id) }}" title="Edit
                                            {{ $a->searchable->file_name }}">
                                            @if(!in_array($a->searchable->extension, ['jpg', 'jpeg', 'png', 'gif']))
                                                @if($a->searchable->extension == 'pdf')
                                                    <i class="far fa-file-pdf fa-8x"></i>
                                                @else
                                                    <i class="far fa-file fa-8x"></i>
                                                @endif
                                            @else
                                                <img class="border rounded-lg"
                                                     src="{{ asset('storage/' . $a->searchable->subfolder . "/" .
                                                    $a->searchable['file']) }}" {!! $a->searchable->imagedata[0] > 400 ?
                                                    'width="400"' : '' !!} />
                                            @endif
                                        </a>
                                        <h4>
                                            <a title="{{ $a->searchable->name }}"
                                               href="{{ route('admin_attachment_edit', $a->searchable->id) }}">
                                                {{ $a->searchable->file_name }}
                                            </a>
                                        </h4>
                                        <h5>Size: {{ $a->searchable->filesize }}</h5>
                                    </td>
                                    <td>
                                        {{ $a->searchable->id }}
                                    </td>
                                    <td> {{ $a->searchable->user->name }} </td>
                                    <td>
                                        <a href="{{ route('admin_attachment_edit', $a->searchable->id) }}"
                                           title="Edit {{ $a->searchable->file_name }}">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td>
                                    <td> {{ $a->searchable->created_at->format('F j Y H:i:s') }} </td>
                                    <td> {{ $a->searchable->updated_at->format('F j Y H:i:s') }} </td>
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
