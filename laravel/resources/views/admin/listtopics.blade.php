@extends('layouts.dashboard')
@section('content')
<div class="container">
    <h1 class="display-3">List Topics</h1>
        <h3>
           <span class="badge badge-primary badge-pill">
               {!! $data['topics']->total()  !!}
           </span>
            Topics.
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
                    <th>#</th>
                    <th>Title</th>
                    <th>Scope</th>
                    <th>Is Live?</th>
                    <th>Sort Order</th>
                    <th>In Menu?</th>
                    <th>Allow Comments?</th>
                    <th>Edit</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                </tr>
                </thead>
                <tbody>
                @foreach ( $data['topics'] as $i )
                    <tr>
                        <td>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="id[]" value="{{$i->id}}" />
                                </label>
                            </div>
                        </td>
                        <td>
                            <h4>
                                <a title="{{$i->name}}" href="{{ route('topic_edit', $i->slug)}}">{{$i->name}}</a>
                            </h4>
                        </td>
                        <td>{{$i->scope}}</td>
                        <td>{{$i->live ? 'yes' : 'no' }}</td>
                        <td>{{$i->sort_order}}</td>
                        <td>{{$i->in_menu ? 'yes' : 'no'}}</td>
                        <td>{{$i->allow_comments ? 'yes' : 'no'}}</td>
                        <td><a href="{{route('topic_edit', $i->slug)}}" title="Edit {{$i->name}}"><i class="fas fa-edit"></i></span></a></td>
                        <td>{{$i->created_at}}</td>
                        <td>{{$i->updated_at}}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="10"> </td>
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
                    {!! $data['topics']->links() !!}
                </ul>
            </div>
        </div>
        <div class="col"></div>
    </div>
    <div class="row" style="margin-top:6em;"></div>
</form>

@endsection
