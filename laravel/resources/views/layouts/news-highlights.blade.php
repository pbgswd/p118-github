<div class="row border border-dark rounded-lg mt-2 pl-4 pt-2 mb-2">
    <h3>
        <a href="{{route('topic_show', 'news')}}" title="news and highlights">
            <i class="far fa-newspaper"></i> News & Highlights
        </a>
    </h3>
</div>
<div class="row mt-2 mb-lg-4">
    <div class="col-6 m-0" style="display: flex;">
        <div class="col-12 border border-dark rounded-lg pt-2 pb-3 flex-row">
            @if($data['news']['posts']->count() > 0)
                <h3>
                    <a href="{{route('posts')}}">Posts</a>
                </h3>
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
        </div>
    </div>
    <div class="col-6">
        <div class="col-12 border border-dark rounded-lg pt-2 pb- flex-row">
            @if($data['news']['pages']->count() > 0)
                <h3>
                    <a href="{{route('pages')}}">Pages</a>
                </h3>
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
    </div>
</div>
