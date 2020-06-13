<?php
$user = $data['user'];
$assigned_role = $data['assigned_role'];
$roles = $data['roles'];
?>
@extends('layouts.dashboard',  ['title' => ' <i class="fas fa-edit"></i>'
                                . $data["action"] . ' Executive role for user '
                                . ($data["action"] == 'Edit user with role of ' ? 'xx' : '')
                                ])
@section('content')
<div class="container">
    <form method="post" name="executive" action="{{ url()->current() }}"
          enctype="multipart/form-data" class="needs-validation" novalidate>
        {!! csrf_field() !!}
    <div class="row mt-lg-3">
        <div class="col-4  text-left">
            <h3>
                <a title="admin edit page for {{ $user->name }}"
                   href="{{ route('user_edit', $user->id) }}">
                    {{$user->name}}
                </a>
            </h3>
        </div>
        @if($data['action'] == 'Edit')
            <p class="col-4 text-right">
                <h5>
                    <a href="{{route('admin_executive_create', $user->id)}}">
                        Create new Executive Role <i class="far fa-arrow-alt-circle-right"></i>
                    </a>
                </h5>
            </p>
        @endif
    </div>
    <div class="row">
        <div class="form-group">
            <div class="col-12">
                <label for="exampleFormControlSelect1">
                    <h4>Title & email</h4>
                </label>
                <select class="form-control" id="exampleFormControlSelect1" name="executive_id">
                    @if($data['action'] == 'Create')
                        <option value="">Select</option>
                    @endif
                     @foreach($roles as $r)
                        <option value="{{$r->id}}"
                                @if( $data['action'] == 'Edit')
                                    @if ($assigned_role->executive_id == $r->id )
                                        selected
                                    @endif
                                @endif
                                    > {{$r->title}} | {{$r->email}}
                        </option>
                     @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="form-group">
            <div class="col-lg-8">
                <h4>
                    <i class="fas fa-calendar-alt"></i>
                    Start date of Term
                </h4>
            </div>
            <div class="col-lg-10">
                <input type="text" class="form-control"  placeholder="YYYY-MM-DD" name="start_date"
                       value="@if( $data['action'] == 'Edit')
{{$assigned_role->start_date->format('Y-m-d')}}
                           @else
{{ \Carbon\Carbon::now()->format('Y-m-d') }}
                           @endif
" size="40" required/>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="form-group">
            <div class="col-lg-8">
                <h4>
                    <i class="fas fa-calendar-alt"></i>
                    End date of Term
                </h4>
            </div>
            <div class="col-lg-10">
                <input type="text" class="form-control"  placeholder="YYYY-MM-DD" name="end_date"
                       value="@if( $data['action'] == 'Edit')
{{$assigned_role->end_date->format('Y-m-d')}}
                       @else
{{ \Carbon\Carbon::now()->add('1 year')->format('Y-m-d') }}
                       @endif
" size="40" required/>
            </div>
        </div>
    </div>
    <div class="row">Todo: notify user?</div>
    <div class="row mt-lg-3 mb-lg-5">
        <div class="col-sm">
            <i class="fas fa-edit fa-2x"></i>
            <input class="btn btn-outline-primary" type="submit" value="{{ $data['action'] }}" />
        </div>
    </form>
        <div class="col-sm"> &nbsp;</div>
        @if ($data['action'] == 'Edit')
             <div class="col-sm" style="float:right">
                 <form name="delete" method="POST" action="{{route('admin_executive_destroy', $assigned_role->id)}}">
                     {!! csrf_field() !!}
                     {!! method_field('DELETE') !!}
                    <i class="far fa-trash-alt fa-2x"></i>
                    <input class="btn btn-outline-danger" type="submit" value="Delete Executive Member role">
                </form>
             </div>
        @endif
    </div>
</div>
@endsection
