@extends('layouts.jumbo')
@section('content')
<div class="jumbotron">
    <div class="container border border-dark rounded-lg" style="background: rgba(220,220,220,0.8);">
        <div class="col-12">
            <h4>
                <a href="{{route('policies_list_public')}}">
                    <i class="far fa-arrow-alt-circle-left"></i>
                    Policies
                </a>
            </h4>
        </div>
        <div class="row d-flex justify-content-end">
            <div class="col-12 col-md-6">
                <h1>
                    <i class="fas fa-scroll"></i>
                    {{$data['policy']->title}}
                </h1>
            </div>
            <div class="col-12 col-md-6 text-md-right">
                <h4>From: {{$data['policy']->date->format('F j Y')}}</h4>
            </div>
        </div>
        <div class="col-12">
            {!! $data['policy']->description !!}
        </div>
        @if($data['policy']->attachments->count() > 0)
            <div class="row mt-4 p-2">
                <h4>
                    <i class="far fa-folder-open"></i>
                    Files for {{$data['policy']->title}}
                </h4>
                <div class="col-12 mb-2">
                    <ul class="list-group">
                        @forelse($data['policy']->attachments as $att)
                            <li class="list-group-item">
                                <a href="{{route('attachment_download', [$att->subfolder, $att->id])}}"
                                   title="Download {{$att->file_name}}" target="_blank">
                                    <i class="fas fa-file-download fa-1x"></i>
                                    {{$att->description ?? $att->file_name}}
                                </a>
                            </li>
                        @empty
                        @endforelse
                    </ul>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection




