@extends('layouts.jumbo')
@section('content')

    <div class="row mt-3">
        <div class="col-12 col-md-6 pl-4">
            <h4>
                <a href="{{route('policies_list_public')}}">
                    <i class="far fa-arrow-alt-circle-left"></i>
                    Policies
                </a>
            </h4>
        </div>
        @can('edit articles')
            <div class="col-12 col-md-6 text-md-right pr-4">
                <a href="{{route('admin_policy_edit', $data['policy']->id)}}"
                   title="Edit {{$data['policy']->title}}">
                    <i class="fas fa-edit"></i> Admin Edit
                </a>
            </div>
        @endcan
    </div>
    <div class="jumbotron text-center">
        <h1>
            <i class="fas fa-scroll"></i>
            {{$data['policy']->title}}
        </h1>
    </div>
    <div class="container border border-dark rounded" style="background: rgba(220,220,220,0.8);">
        <div class="col-12 col-md-4 text-md-right pt-3">
            <h4>
                From: {{$data['policy']->date->format('F j Y')}}
            </h4>
        </div>
        <div class="col-12">
            {!! $data['policy']->description !!}
        </div>
        @if($data['policy']->attachments->count() > 0)
            <div class="row mt-4 p-2">
                <h4>
                    <i class="far fa-folder-open"></i>
                    Files
                </h4>
                <div class="col-12 mb-2">
                    <ul class="list-group">
                        @forelse($data['policy']->attachments as $att)
                            <li class="list-group-item">
                                <a href="{{route('attachment_download', [$att->subfolder, $att->id])}}"
                                   title="Download {{$att->file_name}}" target="_blank">
                                    <i class="fas fa-file-download fa-1x"></i>
                                    {{$att->description ? : $att->file_name}}
                                </a>
                            </li>
                        @empty
                            <li class="list-group-item"> No file </li>
                        @endforelse
                    </ul>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
