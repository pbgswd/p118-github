@extends('layouts.dashboard',  ['title' => '<i class="fas fa-list"></i> List Committees'])
@section('content')
    <div class="container">
        <h3>
           <span class="badge badge-primary badge-pill">
               {{$data['committees']->count()}}
           </span>
            Committees.
            @can('create committee')
                |
                <a href="{{ route('committee_create') }}">
                    Create new Committee <i class="far fa-arrow-alt-circle-right"></i>
                </a>
            @endcan
        </h3>
    </div>
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
                            <th>
                                @can('manage committee')
                                    Edit
                                @endcan
                            </th>
                            <th> @sortablelink('created_at', 'Created At') </th>
                            <th> @sortablelink('updated_at', 'Updated At') </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ( $data['committees'] as $c )
                            <tr>
                                <td>
                                    @can('delete committee')
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="id[]" value="{{$c->id}}" />
                                            </label>
                                        </div>
                                    @endcan
                                </td>
                                <td>
                                    <h4>
                                        <a title="{{ $c->name }}"
                                           href="{{ route('admin_committee_show', $c->slug) }}">
                                            {{ $c->name }}
                                        </a>
                                    </h4>
                                </td>
                                <td> {{ $c->access_level }} </td>
                                <td> {!! $c->live ? "<i class='fas fa-check'></i>" :
                                        "<i class='far fa-times-circle'></i>" !!}
                                </td>
                                <td> {{ $c->sort_order }} </td>
                                <td> {!! $c->in_menu ? '<i class="fas fa-check"></i>' :
                                        '<i class="far fa-times-circle"></i>' !!}
                                </td>
                                <td>{{ $c->creator->name }}</td>
                                <td>
                                    @can('manage committee')
                                        <a href="{{ route('committee_edit', $c->slug) }}"
                                           title="Edit {{ $c->name }} ">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    @endcan
                                </td>
                                <td> {{ $c->created_at->format('F j Y H:i:s') }} </td>
                                <td> {{ $c->updated_at->format('F j Y H:i:s') }} </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10">
                                    No committees yet.
                                </td>
                            </tr>
                        @endforelse
                        <tr>
                            <td colspan="10">&nbsp;</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row mb-lg-5">
            <div class="col">
                @can('delete committee')
                    @if($data['committees']->count() > 0)
                        <i class="far fa-trash-alt fa-2x"></i>
                        <input class="btn btn-outline-danger" type="submit" value="Delete Selected">
                    @endif
                @endcan
            </div>
            <div class="col-6">
                <div class="list-group">
                    <ul class="pagination">
                         {{$data['committees']->links()}}
                    </ul>
                </div>
            </div>
            <div class="col"></div>
        </div>
    </form>
@endsection
