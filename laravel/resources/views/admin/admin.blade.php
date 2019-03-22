@extends('layouts.dashboard')
@section('content')
<div class="container">
    <h1 class="display-3">Dashboard Content</h1>
        <p>
            Page for admin level management of content, privileges for executive, editors, webmin.
        </p>
    </div>
    @include('admin.canvas')
    @include('admin.table')
@endsection
