@extends('layouts.dashboard')
@section('content')
<script>
    console.log('inside admin-blank.blade the template file');
</script>

<div class="mt-6 mb-6"><h1>Blank Page</h1></div>

<div class="mt-6 pt-6" id="anotherapp">
    <form method="post" action="">
    <textarea v-model="deckDescription" id="description" name="description" class="m-3"></textarea>
        <button type="button" class="btn btn-primary m-2">Create</button>
    </form>
</div>
@endsection
