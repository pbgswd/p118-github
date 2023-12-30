@extends('layouts.dashboard')
@section('content')
<div class="container-fluid">
    <div class="jumbotron jumbotron-fluid p-3 rounded">
        <h1 class="display-4">
            @if($data['action'] == 'Edit')
                <i class="far fa-edit"></i>
            @else
                <i class="fas fa-plus-square"></i>
            @endif
            {{$data['action']}} Carousel
        </h1>
        <ul>
            <li>A carousel image requires four images, each for the different screen sizes of devices
                (phones, laptops, etc).</li>
            <li>They dont need to be the same image,
                just that there needs to be four of them.</li>
            <li>Use your image editor to optimize the image size for delivery over the web. Reduce the file
                size as much as possible without causing lossiness (degradation).</li>
            <li> When you are ready with your 4 optimized images, create your carousel.</li>
            <li>Due to layout constraints, only a maximum of 6 carousels should be active.</li>
        </ul>
        <a class="btn btn-outline-info" href="{{route('admin_carousel_list')}}">
            Admin Carousel
        </a>
        @if($data['action'] == 'Edit')
            <a class="btn btn-outline-primary" href="{{route('admin_carousel_create')}}">
                <i class="fas fa-plus-square"></i> Create a new Carousel
            </a>
        @endif
        <p class="help-block mt-3">
            <i>Need help? Get in touch with the web help and he will be happy to help you out.</i>
        </p>
    </div>
    <form method="post" name="carousel" action="{{ url()->current() }}"
          enctype="multipart/form-data" class="needs-validation" novalidate>
        {!! csrf_field() !!}
        <div class="row border border-primary rounded p-3 mb-3">
            <div class="col-12">
                <div class="form-group">
                    <h4><i class="fas fa-comment mr-1"></i>Caption</h4>
                    <input type="text" class="form-control"
                           placeholder="Caption" name="carousel[caption]"
                           value="{{ old('carousel.caption', $data['carousel']->caption??'')}}" size="80" required/>
                </div>
                <p class="help-block">
                    <i>Primary text of caption.</i>
                </p>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <h4><i class="fas fa-comment mr-1"></i>Sub Caption</h4>
                    <input type="text" class="form-control"
                           placeholder="Sub Caption" name="carousel[caption2]"
                           value="{{ old('carousel.caption2', $data['carousel']->caption2??'')}}" size="80" />
                </div>
                <p class="help-block">
                    <i>Smaller text below caption (optional).</i>
                </p>
            </div>
        </div>
        <div class="row border border-primary rounded p-3 mb-3">
            <div class="col-12">
                <h3><i class="fas fa-align-justify mr-1"></i> Text Caption Alignment & Colour</h3>
                <p class="help-block">
                    <i>Make the caption work with the carousel image.</i>
                </p>
            </div>
            <div class="row">
                <div class="col-12 mb-4">
                    <h4>Alignment for the Captions</h4>
                    <div class="form-check form-check-inline">
                        <i class="fas fa-align-left mr-1"></i>
                        <input class="form-check-input" type="radio" name="carousel[align]" id="carouselalign1"
                               value="left" {{ old('carousel.align',
                                    $data['carousel']['align'] == 'left' ? 'checked' : '' )}}>
                        <label class="form-check-label" for="carouselalign1">Left</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <i class="fas fa-align-center mr-1"></i>
                        <input class="form-check-input" type="radio" name="carousel[align]" id="carouselalign2"
                               value="center" {{ old('carousel.align',
                                    $data['carousel']['align'] == 'center' ? 'checked' : '' )}}>
                        <label class="form-check-label" for="carouselalign2">Center</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <i class="fas fa-align-right mr-1"></i>
                        <input class="form-check-input" type="radio" name="carousel[align]" id="carouselalign3"
                               value="right" {{ old('carousel.align',
                                    $data['carousel']['align'] == 'right' ? 'checked' : '' )}}>
                        <label class="form-check-label" for="carouselalign3">Right</label>
                    </div>
                </div>
                <div class="col-12 mb-3">
                    <h4><i class="fas fa-palette mr-1"></i>Caption Text Colour</h4>
                    <label for="favcolor">Select Colour</label>
                    <input type="color" id="favcolor" name="carousel[text_color]"
                           value="{{ old('carousel.text_color', $data['carousel']->text_color??'' )}}"><br>
                    <div style="color: {{ old('carousel.text_color', $data['carousel']->text_color??'' )}}">
                        Current caption color: {{ old('carousel.text_color', $data['carousel']->text_color??'' )}}
                    </div>
                    @if($data['action'] == 'Edit')
                        <div style="color: {{ $data['carousel']->text_color??'' }};
                         @if($data['carousel']['text_outline_color'] !='')
                            text-shadow: -1px 1px 0 {{$data['carousel']['text_outline_color']}},
                                1px 1px 0 {{$data['carousel']['text_outline_color']}},
                                1px -1px 0 {{$data['carousel']['text_outline_color']}},
                                -1px -1px 0 {{$data['carousel']['text_outline_color']}};
                        @endif ">
                            <h2>{{$data['carousel']['caption']}}</h2>
                        </div>
                    @endif
                </div>

                <div class="col-12">
                    <div class="form-group">
                        <h4><i class="fas fa-palette mr-1"></i>Caption Text Outline Colour</h4>
                    <label for="favcolor">Select Colour</label>

                        <input type="color" id="favcolor" name="carousel[text_outline_color]"
                           value="{{ old('carousel.text_outline_color', $data['carousel']->text_outline_color??'' )}}">

                    <div class="bold" style="color: {{ $data['carousel']->text_outline_color??'' }};">
                        Current text outline color: {{ $data['carousel']->text_outline_color ?? 'none'}}
                    </div>
                        @if($data['action'] == 'Edit')
                            @if($data['carousel']->text_outline_color !='')
                                <div class="col-12">
                                    Unset outline colour
                                    <input type="checkbox" name="unset_outline_color" value="1" />
                                </div>
                            @endif

                            <div style="color: {{ $data['carousel']->text_color ?? ''}};">
                                {{$data['carousel']['caption2']}}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @if($data['action'] == 'Edit')
            <div class="row mb-3 mt-3">
                <div class="col-12 text-light bg-info pt-2 rounded">
                    <h4><i class="far fa-images"></i>
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
                        <i class="far fa-image"></i>
                        {{$imgData['size']}} file, under {{$imgData['filesize']}}kb
                    </h4>
                </div>
            @if( strlen(trim($data['carousel']['file_'.$imgData['width']])) == 0 )
                <div class="col p-2">
                    <img src="/storage/public/{{$imgData['blank']}}" class="pb-2"/> <br />
                    <label for="exampleInputFile">
                        <i class="fas fa-cloud-upload-alt fa-2x"></i>
                        File input
                    </label>
                    <input type="file" id="inputFile" name="file[image_{{$imgData['width']}}]" />
                    <p class="help-block">
                        <i>Help block. Info here for the kind of image. Upload a jpg or png file</i>
                    </p>
                </div>
            @elseif( strlen(trim($data['carousel']['file_'.$imgData['width']])) != 0 )
                <div class="col p-2">

