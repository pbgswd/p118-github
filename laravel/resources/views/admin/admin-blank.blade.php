@extends('layouts.dashboard')
@section('content')

<div id="app">App Div </div>
@can('edit articles')
    can edit articles
@endcan
    <div class='container m-lg-5'>
        container 1
        <input
            type='text'
            name="date"
            class="form-control"
            id="pdate"
            data-provide="datepicker"
            data-date-format="yyyy-mm-dd"
            data-date-startDate="-3d"
            style='width: 300px;'
            value=""
        >
    </div>

<div class="container">
    container 2
    <div class="row">
        <div class='col-sm-6'>
            <div class="form-group">
                <div class='row'>
                    <input
                        class="datepicker"
                        data-provide="datepicker"
                        data-date-format="yyyy-mm-dd"
                    >
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    container 3
    <div class="row border border-primary">
        <div class='col-12'>
x

        </div>
    </div>
</div>
@endsection
