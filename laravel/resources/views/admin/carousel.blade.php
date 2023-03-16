@extends('layouts.dashboard')
@section('content')
<div class="container">
    <div class="row border border-primary mb-3">
        <div class='col-6'>
            <h2>
                <a href="{{route('carousel.admin_carousel_list')}}">
                    Admin Carousel
                </a>
            </h2>
        </div>
        <div class='col-6 text-right'>
            <h5>
                <a href="{{route('carousel')}}">Website Carousel </a>
            </h5>
        </div>
    </div>
    <div class="row border border-primary">
        <div class='col-12'>
            <h2>Create new slide set
                <p>form etc</p>
        </div>
    </div>


</div>
@endsection
