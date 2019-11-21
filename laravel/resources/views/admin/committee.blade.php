<?php
$committee = $data['data']['committee'];

?>
@extends('layouts.dashboard',  ['title' => ' <i class="fas fa-edit"></i>' . $data["action"] . ' committee ' . ($data["action"] == 'Edit' ? $committee->name : '') ])
@section('content')
    <script>
        tinymce.init({
            selector: 'textarea#committee-description',
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
    <h3>  <a href="{{ route('committees_list') }}"> <i class="far fa-arrow-alt-circle-left"></i> List of committees</a>  </h3>
    <form method="post" name="committee" action="{{ url()->current() }}" enctype="multipart/form-data" class="needs-validation" novalidate>
        <input type="hidden" name="committee[id]" value="{{ $committee['id'] }}">
        <input type="hidden" name="committee[user_id]" value="{{ $committee['user_id'] }}">

        {!! csrf_field() !!}
        <div class="row" style="margin-top:30px;"> &nbsp;</div>
        <div class="row">
            <div class="form-group">
                <div class="col-lg-2"><h4>Name</h4></div>
                <div class="col-lg-10">
                    <input type="text" class="form-control"  placeholder="Name" name="committee[name]" value="{{ old('committee.name', $committee->name)}}" size="80" required/>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="form-group">
                <div class="col-lg-2">
                    <h4>Description</h4>
                </div>
                <div class="col-lg-10">
                    <textarea name="committee[description]" id="committee-description" placeholder="Summary content" class="form-control">{{old('committee.description', $committee->description)}}</textarea>
                </div>
            </div>
        </div>

        <div class="row" style="margin-top:30px;"> &nbsp;</div>

        <div class="row">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-6 col-sm-3 align-middle"><h4>Access Level</h4></div>
                    <div class="col-6 col-sm-3">
                        <input type="text" class="form-control"  placeholder="Access Level: public, members, executive" name="committee[access_level]" value="{{ old('committee.access_level', $committee->access_level)}}" size="30" required/>
                        <p>Access Level: public, members, executive</p>
                    </div>
                    <div class="col-6 col-sm-3"></div>
                    <div class="col-6 col-sm-3"></div>
                    <!-- Force next columns to break to new line -->
                    <div class="w-100"></div>
                    <div class="col-12">&nbsp;</div>
                    <div class="col-6 col-sm-3"><h4>Sort Order</h4></div>
                    <div class="col-6 col-sm-3">
                        <input type="text" class="form-control"  id="validationCustom02" placeholder="e.g.: 1000, 2000" name="committee[sort_order]" value="{{old('committee.sort_order',$committee->sort_order)}}" size="30" required/>
                        <p>e.g.: 1000, 2000</p>
                    </div>
                    <div class="invalid-feedback">
                        Please add a numeric sort order {{ @$errors->get('committee.sort_order')[0] }}
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="col-lg-2"><h4>Status</h4></div>
                <div class="col-sm">
                    <label>
                        <input name="committee[in_menu]" type="hidden" value="0" />
                        <input name="committee[in_menu]" type="checkbox" value="1" {{ checked(old('committee.in_menu',$committee->in_menu)) }} /> In Menu
                    </label>
                </div>
                <div class="col-sm">
                    <label>
                         <input name="committee[live]" type="hidden" value="0" />
                         <input name="committee[live]" type="checkbox" value="1" {{ checked( old('committee.live', $committee->live)) }} /> Check now to make Live
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
             <form name="delete" method="POST" action="{{route('committee_destroy')}}">
                 {!! csrf_field() !!}
                 {!! method_field('DELETE') !!}
                <i class="far fa-trash-alt fa-2x"></i>
                <input type="hidden" name="id[]" value="{{ $committee->id }}">
                <input class="btn btn-outline-danger" type="submit" value="Delete">
            </form>
         </div>
    @endif
    <div class="row" style="margin-top:100px;"> &nbsp;</div>
</div>
@endsection
