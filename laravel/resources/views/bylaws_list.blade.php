<?php
$bylaws = $data['data']['bylaws'];
?>
@extends('layouts.jumbo',  ['title' => '<i class="fas fa-list"></i> bylaw Postings'])
@section('content')
<div class="container border border-dark rounded-lg" style="background: rgba(220,220,220,0.8);">
    <div class="row">
        <h1>
            <i class="fas fa-gavel"></i> Local 118 Constitution and By-Laws
        </h1>
        <h3 class="font-italic">Please remember, we have pledged to keep confidential the work of this body and to do all in our
            power to discourage and prevent violation of this requirement by brother and sister members.
        </h3>
        <h3>
           <span class="badge badge-primary badge-pill">
               {{ $data['data']['count'] }} Bylaw Documents
           </span>
        </h3>
    </div>
    <div class="table-responsive-md border border-dark rounded-lg p-1" style="background: rgba(220,220,220,0.8); margin-left:auto; margin-right:auto;">
        <table class="table table-sm" style="margin-left:auto; margin-right:auto;">
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
                        {{ $bylaw->date->format('F j Y') }}
                    </td>
                </tr>
            @endforeach
            <tr>
                <td colspan="3">&nbsp;</td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="row mt-lg-2 mb-lg-3">
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
</div>
@endsection
