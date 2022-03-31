<div class="row">
    @forelse($data['news']['features'] as $f)
        <div class="col-12
        @if($loop->first && $loop->count % 2)
            col-md-12
        @else
            col-md-6
        @endif
        pt-2 mb-2">
            <div class="col h-100 w-100 border border-dark rounded-lg pt-2 mb-2">
                @if($f->image)
                    <div class="col text-center d-flex justify-content-center mb-2">
                        <picture>
                            <source srcset="{{asset('storage/public/'. $f->image)}}"
                                    media="(min-width: 577px)">
                            <img srcset="{{asset('storage/public/'.$data['news']['features']->tn_str.$f->image)}}"
                                 alt="{{$f->file_name}}"
                                 class="rounded img-fluid d-block w-75 mx-auto">
                        </picture>
                    </div>
                @endif
                <h2 class="text-center">
                    <a class="text-secondary" href="{{$f->url ?? '#'}}" title="{{$f->title}}">
                        {{$f->title}}
                    </a>
                </h2>
                {!! $f->content !!}
            </div>
        </div>
    @empty
    @endforelse
</div>
<div class="row">
    <div class="col-12 col-md-6 mb-2">
        <div class="col border border-dark rounded w-100 h-100">
            <ul class="list-group list-group-flush p-0 m-0">
                @forelse($data['news']['posts'] as $post)
                    <li class="list-group-item">
                        <a href="{{route('post_show', $post->slug)}}"
                           title="{{$post->title}}">
                            {{$post->title}}
                        </a>
                    </li>
                @empty
                    No posts yet
                @endforelse
            </ul>
        </div>
    </div>
    <div class="col-12 col-md-6 mt-md-0">
        <div class="col border border-dark rounded w-100 h-100">
            <ul class="list-group list-group-flush p-0 m-0">
                @forelse($data['news']['pages'] as $page)
                    <li class="list-group-item">
                        <a href="{{route('page_show', $page->slug)}}"
                           title="{{$page->title}}">
                            {{$page->title}}
                        </a>
                    </li>
                @empty
                    No pages yet
                @endforelse
            </ul>
        </div>
    </div>
</div>
