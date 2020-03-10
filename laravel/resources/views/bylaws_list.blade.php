<?php
$bylaws = $data['data']['bylaws'];
?>
@extends('layouts.jumbo',  ['title' => '<i class="fas fa-list"></i> bylaw Postings'])
@section('content')
<div class="container border border-dark rounded-lg" style="background: rgba(220,220,220,0.6); max-width:768px;">
<h1 class="display-3"><i class="far fa-handshake"></i> Constitution & By-laws </h1>
    <h3>
       <span class="badge badge-primary badge-pill">
           {{ $data['data']['count'] }} bylaw postings
       </span>
    </h3>
    <div class="row">
        <div class="col-12">

        </div>
    </div>
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
        @foreach ( $bylaws as $bylaw )
            <tr>
                <td>
                    <h5>
                        <a title="{{ $bylaw->title }}" href="{{route('bylaw_show', $bylaw->id)}}"> {{ $bylaw->title }}</a>
                    </h5>
                </td>

                <td>
                    {{ $bylaw->date->format('M j Y') }}
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
                {{$bylaws->links()}}
            </ul>
        </div>
    </div>
    <div class="col-3"></div>
</div>
<div class="row" style="margin-top:6em;"></div>
@endsection
