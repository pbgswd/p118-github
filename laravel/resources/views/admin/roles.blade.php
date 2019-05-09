@extends('layouts.dashboard',  ['title' => '<i class="fab fa-redhat"></i> Roles'])
@section('content')
<div class="container">
<h1>Roles</h1>

    <div class="row" style="margin-top:30px;"> &nbsp;</div>

    <div class="row">
        @foreach( $data['roles'] as $i )
            <div class="col-md-4 border border-dark rounded-lg mt-3 mr-3">
                <h2>{{ $i->name }}</h2>
                <p>{{ $i->guard_name}} </p>
                <p>
                    <a class="btn btn-secondary" href="role/{{ $i->id }}" role="button">View details &raquo;</a></p>
            </div> &nbsp;
        @endforeach
    </div>
</div>
@endsection
