@extends('layouts.jumbo')
@section('content')
<div class="jumbotron jumbotron-fluid">
    <div class="container">
        <h1 class="display-4">FAQs for IATSE Local 118</h1>
        <p class="lead">
            FAQs to help you.
        </p>
        <h2>
            FAQ: {{$data['faq']->faq_topic}}
        </h2>
        <h4>
            {{$data['faq']->description}}
        </h4>

        <h5 class="mt-5">
            <a class="btn btn-primary" href="{{route('faqs_list_public')}}" role="button">
                List of FAQs
            </a>
        </h5>
    </div>
</div>
<div class="container border border-dark rounded-lg mt-2" style="background: rgba(220,220,220,0.8);">
    <div class="row mb-2 p-1 pr-3">
        @foreach ( $data['faq']['faq_data'] as $f )
            <div class="col-12 border border-dark rounded-lg p-2 m-2">
                <h3>
                    <a href="#" title="{{$f->faq_topic}}">{{$f->faq_topic}}</a>
                </h3>
                <h6>
                    <i>
                        faq_data
                    </i>
                </h6>
            </div>
        @endforeach
    </div>
</div>
@endsection




