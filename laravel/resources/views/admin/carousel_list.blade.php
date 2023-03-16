@extends('layouts.dashboard')
@section('content')
<div class="container">
    <div class="row border border-primary">
        <div class='col-4'>
            <h2>List of slide sets</h2>
        </div>
        <div class='col-4'>
            <h2>
               <a href="{{route('admin_carousel_list')}}"> Create Carousel Slide</a>
            </h2>
            <p>
                You will require 4 images
            </p>
        </div>
        <div class='col-4 text-right'>
            <h5>
                <a href="{{route('admin_carousel_list')}}">Website Carousel </a>
            </h5>
        </div>
    </div>
    <div class="row border border-primary">
        <div class='col-12'>
            <h2>Create new slide set</h2>
            form etc
        </div>
    </div>
</div>
@endsection
