@extends('layouts.jumbo')
@section('content')
<div class="jumbotron">
    <div class="container border border-dark rounded-lg pb-2" style="background: rgba(220,220,220,0.8);">
        <div class="col-12 p-2 mb-2">
            <a href="{{route('agreements_list_public')}}">
                <i class="far fa-arrow-alt-circle-left"></i>
                Agreements
            </a>
        </div>
        <div class="row d-flex justify-content-end">
            <div class="col-12 col-md-6">
                <h1>
                    <i class="far fa-handshake"></i>
                    {{$data['agreement']->title}}
                </h1>
            </div>
            <div class="col-12 col-md-6 text-md-right">
                <h4>
                    {{$data['agreement']->from->format('F j Y')}} -
                    {{$data['agreement']->until->format('F j Y')}}
                    @if(\Carbon\Carbon::parse($data['agreement']->until)->isPast())
                        <i>(Not current)</i>
                    @endif
                </h4>
            </div>
        </div>
        <div class="col-12">
            {!! $data['agreement']->description !!}
        </div>
        @if(count($data['agreement']->attachments) > 0)
            <div class="col-12">
                <h4>
                    <i class="far fa-folder-open"></i>
                    Files for this agreement
                </h4>
                <ul class="list-group">
                    @foreach($data['agreement']->attachments as $att)
                        <li class="list-group-item">
                            <h4>
                                <a href="{{route('attachment_download', [$att->subfolder, $att->id])}}"
                                   title="Download {{$att->file_name}}" target="_blank">
                                    <i class="fas fa-file-download fa-1x"></i>
                                    {{$att->description}}
                                </a>
                                {{$att->description ?? $att->file_name}}
                            </h4>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
</div>
@endsection




