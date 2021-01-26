@extends('layouts.jumbo')
@section('content')
<div class="jumbotron">
    <div class="container border border-dark rounded-lg" style="background: rgba(220,220,220,0.8);">
        <div class="col-12">
            <h4>
                <a href="{{url()->previous()}}">
                    <i class="far fa-arrow-alt-circle-left"></i>
                    Bylaws
                </a>
            </h4>
        </div>
        <div  class="col-12">
            <h1>
                <i class="fas fa-gavel"></i>
                {{$data['bylaw']->title}}
            </h1>
        </div>
        <div class="col-12">
            <h4>
                From: {{$data['bylaw']->date->format('F j Y')}}
            </h4>
        </div>
        <div class="col-12">
            {!! $data['bylaw']->description !!}
        </div>
        <div class="row mt-lg-2">
            <div class="col-12">
                @if(count($data['bylaw']->attachments) > 0)
                    <h4>
                        <i class="far fa-folder-open"></i>
                        Files for {{$data['bylaw']->title}}
                    </h4>
                    <ul class="list-group">
                        @foreach($data['bylaw']->attachments as $att)
                            <li class="list-group-item">
                                <h4>
                                    <a href="{{route('attachment_download', [$att->subfolder, $att->id])}}"
                                       title="Download {{$att->description}}" target="_blank">
                                        <i class="fas fa-file-download fa-1x"></i>
                                    {{$att->description ?? $att->file_name}}
                                    </a>
                                    {{$att->description ?? '' }}
                                </h4>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection




