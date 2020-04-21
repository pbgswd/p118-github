<?php
$employment = $data['employment'];
?>
@extends('layouts.jumbo',  ['title' => '<i class="fas fa-list"></i> Employment Postings'])
@section('content')
<div class="container border border-dark rounded-lg" style="background: rgba(220,220,220,0.6);">
    <div class="row">
        <h1>
            <span class="badge badge-primary badge-pill">{{ $data['count'] }}</span>
            Employment Postings
        </h1>
    </div>
    <div class="row">
        <div class="col-6">
            <a target="_blank" href="http://www.citt.org/cgi/page.cgi/citt_news.html/Job_Board" title=""CITT Website Job Postings">
            <i class="fas fa-external-link-alt"></i> Visit the CITT website to view a large selection of job postings both locally and across Canada</a>
        </div>
        <div class="col-6">
            <p><i class="fas fa-route"></i> Members interested in work in the Okanagan may contact the Okanagan Dispatcher
                Gord Osland: <br />
                <i class="fas fa-phone-square"></i> <a href="tel:250-809-0741">250-809-0741</a> <br />
                <i class="fas fa-envelope"></i> <a href="mailto:ogord@hotmail.com?Subject=work in Okanagan"> ogord@hotmail.com</a></p>
        </div>
            <div class="col-6">
            <p>
                <a href="{{route('job_view', 14)}}" title="Dispatch" target="_blank"> <i class="far fa-file-pdf fa-2x"></i> ONGOING: IATSE Local 118 Dispatcher Job Posting</a></p>
            </div>
        <div class="col-6">
            <p>
                <a href="/storage/public/YE1ppyxJzBmr52SkgxpbS146lGSeyYmZDzoNwYEh.pdf" title="Working in the U.S.A." target="_blank">
                    <i class="far fa-file-pdf fa-2x"></i>
                    <i class="fas fa-flag-usa fa-2x"></i>
                    Working in the U.S.A.</a>
            </p>
        </div>
    </div>

<div class="table-responsive-md border border-dark rounded-lg p-1" style="background: rgba(220,220,220,0.6); padding:1em; margin-left:auto; margin-right:auto;">
    <table class="table table-sm" style="margin-left:auto; margin-right:auto;">
        <thead>
        <tr>
            <th> @sortablelink('title', 'Title') </th>
            <th>Open/<br />
                Closed</th>
            <th> @sortablelink('deadline', 'Deadline') </th>
        </tr>
        </thead>
        <tbody>
        @foreach ( $employment as $e )
            <tr>
                <td>
                    <h5>
                        <a title="{{ $e->title }}" href="{{route('job_view', $e->id)}}"> {{ $e->title }}</a>
                    </h5>
                </td>
                <td>
                    {{$e->dlval}}
                    @if($e->status == 1)
                        <i class="fas fa-check"></i>
                    @else
                        <i class="far fa-times-circle"></i>
                    @endif
                </td>
                <td>
                    {{ $e->deadline->format('F j Y') }}
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
                {{$employment->links()}}
            </ul>
        </div>
    </div>
    <div class="col-3"></div>
</div>

</div>

@endsection
