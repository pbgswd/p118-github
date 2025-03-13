@extends('layouts.jumbo')
@section('content')
<div class="jumbotron jumbotron-fluid mb-2">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-10 mt-4">
                <h1 class="display-4">FAQs for IATSE Local 118</h1>
                <p class="lead">
                    {{$data['count']}} FAQs to help you.
                </p>
            </div>
            <div class="col-sm-12 col-md-2">
                @can(['edit articles'])
                    <a href="{{route('admin_faqs_list')}}">
                        Admin List FAQs
                    </a>
                @endcan
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">

            @forelse ( $data['faqs'] as $f )
            <div class="col-12 my-2">
                <a id="{{$f->slug}}"></a>
                <h3>
                    <a href="{{route('faq_show', $f->slug )}}">
                        {{$f->faq_topic}} -
                        <i class="fas fa-link"></i> Read All {{$f->faqs_data->count()}} FAQs

                    </a>
                </h3>
            </div>
            @empty
                no faqs
            @endforelse

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
