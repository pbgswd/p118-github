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
        <h3>
            {{count($data['faq']['faqs_data'])}} Questions & Answers
        </h3>
    </div>
    @forelse ( $data['faq']['faqs_data'] as $fd )
         <div class="row">
             <div class="col-12">
                 <p class="d-inline-flex my-2">
                     <a class="btn btn-outline-primary btn-lg" data-bs-toggle="collapse" href="#collapse{{$fd->id}}"
                        aria-expanded="false" aria-controls="collapseExample">
                         {{$fd->question}}
                     </a>
                </p>
                <div class="collapse" id="collapse{{$fd->id}}">
                    <div class="card card-body">
                       {!! $fd->answer !!}
                    </div>
                </div>
             </div>
        </div>
    @empty
        No FAQs for {{$data['faq']->faq_topic}}
    @endforelse
@endsection
