<?php
$bylaws = $data['data']['bylaws'];
?>
@extends('layouts.jumbo',  ['title' => '<i class="fas fa-list"></i> bylaw Postings'])
@section('content')
<div class="container border border-dark rounded-lg mt-3 mb-3" style="background: rgba(220,220,220,0.8);">
    <div class="row p-2">
        <div class="col-12 col-md-6">
            <h2>
                <i class="fas fa-gavel"></i>
                Constitution and By-Laws
            </h2>
        </div>
        <div class="col-12 col-md-6 text-md-right">
        <h3>
           <span class="badge badge-primary badge-pill">
               {{ $data['data']['count'] }}
               Bylaw
               {{ Str::plural('Document', $data['data']['count']) }}
           </span>
        </h3>
        </div>
        <div class="col-12">
            <h5 class="font-italic">Please remember, we have pledged to keep
                confidential the work of this body and
                to do all in our power to discourage and
                prevent violation of this requirement
                by brother and sister members.
            </h5>
        </div>
    </div>
    <div class="table-responsive  border border-dark rounded-lg mb-4">
        <table class="table p-1" style="background: rgba(220,220,220,0.8);">
            <thead>
                <tr>
                    <th> @sortablelink('title', 'Title') </th>
                    <th> @sortablelink('date', 'Date') </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($bylaws as $bylaw)
                    <tr>
                        <td>
                            <p>
                                <a title="{{ $bylaw->title }}" href="{{route('bylaw_show', $bylaw->id)}}">
                                    {{ $bylaw->title }}
                                </a>
                            </p>
                        </td>
                        <td>
                            {{$bylaw->date->format('F j Y')}}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-center">
        <div class="list-group">
            <ul class="pagination">
                {{$bylaws->links()}}
            </ul>
        </div>
    </div>
</div>
@endsection
