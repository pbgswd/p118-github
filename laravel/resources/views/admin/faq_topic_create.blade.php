@extends('layouts.dashboard')
@section('content')
<div class="container">
    <div class="jumbotron jumbotron-fluid p-5">
            <h1 class="display-4">Create/edit FAQ</h1>
            <p class="lead">
                FAQs have a top level topic term, with a list of questions and answers attached.
            </p>
            <a href="{{route('admin_faqs_list')}}">
                List FAQs
            </a>
    </div>
    <div class="row">
        <form method="post" name="employment" action="{{ url()->current() }}" enctype="multipart/form-data"
              class="needs-validation" novalidate>
        {!! csrf_field() !!}
            <div class="row">
                <div class="form-group">
                    <div class="col-lg-2">
                        <h4>Faq Topic</h4>
                    </div>
                    <div class="col-lg-10">
                        <input type="text" class="form-control"  placeholder="Topic" name="faq[faq_topic]"
                               value="{{ old('faq.faq_topic', $data['faq']->faq_topic)}}" size="80" required/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <div class="col-lg-2">
                        <h4>Description</h4>
                    </div>
                    <div class="col-lg-10">
                    <textarea name="faq[description]" id="faq-description" placeholder="Description content"
                              class="form-control">{{old('faq.description', $data['faq']->description)}}
                    </textarea>
                    </div>
                </div>
            </div>
            <div class="row mt-lg-2">
                <div class="col-2">
                    <h4>Live on website</h4>
                </div>
                <div class="col-sm">
                    <label>
                        <input name="faq[live]" type="hidden" value="0" />
                        <input name="faq[live]" type="checkbox" value="1"
                            {{ checked( old('faq.live', $data['faq']->live)) }} />
                        Check now to make Live
                    </label>
                    <p>ie.: Draft or Published.</p>
                </div>
            </div>
            <div class="row mt-3 mb-2 pb-2 pt-2">
                <div class="col-12 col-md-4 text-md-right">
                    <h4>Access Level for FAQ topic</h4>
                </div>
                <div class="col-12 col-md-5 text-left">
                    <div class="form-group">
                        {{ select_options($data['access_levels'], old('faq.access_level',
                            $data['faq']->access_level), ['name' => 'faq[access_level]',
                            'class' => 'form-control']) }}
                    </div>
                </div>
            </div>


            //todo faqs_data table has faq_id, question, answer, access_level, live


            <div class="row mt-lg-3">
                <div class="col-sm">
                    <i class="fas fa-edit fa-2x"></i>
                    <input class="btn btn-outline-primary" type="submit" value="{{ $data['action'] }}" />
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
