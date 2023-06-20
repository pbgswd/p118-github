@extends('layouts.jumbo')
@section('content')
<div class="jumbotron jumbotron-fluid">
    <div class="container">
        <h1 class="display-4">FAQs for IATSE Local 118</h1>
        <p class="lead">
            FAQs to help you.
        </p>
        <h2>
            <a href="{{route('faq_show', $data['faq']->slug )}}">
                <i class="fas fa-link"></i>
            </a>
            FAQ: {{$data['faq']->faq_topic}}
        </h2>
        <h4>
            {!! $data['faq']->description !!}
        </h4>

        <div class="mt-5">
            <a class="btn btn-lg btn-primary" href="{{route('faqs_list_public')}}" role="button">
               Back to list of all FAQs
            </a>
        </div>
    </div>
</div>
<div class="container border border-dark rounded-lg mt-2" style="background: rgba(220,220,220,0.8);">
    <div class="accordion" id="accordionExample">
        @forelse ( $data['faq']['faqs_data'] as $fd )
            <div class="card">
                <div class="card-header" id="heading{{$fd->id}}">
                    <h2 class="mb-0">
                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse"
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
                       {{$fd->answer}}
                    </div>
                </div>

            </div>
        @empty
            No FAQs for {{$data['faq']->faq_topic}}
        @endforelse
    </div>
</div>

@endsection




