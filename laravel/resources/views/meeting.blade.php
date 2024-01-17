@extends('layouts.jumbo')
@section('content')
<div class="jumbotron">
    <div class="container border border-dark rounded" style="background: rgba(220,220,220,0.8);">
        <div class="row d-flex justify-content-end">
            <div class="col-12 col-md-6 mt-3">
                <h4>
                    <a href="{{route('list_meetings')}}">
                        <i class="far fa-arrow-alt-circle-left"></i>
                        Meeting Minutes
                    </a>
                </h4>
            </div>
            <div class="col-12 col-md-6 text-md-right">
                <p>{{$data['meeting']->date->format('F j Y')}}</p>
                @can('edit articles')
                    <a href="{{route('meeting_edit', $data['meeting']->id)}}" title="Edit {{$data['meeting']->title}}">
                        <i class="fas fa-edit"></i> Admin Edit
                    </a>
                @endcan
            </div>
        </div>
        <div class="col-12 text-center">
            <h1>
                {{$data['meeting']->title}}
            </h1>
        </div>
        <div class="col-12">
            <p>{!! $data['meeting']->description !!}</p>
        </div>
        @if(count($data['meeting']->attachments) > 0)
            <div class="col-12 mb-3">
                <h5>
                    <i class="far fa-folder-open"></i>
                    Files
                </h5>
                <ul class="list-group">
                    @forelse($data['meeting']->attachments as $att)
                        <li class="list-group-item">
                            <a href="{{route('attachment_download', [$att->subfolder, $att->id])}}"
                               title="Download {{$att->file_name}}" target="_blank">
                                <i class="fas fa-file-download fa-1x"></i>
                                {{$att->description ? $att->description .' '. $data['meeting']->date->format('F j Y')
                                    : $att->file_name}}
                            </a> &nbsp;
                        </li>
                    @empty
                        <li class="list-group-item">No files</li>
                    @endforelse
                </ul>
            </div>
        @endif

    </div>
</div>
@endsection




