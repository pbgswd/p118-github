@extends('layouts.jumbo')
@section('content')
<div class="jumbotron">
    <div class="container border border-dark rounded" style="background: rgba(220,220,220,0.8);">
        <div class="row">
            <div class="col-12 pt-3 col-md-6">
                <h4>
                    <a href="{{url()->previous()}}">
                        <i class="far fa-arrow-alt-circle-left"></i>
                        Bylaws
                    </a>
                </h4>
            </div>
            @can('edit articles')
                <div class="col-12 pt-3 col-md-6 text-end">
                    <a href="{{route('admin_bylaw_edit', $data['bylaw']->id)}}" title="Edit {{$data['bylaw']->title}}">
                        <i class="fas fa-edit"></i> Admin Edit
                    </a>
                </div>
            @endcan
        </div>
        <div  class="col-12 text-center my-3">
            <h1>
                <i class="fas fa-gavel"></i>
                {{$data['bylaw']->title}}
            </h1>
            <h4>
                From: {{$data['bylaw']->date->format('F j Y')}}
            </h4>
        </div>
        <div class="col-12">
            {!! $data['bylaw']->description !!}
        </div>

        <div class="row mt-lg-2 m-2">
            <div class="col-12">
                @if(count($data['bylaw']->attachments) > 0)
                    <h4>
                        <i class="far fa-folder-open"></i>
                        Files
                    </h4>
                    <ul class="list-group">
                        @foreach($data['bylaw']->attachments as $att)
                            <li class="list-group-item">
                                <a href="{{route('attachment_download', [$att->subfolder, $att->id])}}"
                                   title="Download {{$att->file_name}}" target="_blank">
                                    <i class="fas fa-file-download fa-1x"></i>
                                    {{$att->description ? : $att->file_name}}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>

        <div class="d-flex justify-content-center">
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    @if($data['next'])
                        <li class="page-item">
                            <a class="page-link" href="{{ route('bylaw_show', [$data['next']->id])}}"
                               title="Next Bylaws: {{$data['next']->title}}">
                                Newer Bylaws
                            </a>
                        </li>
                    @endif
                    @if ($data['previous'])
                        <li class="page-item">
                            <a class="page-link" href="{{ route('bylaw_show', [$data['previous']->id])}}"
                               title="Previous Bylaws: {{$data['previous']->title}}">
                                Older Bylaws
                            </a>
                        </li>
                    @endif
                </ul>
            </nav>
        </div>

    </div>
</div>
@endsection
