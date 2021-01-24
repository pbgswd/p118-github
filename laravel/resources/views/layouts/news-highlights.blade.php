<div class="col-12 border border-dark rounded-lg pl-4 pt-2 mb-2">
    <h2>
      News & Highlights
    </h2>

    @if($data['news']['posts']->count() > 0)
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
    @endif

    @if($data['news']['pages']->count() > 0)
        <ul class="list-group p-0 m-0">
            @forelse($data['news']['pages'] as $page)
                <li class="list-group-item pr-1 m-0">
                    <a href="{{route('page_show', $page->slug)}}"
                       title="{{$page->title}}">
                        {{$page->title}}
                    </a>
                    {{$page->created_at->format('M j Y')}}
                </li>
            @empty
                No pages yet
            @endforelse
        </ul>
    @endif
</div>
