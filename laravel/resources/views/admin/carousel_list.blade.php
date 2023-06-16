@extends('layouts.dashboard')
@section('content')
<div class="container">
    <div class="row">
        <div class="jumbotron jumbotron-fluid">
            <div class="container">
                <h1 class="display-4">Front Page Carousel</h1>
                <p class="lead">
                    A carousel image requires four images, each for the different screen sizes of devices
                    (phones, laptops, etc). They dont need to be the same image,
                    just that there needs to be four of them.
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
        <div class="col-6">
            <img src="/storage/public/qox20XLuDz6g6IAnUjisNQt8qQVOU9yJq0WqcAt5.png" class="pb-2" />
            <h4> <i class="far fa-images"></i> 2000 x 500px file, under 300kb</h4>
        </div>
        <div class="col-6">
            <img src="/storage/public/C8ik1J8OqDQqsfgGUw6vt4PFLx5ukhDnbgtHLdvp.png" class="pb-2" />
            <h4> <i class="far fa-images"></i> 1400 x 500px file, under 300kb</h4>
        </div>
        <div class="col-6">
            <img src="/storage/public/hEucTumAZtAu6TFPf95ASEKhb1ped3prLplCVl52.png" class="pb-2" />
            <h4> <i class="far fa-images"></i> 800 x 500px file, under 100kb</h4>
        </div>
        <div class="col-6">
            <img src="/storage/public/TVWxK0pdgrqpS3Ow54mk4ZvodhKDw77SYiBaL5f5.png" class="pb-2" />
            <h4> <i class="far fa-images"></i> 600 x 500px file, under 100kb</h4>
        </div>
    </div>
    <div class="row border border-primary p-5">
        <div class='col-12'>
            <a class="btn btn-primary" role="button" href="{{route('admin_carousel_create')}}">
                Create new carousel</a>
        </div>
    </div>
@endsection
