@extends('layouts.dashboard')
@section('content')
<script>
    console.log('inside admin-blank.blade the template file');
</script>

<div id="anotherapp">
    <form method="post" action="">
        My name: @{{ myName }} <br />
    <input v-model="someName" type="text" id="name" name="name"> (@{{ someName.length }} characters)
    <textarea v-model="deckDescription" id="description" name="description"></textarea>
    (@{{ 200 - deckDescription.length }} left)
        <button type="submit">Create</button>
    </form>
</div>

@can('edit articles')
    can edit articles
@endcan

<input type="date" id="pick-date" name="date" />
<div class="container mt-5">
    container 3
    <div class="row border border-primary">
        <div class='col-12'>
            x
        </div>
    </div>
</div>
@endsection
