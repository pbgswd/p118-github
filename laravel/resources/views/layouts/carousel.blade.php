<link href="{{ mix('css/carousel.css') }}" rel="stylesheet">
<div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
    <div id="carouselExampleIndicators" class="carousel slide">
        <div class="carousel-indicators">
            @foreach($data['carousel'] as $d)
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="{{$loop->index}}"
                        @if ($loop->first) class="active" aria-current="true"
                        @else
                            data-bs-slide-to="{{$loop->iteration}}"
                        @endif
                        aria-label="Slide {{$loop->iteration}}"></button>
            @endforeach
        </div>
        <div id="carouselExampleFade" class="carousel slide carousel-fade" data-bs-ride="carousel">
            <div class="carousel-inner">
                @foreach($data['carousel'] as $d)
                    <div class="carousel-item @if ($loop->first) active @endif" data-bs-interval="4000">
                        <picture>
                            <source srcset="{{asset('storage/carousel/'.$d['file_2000'])}}" media="(min-width: 1400px)">
                            <source srcset="{{asset('storage/carousel/'.$d['file_1400'])}}" media="(min-width: 769px)">
                            <source srcset="{{asset('storage/carousel/'.$d['file_800'])}}" media="(min-width: 577px)">
                            <img srcset="{{asset('storage/carousel/'.$d['file_600'])}}" alt="{{$d['caption']}}"
                                 class="d-block img-fluid">
                        </picture>
                        <div class="carousel-caption">
                            <div class="text-{{$d['align']}}"
                                 style="color: {{$d['text_color']}};
                                 @if($d['text_outline_color'] !='')
                                    text-shadow: -1px 1px 0 {{$d['text_outline_color']}},
                                        1px 1px 0 {{$d['text_outline_color']}},
                                        1px -1px 0 {{$d['text_outline_color']}},
                                        -1px -1px 0 {{$d['text_outline_color']}};
                                        text-align: {{$d['align']}};
                                 @endif
                            ">
                                <h2>{{$d['caption']}}</h2>
                                <p style="letter-spacing: .2rem;">{{$d['caption2']}}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </div>
</div>
