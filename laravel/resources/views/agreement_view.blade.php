@extends('layouts.jumbo')
@section('content')
<div class="jumbotron">
    <div class="container border border-dark rounded-lg" style="background: rgba(220,220,220,0.8);">
        <div  class="col-12 pt-2">
            <h1>
                <i class="far fa-handshake"></i>
                {{$data['agreement']->title}}
            </h1>
            <h4>
                From: {{$data['agreement']->from->format('F j Y')}}
                Until {{$data['agreement']->until->format('F j Y')}}
                @if(\Carbon\Carbon::parse($data['agreement']->until)->isPast())
                    <i>(Not current)</i>
                @endif
            </h4>
            {!! $data['agreement']->description !!}

            @if(count($data['agreement']->attachments) > 0)
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
            @endif
        </div>
    </div>
</div>
@endsection




