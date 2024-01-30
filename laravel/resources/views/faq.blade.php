@extends('layouts.jumbo')
@section('content')
<div class="jumbotron jumbotron-fluid">
    <div class="container">
        <h1>
            <a href="{{route('faq_show', $data['faq']->slug )}}">
                <i class="fas fa-link"></i>
            </a>
            FAQ: {{$data['faq']->faq_topic}}
        </h1>
        {!! $data['faq']->description !!}
        <div class="mt-5">
            <a class="btn btn-lg btn-secondary" href="{{route('faqs_list_public')}}" role="button">
               Back to list of all FAQs
            </a>
        </div>

        @can(['edit articles'])
            <div class="text-right">
                <a href="{{route('admin_faq_edit', $data['faq']->slug)}}"
                   title="Edit {{$data['faq']->slug}}">
                    <i class="fas fa-edit"></i> Admin Edit
                </a>
            </div>
        @endcan
    </div>
</div>
<div class="container border border-dark rounded mt-2 pb-3">
    <div class="row m-3">
        <h3>
            {{count($data['faq']['faqs_data'])}} Questions & Answers
        </h3>
    </div>
    <div class="accordion" id="accordionExample">
        @forelse ( $data['faq']['faqs_data'] as $fd )
            <div class="card mb-2">
                <div class="card-header" id="heading{{$fd->id}}">
                    <h2 class="mb-0">
                        <button class="btn btn-link btn-block text-left text-decoration-none" type="button" data-toggle="collapse"
                                data-target="#collapse{{$fd->id}}" aria-expanded="true"
                                aria-controls="collapse{{$fd->id}}">
                            <h3>
                                {{$fd->question}}
                            </h3>
                        </button>
                    </h2>
                </div>
                <div id="collapse{{$fd->id}}" class="collapse show" aria-labelledby="heading{{$fd->id}}"
                     data-parent="#accordionExample">
                    <div class="card-body">
                       {!! $fd->answer !!}
                    </div>
                </div>
            </div>
        @empty
            No FAQs for {{$data['faq']->faq_topic}}
        @endforelse
    </div>
</div>
@endsection
