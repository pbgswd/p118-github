@extends('layouts.dashboard')
@section('content')
<div class="container">
    <div class="row">
        <div class="jumbotron jumbotron-fluid">
            <div class="container">
                <h1 class="display-4">Front Page Carousel</h1>
                <h3>4 optimized images </h3>
                <p class="lead">
                    A carousel image requires four images, each for the different screen sizes of devices
                    (phones, laptops, etc). They dont need to be the same image,
                    but there needs to be four of them of the different sizes specified.
                </p>
                <p class="lead">
                    Use your image editor to optimize the image size for delivery over the web. Reduce the file
                    size as much as possible without causing lossiness (degradation).
                </p>
                <p class="lead">
                    When you are ready with your 4 optimized images, create your carousel.
                </p>
                <a href="{{route('admin_carousel_create')}}">
                    Create Carousel
                </a>
            </div>
        </div>
        @foreach($data['image_data'] as $imgData)
        <div class="col-6">
            <img src="/storage/public/{{$imgData['blank']}}" class="pb-2" />
            <h4> <i class="far fa-images"></i> {{$imgData['size']}}px file, under {{$imgData['filesize']}}kb</h4>
        </div>
        @endforeach
    </div>
    <div class="row border border-primary p-5">
        <div class='col-12'>
            <a class="btn btn-primary" role="button" href="{{route('admin_carousel_create')}}">
                Create new carousel</a>
        </div>
    </div>
@endsection
