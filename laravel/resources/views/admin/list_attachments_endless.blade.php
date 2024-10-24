@extends('layouts.dashboard',  ['title_icon' => '<i class="fas fa-paperclip"></i> <i class="far fa-image"></i>',
'title' => ' List Attachement endless'])
@section('content')

    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/intersect@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/@imacrayon/alpine-ajax@0.9.0/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.1/dist/cdn.min.js"></script>


<a href="https://alpine-ajax.js.org/examples/infinite-scroll/"
   target="_blank">https://alpine-ajax.js.org/examples/infinite-scroll/</a>
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
    <div id="pagination" x-init x-intersect="$ajax('/admin/attachments/endless/data?page=2', { target: 'records pagination' })">
    </div>
    <noscript>
        <div>Page 1 of 5</div>
        <div>
            <!-- Page 2 and up would have a "Previous" link like this -->
            <!-- <a href="/contacts?page=1"><span aria-hidden="true">← </span> Previous</a> -->
            < href="/admin/attachments/endless?page=2">Next<span aria-hidden="true"> →</span></div></noscript>
</table>
@endsection
