@extends('layouts.jumbo')
@section('content')
<div class="container border border-dark rounded mt-3" style="background: rgba(220,220,220,0.8);">
    <div class="col-12 py-3 text-center">
        <h1>Features</h1>
    </div>
    <div class="row mb-3">
        @foreach ($data['features'] as $f)
            <div class="col-12 col-md-6 p-1">
                <div class="col border border-dark rounded w-100 h-100 p-2">
                        @if($f->image)
                            <div class="col-12 text-center me-2 d-flex align-items-center justify-content-center">
                                <picture>
                                    <source srcset="{{asset('storage/public/'. $f->image)}}" media="(min-width: 577px)">
                                    <img srcset="{{asset('storage/public/'.$data['thumbs']['tn_str'].$f->image)}}"
                                         alt="{{$f->name}}"
                                         class="rounded img-fluid d-block me-2">
                                </picture>
                            </div>
                        @endif
                        <h3 class="text-center mt-2">
                            <a href="{{ route('feature', $f->slug) }}" title="{{ $f->title }}">
                                {{ $f->title }}
                            </a>
                        </h3>
                        <p>{!! $f->content !!}</p>
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




