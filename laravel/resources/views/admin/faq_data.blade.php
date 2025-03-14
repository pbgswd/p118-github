@extends('layouts.dashboard',  ['title_icon' => '<i class="far fa-question-circle"></i>', 'title' => $data['action'] .
    ' Question & Answer for '. $data['faq_data']['faq']->faq_topic ?? ''])
@section('content')
<div class="container">
    <div class="row">
        <p class="lead">
            FAQs have a top level topic term, with a list of questions and answers attached.
        </p>
        <div class="h2 text-warning-emphasis">
           Create edit single faq question answer pair
        </div>
    </div>
    <div class="row">
        <ul class="list-group list-group-horizontal">
            <li class="list-group-item">
                <a href="{{route('admin_faqs_list')}}">
                    View List FAQs
                </a>
            </li>

                <li class="list-group-item">
                    <a href="{{route('faq_show', $data['faq_data']['faq']->slug)}}" title="View {{$data['faq_data']['faq']->faq_topic}}">
                        <i class="fas fa-eye"></i> View {{$data['faq_data']['faq']->faq_topic}} on website
                    </a>
                </li>

                <li class="list-group-item">
                    Created by: {{$data['faq_data']['faq']['user']->name}}
                </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-12 border border-gray-100 p-4 mt-4">
            {{$data['faq_data']['faq']->faq_topic}} <br />
            Description: {!! $data['faq_data']['faq']->description ?? '' !!} <br />
            <a href="{{route('admin_faq_edit', $data['faq_data']['faq']->slug)}}">Return to Edit page for {{$data['faq_data']['faq']->faq_topic}}
            </a>
        </div>
    </div>

    <form method="post" name="faq_data" action="{{ url()->current() }}" enctype="multipart/form-data" class="needs-validation" novalidate>
        {!! csrf_field() !!}

        <div class="row">
            <div class="col-12 border border-dark rounded p-2 my-4 mb-6">
                <div class="form-group">
                    <div class="col-sm-12 col-md-8">
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="inputGroup-sizing-default">Question</span>
                            <input type="text" class="form-control" aria-label="Sizing example input"
                                   aria-describedby="inputGroup-sizing-default"
                                   placeholder="Question"
                                   name="faq_data[question]"
                                   value="{{ $data['faq_data']->question ?? ''}}" size="80"
                                   required/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row my-4">
            <div class="form-group">
                <div class="col-12">
                    <div class="col-12 mb-4">
                        <div class="col input-group editor-container editor-container_classic-editor" id="editor-container">
                            <span class="input-group-text">Answer</span>
                            <div class="editor-container__editor">
                            <textarea name="faq_data[answer]" id="textarea" placeholder="Content" class="form-control text-black">
                            </textarea>
                            </div>
                        </div>
                    </div>
                    <script type="importmap">
                        {
                            "imports": {
                                "ckeditor5": "/js/ckeditor5/ckeditor5.js",
                                "ckeditor5/": "/js/ckeditor5/"
                            }
                        }
                    </script>
                    <script>
                        var textarea = @json($data['faq_data']->answer ?? '');
                        var textarea1 = @json("asdfasdfasdf" ?? '');
                    </script>
                    <script type="module" src="{{mix('js/admin/ckeditor5/ck_main_admin.js')}}"></script>
                </div>
            </div>
        </div>
        <div class="row my-4">
            <div class="col-sm-12 col-md-6">
                <h4>Live with topic</h4>
                <label>
                    <input name="faq_data[live]" type="hidden" value="0" />
                    <input name="faq_data[live]" type="checkbox" value="1"
                        {{ checked( old('faq_data.live', $data['faq_data']->live)) }} />
                    Check now to make Live
                </label>
            </div>
            <div class="col-sm-12 col-md-6">
                <h4>Access Level for FAQ question & answer</h4>
                <div class="form-group">
                    {{ select_options($data['access_levels'], old('faq_data.access_level',
                        $data['faq_data']->access_level), ['name' => 'faq_data[access_level]',
                        'class' => 'form-control']) }}
                </div>
            </div>
        </div>
        <div class="form-group my-4">
            <div class="col-sm-12 col-md-6 my-4">
                <h4>Sort Order (largest number is first)</h4>
                <input type="text" class="form-control"  placeholder="sort_order"
                       name="faq_data[sort_order]"
                       value="{{ old('faq_data.sort_order', $data['faq_data']->sort_order) }}" size="80"
                       required />
            </div>
        </div>
        <div class="row my-5">
            <div class="col-sm-12 col-md-6 mb-sm-5 mb-md-0 float-start">
                <i class="fas fa-edit fa-2x mx-2"></i>
                <input class="btn btn-outline-primary mb-sm-4" type="submit" value="{{ $data['action'] }}" />
            </div>
    </form>
            @if ($data['action'] == 'Edit')
                <div class="col-sm-12 col-md-6 mt-sm-6 mt-md-0 float-end">
                    <form name="delete" method="POST" action="{{route('admin_faq_data_destroy')}}">
                        {!! csrf_field() !!}
                        {!! method_field('DELETE') !!}
                        <i class="far fa-trash-alt fa-2x mx-2"></i>
                        <input type="hidden" name="id[]" value="{{ $data['faq_data']->id }}">
                        <input class="btn btn-outline-danger" type="submit" value="Delete Question & Answer">
                    </form>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
