@extends('layouts.dashboard',  ['title' => '<i class="fas fa-list"></i> List Members'])
@section('content')
    <div class="row my-4">
        <div class="col-6">
            <h2>
                <span class="badge rounded-pill text-bg-info">
                   {!! $data['counts']['membership'] ?? 0 !!}
                </span>
                Members.
            </h2>
            <h2>
                <span class="badge rounded-pill text-bg-info">
                   {!! $data['counts']['invite'] !!}
                </span>
                Members with pending website invitations.
            </h2>
        </div>
        <div class="col-6">
            <h2>
                <span class="badge rounded-pill text-bg-info">
                   {!! $data['counts']['office'] !!}
                </span>
                Office Staff.
            </h2>
            <h2>
            <a href="{{ route('invite-new-user') }}">Invite new member
                <i class="far fa-arrow-alt-circle-right"></i>
            </a>
            </h2>
        </div>
    </div>
    <div class="row">
        <form name="delete" method="POST" action="{{route('user_destroy')}}">
            {!! csrf_field() !!}
            {!! method_field('DELETE') !!}
            <div class="form-group">
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th> @sortablelink('id','#') </th>
                                <th> @sortablelink('name', 'Name') </th>
                                <th> @sortablelink('email', 'Email') </th>
                                <th> Membership Type </th>
                                <th> Website Role </th>
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
                                        <a title="public profile for {{ $i->name }}" target="_blank"
                                           href="{{ route('member', $i->id) }}">
                                            <i class="far fa-user-circle"></i>
                                        </a>
                                        <a title="admin edit page for {{ $i->name }}" href="{{ route('user_edit', $i->id) }}">
                                            {{ $i->name }}
                                        </a>
                                        @if($i->is_banned == 1)
                                            <span class="text-danger">Suspended</span>
                                        @endif
                                    </h4>
                                    @if(count($i->currentExecutiveRoles) > 0)
                                        @foreach($i->currentExecutiveRoles as $a)
                                            {{$a->title}} From:
                                            {{\Carbon\Carbon::parse($a->pivot->start_date)->format('F j Y')}}
                                            Until:  {{\Carbon\Carbon::parse($a->pivot->end_date)->format('F j Y')}}
                                            <br />
                                        @endforeach
                                    @endif
                                </td>
                                <td>
                                    <a href="mailto:{{ $i->email }}">{{ $i->email }}</a>
                                </td>
                                <td>
                                     {{ $i->membership['membership_type'] ?? '- -'}}
                                </td>
                                <td>
                                    @foreach ($i->roles as $role)
                                        <i>{{ $role['name'] }}</i>
                                    @endforeach
                                </td>
                                <td>
                                    <a href="{{ route('user_edit', $i->id) }}" title="Edit {{ $i->name }} ">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                                <td> {{ $i->created_at->format('F j Y H:i:s') }} </td>
                                <td> {{ $i->updated_at->format('F j Y H:i:s') }} </td>
                            </tr>
                        @endforeach
                            <tr>
                                <td colspan="8">&nbsp;</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            @if($data['users']->total() > 0)
                <div class="row mb-lg-5">
                    <div class="col">
                        <i class="far fa-trash-alt fa-2x p-3"></i>
                        <input class="btn btn-outline-danger" type="submit" value="Delete Selected">
                    </div>
                </div>
                <div class="row">
                    <div class="list-group">
                        <ul class="pagination justify-content-center">
                            {!! $data['users']->links() !!}
                        </ul>
                    </div>
                </div>
            @endif
        </form>
    </div>
</div>
@endsection
