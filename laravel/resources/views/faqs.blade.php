@extends('layouts.jumbo')
@section('content')
<div class="jumbotron jumbotron-fluid">
    <div class="container">
        <h1 class="display-4">FAQs for IATSE Local 118</h1>
        <p class="lead">
            {{$data['count']}} FAQs to help you.
        </p>
    </div>
</div>
<div class="container border border-dark rounded-lg mt-2" style="background: rgba(220,220,220,0.8);">
    <div class="row mb-2 p-1 pr-3">
        @foreach ( $data['faqs'] as $f )
            <div class="col-12 border border-dark rounded-lg p-2 m-2">
                <h3>
                    <a href="{{ route('faq_show', $f->slug) }}" title="{{$f->faq_topic}}">{{$f->faq_topic}}</a>
                </h3>
                <h6>
                    <i>
                        faq_data
                    </i>
                </h6>
            </div>
        @endforeach
    </div>
    <div class="d-flex justify-content-center">
        <div class="list-group">
            <ul class="pagination">
                {!! $data['faqs']->links() !!}
            </ul>
        </div>
    </div>
</div>
@endsection




