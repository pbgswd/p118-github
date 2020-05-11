<?php
$policies = $data['data']['policies'];
?>
@extends('layouts.jumbo',  ['title' => '<i class="fas fa-scroll"></i> Policies'])
@section('content')
<div class="container border border-dark rounded-lg" style="background: rgba(220,220,220,0.8);">
    <div class="row">
        <h1>
            <i class="fas fa-scroll"></i> Local 118 Policies
        </h1>
        <h3 class="font-italic">Please remember, we have pledged to keep confidential the work of this body and to do all in our
            power to discourage and prevent violation of this requirement by brother and sister members.
        </h3>
        <h3>
           <span class="badge badge-primary badge-pill">
               {{ $data['data']['count'] }} Policy Documents
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
            @foreach ( $policies as $policy )
                <tr>
                    <td>
                        <h5>
                            <a title="{{ $policy->title }}" href="{{route('policy_show_public', $policy->id)}}"> {{ $policy->title }}</a>
                        </h5>
                    </td>

                    <td>
                        {{ $policy->date->format('F j Y') }}
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
                    {{$policies->links()}}
                </ul>
            </div>
        </div>
        <div class="col-3"></div>
    </div>
</div>
@endsection
