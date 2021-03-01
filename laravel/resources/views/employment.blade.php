@extends('layouts.jumbo')
@section('content')
<div class="jumbotron">
    <div class="container border border-dark rounded-lg mb-3" style="background: rgba(220,220,220,0.8);">
        <div class="row">
            <div class="col-12 col-md-6">
                <h4>
                    <a href="{{route('jobs_list')}}">
                        <i class="far fa-arrow-alt-circle-left"></i>
                        Employment postings
                    </a>
                </h4>
            </div>
            @can(['edit articles'])
                <div class="col-12 col-md-6 text-md-right">
                    <a href="{{route('admin_employment_edit', $data['employment']->id)}}"
                       title="Edit {{$data['employment']->title}}">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                </div>
            @endcan
        </div>
        <div class="row">
            <div class="col-12 text-center">
                <h1>{{$data['employment']->title}}</h1>
            </div>
            <div class="col-12 col-md-6">
                <h4>
                    Deadline: {{$data['employment']->deadline->format('F j Y')}}
                </h4>
            </div>
            <div class="col-12 col-md-6 text-md-right">
                <h4>Status:
                    @if($data['employment']->status == 1)
                        <i class="fas fa-check"></i> Open
                    @else
                        <i class="far fa-times-circle"></i> Closed
                    @endif
                </h4>
            </div>
        </div>
        @if($data['employment']->url != '')
            <div class="row mt-3 mb-lg-2">
                <div class="col-12">
                    <h4>
                        <a href="{{$data['employment']->url}}"
                           title="External link to {{$data['employment']->title}}" target="_blank">
                            <i class="fas fa-external-link-alt fa-2x"></i>
                            {{ $data['employment']->url }}
                        </a>
                    </h4>
                </div>
            </div>
        @endif
        <div class="row">
            <div class="col-12">
                {!! $data['employment']->description !!}
            </div>
        </div>
        @if(count($data['employment']->attachments) > 0)
            <div class="row mt-lg-2 mb-3">
                <div class="col-12">
                    <h4>
                        <i class="far fa-folder-open"></i>
                        Files
                    </h4>
                    <ul class="list-group">
                        @foreach($data['employment']->attachments as $att)
                            <li class="list-group-item">
                                <a href="{{route('attachment_download', [$att->subfolder, $att->id])}}"
                                   title="Download {{$att->file_name}}" target="_blank">
                                    <i class="fas fa-file-download fa-1x"></i>
                                    {{$att->description ?? $att->file_name}}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection




