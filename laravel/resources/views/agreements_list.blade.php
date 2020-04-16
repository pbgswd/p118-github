<?php
$agreements = $data['data']['agreements'];
?>
@extends('layouts.jumbo',  ['title' => '<i class="fas fa-list"></i> Agreement Postings'])
@section('content')
<div class="container border border-dark rounded-lg" style="background: rgba(220,220,220,0.6);">
<h1><i class="far fa-handshake"></i> Collective Agreements </h1>
    <h3>
       <span class="badge badge-primary badge-pill">
           {{ $data['data']['count'] }} agreement postings
       </span>
    </h3>
<div class="table-responsive-md border border-dark rounded-lg p-1" style="background: rgba(220,220,220,0.6); margin-left:auto; margin-right:auto;">
    <table class="table table-sm" style="margin-left:auto; margin-right:auto;">
        <thead>
        <tr>
            <th> @sortablelink('title', 'Title') </th>
            <th> @sortablelink('from', 'From') </th>
            <th> @sortablelink('until', 'Until') </th>
        </tr>
        </thead>
        <tbody>
        @foreach ($agreements as $agreement)
            <tr>
                <td>
                    <h5>
                        <a title="{{ $agreement->title }}" href="{{route('agreement_show', $agreement->id)}}"> {{ $agreement->title }}</a>
                    </h5>
                </td>
                <td>
                    {{ $agreement->from->format('F j Y') }}
                </td>
                <td>
                    {{ $agreement->until->format('F j Y') }}
                </td>
            </tr>
        @endforeach
        <tr>
            <td colspan="3">&nbsp;</td>
        </tr>
        </tbody>
    </table>
</div>
</div>
<div class="row mt-2 mb-lg-5">
    <div class="col-5"></div>
    <div class="col-3">
        <div class="list-group">
            <ul class="pagination">
                {{$agreements->links()}}
            </ul>
        </div>
    </div>
    <div class="col-3"></div>
</div>
@endsection
