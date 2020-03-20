<?php
$page = $data['page'];
$tags = join(', ', $page->tagNames());
?>
@extends('layouts.jumbo')
@section('content')
<div class="jumbotron">
    <div class="container border border-dark rounded-lg" style="background: rgba(220,220,220,0.6);">
        <div  class="col-12">
            <h1 class="display-3">{{$page->title}}</h1>
        </div>
        <div class="col-12">
            <h2>{!! $page->description !!}</h2>
        </div>
        <div class="col-12">
            {!! $page->content !!}
         </div>
        @if(count($page->attachments) > 0)
            <div class="col-md-12">
                <h4>Files</h4>
                <table class="table table-striped table-sm">
                    <thead>
                    <tr>
                        <th> File </th>
                        <th> Description </th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($page->attachments as $pa)
                            <tr>
                                <td>
                                    <a href="{{route('attachment_download', [$page->getAttachmentFolder(), $pa->id])}}" title="Download {{$pa->file_name}}">{{$pa->file_name}}</a>
                                </td>
                                <td>
                                    {{ $pa->description}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
        @if ($tags != '')
            <div class="row">
                Tags: {{$tags}}
            </div>
        @endif
        <div class="row">
            <a href="{{route('pages')}}">Pages / </a> &nbsp;
            {{$page->title}}
        </div>
    </div>
<div class="row mt-lg-5"></div>
</div>
@endsection




