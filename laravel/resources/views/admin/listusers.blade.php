@extends('layouts.dashboard')
@section('content')
<div class="container">
    <h1 class="display-3"><i class="fas fa-list"></i> List Members</h1>
        <h3>
           <span class="badge badge-primary badge-pill">
               {!! $data['users']->total()  !!}
           </span>
            Members. | <a href="{{ route('user_create') }}">Create new member <i class="far fa-arrow-alt-circle-right"></i> </a>
        </h3>
</div>

<form name="delete" method="POST" action="{{route('topic_destroy')}}">
    {!! csrf_field() !!}
    {!! method_field('DELETE') !!}

    <div class="form-group">
        <div class="table-responsive">
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th> @sortablelink('id','#') </th>
                        <th> @sortablelink('name', 'Title') </th>
                        <th> @sortablelink('access_level', 'Access Level') </th>
                        <th> @sortablelink('live', 'Is Live?') </th>
                        <th> @sortablelink('sort_order', 'Sort Order') </th>
                        <th> @sortablelink('in_menu', 'In Menu?') </th>
                        <th> @sortablelink('allow_comments', 'Allow Comments?') </th>
                        <th> Edit </th>
                        <th> @sortablelink('created_at', 'Created At') </th>
                        <th> @sortablelink('updated_at', 'Updated At') </th>
                    </tr>
                </thead>
                <tbody>
                @foreach ( $data['users'] as $i )
                    <tr>
                        <td>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="id[]" value="{{ $i->id }}" />
                                </label>
                            </div>
                        </td>
                        <td>
                            <h4>
                                <a title="{{ $i->name }}" href="{{ route('topic_edit', $i->slug) }}">{{ $i->name }}</a>
                            </h4>
                        </td>
                        <td> {{ $i->access_level }} </td>
                        <td> {!! $i->live ? "<i class='fas fa-check'></i>" : "<i class='far fa-times-circle'></i>" !!} </td>
                        <td> {{ $i->sort_order }} </td>
                        <td> {!! $i->in_menu ? '<i class="fas fa-check"></i>' : '<i class="far fa-times-circle"></i>' !!} </td>
                        <td> {!! $i->allow_comments ? "<i class='fas fa-check'></i>" : '<i class="far fa-times-circle"></i>' !!} </td>
                        <td>
                            <a href="{{ route('topic_edit', $i->slug) }}" title="Edit {{ $i->name }} ">
                                <i class="fas fa-edit"></i>
                            </a>
                        </td>
                        <td> {{ $i->created_at }} </td>
                        <td> {{ $i->updated_at }} </td>
                    </tr>
                @endforeach
                    <tr>
                        <td colspan="10">&nbsp;</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    @if($data['users']->total() > 0)
    <div class="row">
        <div class="col">
            <i class="far fa-trash-alt fa-2x"></i>
            <input class="btn btn-outline-danger" type="submit" value="Delete Selected">
        </div>
        <div class="col-6">
            <div class="list-group">
                <ul class="pagination">
                    {!! $data['users']->links() !!}
                </ul>
            </div>
        </div>
        <div class="col"></div>
    </div>
    @endif
    <div class="row" style="margin-top:6em;"></div>
</form>

@endsection
