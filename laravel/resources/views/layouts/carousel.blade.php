<link href="{{ mix('css/carousel.css') }}" rel="stylesheet">
<div id="carousel" class="carousel slide carousel-fade mb-3" data-ride="carousel" data-interval="6000">
    <ol class="carousel-indicators">
        @for($i = 0; $i < $data['count']; $i++ )
            <li data-target="#carousel" data-slide-to="{{$i}}" class="{{$i == 0 ? 'active' : ''}}"></li>
        @endfor
    </ol>
    <div class="carousel-inner" role="listbox">
        @foreach($data['carousel'] as $d)
            <div class="carousel-item @if ($loop->first) active @endif">
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
                         @endif
                    ">
                        <h2>
                            {{$d['caption']}}
                        </h2>
                        <p style="letter-spacing: .2rem;">
                            {{$d['caption2']}}
                        </p>
                    </div>
                </div>
            </div>
        @endforeach
        <!-- /.carousel-item -->
    </div>
    <!-- /.carousel-item -->

    <!-- /.carousel-inner -->
    <a class="carousel-control-prev" href="#carousel" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carousel" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>
<!-- /.carousel -->
