@extends('layouts.dashboard',  ['title_icon' => '<i class="far fa-question-circle"></i>', 'title' => $data['action'] .
    ' FAQ '. $data['faq']->faq_topic ?? ''])
@section('content')
<div class="container">
    <div class="row">
        <p class="lead">
            FAQs have a top level topic term, with a list of questions and answers attached.
        </p>
        <div class="h2 text-warning-emphasis">
            Work in progress, it does work, but is being fixed, msg me if you need help - PG.
        </div>
    </div>
    <div class="row">
        <ul class="list-group list-group-horizontal">
            <li class="list-group-item">
                <a href="{{route('admin_faqs_list')}}">
                    List FAQs
                </a>
            </li>
            @if($data['action'] == 'Update')
                <li class="list-group-item">
                    <a href="{{route('faq_show', $data['faq']->slug)}}" title="View {{$data['faq']->faq_topic}}">
                        <i class="fas fa-eye"></i> View {{$data['faq']->faq_topic}} on website
                    </a>
                </li>
                <li class="list-group-item">
                    <a href="{{route('admin_faq_create')}}">
                        Create new FAQ
                    </a>
                </li>
                <li class="list-group-item">
                    Created by: {{$data['faq']['user']->name}}
                </li>

                <a href="{{route('admin_faq_data_create', $data['faq']->slug )}}">
                    create a new question and answer pair </a>

            @endif
        </ul>
    </div>

    <form method="post" name="employment" action="{{ url()->current() }}" enctype="multipart/form-data" class="needs-validation" novalidate>
        {!! csrf_field() !!}
        <div class="row my-4">
            <div class="form-group">
                <div class="col-sm-12 col-md-8">
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="inputGroup-sizing-default">FAQ topic</span>
                        <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default"
                               placeholder="Topic" name="faq[faq_topic]"
                               value="{{ old('faq.faq_topic', $data['faq']->faq_topic)}}" size="40" required/>
                    </div>
                </div>
            </div>
        </div>
        <div class="row my-4">
            <div class="form-group">

                <div class="col-12">
                    <div class="col-12 mb-4">
                        <div class="col input-group editor-container editor-container_classic-editor" id="editor-container">
                            <span class="input-group-text">Description</span>
                            <div class="editor-container__editor">
                            <textarea name="faq[description]" id="textarea" placeholder="Content" class="form-control text-black">
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
                        var textarea = @json($data['faq']->description ?? '');
                        var textarea1 = @json("asdfasdfasdf" ?? '');
                        var textarea2 = @json("asdfasdfasdf22222222222" ?? '');
                    </script>
                    <script type="module" src="{{mix('js/admin/ckeditor5/ck_main_admin.js')}}"></script>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <h4>Live on website</h4>
                <label>
                    <input name="faq[live]" type="hidden" value="0" />
                    <input name="faq[live]" type="checkbox" value="1"
                        {{ checked( old('faq.live', $data['faq']->live)) }} />
                    Check now to make Live
                </label>
                <p>ie.: Draft or Published.</p>
            </div>
            <div class="col-sm-12 col-md-4">
                <h4>Access Level for FAQ topic</h4>
                <div class="form-group">
                    {{ select_options($data['access_levels'], old('faq.access_level',
                        $data['faq']->access_level), ['name' => 'faq[access_level]',
                        'class' => 'form-control']) }}
                </div>
            </div>
        </div>
        <div class="row my-4 text-lg">
            <div class="col-12">
                <h4>
                    @if($data['action'] == 'Update')
                        {{count($data['faq']['faqs_data']) == 0 ? 'No current' : count($data['faq']['faqs_data'])}}
                    @endif
                    FAQ Questions and Answers
                </h4>
            </div>
        </div>
        @if($data['action'] == 'Update')
            <div class="row">
                @foreach( $data['faq']['faqs_data'] as $fd )
                    <div class="col-12 border border-dark rounded p-2 m-2 mb-6">
                        <h3>
                            <a href="{{route('admin_faq_data_edit', [$data['faq']->slug, $fd->id])}}">Edit {{$fd->question}}</a>
                        </h3>
                        <input type="hidden" name="faq[faq_data][{{$fd->id}}][id]" value="{{$fd->id}}" />
                        <input type="hidden" name="faq[faq_data][{{$fd->id}}][faq_id]" value="{{$data['faq']->id}}" />
                        <div class="form-group">
                            <div class="col-sm-12 col-md-8">
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="inputGroup-sizing-default">Question {{$fd->id}}</span>
                                    <input type="text" class="form-control" aria-label="Sizing example input"
                                           aria-describedby="inputGroup-sizing-default"
                                           placeholder="Question"
                                           name="faq[faq_data][{{$fd->id}}][question]"
                                           value="{{ old('faq.faq_data.question', $fd->question)}}" size="80"
                                           required/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group my-4">
                            <div class="col-12">
                                <h4>Answer</h4>
                                <textarea name="faq[faq_data][{{$fd->id}}][answer]" id="textarea{{$fd->id}}"
                                          placeholder="Description content"
                                          class="form-control">{{old('faq.faq_data.answer', $fd->answer)}}
                                </textarea>
                            </div>
                        </div>
                        <div class="row my-4">
                            <div class="col-sm-12 col-md-6">
                                <h4>Live with topic</h4>
                                <label>
                                    <input name="faq[faq_data][{{$fd->id}}][live]" type="hidden" value="0" />
                                    <input name="faq[faq_data][{{$fd->id}}][live]" type="checkbox" value="1"
                                        {{ checked( old('faq.faq_data.live', $fd->live)) }} />
                                    Check now to make Live
                                </label>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <h4>Access Level for FAQ question & answer</h4>
                                <div class="form-group">
                                    {{ select_options($data['access_levels'], old('faq.faq_data.access_level',
                                        $fd->access_level), ['name' => 'faq[faq_data]['. $fd->id .'][access_level]',
                                        'class' => 'form-control']) }}
                                </div>
                            </div>
                        </div>
                        <div class="form-group my-4">
                            <div class="col-sm-12 col-md-6 my-4">
                                <h4>Sort Order (largest number is first)</h4>
                                <input type="text" class="form-control"  placeholder="sort_order"
                                       name="faq[faq_data][{{$fd->id}}][sort_order]"
                                       value="{{ old('faq.faq_data.sort_order', $fd->sort_order) }}" size="80"
                                       required />
                            </div>
                        </div>
                        <div class="row my-4">
                            <div class="col-12 my-4 input-group-lg">
                                <h5>Delete this question and answer</h5>
                                <label>
                                    <input name="faq[faq_data][{{$fd->id}}][delete]" type="hidden" value="0" />
                                    <input name="faq[faq_data][{{$fd->id}}][delete]" type="checkbox" value="1" />
                                    Check to delete, and then submit.
                                </label>
                                <hr />
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
            <!-- begin section to be generated -->
        <div class="row mb-6">
                    <div class="col-12">
                        <button class="btn btn-primary m-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample"
                                aria-expanded="false" aria-controls="collapseExample">
                            <i class="fa fa-plus"></i>
                            Add a question and answer
                        </button>
                        <div class="collapse" id="collapseExample">
                            <div class="card card-body">
                                <div class="form-group">
                                    <div class="col-12 mb-6">
                                        <h4>Question</h4>
                                        <input type="text" class="form-control"  placeholder="Question"
                                               name="new[question]"
                                               value="" size="40">
                                    </div>
                                </div>
                                <div class="form-group my-4">
                                    <div class="col-12">
                                        <h4>Answer</h4>
                                    </div>
                                    <div class="col-12">
                                    <textarea name="new[answer]" id="faq-faq_data-answer"
                                              placeholder="Answer content"
                                              class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="row my-2">
                                    <div class="col-sm-12 col-md-6">
                                        <h4>Live with topic</h4>

                                        <label>
                                            <input name="new[live]" type="hidden" value="0" />
                                            <input name="new[live]" type="checkbox" value="1"
                                            />
                                            Check now to make Live (ie.: Draft or Published).
                                        </label>
                                    </div>

                                    <div class="col-sm-12 col-md-6">
                                        <h4>Access Level for FAQ question & answer</h4>
                                        <div class="form-group">
                                            {{ select_options($data['access_levels'], old('faq.faq_data.access_level',
                                                'public'), ['name' => 'new[access_level]',
                                                'class' => 'form-control']) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-12 mb-5">
                                        <h4>Sort Order</h4>
                                        <input type="text" class="form-control"  placeholder="Sort order: 100, 200, etc. "
                                               name="new[sort_order]"
                                               value="" size="10"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    <!-- end of section to be generated -->

            <div class="row my-5">
                <div class="col-sm-12 col-md-6 mb-sm-5 mb-md-0 float-start">
                    <i class="fas fa-edit fa-2x mx-2"></i>
                    <input class="btn btn-outline-primary mb-sm-4" type="submit" value="{{ $data['action'] }}" />
                </div>
            </form>
            @if ($data['action'] == 'Update')
                <div class="col-sm-12 col-md-6 mt-sm-6 mt-md-0 float-end">
                    <form name="delete" method="POST" action="{{route('admin_faq_destroy')}}">
                        {!! csrf_field() !!}
                        {!! method_field('DELETE') !!}
                        <i class="far fa-trash-alt fa-2x mx-2"></i>
                        <input type="hidden" name="id[]" value="{{ $data['faq']->id }}">
                        <input class="btn btn-outline-danger" type="submit" value="Delete FAQ">
                    </form>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
