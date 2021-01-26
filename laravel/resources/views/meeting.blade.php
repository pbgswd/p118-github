@extends('layouts.jumbo')
@section('content')
<div class="jumbotron">
    <div class="container border border-dark rounded-lg" style="background: rgba(220,220,220,0.8);">
        <div class="col-12 pt-2">
            <h4>
                <a href="{{url()->previous()}}">
                    <i class="far fa-arrow-alt-circle-left"></i>
                    Meetings & Minutes
                </a>
            </h4>
        </div>
        <div class="col-12">
            <h1>
                {{$data['meeting']->title}}
            </h1>
        </div>
        <div class="col-12">
            <p>{{$data['meeting']->date->format('F j Y')}}</p>
            <p>{!! $data['meeting']->description !!}</p>
        </div>
        <div class="col-12 mb-lg-5">
            @if(count($data['meeting']->attachments) > 0)
                <ul class="list-group">
                    @foreach($data['meeting']->attachments as $att)
                        <li class="list-group-item">
                            <h4>
                                <a href="{{route('attachment_download', [$att->subfolder, $att->id])}}"
                                   title="Download {{$att->description}}" target="_blank">
                                    <i class="fas fa-file-download fa-1x"></i>
                                    {{$att->file_name}}
                                </a> &nbsp;
                                {{$att->description}}
                            </h4>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</div>
@endsection




