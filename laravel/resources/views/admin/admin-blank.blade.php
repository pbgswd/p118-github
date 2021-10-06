@extends('layouts.dashboard')
@section('content')

<div id="app">App Div </div>
@can('edit articles')
    can edit articles
@endcan


        <input type="date" id="pick-date" name="date" />




<div class="container mt-5">
    container 3
    <div class="row border border-primary">
        <div class='col-12'>
x

        </div>
    </div>
</div>
@endsection
