@extends('layouts.dashboard',  ['title' => '<i class="fas fa-list"></i> Employment postings'])
@section('content')
<div class="container">
        <h3>
           <span class="badge badge-primary badge-pill">
               {!! $data['count']  !!}
           </span>
            employment postings. |
            <a href="{{ route('admin_employment_create') }}">
                Create new Employment Posting
                <i class="far fa-arrow-alt-circle-right"></i>
            </a>
        </h3>
</div>
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
                    @forelse ( $data['employment'] as $e )
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
                                    <a title="{!! $e->title !!}" href="{{route('admin_employment_edit', $e->id)}}">
                                        {{ $e->title }}
                                    </a>
                                </h4>
                                <h6>
                                    {{$e->attachments->count()}}
                                    {{Str::plural('Attachment', $e->attachments->count())}}
                                </h6>
                            </td>
                            <td>
                                @forelse ($e->attachments as $ea)
                                    <a href="{{route('attachment_download', [$e->getAttachmentFolder(), $ea->id])}}"
                                       title="Download {{$ea->file_name}} {{$ea->description}}">
                                        <i class="fas fa-file-download fa-2x"></i>
                                    </a>
                                @empty
                                @endforelse
                                @if ($e->url != '')
                                    <a href="{{$e->url}}" title="Open {{$e->title}} in new tab" target="_blank">
                                        <i class="fas fa-external-link-alt fa-2x"></i>
                                    </a>
                                @endif
                            </td>
                            <td> {!! $e->live ? "<i class='fas fa-check'></i>" :
                                    "<i class='far fa-times-circle'></i>" !!}
                            </td>
                            <td> {!! $e->status ? "<i class='fas fa-check'></i>" :
                                    "<i class='far fa-times-circle'></i>" !!}
                            </td>
                            <td>
                                <a href="{{ route('admin_employment_edit', $e->id) }}" title="Edit {{ $e->title }} ">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                            <td> {{ $e->deadline->format('F j Y') }} </td>
                            <td> {{ $e->created_at->format('F j Y H:i:s') }} </td>
                            <td> {{ $e->updated_at->format('F j Y H:i:s') }} </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9">Nothing posted</td>
                        </tr>
                    @endforelse
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
                     {{ $data['employment']->links() }}
                </ul>
            </div>
        </div>
        <div class="col"></div>
    </div>
</form>
@endsection
