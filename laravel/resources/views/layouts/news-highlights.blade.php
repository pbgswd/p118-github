<div class="row">
<div class="col-12 border border-dark rounded-lg pl-4 pt-2 mb-2 bg-secondary text-white">
    <h2>
      News & Highlights
    </h2>
</div>
</div>
<div class="row">
    <div class="col-12 col-md-6 w-100 h-100">
        <div class="col border border-dark rounded w-100 h-100">
            <ul class="list-group p-0 m-0">
                @forelse($data['news']['posts'] as $post)
                    <li class="list-group-item pr-1 m-0">
                        <a href="{{route('post_show', $post->slug)}}"
                           title="{{$post->title}}">
                            {{$post->title}}
                        </a>
                        {{$post->created_at->format('M j Y')}}
                    </li>
                @empty
                    No posts yet
                @endforelse
            </ul>
        </div>
     </div>
    <div class="col-12 col-md-6 w-100 h-100">
        <div class="col border border-dark rounded w-100 h-100">
            <ul class="list-group p-0 m-0">
                @forelse($data['news']['pages'] as $page)
                    <li class="list-group-item pr-1 m-0">
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
