@extends('layouts.dashboard',  ['title_icon' => '<i class="fas fa-paint-brush"></i>', 'title' => 'Page For Development'])
@section('content')
<script>
    console.log('inside admin-development.blade the template file');
</script>

<div class="row my-5">
    <div class="col-12">
        <a href="{{ route('blank') }}">Blank Page</a> | <a href="{{ route('developer') }}">Resources Page</a>
    </div>
</div>
<div class="row mb-6">


</div>

<div class="row border rounded mt-6 mb-3 p-3">
    <div class="col-12">
        <h2>Todo: dev page</h2>
    </div>
    <div class="col-12">
 aa
    </div>
    <div class="col-12">
 xx
    </div>
</div>
@endsection
