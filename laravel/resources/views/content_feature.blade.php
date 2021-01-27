<div class="row border border-dark rounded-lg my-3 py-1" style="background: rgba(220,220,220,0.8);">
    <div class="col col-md-3 pt-2">
        <div class="col col-12 border border-dark rounded-lg pt-3 pb-2 mb-2 bg-dark text-white">
            <h4> Menu </h4>
        </div>
        <div class="col-12 border border-dark rounded-lg mb-2">
            <a href="#search"><i class="fas fa-search"></i> Search</a>
        </div>
        <div class="col-12 border border-dark rounded-lg mb-2">
            <a href="{{route('members')}}"><i class="fas fa-user-friends"></i> Members</a>
        </div>
        <div class="col-12 border border-dark rounded-lg mb-2">
            <a href="{{route('jobs_list')}}"><i class="fas fa-hard-hat"></i> Jobs</a>
        </div>
        <div class="col-12 border border-dark rounded-lg mb-2">
            <a href="{{route('venues')}}"><i class="far fa-building"></i> Venues</a>
        </div>
        <div class="col-12 border border-dark rounded-lg mb-2">
            <a href="{{route('organizations')}}"><i class="fas fa-user-tie"></i> Organizations</a>
        </div>
        <div class="col-12 border border-dark rounded-lg mb-2">
            Governance
        </div>
        <div class="col-12 border border-dark rounded-lg mb-2">
            <a href="{{route('committees')}}"><i class="fas fa-users"></i> Committees</a>
        </div>
        <div class="col-12 border border-dark rounded-lg mb-2">
            <a href="{{route('executive')}}"><i class="fas fa-users"></i> Executive</a>
        </div>
        <div class="col-12 border border-dark rounded-lg mb-2">
            <a href="{{route('list_meetings')}}"><i class="far fa-folder"></i> Meetings & Minutes</a>
        </div>
        <div class="col-12 border border-dark rounded-lg mb-2">
            <a href="{{route('agreements_list_public')}}"><i class="far fa-handshake"></i> Agreements</a>
        </div>
        <div class="col-12 border border-dark rounded-lg mb-2">
            <a href="{{route('bylaws_list_public')}}"><i class="fas fa-gavel"></i> By-Laws</a>
        </div>
        <div class="col-12 border border-dark rounded-lg mb-2">
            <a href="{{route('policies_list_public')}}"><i class="fas fa-scroll"></i>  Policies</a>
        </div>
        <div class="col col-12 border border-dark rounded-lg pt-3 pb-2 mb-2 bg-dark text-white">
            <h4>
                <a class="text-white" href="{{route('topics')}}">Topics</a>
            </h4>
        </div>
        @foreach ($data['topics'] as $t)
            <div class="col-12 border border-dark rounded-lg pt-1 mb-2">
                <h5>
                    <a href="{{ route('topic_show', $t->slug) }}">{{ $t->name }}</a>
                </h5>
            </div>
        @endforeach
    </div>
    <div class="col col-md-9 pt-2">
        <div class="col col-12 border border-dark rounded-lg pt-2 pb-2 mb-2 bg-dark text-white">
            <h3>Important Announcements</h3>
        </div>
        <div class="col col-12 border border-dark rounded-lg bg-secondary pt-2 pb-2 mb-2">
            <h4>
                <a class="text-white" href="{{route('posts')}}">Posts</a>
            </h4>
        </div>
        @foreach ($data['posts'] as $post)
            <div class="col-12 border border-dark rounded-lg pt-2 mb-2">
                <h4>
                    <a href="{{ route('post_show', $post->slug) }}">
                        {{ $post->title }}
                    </a>
                </h4>
                {!! $post->description !!}
                <h6 class="font-weight-bold text-md-right">
                    {{$post->updated_at->format('F j Y')}}
                </h6>
            </div>
        @endforeach
        <div class="col col-12 border border-dark rounded-lg bg-secondary pt-2 pb-2 mb-2">
            <h4>
                <a class="text-white" href="{{route('pages')}}">Pages</a>
            </h4>
        </div>
        @foreach ($data['pages'] as $page)
            <div class="col-12 border border-dark rounded-lg pt-2 mb-2">
                <h4>
                    <a href="{{ route('page_show', $page->slug) }}">
                        {{ $page->title }}
                    </a>
                </h4>
            </div>
        @endforeach
    </div>
</div>
