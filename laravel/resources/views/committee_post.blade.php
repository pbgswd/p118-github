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
            <div class="col-12 border border-dark rounded mb-3">
                <h1 class="display-4">{{$data['committeepost']->title}}</h1>
                <h5>
                    By {{$data['committeepost']->creator->name}},
                    {{ \Carbon\Carbon::parse($data['committeepost']->updated_at)->format(' F j, Y') }}
                </h5>
                {!! $data['committeepost']->content !!}
            </div>
            @if($data['canManage'] == 1)

                <div class="col-2 p-2">
                    <h5>
                        <a href="{{route('committee_post_edit_form', [$data['committeepost']->committee->slug,
                            $data['committeepost']->slug])}}">
                            <i class="far fa-edit"></i> Edit Post
                        </a>
                    </h5>
                </div>
                <div class="col-8"> &nbsp;</div>
                <div class="col-2" style="float:right">
                    <form name="delete" method="POST"
                          action="{{route('public_committee_post_destroy', [$data['committeepost']->committee->slug,
                                        $data['committeepost']->slug])}}">
                        {!! csrf_field() !!}
                        {!! method_field('DELETE') !!}
                        <i class="far fa-trash-alt fa-2x"></i>
                        <input type="hidden" name="id[]" value="{{ $data['committeepost']->id }}">
                        <input class="btn btn-outline-danger" type="submit" value="Delete">
                    </form>
                </div>

            @endif
        </div>
    </div>
</div>
@endsection
