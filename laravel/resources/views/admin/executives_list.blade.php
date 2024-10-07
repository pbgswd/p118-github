@extends('layouts.dashboard',  ['title_icon' => '<i class="fas fa-list"></i>', 'title' => ' Executive Members'])
    @section('content')
    <div class="container">
        <h3>
            <a href="{{ route('users_list') }}">
                <i class="far fa-arrow-alt-circle-left"></i>
                All Members
            </a>
        </h3>
    </div>
    <form name="delete" method="POST" action="{{route('admin_executive_destroy')}}">
            {!! csrf_field() !!}
            {!! method_field('DELETE') !!}
            <div class="form-group">
                <div class="table-responsive mb-3">
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th> @sortablelink('id','#') </th>
                                <th>Name</th>
                                <th> @sortablelink('title', 'Title') </th>
                                <th> @sortablelink('current', 'Current') </th>
                                <th> Edit </th>
                                <th> @sortablelink('start_date', 'Start of Term') </th>
                                <th> @sortablelink('end_date', 'End of Term') </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $e )
                                <tr>
                                    <td>
                                        @if( !empty($e->user[0]))
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="id[]"
                                                           value="{{$e->user[0]->pivot->id }}" />
                                                </label>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        @if(!empty($e->user[0]))
                                            <a href="{{route('user_edit', $e->user[0]->id)}}">
                                                {{$e->user[0]->name}}
                                            </a>
                                        @else
                                            <i>not filled</i>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $e->title }}
                                    </td>
                                    <td>
                                        @if( !empty($e->user[0]))
                                            @if(\Carbon\Carbon::now() >
                                                    \Carbon\Carbon::parse($e->user[0]->pivot->start_date)
                                                &&
                                                \Carbon\Carbon::now() <
                                                    \Carbon\Carbon::parse($e->user[0]->pivot->end_date))
                                                <i class='fas fa-check'></i>
                                            @else
                                                <i class='far fa-times-circle'></i>
                                            @endif
                                        @endif
                                    </td>
                                    <td>
                                        @if( !empty($e->user[0]))
                                            <a href="{{route('admin_executive_edit', $e->user[0]->pivot->id)}}"
                                               title="Edit Executive Assignment for {{$e->user[0]->name}} ">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @else
                                            <i>not filled</i>
                                        @endif
                                    </td>
                                    <td>
                                        @if( !empty($e->user[0]))
                                            {{\Carbon\Carbon::parse($e->user[0]->pivot->start_date)->format('F j, Y')}}
                                        @endif
                                    </td>
                                    <td>
                                        @if( !empty($e->user[0]))
                                            {{\Carbon\Carbon::parse($e->user[0]->pivot->end_date)->format('F j, Y')}}
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7">No executive roles currently assigned.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        <div class="row mb-lg-5">
            <div class="col">
                <i class="far fa-trash-alt fa-2x"></i>
                <input class="btn btn-outline-danger" type="submit" value="Delete Selected">
            </div>
            <div class="col"></div>
        </div>
    </form>
    <h5>
        <i class="fas fa-info-circle"></i>
        Go to a <a href="{{route('users_list')}}">member profile page</a>
        to assign a new Executive role.
    </h5>
@endsection
