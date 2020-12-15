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
        <div class="row">
            <div  class="col-12">
                <h1 class="display-8"><i class="fas fa-scroll"></i>  {{$data['policy']->title}}</h1>
            </div>
        </div>
        <div class="row mb-lg-2">
            <div class="col-md-12">
                <h4>From: {{$data['policy']->date->format('F j Y')}} </h4>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                {!! $data['policy']->description !!}
            </div>
        </div>
        <div class="row mt-lg-2">
            <div class="col-12">
                    <ul class="list-group">
                        @forelse($data['policy']->attachments as $att)
                            <li class="list-group-item">
                                <h4>
                                    <a href="{{route('attachment_download', [$att->subfolder, $att->id])}}"
                                       title="Download {{$att->description}}" target="_blank">
                                        <i class="fas fa-file-download fa-1x"></i>
                                        {{$att->description}}
                                    </a>
                                </h4>
                            </li>
                        @empty
                        @endforelse
                    </ul>
            </div>
        </div>
    </div>
    <div class="row mt-lg-5"></div>
</div>
@endsection




