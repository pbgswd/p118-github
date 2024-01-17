@extends('layouts.dashboard',  ['title' => '<i class="fab fa-redhat"></i> Roles'])
@section('content')
<div class="container">
    <div class="row">
        @foreach( $data['roles'] as $i )
            <div class="col-md-4 border border-dark rounded mt-3 mr-3">
                <h2>Role: {{ $i->name }}</h2>
                <p>Guard: {{ $i->guard_name}} </p>
                <p>Permissions: </p>
                <ul class="list-group">
                    @foreach ($i->permissions as $p)
                       <li class="list-group-item">
                           {{ $p->name }}
                       </li>
                    @endforeach
                </ul>
            </div>
        @endforeach
    </div>
</div>
@endsection
