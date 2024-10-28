@extends('layouts.dashboard',  ['title_icon' => '<i class="fas fa-paperclip"></i> <i class="far fa-image"></i>',
'title' => ' List Attachement endless'])
@section('content')
    <h1 x-data="{ message: 'I ❤️ Alpine' }" x-text="message"></h1>
    <div>Page 1 of {{$data['pages']}}</div>

<a href="https://alpine-ajax.js.org/examples/infinite-scroll/" target="_blank">https://alpine-ajax.js.org/examples/infinite-scroll/</a>

<table class="table my-5">
    <thead>
        <tr>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
            <th scope="col">Status</th>
        </tr>
    </thead>
    <tbody id="records" x-merge="append">
    <tr>
        <td>AMO</td>
        <td>amo@mo.co</td>
        <td>Active</td>
    </tr>
    </tbody>


    <noscript>
        <div>Page 1 of {{$data['pages']}}</div>
        <div>
            <!-- Page 2 and up would have a "Previous" link like this -->
            <!-- <a href="/contacts?page=1"><span aria-hidden="true">← </span> Previous</a> -->
            <a href="/admin/attachments/endless?page=2">Next<span aria-hidden="true"> →</span></div>
    </noscript>
</table>
    <div id="pagination" x-init x-intersect="$ajax('/admin/attachments/endless/data?page=2', { target: 'records pagination' })">
    </div>
@endsection
