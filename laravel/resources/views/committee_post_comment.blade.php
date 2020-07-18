@section('content')
@if($post->allow_comments == 1)
    <div class="row mt-3 p-2">
        <div class="col-6">
            <h5>
                <i class="far fa-comments"></i>
                {{count($data['committeepost']->post_comments)}} {{Str::plural('Comment', count($data['committeepost']->post_comments))}} for {{$post->title}}
            </h5>
            <a href="#comment" title="Go to add my comment">
                <i class="far fa-comment"></i> Add my comment to {{$post->title}}
            </a>
        </div>
    </div>
    <div class="row mt-3 p-4">
        @foreach($data['committeepost']->post_comments as $comment)
            <div class="col-12 border border-dark rounded mb-4">
                <div class="col-12 mb-2 mt-1">
                    <a title="{{$comment->comment_author->name}}" href="{{route('member', $comment->user_id)}}">
                        {{$comment->comment_author->name}}
                    </a>
                    {{ \Carbon\Carbon::parse($comment->created_at)->format(' F j, Y') }}
                </div>
                {!! $comment->content !!}
                <div class="col-12 mb-2 mt-1">
                    <a href="#" title="{{$post->slug}}/comment/{{$comment->id}}">
                        <i class="far fa-comment"></i> Add my comment to {{$post->title}}
                    </a>
                </div>
            </div>
        @endforeach
    </div>
    <a name="comment"></a>
    <form class="form-horizontal" role="form" action="{{ route('public_committee_post_comment', [$c->slug, $post->slug]) }}" method="post">
        {!! csrf_field() !!}
        <div class="row mt-lg-3 p-2">
            <div class="col-12 pb-lg-3">
                <div class="form-group">
                    <label for="content" class="control-label">
                        <h3><i class="far fa-comment"></i> Add my comment</h3>
                    </label>
                    <textarea name="comment[content]" class="form-control input-lg" rows="3" cols="100" placeholder="Your comments"></textarea>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-2">
            </div>
            <div class="col-4">
                <input class="btn btn-primary" type="submit" value="{{ $data['action'] }}" />
            </div>
            <div class="col-4">
                <button type="reset"
                        class="btn btn-outline-primary btn-reset"
                        name="Reset">
                    Reset
                </button>
            </div>
        </div>
    </form>
    </div>
@endif
@endsection

