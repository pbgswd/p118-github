@extends('layouts.jumbo')
@include('layouts.carousel')
@section('content')
    <div class="container">
    <div class="row">
        <div class="col-12 mt-0 mb-3">
            <img src="/storage/public/64tsEl26mhTFapH4Rco0QidSjj5yMx9s0cJfePq8.png"
                 style="padding:1em; display: block; margin-left: auto; margin-right: auto;" alt="{{env('APP_NAME')}}"  class="border border-dark rounded img-fluid rounded"/>
        </div>
    </div>

    @include('layouts.history-statement')
    @include('layouts.news-highlights')
</div>
@endsection
