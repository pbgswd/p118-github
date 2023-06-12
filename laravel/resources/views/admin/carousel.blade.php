@extends('layouts.dashboard')
@section('content')
<div class="container">

    <div class="jumbotron jumbotron-fluid">
        <div class="container">
            <h1 class="display-4">Carousel</h1>
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

            <a href="{{route('admin_carousel_list')}}">
                Admin Carousel
            </a>
        </div>
    </div>


    <form method="post" name="carousel" action="{{ url()->current() }}"
          enctype="multipart/form-data" class="needs-validation" novalidate>
        {!! csrf_field() !!}
        <div class="row mt-lg-3">
            <div class="form-group">
                <div class="col-lg-2"><h4>Caption</h4></div>
                <div class="col-lg-10">
                    <input type="text" class="form-control"
                           placeholder="Caption" name="carousel[caption]"
                           value="{{ old('carousel.caption', $data['carousel']->caption??'')}}" size="80" required/>
                </div>
                <p class="help-block">
                    <i>Primary text of caption.</i>
                </p>
            </div>
        </div>
        <div class="row mt-lg-3">
            <div class="form-group">
                <div class="col-12">
                    <h4>Sub Caption</h4>
                </div>
                <div class="col-12">
                    <input type="text" class="form-control"
                           placeholder="Sub Caption" name="carousel[caption2]"
                           value="{{ old('carousel.caption2', $data['carousel']->caption2??'')}}" size="80" />
                </div>
                <p class="help-block">
                    <i>Smaller text below caption (optional).</i>
                </p>
            </div>
        </div>
        <div class="row mt-lg-3">
            <div class="col-12">
                <h3>Button, link, alignment</h3>
                <p class="help-block">
                    <i>Add this information for a button on the image to direct the visitor somewhere.</i>
                </p>
            </div>
        </div>

        <div class="row mt-lg-3 border border-info rounded">
            <div class="form-group">
                <div class="col-lg-12">
                    <h4>Show the button, yes no</h4>
                </div>
                <div class="col-12">
                           value={{ old('carousel.button', $data['carousel']->button??'' )}} <br />

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="carousel[button]" id="carouselbutton1"
                               value="1" checked>
                        <label class="form-check-label" for="carouselalign1">Show (default)</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="carousel[button]" id="carouselbutton2"
                               value="0">
                        <label class="form-check-label" for="carouselalign1">Hide it</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-lg-3  border border-info rounded">
            <div class="form-group">
                <div class="col-12">
                    <h4>Link</h4>
                </div>
                <div class="col-12">
                    <input type="text" class="form-control"
                           placeholder="Title" name="carousel[link]"
                           value="{{ old('carousel.link', $data['carousel']->link??'' )}}" size="80" />
                    <p class="help-block">
                        <i>Full link to the web page the button takes you to.</i>
                    </p>
                </div>
            </div>
        </div>

        <div class="row mt-lg-3  border border-info rounded">
            <div class="form-group">
                <div class="col-12">
                    <h4>Button color</h4>
                </div>
                <div class="col-12">
                    <input type="text" class="form-control"
                           placeholder="color" name="carousel[color]"
                           value="{{ old('carousel.color', $data['carousel']->color??'' )}}" size="80" />
                    <p class="help-block">
                        <i>Color of button</i>
                    </p>
                </div>
            </div>
        </div>

        <div class="row mt-lg-3  border border-info rounded">
            <div class="form-group">
                <div class="col-12">
                    <h4>Alignment for the button</h4>
                </div>
                <div class="col-lg-12">
                           value= {{ old('carousel.align', $data['carousel']->align??'' )}} <br />
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="carousel[align]" id="carouselalign1"
                               value="left" checked>
                        <label class="form-check-label" for="carouselalign1">Left (default)</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="carousel[align]" id="carouselalign2"
                               value="center">
                        <label class="form-check-label" for="carouselalign2">Center</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="carousel[align]" id="carouselalign3"
                               value="right">
                        <label class="form-check-label" for="carouselalign3">Right</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-lg-3">
            <div class="form-group">
                <div class="col-lg-12"><h4>Photo Credit</h4></div>
                <div class="col-lg-12">
                    <input type="text" class="form-control"
                           placeholder="Name for photo credit" name="carousel[credit]"
                           value="{{ old('carousel.credit', $data['carousel']->credit??'' )}}" size="80"/>
                </div>
            </div>
        </div>
        <div class="row mt-lg-3">
            <div class="form-group">
                <div class="col-lg-12"><h4>Check to make live.</h4></div>
                <div class="col-lg-12">
                    <input type="checkbox" class="form-control"
                             name="carousel[live]"
                           value="{{ old('carousel.live', $data['carousel']->live?? '1' )}}" required/>
                    <p class="help-block">
                        <i>All 4 images are required to go live</i>
                    </p>
                </div>
            </div>
        </div>

        <div class="row mt-lg-3">
            <div class="form-group">
                <div class="col-lg-12">
                    <h4>Order, number</h4>
                </div>
                <div class="col-lg-12">
                    <input type="text" class="form-control"
                           placeholder="order number, integer" name="carousel[order]"
                           value="{{ old('carousel.order', $data['carousel']->order??'' )}}" size="80" required/>
                    <p class="help-block">
                        <i>Up to 6 frames in the carousel can be live. </i>
                    </p>
                </div>
            </div>
        </div>
        <div class="row border border-3 rounded">
            @if( isset($data['carousel']->file_2000) )
                <div class="row mb-3">
                    <div class="col-12 mt-5 text-center">
                        <h4>
                            <i class="far fa-images"></i>
                            {{ $data['carousel']->file_2000 }}
                        </h4>
                        <p class="d-sm-block d-md-none">
                            <i>(Thumbnail for mobile view)</i>
                        </p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-12 col-md-6 text-center d-flex align-items-center justify-content-center">
                        <picture>
                            <source srcset="{{asset('storage/'. $data['folder'] .'/'. $data['carousel']->file_2000)}}"
                                    media="(min-width: 577px)">
                            <img srcset="{{asset('storage/'. $data['folder'] . "/" .
                                $data['tn_prefix'].$data['carousel']->file_2000)}}"
                                alt="{{$data['carousel']->file_2000}}"
                                class="rounded img-fluid mx-auto">
                        </picture>
                    </div>
                </div>
                <div class="col-12 text-center">
                    <input type="hidden" name="carousel[image_2000]" value="{{$data['carousel']->image_2000}}" />
                    <input type="hidden" name="carousel[file_2000]" value="{{$data['carousel']->file_2000}}" />
                    <h5>
                        {{"File Size: " . $data['filesize'] ?? ''}}
                    </h5>
                    <p class="d-sm-block d-md-none">
                        <i>(Size is for full size image)</i>
                    </p>
                </div>
                <div class="input-group mb-6">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <input name="carousel[delete_image]" type="checkbox" value="1" />
                        </div>
                    </div>
                    <input type="text" class="form-control" aria-label="Text input with checkbox"
                           value=" Check to delete image." size="40" readonly>
                </div>
            @else
                <div class="form-group m-3">

                    <img src="/storage/public/qox20XLuDz6g6IAnUjisNQt8qQVOU9yJq0WqcAt5.png" class="pb-2"/>
                    <h4> <i class="far fa-images"></i> 2000 x 500 file, under 300kb</h4>
                    <label for="exampleInputFile">
                        <i class="fas fa-cloud-upload-alt fa-2x"></i>
                        File input
                    </label>
                    <input type="file" id="inputFile" name="image" />
                    <p class="help-block">
                        <i>Help block. Info here for the kind of image.</i>
                    </p>
                </div>
            @endif
        </div>
        <div class="row mt-2">
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
        <div class="row pt-5 pl-2 m-2">
            <i class="fas fa-edit fa-2x"></i>
            <input class="btn btn-primary btn-lg" type="submit" value="Add images" />
        </div>
    </form>
</div>
@endsection
