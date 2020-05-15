<?php
$executive = $data['executive'];
?>
@extends('layouts.dashboard',  ['title' => ' <i class="fas fa-edit"></i>' . $data["action"] . ' Executive role for user ' . ($data["action"] == 'Edit user with role of ' ? $executive->title : '') ])
@section('content')

<div class="container">
    <h3><a href="{{ route('admin_executives_list') }}">
            <i class="far fa-arrow-alt-circle-left"></i> List of executive roles
        </a>
    </h3>
    <form method="post" name="executive" action="{{ url()->current() }}" enctype="multipart/form-data" class="needs-validation" novalidate>
        {!! csrf_field() !!}
        <div class="row mt-lg-3">
            <h3>
                <a title="admin edit page for {{ $executive->user->name }}" href="{{ route('user_edit', $executive->user->id) }}">
                    {{$executive->user->name}}
                </a>
            </h3>
            <br />
            <p>xxxxxall exec roles have titles, but not all titles have emails.</p>
        </div>
        <div class="row">
            <div class="form-group">
                <div class="col-lg-2">
                    <h4>Title todo:menu</h4>
                </div>
                <div class="col-lg-10">
                    <input type="text" class="form-control"  placeholder="Title" name="executive[title]" value="{{ old('executive.title', $executive->title)}}" size="80" required/>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <div class="col-lg-2">
                    <h4>Email todo:menu</h4>
                </div>
                <div class="col-lg-10">
                    <input type="text" class="form-control"  placeholder="Email" name="executive[email]" value="{{ old('executive.email', $executive->email)}}" size="80" required/>
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
                    <input type="text" class="form-control"  placeholder="YYYY-MM-DD" name="executive[start_date]" value="{{ old('executive.start_date', $executive->start_date)}}" size="80" required/>
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
                    <input type="text" class="form-control"  placeholder="YYYY-MM-DD" name="executive[end_date]" value="{{ old('executive.end_date', $executive->end_date)}}" size="80" required/>
                </div>
            </div>
        </div>
        <div class="row">Todo: notify user?</div>

        @if ($data['action'] == 'Edit')
            <div class="row">
                <div class="form-group">
                    <div class="col-12 mt-2 mb-2">
                        <h4>
                            Current status: {{$executive->current}} <br />
                            {!! $executive->current ? "<i class='fas fa-check'></i> Current" : "<i class='far fa-times-circle'></i> Not current" !!}
                        </h4>
                    </div>
                </div>
            </div>
        @endif



        <div class="row mt-lg-3 mb-lg-5">
            <div class="col-sm">
                <i class="fas fa-edit fa-2x"></i>
                <input class="btn btn-outline-primary" type="submit" value="{{ $data['action'] }}" />
            </div>
    </form>
    <div class="col-sm"> &nbsp;</div>
    @if ($data['action'] == 'Edit')
         <div class="col-sm" style="float:right">
             <form name="delete" method="POST" action="{{route('admin_executive_destroy')}}">
                 {!! csrf_field() !!}
                 {!! method_field('DELETE') !!}
                <i class="far fa-trash-alt fa-2x"></i>
                <input type="hidden" name="id[]" value="{{ $executive->id }}">
                <input class="btn btn-outline-danger" type="submit" value="Delete Executive Member role">
            </form>
         </div>
    @endif
</div>
@endsection
