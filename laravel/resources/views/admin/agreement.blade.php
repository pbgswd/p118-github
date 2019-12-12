<?php
//dd($data);
$agreement = $data['data']['agreement'];
?>
@extends('layouts.dashboard',  ['title' => ' <i class="fas fa-edit"></i>' . $data["action"] . ' agreement ' . ($data["action"] == 'Edit' ? $agreement->name : '') ])
@section('content')
    <script>
        tinymce.init({
            selector: 'textarea#agreement-description',
            height: 200,
            width:800,
            menubar: false,
            plugins: [
                'advlist autolink lists link image charmap print preview anchor textcolor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table paste code help wordcount'
            ],
            toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
            content_css: [
                '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
                '//www.tiny.cloud/css/codepen.min.css'
            ]
        });
    </script>
<div class="container">
    <h3>  <a href="{{ route('agreements_list') }}"> <i class="far fa-arrow-alt-circle-left"></i> List of agreements</a>  </h3>
    <form method="post" name="agreement" action="{{ url()->current() }}" enctype="multipart/form-data" class="needs-validation" novalidate>
        {!! csrf_field() !!}
        <div class="row" style="margin-top:30px;"> &nbsp;</div>
        <div class="row">
            <div class="form-group">
                <div class="col-lg-2"><h4>Name</h4></div>
                <div class="col-lg-10">
                    <input type="text" class="form-control"  placeholder="Name" name="agreement[name]" value="{{ old('agreement.name', $agreement->name)}}" size="80" required/>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <div class="col-lg-2">
                    <h4>Description</h4>
                </div>
                <div class="col-lg-10">
                    <textarea name="agreement[description]" id="agreement-description" placeholder="Summary content" class="form-control">{{old('agreement.description', $agreement->description)}}</textarea>
                </div>
            </div>
        </div>
        <div class="row" style="margin-top:30px;"> &nbsp;</div>
        <div class="row" style="margin-top:30px;">file upload</div>
        <div class="row" style="margin-top:30px;"> &nbsp;</div>
        <div class="row" style="margin-top:30px;"> Associate with which venue or organization?</div>
        <div class="row" style="margin-top:30px;"> &nbsp;</div>
        <div class="row">
            <div class="form-group">
                <div class="col-lg-8"><h4>agreement Website Link</h4></div>
                <div class="col-lg-10">
                    <input type="text" class="form-control"  placeholder="Website Address - http://...." name="agreement[url]" value="{{ old('agreement.url', $agreement->url)}}" size="80" />
                </div>
            </div>
        </div>
        <div class="row" style="margin-top:30px;"> &nbsp;</div>
        <div class="row">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-6 col-sm-3 align-middle"><h4>Access Level</h4></div>
                    <div class="col-6 col-sm-3">
                       <p>Access Level for content:</p>
                        <div class="form-group">
                            {{ select_options($data['access_levels'], old('agreement.access_level', $agreement->access_level), ['name' => 'agreement[access_level]', 'class' => 'form-control', 'placeholder' => 'Access Level']) }}
                        </div>
                    </div>
                    <div class="col-6 col-sm-3"></div>
                    <div class="col-6 col-sm-3"></div>
                    <!-- Force next columns to break to new line -->
                    <div class="w-100"></div>
                    <div class="col-12">&nbsp;</div>
                    <div class="col-6 col-sm-3"><h4>Sort Order</h4></div>
                    <div class="col-6 col-sm-3">
                        <input type="text" class="form-control"  id="validationCustom02" placeholder="e.g.: 1000, 2000" name="agreement[sort_order]" value="{{old('agreement.sort_order',$agreement->sort_order)}}" size="30" required/>
                        <p>e.g.: 1000, 2000</p>
                    </div>
                    <div class="invalid-feedback">
                        Please add a numeric sort order {{ @$errors->get('agreement.sort_order')[0] }}
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="col-lg-2"><h4>Status</h4></div>
                <div class="col-sm">
                    <label>
                         <input name="agreement[live]" type="hidden" value="0" />
                         <input name="agreement[live]" type="checkbox" value="1" {{ checked( old('agreement.live', $agreement->live)) }} /> Check now to make Live
                    </label>
                    <p>ie.: Draft or Published.</p>
                </div>
            </div>
        </div>
        <div class="row" style="margin-top:30px;"> &nbsp;</div>
        <div class="row">
            <div class="col-sm">
                <i class="fas fa-edit fa-2x"></i>
                <input class="btn btn-outline-primary" type="submit" value="{{ $data['action'] }}" />
            </div>
    </form>
    <div class="col-sm"> &nbsp;</div>
    @if ($data['action'] == 'Edit')
         <div class="col-sm" style="float:right">
             <form name="delete" method="POST" action="{{route('agreement_destroy')}}">
                 {!! csrf_field() !!}
                 {!! method_field('DELETE') !!}
                <i class="far fa-trash-alt fa-2x"></i>
                <input type="hidden" name="id[]" value="{{ $agreement->id }}">
                <input class="btn btn-outline-danger" type="submit" value="Delete">
            </form>
         </div>
    @endif
    <div class="row" style="margin-top:100px;"> &nbsp;</div>
</div>
@endsection
