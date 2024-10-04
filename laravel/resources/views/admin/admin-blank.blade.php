@extends('layouts.dashboard',  ['title' => '<i class="fas fa-paint-brush"></i> Blank Page For Whatever'])
@section('content')
<script>
    console.log('inside admin-blank.blade the template file');
</script>
<div class="row my-5">
    <div class="col-12">
        <a href="{{ route('developer') }}">Resources Page</a> | <a href="{{ route('development') }}">Development Page</a>
    </div>
</div>




@endsection
