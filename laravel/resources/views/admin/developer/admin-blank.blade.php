@extends('layouts.dashboard',  ['title_icon' => '<i class="fas fa-paint-brush"></i>', 'title' => 'Blank Page For Whatever'])
@section('content')
<script>
    console.log('inside admin-blank.blade the template file');
</script>
<div class="row my-5">
    <div class="col-12">
        <a href="{{ route('developer') }}">Resources Page</a> | <a href="{{ route('blank') }}">Development Page</a>
    </div>
</div>
<div class="row">
    <div class="col-12">
    </div>
</div>
<div class="row">
    <div class="col-12">
    </div>
</div>
<div class="row">
    <div class="col-12">
    </div>
</div>
<div class="row">
    <div class="col-12">
    </div>
</div>
<div class="row">
    <div class="col-12">
    </div>
</div>
<div class="row">
    <div class="col-12">
    </div>
</div>
<div class="row">
    <div class="col-12">
    </div>
</div>
<div class="row">
    <div class="col-12">
    </div>
</div>
@endsection
