@extends('layouts.jumbo')
@section('content')
<div class="jumbotron">
    <div class="container border border-dark rounded-lg pb-2" style="background: rgba(220,220,220,0.8);">
        <div class="row mb-2">
            <div class="col-6">
                <a href="{{route('agreements_list_public')}}">
                    <i class="far fa-arrow-alt-circle-left"></i>
                    Agreements
                </a>
            </div>
            @can('edit articles')
                <div class="col-6 text-md-right">
                    <a href="{{route('agreement_edit', $data['agreement']->id)}}"
                       title="Edit {{$data['agreement']->title}}">
                        <i class="fas fa-edit"></i> Admin Edit
                    </a>
                </div>
            @endcan
        </div>
        <div class="row">
            <div class="col-12 text-center">
                <h1>
                    <i class="far fa-handshake"></i>
                    {{$data['agreement']->title}}
                </h1>
                <h4>
                    {{$data['agreement']->from->format('F j Y')}} -
                    {{$data['agreement']->until->format('F j Y')}}
                    @if(\Carbon\Carbon::parse($data['agreement']->until)->isPast())
                        @auth
                            <i>(Not current)</i>
                        @endauth
                    @endif
                </h4>
            </div>
        </div>
        <div class="col-12 text-center">
            @forelse($data['agreement']->organizations as $org)
                <a href="{{route('organization', $org->slug)}}">
                    {{$org->name}}
                </a>
                @if(!$loop->last)|@endif
                @if($loop->last)<br />@endif
            @empty
            @endforelse
            @forelse($data['agreement']->venues as $venue)
                <a href="{{route('venue', $venue->slug)}}">
                    {{$venue->name}}
                </a>
                @if(!$loop->last)|@endif
                @if($loop->last)<br />@endif
            @empty
            @endforelse
        </div>
        <div class="col-12 mt-2">
            {!! $data['agreement']->description !!}
        </div>
        @if(count($data['agreement']->attachments) > 0)
            <div class="col-12 mt-3">
                <h4>
                    <i class="far fa-folder-open"></i>
                    Files
                </h4>
                <ul class="list-group">
                    @forelse($data['agreement']->attachments as $att)
                        @if((false === Auth::check()
                                && $att->access_level == App\Constants\AccessLevelConstants::PUBLIC)
                                || Auth::user())
                            <li class="list-group-item">
                                <a href="{{route('attachment_download', [$att->subfolder, $att->id])}}"
                                   title="Download {{$att->file_name}}" target="_blank">
                                    <i class="fas fa-file-download fa-1x"></i>
                                    {{$att->description ? : $att->file_name}}
                                </a>
                            </li>
                        @endif
                    @empty
                        <li class="list-group-item">
                            No files
                        </li>
                    @endforelse
                </ul>
            </div>
        @endif
    </div>
</div>
@endsection




