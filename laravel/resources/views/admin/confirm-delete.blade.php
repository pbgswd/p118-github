@extends('layouts.dashboard')
@section('content')
<div class="container">
    <h1 class="page-header">
        <i class="far fa-trash-alt fa-7x"></i> Confirm Deletion
    </h1>

        <div class="col-sm" style="float:right">
            <form method="post" name="topic" action="{{route('topic_destroy')}}"><i class="far fa-trash-alt fa-2x"></i>
                <input type="hidden" name="id[]" value="{{ $topic->id }}">

                <input class="btn btn-outline-danger" type="submit" value="Delete">
            </form>
        </div>
    </div>
    <div class="row" style="margin-top:30px;"> &nbsp;</div>
@endsection
