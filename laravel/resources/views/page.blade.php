<?php
$page = $data['page'];
$tags = join(', ', $page->tagNames());
?>
@extends('layouts.jumbo')
@section('content')
<div class="jumbotron">
    <div class="container border border-dark rounded-lg" style="background: rgba(220,220,220,0.8);">
        <div class="row mb-lg-5">
            <div  class="col-4">
                Left Col 
            </div>
            <div  class="col-8">
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
                    <div class="col-md-12">
                        Tags: {{$tags}}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection




