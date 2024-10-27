@extends('layouts.dashboard',  ['title_icon' => '<i class="fas fa-list"></i>', 'title' =>
    ' Temporary Imports'])
@section('content')
<div class="container">
        <h3>
           <span class="badge badge-primary badge-pill">
             {{$data->count()}}
               {{ Str::plural('User', $data->count()) }}
               In temp import invite list
           </span>
            | <a href="{{ route('invite-new-user') }}">
                Create new invitation to website
                <i class="far fa-arrow-alt-circle-right"></i>
            </a>
        </h3>
    <div class="col-12">
        <a href="{{route('process_import_invitation')}}">Process Import Invitation</a>
    </div>
</div>

        <div class="table-responsive">
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th> id</th>
                        <th>name</th>
                        <th> Email </th>

                        <th> Membership Type

                        </th>
                        <th> created_at </th>
                        <th> updated_at </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ( $data as $i )
                        <tr>
                            <td>
                                {{$i->id}}
                            </td>
                            <td>
                                {{ $i->name }}
                            </td>
                            <td>
                                <a href="mailto:{{$i->email}}">{{$i->email}}</a>
                            </td>
                            <td>
                                {{$i->membership_type}}
                            </td>
                            <td> {{ $i->created_at}} </td>
                            <td> {{ $i->updated_at}} </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6"> No invitations to the site presently.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>



    <div class="row mb-lg-5">


        <div class="col-6">
            <div class="list-group">
                <ul class="pagination">

                </ul>
            </div>
        </div>
        <div class="col"></div>
    </div>
</form>
@endsection
