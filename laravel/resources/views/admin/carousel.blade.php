@extends('layouts.dashboard')
@section('content')
<div class="container-fluid">
    <div class="jumbotron jumbotron-fluid p-3 rounded">
        <h1 class="display-4">
            {{$data['action']}} Carousel
        </h1>
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
    <form method="post" name="carousel" action="{{ url()->current() }}"
          enctype="multipart/form-data" class="needs-validation" novalidate>
        {!! csrf_field() !!}
            <div class="form-group">
                <div class="col-2">
                    <h4>Caption</h4>
                </div>
                <div class="col-12">
                    <input type="text" class="form-control"
                           placeholder="Caption" name="carousel[caption]"
                           value="{{ old('carousel.caption', $data['carousel']->caption??'')}}" size="80" required/>
                </div>
                <p class="help-block">
                    <i>Primary text of caption.</i>
                </p>
            </div>
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
            <div class="col-12">
                <h3>Button, link, alignment</h3>
                <p class="help-block">
                    <i>Add this information for a button on the image to direct the visitor somewhere.</i>
                </p>
            </div>
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
            <div class="form-group">
                <div class="col-12">
                    <h4>Button color</h4>
                </div>
                <div class="col-12">
                    @if($data['action'] == 'Edit')
                        <button style="background-color: {{ $data['carousel']->color??''}}" class="btn m-2">
                            {{ $data['carousel']->color?? 'none'}}
                        </button>
                    @endif
                    <input type="text" class="form-control"
                           placeholder="color" name="carousel[color]"
                           value="{{ old('carousel.color', $data['carousel']->color??'' )}}" size="80" />
                    <p class="help-block">
                        <i>Color of button</i>
                    </p>
                </div>
            </div>
            <div class="form-group">
                <div class="col-12">
                    <h4>Alignment for the button</h4>
                </div>
                <div class="col-12">
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
            <div class="form-group">
                <div class="col-12"><h4>Photo Credit</h4></div>
                <div class="col-12">
                    <input type="text" class="form-control"
                           placeholder="Name for photo credit" name="carousel[credit]"
                           value="{{ old('carousel.credit', $data['carousel']->credit??'' )}}" size="80"/>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <h4>Check to make live.</h4>
                        <div class="form-group">
                    <input type="checkbox" class="form-control"
                             name="carousel[live]"
                           value="{{ old('carousel.live', $data['carousel']->live?? '1' )}}" required/>
                    <p class="help-block">
                        <i>All 4 images are required to go live</i>
                    </p>
                </div>
            </div>

            <div class="col">
                <h4>Order, number</h4>
                <div class="form-group">
                    <input type="text" class="form-control"
                           placeholder="order number, integer" name="carousel[order]"
                           value="{{ old('carousel.order', $data['carousel']->order??'' )}}" size="80" required/>
                    <p class="help-block">
                        <i>Up to 6 frames in the carousel can be live. </i>
                    </p>
                </div>
            </div>
        </div>
        @if($data['action'] == 'Edit')
            <div class="row mb-3">
                <div class="col-12 text-light bg-info pt-2 rounded">
                    <h4>
                        There are {{$data['count']}} of {{count($data['image_data'])}} images uploaded.
                        @if($data['count'] == count($data['image_data']))
                            You are ready to publish this carousel slide.
                        @else
                            You need to upload {{count($data['image_data']) - $data['count']}}
                            more image before publishing this carousel slide.
                        @endif
                    </h4>

                </div>
            </div>
        @endif
        @foreach($data['image_data'] as $imgData)
            <div class="row mb-3 p-1 pt-3 border border-1 border-primary rounded">
                <div class="col-12">
                    <h4>
                        <i class="far fa-images"></i>
                        {{$imgData['size']}} file, under {{$imgData['filesize']}}kb
                    </h4>
                </div>
                @if( !isset($data['carousel']['file_'.$imgData['width']]) )
                    <div class="col p-2">
                        <img src="/storage/public/{{$imgData['blank']}}" class="pb-2"/> <br />
                        <label for="exampleInputFile">
                            <i class="fas fa-cloud-upload-alt fa-2x"></i>
                            File input
                        </label>
                        <input type="file" id="inputFile" name="image_{{$imgData['size']}}" />
                        <p class="help-block">
                            <i>Help block. Info here for the kind of image.</i>
                        </p>
                    </div>
                @endif
                @if( isset($data['carousel']['file_'.$imgData['width']] ) )
                    <div class="col p-2">
                    <img src="{{asset('storage/'. $data['folder']
                                .'/'. $data['carousel']['file_'.$imgData['width']])}}"
                        media="(min-width: 577px)" />
                    <img src="{{asset('storage/'. $data['folder'] . "/" .
                        $data['tn_prefix'].$data['carousel']['file_'.$imgData['width']])}}"
                         class="rounded img-fluid mx-auto" />
                    <h5>
                        {{$data['carousel']['image_'.$imgData['width']]}} <br />
                        {{$data['carousel']['file_'.$imgData['width']]}} <br />
                      x  File Size: {{ $data['filesize'] ?? 'xxx'}}xx
                    </h5>
                    <p class="d-sm-block d-md-none">
                        <i>(Size is for full size image)</i>
                    </p>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <input name="carousel[delete_image]" type="checkbox" value="1" />
                            </div>
                        </div>
                        <input type="text" class="form-control" aria-label="Text input with checkbox"
                               value=" Check to delete image." size="40" readonly>
                    </div>
                    <input type="hidden" name="carousel[image_{{$imgData['size']}}]" value="" />
                    <input type="hidden" name="carousel[file_{{$imgData['size']}}]" value="" />
                </div>
                @endif
            </div>
        @endforeach
            <i class="fas fa-edit fa-2x"></i>
            <input class="btn btn-primary btn-lg" type="submit" value="Add images" />
    </form>
</div>
@endsection
