<?php
$meetings = $data['meetings'];
?>
@extends('layouts.jumbo',  ['title' => '<i class="fas fa-list"></i> List Members'])
@section('content')
<div class="container border border-dark rounded-lg" style="background: rgba(220,220,220,0.8); max-width:768px;">
<h1>Meetings & Minutes</h1>
    <h3>
       <span class="badge badge-primary badge-pill">
           {{ $data['count'] }} meetings & minutes
       </span>
    </h3>
</div>
<div class="table-responsive-md border border-dark rounded-lg" style="background: rgba(220,220,220,0.8); padding:1em;  max-width:768px; margin-left:auto; margin-right:auto;">
    <table class="table table-sm" style="margin-left:auto; margin-right:auto;">
        <thead>
        <tr>
            <th> @sortablelink('title', 'Title') </th>
            <th> @sortablelink('date', 'Date') </th>
        </tr>
        </thead>
        <tbody>
        @foreach ( $meetings as $a )
            <tr>
                <td>
                    <h5>
                        <a title="{{ $a->title }}" href="{{route('meeting', $a->id)}}"> {{ $a->title }}</a>
                    </h5>
                </td>
                <td> {{ $a->date->format('F j Y') }} </td>
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
                {{$meetings->links()}}
            </ul>
        </div>
    </div>
    <div class="col-3"></div>
</div>
<div class="row" style="margin-top:6em;"></div>
@endsection
