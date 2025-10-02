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
                                <th> id</th>
                                <th>Name</th>
                                <th>Title</th>
                                <th> Edit </th>
                                <th> Start of Term </th>
                                <th> End of Term </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data['users'] as $e )
                                <tr>
                                    <td>
                                        @if( !empty($e->id))
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="id[]"
                                                           value="{{$e->id }}" />
                                                </label>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        @if(!empty($e->name))
                                            <a href="{{route('user_edit', $e->id)}}">
                                                {{$e->name}}
                                            </a>
                                        @else
                                            <i>not filled</i>
                                        @endif
                                    </td>
                                    <td>
                                        {{$e->user_exec_role[0]->title}}
                                    </td>
                                    <td>
                                            <a href="{{route('admin_executive_edit', $e->user_exec_role[0]->pivot->id)}}"
                                               title="Edit Executive Assignment for {{$e->name}} ">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                    </td>
                                    <td>
                                        {{\Carbon\Carbon::parse($e->user_exec_role[0]->pivot->start_date)->format('F j, Y')}}
                                    </td>
                                    <td>
                                        {{\Carbon\Carbon::parse($e->user_exec_role[0]->pivot->end_date)->format('F j, Y')}}
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
        </div>
    </form>
    <h5>
        <i class="fas fa-info-circle"></i>
        Go to a <a href="{{route('users_list')}}">member profile page</a>
        to assign a new Executive role.
    </h5>
@endsection
