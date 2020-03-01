<?php
$invite = $data['invite'];
$roles = $data['roles'];
//dd($invite->role);
?>
@extends('layouts.dashboard')
@section('content')
<div class='container mt-lg-4'>
    <h1>Invite User</h1>

    <div class="col-12">
<pre>
    - name
- email
        submission validation
        message to person with id, hash passwd
        - time limit
        - acceptance process
        - delete after accepted and processed
        - msg to office that user has updated
        - form for person who doesnt have access but wants it. process for verification
        - role
</pre>
    </div>
        <form method="post" name="invite_user" action="{{ url()->current() }}" enctype="multipart/form-data" class="needs-validation" novalidate>
        {!! csrf_field() !!}

            <div class="col-12 input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-default">Name</span>
                    <input type="text" class="form-control"  placeholder="Name" name="invite[name]" value="{{ old('invite.name', $invite->name ?? '')}}" size="80" required />
                </div>
            </div>
            <div class="col-12 input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-default">Email</span>
                    <input type="text" class="form-control"  placeholder="Email" name="invite[email]" value="{{ old('invite.email', $invite->email ?? '')}}" size="80" required/>
                </div>
            </div>
            <div class="row">
                <div class="col-12 border border-primary rounded-lg border-3 mt-lg-2 p-2">
                    <h4>User website roles </h4>
                    @foreach ($roles as $role)
                        <div class="input-group mb-6 col-12">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <input name="user_role" type="radio" value="{{$role->name}}" {{ checked(array_key_exists($role->name, $invite->role)) }} />
                                </div>
                            </div>
                            <input type="text" class="form-control" aria-label="Text input with checkbox" value="{{$role->name}} ( @foreach ($role->permissions as $p){{ $p->name }},  @endforeach)" size="40" readonly />
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="row">
                <div class="col-sm">
                    <i class="fas fa-edit fa-2x"></i>
                    <input class="btn btn-outline-primary" type="submit" value="{{ $data['action'] }}" />
                </div>
        </form>
    <div class="col-sm"> &nbsp;</div>
    @if ($data['action'] == 'Edit')
        @hasanyrole('super-admin|admin')
        <div class="col-sm" style="float:right">
            <form name="delete" method="POST" action="{{route('user_destroy')}}">
                {!! csrf_field() !!}
                {!! method_field('DELETE') !!}
                <i class="far fa-trash-alt fa-2x"></i>
                <input type="hidden" name="id[]" value="{{ $user->id }}">
                <input class="btn btn-outline-danger" type="submit" value="Delete">
            </form>
        </div>
        @endhasanyrole
    @endif
    <div class="row mt-lg-5"> &nbsp;</div>


</div>
<div class="row mt-lg-3"> &nbsp;</div>
@endsection
