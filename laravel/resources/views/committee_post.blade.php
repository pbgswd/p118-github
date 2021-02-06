@extends('layouts.jumbo')
@section('content')
    <div class="container border border-dark rounded-lg p-2 mt-3" style="background: rgba(220,220,220,0.8);">
        <div class="row">
            <div class="col-12">
                <img src="{{ asset('storage/committees/'.$data['committeepost']->committee->image)}}"
                     class="border rounded-lg img-fluid mb-2" />
            </div>
            <div class="col-12">
               <h4>
                   <a href="{{ route('committee', $data['committeepost']->committee->slug) }}">
                       {{$data['committeepost']->committee->name}}
                   </a>
               </h4>
                <h1>{{$data['committeepost']->title}}</h1>
                <h5>
                    By {{$data['committeepost']->creator->name}},
                    {{ \Carbon\Carbon::parse($data['committeepost']->updated_at)->format(' F j, Y') }}
                </h5>
                {!! $data['committeepost']->content !!}
            </div>
            @if($data['canManage'] == 1)
                <div class="col-12 p-4">
                    <h5>
                        <a href="{{route('committee_post_edit_form', [$data['committeepost']->committee->slug,
                            $data['committeepost']->slug])}}">
                            <i class="far fa-edit"></i> Edit Post
                        </a>
                    </h5>
                </div>
            @endif
        </div>
    </div>
@endsection
