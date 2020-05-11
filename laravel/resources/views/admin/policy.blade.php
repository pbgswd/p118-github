<?php
$policy = $data['policy'];
?>
@extends('layouts.dashboard',  ['title' => ' <i class="fas fa-gavel"></i> <i class="fas fa-edit"></i>' . $data["action"] . ' Policy ' . ($data["action"] == 'Edit' ? $policy->name : '') ])
@section('content')
<script>
    tinymce.init({
        selector: 'textarea#policy-description',
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
    <h3>  <a href="{{ route('policies_list') }}"> <i class="far fa-arrow-alt-circle-left"></i> List of Policies</a>  </h3>
    <form method="post" name="policy" action="{{ url()->current() }}" enctype="multipart/form-data" class="needs-validation" novalidate>
        {!! csrf_field() !!}
        <div class="row mt-lg-3">
            <div class="form-group">
                <div class="col-lg-2"><h4>Title</h4></div>
                <div class="col-lg-10">
                    <input type="text" class="form-control"  placeholder="Title" name="policy[title]" value="{{ old('policy.title', $policy->title)}}" size="80" required/>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <div class="col-lg-2">
                    <h4>Description</h4>
                </div>
                <div class="col-lg-10">
                    <textarea name="policy[description]" id="policy-description" placeholder="Information about the policy, or pasted from the pdf." class="form-control">{{old('policy.description', $policy->description)}}</textarea>
                </div>
            </div>
        </div>
        <div class="row mt-lg-3">
            <div class="col-md-6">
                <div class="form-group">
                    <h4>Start Date of policy</h4>
                        <input
                            type="text"
                            class="form-control"
                            placeholder="YYYY-MM-DD"
                            name="policy[date]"
                            value="{{ old('policy.date', \optional($policy->date)->toDateString())}}"
                            size="10"
                            data-provide="datepicker"
                            data-date-format="yyyy-mm-dd"
                            required />
                </div>
            </div>
        </div>
        <div class="row mt-lg-3">
            <div class="col-md-4">
                <div class="col-lg-2"><h4>Status</h4></div>
                <div class="col-sm">
                    <label>
                         <input name="policy[live]" type="hidden" value="0" />
                         <input name="policy[live]" type="checkbox" value="1" {{ checked( old('policy.live', $policy->live)) }} /> Check now to make Live
                    </label>
                    <p>ie.: Draft or Published.</p>
                </div>
            </div>
        </div>
        <div class="row mt-lg-3">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="exampleInputFile">
                        <i class="fas fa-cloud-upload-alt fa-2x"></i>
                        Add File(s) To policy
                    </label>
                    <input type="file" id="inputFile" name="attachments[]" multiple />
                </div>
            </div>
        </div>
        <div class="row mt-lg-3">
            @if ($data['action'] == 'Edit')
                @if(count($policy->attachments) > 0)
                    <div class="col-md-12">
                        <h2>Files</h2>
                        <table class="table table-striped table-sm">
                            <thead>
                            <tr>
                                <th> # </th>
                                <th> File </th>
                                <th> Access Level </th>
                                <th> <i class="far fa-edit"></i></th>
                                <th> Description </th>
                                <th> Created At </th>
                                <th> Updated At </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($policy->attachments as $policy_attachment)
                                <tr>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="attachment[{{$policy_attachment->id}}][id]" value="{{$policy_attachment->id}}" />
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="{{route('attachment_download', [$policy->getAttachmentFolder(), $policy_attachment->id])}}" title="Download {{$policy_attachment->file_name}}">{{$policy_attachment->file_name}}</a>
                                    </td>
                                    <td>{{$policy_attachment->access_level}}</td>
                                    <td>
                                        <a title="Edit page for {{ $policy_attachment->file_name }}" href="{{ route('admin_attachment_edit', $policy_attachment->id) }}"><i class="far fa-edit"></i></a>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control"  placeholder="Add a description for this file" name="attachment[{{$policy_attachment->id}}][description]" value="{{ old('attachments.description', $policy_attachment->description)}}" size="40"/>
                                    </td>
                                    <td>
                                        {{$policy_attachment->created_at}}
                                    </td>
                                    <td>
                                        {{$policy_attachment->updated_at}}
                                    </td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="5">
                                    <i class="far fa-trash-alt"></i> Select checkbox to delete a file
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                @endif
            @endif
        </div>
        <div class="row mb-lg-5">
            <div class="col-sm">
                <i class="fas fa-edit fa-2x"></i>
                <input class="btn btn-outline-primary" type="submit" value="{{ $data['action'] }}" />
            </div>
    </form>
            <div class="col-sm"> &nbsp;</div>
            @if ($data['action'] == 'Edit')
                 <div class="col-sm" style="float:right">
                     <form name="delete" method="POST" action="{{route('admin_policy_destroy')}}">
                         {!! csrf_field() !!}
                         {!! method_field('DELETE') !!}
                        <i class="far fa-trash-alt fa-2x"></i>
                        <input type="hidden" name="id[]" value="{{ $policy->id }}">
                        <input class="btn btn-outline-danger" type="submit" value="Delete">
                    </form>
                 </div>
            @endif
        </div>
</div>
@endsection
