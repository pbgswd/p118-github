@extends('layouts.jumbo')
@section('content')
<div class="jumbotron">
    <div class="container border border-dark rounded-lg p-lg-2" style="background: rgba(220,220,220,0.8);">
        <div class="row p-4">
            <div class="col-12">
               <h3>
                   <a href="{{route('committees')}}">Committees /</a>
                   <a href="{{ route('committee', $data['committeepost']->committee->slug) }}">
                       {{$data['committeepost']->committee->name}}
                   </a> /  Posts
               </h3>
            </div>
            <div class="col-12 border border-dark rounded">
                <h1 class="display-4">{{$data['committeepost']->title}}</h1>
                <h5>
                    By {{$data['committeepost']->creator->name}},
                    {{ \Carbon\Carbon::parse($data['committeepost']->updated_at)->format(' F j, Y') }}
                </h5>
                {!! $data['committeepost']->content !!}
                <br clear="all" />
                @hasanyrole('super-admin|committee')
                <h5>
                    <a href="{{route('committee_post_edit_form', [$data['committeepost']->committee->slug,
                        $data['committeepost']->slug])}}">
                        <i class="far fa-edit"></i> Edit Post
                    </a>
                </h5>
                @endhasanyrole
            </div>
        </div>
    </div>
</div>
@endsection
