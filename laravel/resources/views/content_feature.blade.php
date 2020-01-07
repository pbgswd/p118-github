<div class="col-12">
    <div class="col-md-3 border border-dark rounded-lg mt-3 mr-3">
        <h2>{{ $post->title }}</h2>
        <p>{!! $post->description !!} </p>
        {{$post->short_body}}
        <p>
            <a class="btn btn-secondary" href="{{ route('post_show', $post->slug) }}" role="button">View details &raquo;</a>
        </p>
    </div>
</div>

