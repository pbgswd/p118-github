<?php
$attachment = $data['attachment'];
?>
@extends('layouts.dashboard',  ['title' => '<i class="fas fa-paperclip"></i> ' . $data['action'] . ' Attachement'])


@section('content')
<div class="container">
    <form method="post" name="attachment" action="{{ url()->current() }}" enctype="multipart/form-data" class="needs-validation" novalidate>
        <input type="hidden" name="attachment[id]" value="{{ $attachment['id'] }}">
        {!! csrf_field() !!}
        <div class="col-md-6">
            <div class="form-group">
                <label for="exampleInputFile">
                    <i class="fas fa-cloud-upload-alt fa-2x"></i>
                    File input
                </label>

                <input type="file" id="inputFile" name="images[]" multiple />
                <p class="help-block">
                    Upload image for attachment.
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-sm">
                <i class="fas fa-edit fa-2x"></i>
                <input class="btn btn-outline-primary" type="submit" value="{{ $data['action'] }}" />
            </div>
        </div>
    </form>
</div>
<div class="row" style="margin-top:30px;"> &nbsp;</div>
@endsection