<div class="img-fluid border border-primary p-3" style>
    <img src="{{asset('storage/'. $data['folder']
                         .'/'. $data['carousel']['file_'.$imgData['width']])}}"
         class="rounded img-fluid mx-auto" />

    <div class="text-{{$data['carousel']['align']}}"
         style="color: {{$data['carousel']['text_color']}};
                 @if($data['carousel']['text_outline_color'] !='')
                    text-shadow: -1px 1px 0 {{$data['carousel']['text_outline_color']}},
                        1px 1px 0 {{$data['carousel']['text_outline_color']}},
                        1px -1px 0 {{$data['carousel']['text_outline_color']}},
                        -1px -1px 0 {{$data['carousel']['text_outline_color']}};
                 @endif
        ">
        <h2>{{$data['carousel']['caption']}}</h2>
        <p style="letter-spacing: .2rem;">{{$data['carousel']['caption2']}}</p>
    </div>
</div>
                    <h5 class="mt-2">
                        <i class="far fa-image"></i>
                        {{$data['carousel']['image_'.$imgData['width']]}}
                    </h5>
                    <p class="d-sm-block d-md-none">
                        <i>(Size is for full size image)</i>
                    </p>
                    <div class="input-group">
                        <i class='far fa-trash-alt fa-2x m-1'></i>
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <input name="delete_image_{{$imgData['width']}}" type="checkbox" value="1" />
                            </div>
                        </div>
                        <input type="text" class="form-control" aria-label="Text input with checkbox"
                               value="Check to delete image." size="40" readonly>
                    </div>
                    <input type="hidden" name="carousel[image_{{$imgData['width']}}]"
                           value="{{$data['carousel']['image_'.$imgData['width']]}}" />
                    <input type="hidden" name="carousel[file_{{$imgData['width']}}]"
                           value="{{$data['carousel']['file_'.$imgData['width']]}}" />
                </div>
            @endif
        </div>
        @endforeach
    <div class="row">
        <div class="col-4">
            <h4>
                Check to make live. @if(old('carousel.live', $data['carousel']->live ?? '1'))Uncheck to hide. @endif
            </h4>
            @if($data['carousel']->live == '1') checked @endif
                <input type="checkbox" class="form-control" name="carousel[live]"
                       value="1"
                       @if(count($data['image_data']) > $data['count']) disabled @endif
                        @if($data['carousel']->live == '1') checked @endif
                />
                <p class="help-block">
                    @if(count($data['image_data']) > $data['count'])
                        <i>The Live checkbox will be disabled until the
                            {{count($data['image_data'])}} images have been uploaded.</i>
                    @else
                        <i>This carousel now has
                            {{count($data['image_data'])}} / {{$data['count']}} images.
                            @if($data['carousel']->live != '1')
                                Check the box and make it live.
                           @endif
                        </i>
                    @endif
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <i class="fas fa-edit fa-2x"></i>
                <input class="btn btn-primary btn-lg" type="submit" value="{{$data['action']}}" />
            </div>
    </form>
            @if($data['action'] == 'Edit')
                <div class="col">
                    <form name="delete" method="POST" action="{{route('admin_carousel_destroy')}}">
                        {!! csrf_field() !!}
                        {!! method_field('DELETE') !!}
                        <input type="hidden" name="id[]" value="{{$data['carousel']['id']}}">
                        <i class="far fa-trash-alt fa-2x"></i>
                        <input class="btn btn-outline-danger" type="submit" value="Delete">
                    </form>
                </div>
            @endif
    </div>
@endsection
