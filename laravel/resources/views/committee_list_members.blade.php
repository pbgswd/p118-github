<?php
$committee = $data['committee'];
?>
@extends('layouts.jumbo',  ['title' => '<i class="fas fa-list"></i> List Members'])
@section('content')
<div class="container border border-dark rounded" style="background: rgba(220,220,220,0.8); max-width:768px;">
<h1 class="display-3"></h1>
    <h3>
       <span class="badge badge-primary badge-pill">
           {!! $committee->active_committee_members->count()  !!}
       </span>
        Members in <a href="{{route('committee', $committee->slug)}}" title="Return to {{$committee->name}}">{{$committee->name}}</a>
    </h3>
</div>
<div class="table-responsive-md border border-dark rounded p-1" style="background: rgba(220,220,220,0.8); max-width:768px; margin-left:auto; margin-right:auto;">
    <table class="table table-sm ml-auto mr-auto">
        <thead>
            <tr>
                <th> @sortablelink('name', 'Name') </th>
                <th> Role </th>
                <th> @sortablelink('email', 'Email') </th>
                <th> @sortablelink('created_at', 'Joined') </th>
            </tr>
        </thead>
        <tbody>
        @foreach ( $committee->active_committee_members as $c )
            <tr>
                <td>
                    <h4>
                        <a title="{{ $c->name }}" href="{{ route('member', $c->id) }}">
                            {{ $c->name }}
                        </a>
                    </h4>
                </td>
                <td>
                    {{$c->pivot->role}}
                </td>
                <td>
                    <a href="mailto:{{ $c->email }}">{{ $c->email }}</a>
                </td>
                <td>
                    {{ $c->created_at->format('F j Y H:i:s') }}
                </td>
            </tr>
        @endforeach
            <tr>
                <td colspan="3">&nbsp;</td>
            </tr>
        </tbody>
    </table>
</div>
<div class="row mt-lg-2 mb-lg-5">
    <div class="col-5"></div>
    <div class="col-3">
        <div class="list-group">
            <ul class="pagination">

            </ul>
        </div>
    </div>
    <div class="col-3"></div>
</div>
@endsection
