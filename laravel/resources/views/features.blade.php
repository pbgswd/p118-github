@extends('layouts.jumbo')
@section('content')
<div class="container border border-dark rounded-lg mt-3" style="background: rgba(220,220,220,0.8);">
    <div class="col-12 text-center">
        <h1>Features</h1>
    </div>
    <div class="row mb-3">
        @foreach ($data['features'] as $f)
            <div class="col-12 col-md-6 p-1">
                <div class="col border border-dark rounded-lg w-100 h-100 p-2">
                    <a href="{{ route('feature', $f->slug) }}" title="{{ $f->title }}">
                        @if($f->image)
                            <img src="{{asset('storage/public/'.
                                $data['thumbs']['tn_str'].$f->image)}}" alt="{{$f->title}}"
                                class="rounded img-fluid"/>
                        @endif
                        <h3>{{ $f->title }}</h3>
                        <p>{!! $f->content !!}</p>
                    </a>
                </div>
            </div>
        @endforeach
    </div>
    <div class="d-flex justify-content-center">
        <div class="list-group">
            <ul class="pagination">
                {!! $data['features']->links() !!}
            </ul>
        </div>
    </div>
</div>
@endsection




