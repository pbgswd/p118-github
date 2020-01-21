<div class="row">
    @foreach ($posts as $post)
    <div class="col-md-6 border border-dark rounded-lg mt-3 mr-3" style="background: rgba(220,220,220,0.6);">
        <h2>{{ $post->title }}</h2>
        <p>{!! $post->description !!} </p>
        {!!  substr($post->content, 0, 60)  !!}
        <p>
            <a class="btn btn-secondary" href="{{ route('post_show', $post->slug) }}" role="button">View details &raquo;</a>
        </p>
    </div>
    @endforeach
</div>

