@extends('layouts.dashboard',  ['title' => '<i class="fas fa-list"></i> Bulk add users to ' . $data['committee']->name ])
@section('content')
<div class="container">
    <h3>
       <span class="badge badge-primary badge-pill">
           {!! count($data['users']) !!}
       </span>
        Members. <a href="{{route('committee_show', $data['committee']['slug'])}}">Return to {{$data['committee']['name']}} page</a>
    </h3>
    <form method="post" name="committee-bulk-add" action="{{ url()->current() }}" enctype="multipart/form-data" class="needs-validation" novalidate>
        {!! csrf_field() !!}
        <div class="form-group">
            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th> @sortablelink('id','#') </th>
                            <th> @sortablelink('name', 'Name') </th>
                            <th> @sortablelink('email', 'Email') </th>
                            <th> Role </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ( $data['users'] as $i )
                            <tr>
                                <td>
                                    @if($i['isMember'] != 'true')
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="members[{{ $i['id'] }}][id]" value="{{ $i['id'] }}" />
                                            </label>
                                        </div>
                                    @else
                                        <i class="fas fa-user-check"></i>
                                    @endif
                                </td>
                                <td>
                                    <h4>
                                        <a title="{{ $i['name'] }}" href="{{ route('user_edit', $i['id']) }}">{{ $i['name'] }}</a>
                                        @if($i['isMember'] == 'true')
                                            is already a member
                                        @endif
                                    </h4>
                                </td>
                                <td> {{ $i['email'] }} </td>
                                <td>
                                    <div class="form-group">
                                        {{ select_options($data['committee_levels'], old('member.role', 'member'), ['name' => 'members['. $i['id'] .'][role]', 'class' => 'form-control', 'placeholder' => 'Role'], $selected = 'Member') }}
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="4">&nbsp;</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        @if(count($data['users']) > 0)
        <div class="row">
            <div class="col">
                <i class="far fa-trash-alt fa-2x"></i>
                <input class="btn btn-outline-success" type="submit" value="Add Selected">
            </div>
            <div class="col-6">
                <div class="list-group">
                    <ul class="pagination">
                        {!! $users->links() !!}
                    </ul>
                </div>
            </div>
            <div class="col"></div>
        </div>
        @endif
        <div class="row" style="margin-top:6em;"></div>
    </form>
</div>
@endsection
