@extends('layouts.dashboard',  ['title' => ' <i class="fas fa-edit"></i>' . $data["action"] . ' Feature ' .
    ($data["action"] == 'Edit' ? $data['feature']->title : '') ])
@section('content')
@include('admin.admin_partials.admin_tinymce')
<div class="container">
    <div class="row">
        <div class="col-12 col-md-6">
            <h3>
                <a href="{{route('admin_features_list')}}">
                    <i class="far fa-arrow-alt-circle-left"></i>
                    List Features
                </a>
            </h3>
        </div>
        @if ($data['action'] == 'Edit')
            <div class="col-12 col-md-6 text-md-right">
                <a href="{{route('feature', $data['feature']->slug)}}"
                   title="View {{$data['feature']->title}}">
                    <i class="fas fa-eye"></i> View on website
                </a>
            </div>
        @endif
    </div>
    <form method="post" name="page" action="{{ url()->current() }}" enctype="multipart/form-data"
          class="needs-validation" novalidate>
        {!! csrf_field() !!}
        <div class="row">
            <div class="form-group">
                <div class="col-12">
                    <h4>Title</h4>
                </div>
                <div class="col-12">
                    <input type="text" class="form-control"  placeholder="Title" name="feature[title]"
                           value="{{ old('feature.title', $data['feature']->title)}}" size="80" required/>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="form-group">
                <div class="col-12">
                    <h4>
                        URL Link for Title (optional, relative or absolute link)
                    </h4>
                </div>
                <div class="col-12">
                    <input type="text" class="form-control"  placeholder="url" name="feature[url]"
                           value="{{ old('feature.url', $data['feature']->url)}}" size="80"/>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="form-group">
                <div class="col-lg-2">
                    <h4>Content</h4>
                </div>
                <div class="col-lg-10">
                <textarea name="feature[content]" id="page-content" placeholder="Content" class="form-control">
                    {{old('feature.content', $data['feature']->content)}}
                </textarea>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-6">
                <div class="form-group">
                    <h4>Publish Date</h4>
                    <input
                        type="text"
                        class="form-control"
                        placeholder="YYYY-MM-DD"
                        name="feature[date]"
                        value="{{old('feature.date', \optional($data['feature']->date)->toDateString())}}"
                        size="10"
                        data-provide="datepicker"
                        data-date-format="yyyy-mm-dd"
                        required />
                </div>
            </div>
        </div>
        <div class="row mt-3 mb-2 pb-2 pt-2">
            <div class="col-12 col-md-4 text-md-right">
                <h4>Access Level for content</h4>
            </div>
            <div class="col-12 col-md-5 text-left">
                <div class="form-group">
                    {{ select_options($data['access_levels'], old('feature.access_level',
                        $data['feature']->access_level), ['name' => 'feature[access_level]',
                        'class' => 'form-control']) }}
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-12">
                <h4>Status</h4>
            </div>
            <div class="p-2">
                <label>
                    <input name="feature[front_page]" type="hidden" value="0" />
                    <input name="feature[front_page]" type="checkbox" value="1"
                        {{ checked(old('feature.front_page',$data['feature']->front_page)) }} />
                    Front Page
                </label>
            </div>
            <div class="p-2">
                <label>
                    <input name="feature[landing_page]" type="hidden" value="0" />
                    <input name="feature[landing_page]" type="checkbox" value="1"
                        {{ checked(old('feature.landing_page', $data['feature']->landing_page)) }} />
                    Landing Page
                </label>
            </div>
            <div class="col-12">
                <label>
                    <input name="feature[live]" type="hidden" value="0" />
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <input name="feature[live]" type="checkbox" value="1"
                                {{ checked( old('feature.live', $data['feature']->live)) }} />
                        </div>
                        <input type="text" class="form-control" aria-label="Text input with checkbox"
                               value="Check to make feature live." size="40" readonly>
                    </div>
                </label>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12">
                <div class="form-group">
                    @if(!isset($data['feature']->image))
                        <label for="exampleInputFile">
                            <i class="far fa-file-image fa-2x"></i>
                            <i class="fas fa-cloud-upload-alt fa-2x"></i>
                            Add Primary Image To Feature
                        </label>
                        <input type="file" id="inputFile" name="image" />
                    @else
                        <img src="{{ asset('storage/public/'. $data['feature']->image)}}"
                            class="rounded img-fluid" /><br />
                        {{$data['feature']->filesize}}<br />
                        <img src="{{ asset('storage/public/'. $data['feature']->thumb) }}"
                             class="rounded img-fluid" /><br />
                        {{$data['feature']->thumb_size}} (thumbnail)<br />
                        <input type="hidden" name="feature[image]" value="{{$data['feature']->image}}" />
                        <input type="hidden" name="feature[file_name]" value="{{$data['feature']->file_name}}" />
                        <h5>
                            {{$data['filesize'] ?? ''}}
                        </h5>
                        <label for="exampleInputFile">
                            <i class="far fa-trash-alt"></i>
                            Delete Image
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <input name="delete_image" type="checkbox" value="1" />
                                </div>
                                <input type="text" class="form-control" aria-label="Text input with checkbox"
                                       value="Check to delete image." size="40" readonly>
                            </div>

                        </label>
                    @endif
                </div>
            </div>
        </div>
<!---
        <div class="row mt-lg-3">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="exampleInputFile">
                        <i class="fas fa-cloud-upload-alt fa-2x"></i>
                        Add Attachment files
                    </label>
                    <input type="file" id="inputFile" name="attachments[]" multiple />
                </div>
            </div>
        </div>
-->
        <div class="row mt-3 pt-5">
            <div class="col-6">
                <i class="fas fa-edit fa-2x"></i>
                <input class="btn btn-outline-primary" type="submit" value="{{ $data['action'] }}" />
            </div>
    </form>
            @if ($data['action'] == 'Edit')
                <div class="col-6 text-md-right">
                    <form name="delete" method="POST" action="{{route('admin_feature_destroy')}}">
                        {!! csrf_field() !!}
                        {!! method_field('DELETE') !!}
                        <i class="far fa-trash-alt fa-2x"></i>
                        <input type="hidden" name="id[]" value="{{ $data['feature']->id }}">
                        <input class="btn btn-outline-danger" type="submit" value="Delete">
                    </form>
                </div>
            @endif
        </div>
</div>
@endsection
