@extends('layouts.dashboard',  ['title' => '<i class="fas fa-list"></i> Pending Invitations to website'])
@section('content')
<div class="container">
        <h3>
           <span class="badge badge-primary badge-pill">
             {{$data['invitations']->count()}}
               {{ Str::plural('Invitation', $data['invitations']->count()) }}
               Pending
           </span>
            | <a href="{{ route('invite-new-user') }}">
                Create new invitation to website
                <i class="far fa-arrow-alt-circle-right"></i>
            </a>
        </h3>
</div>
<form name="delete" method="POST" action="{{route('invited_user_destroy')}}">
    {!! csrf_field() !!}
    {!! method_field('DELETE') !!}
    <div class="form-group">
        <div class="table-responsive">
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th> @sortablelink('id','#') </th>
                        <th> @sortablelink('name', 'Name') </th>
                        <th> Email </th>
                        <th>Invited since</th>
                        <th>
                            Membership Type<br />
                            (Member or Office)
                        </th>
                        <th> Website Access <br />
                            Role
                        </th>
                        <th> Message Link</th>
                        <th> Added by </th>
                        <th> @sortablelink('created_at', 'Created At') </th>
                        <th> @sortablelink('updated_at', 'Updated At') </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ( $data['invitations'] as $i )
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
                                    {{ $i->name }}
                                </h4>
                            </td>
                            <td>
                                <a href="{{$i->email}}">{{$i->email}}</a>
                            </td>
                            <td>
                                @if($i->remaining < 0)
                                    expired
                                @else
                                    {{$i->since}} <br />
                                    ({{$i->remaining}} h left)
                                @endif
                            </td>
                            <td>
                                {{$i->membership_type}}
                            </td>
                            <td>
                                {{$i->role}}
                            </td>
                           <td>
                               <a href="{{route('invite_user_signup',
                                    ['inviteUser' => $i->id, 'password' => $i->password])}}" target="_blank">
                                   <i class="fas fa-envelope-open-text"></i>
                               </a>
                            </td>
                            <td>
                                {{$i->user->name}}
                            </td>
                            <td> {{ $i->created_at->format('F j Y H:i:s') }} </td>
                            <td> {{ $i->updated_at->format('F j Y H:i:s') }} </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8"> No invitations to the site presently.</td>
                        </tr>
                    @endforelse
                    <tr>
                        <td colspan="8">&nbsp;</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row mb-lg-5">
        @if($data['invitations']->count() > 0)
            <div class="col">
                <i class="far fa-trash-alt fa-2x"></i>
                <input class="btn btn-outline-danger" type="submit" value="Delete Selected">
            </div>
        @endif

        <div class="col-6">
            <div class="list-group">
                <ul class="pagination">
                     {{$data['invitations']->links() }}
                </ul>
            </div>
        </div>
        <div class="col"></div>
    </div>
</form>
@endsection
