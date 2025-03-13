@extends('layouts.jumbo')
@section('content')
<div class="jumbotron jumbotron-fluid">
    <div class="container pt-4">
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <h1>
                    <a href="{{route('faq_show', $data['faq']->slug )}}">
                        <i class="fas fa-link"></i>
                    </a>
                    FAQ: {{$data['faq']->faq_topic}}
                </h1>
            </div>
            <div class="col-sm-12 col-md-6">
                @can(['edit articles'])
                    <div class="float-end">
                        <a href="{{route('admin_faq_edit', $data['faq']->slug)}}"
                           title="Edit {{$data['faq']->slug}}">
                            <i class="fas fa-edit"></i> Admin Edit
                        </a>
                    </div>
                @endcan
            </div>
        </div>
        <div class="row">
            <div class="col-12 mt-4">
                {!! $data['faq']->description !!}
            </div>
        </div>
        <div class="row">
            <div class="col-12 my-4">
                <a class="btn btn-lg btn-secondary" href="{{route('faqs_list_public')}}" role="button">
                    Back to list of all FAQs
                </a>
            </div>
        </div>
    </div>
</div>
<div class="container border border-dark rounded mt-2 pb-3">
    <div class="row m-3">
        <h2>
            {{count($data['faq']['faqs_data'])}} Frequently Asked Questions & The Answers
        </h2>
    </div>

    <div class="row">
        <div class="col-12">
            @forelse ( $data['faq']['faqs_data'] as $fd )
                <div class="accordion mb-3" id="accordionExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse{{$fd->id}}" aria-expanded="false" aria-controls="collapseOne">
                                <h3>{{$fd->question}}</h3>
                            </button>
                        </h2>
                        <div id="collapse{{$fd->id}}" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                {!! $fd->answer !!}
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                No FAQs for {{$data['faq']->faq_topic}}
            @endforelse
        </div>
    </div>
</div>
@endsection
