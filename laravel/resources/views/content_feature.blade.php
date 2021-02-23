<div class="row border border-dark rounded-lg my-3 py-1" style="background: rgba(220,220,220,0.8);">
    <div class="col col-md-3 pt-2">
        <div class="col-12 border border-dark rounded-lg mb-2 text-center">
            <h3>
                Hi {{$data['user']->name}}
            </h3>
            <a href="{{route('member', $data['user']->id)}}" title="My Profile">
                @if($data['user']->user_info->thumb != '')
                    <img src="{{asset('storage/users/'. $data['user']->user_info->thumb)}}"
                         class="img-fluid mb-2 rounded-circle"/>
                    <br />
                @endif
                <h5 class="font-weight-bolder">
                    <i class="fas fa-user"></i> View your profile.
                </h5>
            </a>
        </div>

        <div class="col col-12 border border-dark rounded-lg pt-1 mb-2 bg-dark text-white">
            <h5> Menu </h5>
        </div>
        <div class="col-12 border border-dark rounded-lg mb-2 bg-secondary font-weight-bold">
            <a href="https://login.callsteward.ca/" class="text-white font-weight-bold" target="_blank"
               title="Link to CallSteward">
                <i class="fas fa-headset"></i>
                Call Steward
                <i class="fas fa-headset"></i>
            </a>
        </div>
        <div class="col-12 border border-dark rounded-lg mb-2">
            <a href="{{route('members')}}"><i class="fas fa-user-friends"></i> Member List</a>
        </div>
        <div class="col-12 border border-dark rounded-lg mb-2">
            <a href="{{route('memoriam_list')}}"><i class="fas fa-heart"></i> In Memoriam</a>
        </div>
        <div class="col-12 border border-dark rounded-lg mb-2">
            <a href="{{route('jobs_list')}}"><i class="fas fa-hard-hat"></i> Job Postings</a>
        </div>
        <div class="col-12 border border-dark rounded-lg mb-2">
            <a href="{{route('venues')}}"><i class="far fa-building"></i> Venues</a>
        </div>
        <div class="col-12 border border-dark rounded-lg mb-2">
            <a href="{{route('organizations')}}"><i class="fas fa-user-tie"></i> Organizations</a>
        </div>
        <div class="col-12 border border-dark rounded-lg mb-2">
            <a href="{{route('committees')}}"><i class="fas fa-users"></i> Committees</a>
        </div>
        <div class="col-12 border border-dark rounded-lg mb-2">
            <a href="{{route('executive')}}"><i class="fas fa-users"></i> Executive</a>
        </div>
        <div class="col-12 border border-dark rounded-lg mb-2">
            <a href="{{route('list_meetings')}}"><i class="far fa-folder"></i> Meeting Minutes</a>
        </div>
        <div class="col-12 border border-dark rounded-lg mb-2">
            <a href="{{route('agreements_list_public')}}"><i class="far fa-handshake"></i> Collective Agreements</a>
        </div>
        <div class="col-12 border border-dark rounded-lg mb-2">
            <a href="{{route('bylaws_list_public')}}"><i class="fas fa-gavel"></i> Constitution & By-Laws</a>
        </div>
        <div class="col-12 border border-dark rounded-lg mb-2">
            <a href="{{route('policies_list_public')}}"><i class="fas fa-scroll"></i>  Policies</a>
        </div>
        <hr />
        @foreach ($data['topics'] as $t)
            <div class="col-12 border border-dark rounded-lg pt-1 mb-2">
                <h5>
                    <a href="{{ route('topic_show', $t->slug) }}">{{ $t->name }}</a>
                </h5>
            </div>
        @endforeach
    </div>
    <div class="col col-md-9 pt-2">
        <div class="col col-12 border border-dark rounded-lg pt-2 pb-2 mb-2 bg-dark">
            <h3>
                <a class="text-white" href="{{route('features')}}">
                    Feature News
                </a>
            </h3>
        </div>
        @forelse($data['features'] as $f)
            <div class="col-12 border border-dark rounded-lg pt-2 mb-2">
                @if($f->image)
                    <div class="col-12 text-center d-flex align-items-center justify-content-center mb-2">
                        <picture>
                            <source srcset="{{asset('storage/public/'. $f->image)}}"
                                    media="(min-width: 577px)">
                            <img srcset="{{asset('storage/public/'.$data['features']->tn_str.$f->image)}}"
                                 alt="{{$f->file_name}}"
                                 class="rounded img-fluid d-block">
                        </picture>
                    </div>
                @endif
                <h2 class="text-center">
                    <a class="text-secondary" href="{{route('feature', $f->slug)}}">
                        {{$f->title}}
                    </a>
                </h2>
                {!! $f->content !!}
            </div>
        @empty
        @endforelse
        <div class="col-12 border border-dark rounded-lg bg-secondary pt-2 mb-2">
            <h4>
                <a class="text-white" href="{{route('posts')}}">
                    Posts
                </a>
            </h4>
        </div>
        <div class="row mb-2">
            @foreach ($data['posts'] as $post)
                <div class="col-12 col-md-6 pt-1 pb-1">
                    <div class="border border-dark rounded-lg w-100 h-100 p-2">
                        <h6>
                            <i>
                                @foreach($post->topics as $pt)
                                    <a href="{{route('topic_show', $pt->slug)}}"
                                       title="{{$pt->name}}">
                                        {{$pt->name}}{{$loop->last ? '' : ','}}
                                    </a>
                                @endforeach
                            </i>
                        </h6>
                        <h5>
                            <a href="{{ route('post_show', $post->slug) }}">
                                {{ $post->title }}
                            </a>
                        </h5>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="col col-12 border border-dark rounded-lg bg-secondary pt-2 mb-2">
            <h4>
                <a class="text-white" href="{{route('pages')}}">
                    Pages
                </a>
            </h4>
        </div>
        <div class="row mb-2">
            @foreach ($data['pages'] as $page)
                <div class="col-12 col-md-6 pt-1 pb-1">
                    <div class="border border-dark rounded-lg w-100 h-100 p-2">
                        <h6>
                            <i>
                                @foreach($page->topics as $pt)
                                    <a href="{{route('topic_show', $pt->slug)}}"
                                        title="{{$pt->name}}">{{$pt->name}}{{$loop->last ? '' : ','}}
                                    </a>
                                @endforeach
                            </i>
                        </h6>
                        <h5>
                            <a href="{{route('page_show', $page->slug)}}">
                                {{ $page->title }}
                            </a>
                        </h5>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
