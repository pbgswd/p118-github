<?php
$meetings = $data['meetings'];
?>
@extends('layouts.jumbo',  ['title' => '<i class="fas fa-list"></i> List Members'])
@section('content')
<div class="container border border-dark rounded-lg" style="background: rgba(220,220,220,0.6); max-width:768px;">
<h1 class="display-3"></h1>
    <h3>
       <span class="badge badge-primary badge-pill">
           {!! count($data['meetings'])  !!} meetings
       </span>

    </h3>
</div>
<div class="table-responsive-md border border-dark rounded-lg" style="background: rgba(220,220,220,0.6); padding:1em;  max-width:768px; margin-left:auto; margin-right:auto;">
    <table class="table table-dark table-sm" style="margin-left:auto; margin-right:auto;">
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
                    <h4>
                        <a title="{{ $a->title }}" href="#">{{ $a->title }}</a>
                    </h4>
                </td>
                <td> {{ $a->date->format('F j Y H:i:s') }} </td>
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
                meeting->links()
            </ul>
        </div>
    </div>
    <div class="col-3"></div>
</div>
<div class="row" style="margin-top:6em;"></div>
@endsection
