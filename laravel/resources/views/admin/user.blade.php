<?php
$user = $data['user'];
?>
@extends('layouts.dashboard',  ['title' => ' <i class="fas fa-edit"></i>' . $data["action"] . ' Member ' . ($data["action"] == "Edit" ? $user->name : '') ])
@section('content')
    <script>
        tinymce.init({
            selector: 'textarea#user-description',
            height: 200,
            width:800,
            menubar: false,
            plugins: [
                'advlist autolink lists link image charmap print preview anchor textcolor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table paste code help wordcount'
            ],
            toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
            content_css: [
                '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
                '//www.tiny.cloud/css/codepen.min.css'
            ]
        });
    </script>

<div class="container">

    <h3>  <a href="{{ route('users_list') }}"> <i class="far fa-arrow-alt-circle-left"></i> List of members</a>  </h3>


    <form method="post" name="user" action="{{ url()->current() }}" enctype="multipart/form-data" class="needs-validation" novalidate>
        <input type="hidden" name="user[id]" value="{{ $user['id'] }}">
        {!! csrf_field() !!}
        <div class="row" style="margin-top:30px;"> &nbsp;</div>
        <div class="row">
            <div class="form-group">
                <div class="col-lg-2"><h4>Name</h4></div>
                <div class="col-lg-10">
                    <input type="text" class="form-control"  placeholder="Name" name="user[name]" value="{{ old('user.name', $user->name)}}" size="80" required/>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <div class="col-lg-2"><h4>Email</h4></div>
                <div class="col-lg-10">
                    <input type="text" class="form-control"  placeholder="Email" name="user[email]" value="{{ old('user.email', $user->email)}}" size="80" required/>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="form-group">
                <div class="col-lg-2"><h4>Phone</h4></div>
                <div class="col-lg-10">
                    <input type="text" class="form-control"  placeholder="Phone" name="user[phone]" value="{{ old('user.phone', $user->phone)}}" size="80" required/>
                </div>
            </div>
        </div>
        <div class="row">
            <ol>
                <li>head shot</li>
                <li>address</li>
                <li>member status</li>
                <li>since when</li>
                <li>policies on sharing phone </li>
                <li>policies on sharing email address</li>
                <li>dues status</li>
            </ol>
        </div>


        <div class="row" style="margin-top:30px;"> &nbsp;</div>
        <div class="row">
            <div class="col-sm">
                <i class="fas fa-edit fa-2x"></i>
                <input class="btn btn-outline-primary" type="submit" value="{{ $data['action'] }}" />
            </div>
    </form>

         <div class="col-sm"> &nbsp;</div>
    @if ($data['action'] == 'Edit')
         <div class="col-sm" style="float:right">
             <form name="delete" method="POST" action="{{route('user_destroy')}}">
                 {!! csrf_field() !!}
                 {!! method_field('DELETE') !!}
                <i class="far fa-trash-alt fa-2x"></i>
                <input type="hidden" name="id[]" value="{{ $user->id }}">
                <input class="btn btn-outline-danger" type="submit" value="Delete">
            </form>
         </div>
    @endif
    <div class="row" style="margin-top:100px;"> &nbsp;</div>
</div>
@endsection
