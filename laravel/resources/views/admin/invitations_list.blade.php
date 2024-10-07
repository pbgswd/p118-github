@extends('layouts.dashboard',  ['title_icon' => '<i class="fas fa-list"></i>',
    'title' => ' Pending Invitations to website'])
@section('content')
    <div class="container">
            <h3>
               <span class="badge badge-primary badge-pill">
                 {{$data['count']}}
                   {{ Str::plural('Invitation', $data['count']) }}
                   Pending
               </span>
                | <a href="{{ route('invite-new-user') }}">
                    Create new invitation to website
                    <i class="far fa-arrow-alt-circle-right"></i>
                </a>
            </h3>
        <h3 class="mt-5">
            <a href="{{route('list_import')}}">View Temporary Member Import Data</a> ||
            <a href="{{route('invite-resend-list')}}">Send invited members to users data table</a>
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
                                    <a href="mailto:{{$i->email}}">{{$i->email}}</a>
                                </td>
                                <td>
                                    {{$i->since}}
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
                                <td colspan="10"> No invitations to the site presently.</td>
                            </tr>
                        @endforelse
                        <tr>
                            <td colspan="10">&nbsp;</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="row">
                <div class="col p-3">
                    <p class="d-inline-flex gap-1">
                        <button class="btn btn-primary m-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                            Full comma separated list for bulk reminder messaging.
                        </button>
                    </p>
                    <div class="collapse" id="collapseExample">
                        <div class="card card-body">
                            @forelse($data['all'] as $i)
                                {{$i->email}},
                            @empty
                                No outstanding invitations at present.
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-lg-5">
            @if($data['invitations']->count() > 0)
                <div class="col">
                    <i class="far fa-trash-alt fa-2x"></i>
                    <input class="btn btn-outline-danger" type="submit" value="Delete Selected">
                </div>
            @endif
            <div class="col">
                <div class="list-group">
                    <ul class="pagination">
                         {{$data['invitations']->links() }}
                    </ul>
                </div>
            </div>
        </div>
    </form>
@endsection
