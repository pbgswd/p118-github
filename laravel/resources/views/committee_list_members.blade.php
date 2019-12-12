<?php
$committee = $data['committee'];
?>
@extends('layouts.jumbo',  ['title' => '<i class="fas fa-list"></i> List Members'])
@section('content')
<div class="container border border-dark rounded-lg" style="background: rgba(220,220,220,0.6); max-width:768px;">
<h1 class="display-3"></h1>
    <h3>
       <span class="badge badge-primary badge-pill">
           {!! count($committee->committee_members)  !!}
       </span>
        Members in <a href="{{route('committee', $committee->slug)}}" title="Return to {{$committee->name}}">{{$committee->name}}</a>
    </h3>
</div>
<div class="table-responsive-md border border-dark rounded-lg" style="background: rgba(220,220,220,0.6); padding:1em;  max-width:768px; margin-left:auto; margin-right:auto;">
    <table class="table table-dark table-sm" style="margin-left:auto; margin-right:auto;">
        <thead>
            <tr>
                <th> @sortablelink('name', 'Name') </th>
                <th> @sortablelink('email', 'Email') </th>
                <th> @sortablelink('created_at', 'Joined') </th>
            </tr>
        </thead>
        <tbody>
        @foreach ( $committee->committee_members as $c )
            <tr>
                <td>
                    <h4>
                        <a title="{{ $c->name }}" href="{{ route('member', $c->id) }}">
                            {{ $c->name }}
                        </a>
                    </h4>
                </td>
                <td>
                    <a href="mailto:{{ $c->email }}">{{ $c->email }}</a>
                </td>
                <td>
                    {{ $c->created_at }}
                </td>
            </tr>
        @endforeach
            <tr>
                <td colspan="3">&nbsp;</td>
            </tr>
        </tbody>
    </table>
</div>
<div class="row" style="margin-top:2em;">
    <div class="col-5"></div>
    <div class="col-3">
        <div class="list-group">
            <ul class="pagination">
                committee->links()
            </ul>
        </div>
    </div>
    <div class="col-3"></div>
</div>
<div class="row" style="margin-top:6em;"></div>
@endsection
