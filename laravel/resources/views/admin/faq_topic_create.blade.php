@extends('layouts.dashboard',  ['title' => '<i class="far fa-question-circle"></i>  '.  $data['action'] . ' FAQ '])
@section('content')
<div class="container">
    <div class="jumbotron jumbotron-fluid p-5">
        <p class="lead">
            FAQs have a top level topic term, with a list of questions and answers attached.
        </p>
        <a href="{{route('admin_faqs_list')}}">
            List FAQs
        </a>
        @if($data['action'] == 'Update')
            |  <a href="{{route('faq_show', $data['faq']->slug)}}" title="View {{$data['faq']->faq_topic}}">
                <i class="fas fa-eye"></i> View {{$data['faq']->faq_topic}} on website
            </a>
            | <a href="{{route('admin_faq_create')}}">
                Create new FAQ
            </a>
            | Created by: {{$data['faq']['user']->name}}
        @endif
    </div>
    <div class="row">
        <form method="post" name="employment" action="{{ url()->current() }}" enctype="multipart/form-data"
              class="needs-validation" novalidate>
        {!! csrf_field() !!}
        <div class="form-group">
            <div class="col-12">
                <h4>Faq Topic</h4>
                <input type="text" class="form-control"  placeholder="Topic" name="faq[faq_topic]"
                       value="{{ old('faq.faq_topic', $data['faq']->faq_topic)}}" size="80" required/>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="form-group">
            <div class="col-12 mt-3">
                <h4>Content</h4>
            </div>
            <div class="col-12">
                <div class="col-12 mb-4">
                    <div class=" col editor-container editor-container_classic-editor" id="editor-container">
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
                    var textarea1 = @json($data['textarea1'] ?? '');
                </script>
                <script type="module" src="{{mix('js/ckeditor5/ck_main_admin.js')}}"></script>
            </div>
        </div>
    </div>
    <div class="col-6">
        <h4>Live on website</h4>
        <label>
            <input name="faq[live]" type="hidden" value="0" />
            <input name="faq[live]" type="checkbox" value="1"
                {{ checked( old('faq.live', $data['faq']->live)) }} />
            Check now to make Live
        </label>
        <p>ie.: Draft or Published.</p>
    </div>
    <div class="col-6">
        <h4>Access Level for FAQ topic</h4>
        <div class="form-group">
            {{ select_options($data['access_levels'], old('faq.access_level',
                $data['faq']->access_level), ['name' => 'faq[access_level]',
                'class' => 'form-control']) }}
        </div>
    </div>
    <h4>
        @if($data['action'] == 'Update')
            {{count($data['faq']['faqs_data'])}}
        @endif
            FAQ Questions and Answers
    </h4>
                @if($data['action'] == 'Update')
                    <div class="row">
                        @foreach( $data['faq']['faqs_data'] as $fd )
                            <div class="col-12 border border-dark rounded p-2 m-2">
                                <input type="hidden" name="faq[faq_data][{{$fd->id}}][id]" value="{{$fd->id}}" />
                                <input type="hidden" name="faq[faq_data][{{$fd->id}}][faq_id]"
                                       value="{{$data['faq']->id}}" />
                                <div class="form-group">
                                    <div class="col-lg-2">
                                        <h4>Question</h4>
                                    </div>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control"  placeholder="Question"
                                               name="faq[faq_data][{{$fd->id}}][question]"
                                               value="{{ old('faq.faq_data.question', $fd->question)}}" size="80"
                                               required/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-2">
                                        <h4>Answer</h4>
                                    </div>
                                    <div class="col-lg-10">
                                        <textarea name="faq[faq_data][{{$fd->id}}][answer]" id="faq-faq_data-answer"
                                                  placeholder="Description content"
                                                  class="form-control">{{old('faq.faq_data.answer',
                                                  $fd->answer)}}
                                        </textarea>
                                    </div>
                                </div>
                                <div class="row mt-lg-2">
                                    <div class="col-2">
                                        <h4>Live with topic</h4>
                                    </div>
                                    <div class="col-sm">
                                        <label>
                                            <input name="faq[faq_data][{{$fd->id}}][live]" type="hidden" value="0" />
                                            <input name="faq[faq_data][{{$fd->id}}][live]" type="checkbox" value="1"
                                                {{ checked( old('faq.faq_data.live', $fd->live)) }} />
                                            Check now to make Live
                                        </label>
                                        <p>ie.: Draft or Published.</p>
                                    </div>
                                </div>
                                <div class="row mt-3 mb-2 pb-2 pt-2">
                                    <div class="col-12 col-md-4 text-md-right">
                                        <h4>Access Level for FAQ question & answer</h4>
                                    </div>
                                    <div class="col-12 col-md-5 text-left">
                                        <div class="form-group">
                                            {{ select_options($data['access_levels'], old('faq.faq_data.access_level',
                                                $fd->access_level), ['name' => 'faq[faq_data]['. $fd->id .'][access_level]',
                                                'class' => 'form-control']) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-12">
                                        <h4>Sort Order (largest number is first)</h4>
                                    </div>
                                    <div class="col-12">
                                        <input type="text" class="form-control"  placeholder="sort_order"
                                               name="faq[faq_data][{{$fd->id}}][sort_order]"
                                               value="{{ old('faq.faq_data.sort_order', $fd->sort_order) }}" size="80"
                                               required/>
                                    </div>
                                </div>
                                <div class="row mt-lg-2">
                                    <div class="input-group input-group-lg">
                                        <div class="col-12">
                                            <h4>Delete this question and answer</h4>
                                            <label>
                                                <input name="faq[faq_data][{{$fd->id}}][delete]" type="hidden"
                                                       value="0" />
                                                <input name="faq[faq_data][{{$fd->id}}][delete]" type="checkbox"
                                                       value="1" style="width: 2rem; height: 2rem;" />
                                                Check to delete, and update
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
                @if($data['action'] == "Create" || $data['faq']['faqs_data']->count() == 0)
                    <div class="row">
                        <div class="col-12 p-2">
                            No Questions and answers yet.
                        </div>
                    </div>
                @endif
            <!-- begin section to be generated -->
                <div class="row">
                    <div class="col-12">
                        <button class="btn btn-primary m-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample"
                                aria-expanded="false" aria-controls="collapseExample">
                            <i class="fa fa-plus"></i>
                            Add a question and answer
                        </button>
                        <div class="collapse" id="collapseExample">
                            <div class="card card-body">
                                <div class="form-group">
                                    <div class="col-lg-2">
                                        <h4>Question</h4>
                                    </div>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control"  placeholder="Question"
                                               name="new[question]"
                                               value="" size="80"
                                        />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-12">
                                        <h4>Answer</h4>
                                    </div>
                                    <div class="col-12">
                                    <textarea name="new[answer]" id="faq-faq_data-answer"
                                              placeholder="Answer content"
                                              class="form-control">
                                    </textarea>
                                    </div>
                                </div>
                                <div class="row mt-lg-2">
                                    <div class="col-12">
                                        <h4>Live with topic</h4>
                                    </div>
                                    <div class="col-12">
                                        <label>
                                            <input name="new[live]" type="hidden" value="0" />
                                            <input name="new[live]" type="checkbox" value="1"
                                            />
                                            Check now to make Live (ie.: Draft or Published).
                                        </label>
                                    </div>
                                </div>
                                <div class="row mt-3 mb-2 pb-2 pt-2">
                                    <div class="col-12 col-md-4 text-md-right">
                                        <h4>Access Level for FAQ question & answer</h4>
                                    </div>
                                    <div class="col-12 col-md-5 text-left">
                                        <div class="form-group">
                                            {{ select_options($data['access_levels'], old('faq.faq_data.access_level',
                                                'public'), ['name' => 'new[access_level]',
                                                'class' => 'form-control']) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-2">
                                        <h4>Sort Order</h4>
                                    </div>
                                    <div class="col-lg-10">
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
                <div class="row mt-lg-3">
                    <div class="col-sm">
                        <i class="fas fa-edit fa-2x"></i>
                        <input class="btn btn-outline-primary" type="submit" value="{{ $data['action'] }}" />
                    </div>
        </form>
        @if ($data['action'] == 'Update')
            <div class="col-sm" style="float:right">
                <form name="delete" method="POST" action="{{route('admin_faq_destroy')}}">
                    {!! csrf_field() !!}
                    {!! method_field('DELETE') !!}
                    <i class="far fa-trash-alt fa-2x"></i>
                    <input type="hidden" name="id[]" value="{{ $data['faq']->id }}">
                    <input class="btn btn-outline-danger" type="submit" value="Delete FAQ">
                </form>
            </div>
        @endif
        </div>
    </div>
</div>
@endsection
