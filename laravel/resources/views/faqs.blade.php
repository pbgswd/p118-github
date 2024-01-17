@extends('layouts.jumbo')
@section('content')
<div class="jumbotron jumbotron-fluid mb-2">
    <div class="container">
        <h1 class="display-4">FAQs for IATSE Local 118</h1>
        <p class="lead">
            {{$data['count']}} FAQs to help you.
        </p>
        @can(['edit articles'])
            <a href="{{route('admin_faqs_list')}}">
                Admin List FAQs
            </a>
        @endcan
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="accordion p-0" id="accordionTop">
                @foreach ( $data['faqs'] as $f )
                    <a id="{{$f->slug}}"></a>
                    <div class="card p-0 mb-2">
                        <div class="card-header" id="heading{{$f->slug}}">
                            <button class="btn btn-link btn-block text-left" type="button" href="#{{$f->slug}}"
                                    data-toggle="collapse" data-target="#collapse{{$f->slug}}" aria-expanded="false"
                                    aria-controls="collapse{{$f->slug}}">
                                <h3>{{$f->faq_topic}}</h3>
                            </button>
                            {!! $f->description!!}
                            <br />
                            <a href="{{route('faq_show', $f->slug )}}">
                                <i class="fas fa-link"></i> All {{$f->faqs_data->count()}} FAQs for
                                {{$f->faq_topic}}
                            </a>
                        </div>
                        @foreach($f['faqs_data'] as $fd)
                            <div id="collapse{{$f->slug}}" class="col-12 collapse m-0"
                                 aria-labelledby="heading{{$f->slug}}" data-parent="#accordionTop">
                                <div class="card-body p-0">
                                    <div class="accordion p-0" id="accordionSub">
                                        <div class="card m-0">
                                            <div class="col-12 card-header" id="headingSub{{$fd->id}}">
                                                <h2 class="mb-0">
                                                    <button class="btn btn-link btn-block text-left" type="button"
                                                            data-toggle="collapse" data-target="#collapseSub{{$fd->id}}"
                                                            aria-expanded="false"
                                                            aria-controls="collapseSub{{$fd->id}}">
                                                        <h3>
                                                            <i class="fas fa-question-circle"></i> {{$fd->question}}
                                                        </h3>
                                                    </button>
                                                </h2>
                                            </div>
                                            <div id="collapseSub{{$fd->id}}" class="collapse mt-3 p-3"
                                                 aria-labelledby="headingSub{{$fd->id}}"
                                                 data-parent="#accordionSub">
                                                {!! $fd->answer !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
            <div class="row mt-2">
                <div class="col-12">
                    <div class="d-flex justify-content-center">
                        <div class="list-group">
                            <ul class="pagination">
                                {!! $data['faqs']->links() !!}
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
