@extends('layouts.app')
@section('page_title', env('SITE_NAME'))
@section('content')
@include('page_parts.content_feature')
	@foreach ( $data['posts'] as $p )
		@if (get_datum('content_feature_id') != $p->id)
			<div class="col-sm-6 col-md-4 bodyrow">
				<h2><a title="{{$p->author_name }} - {{$p->title}}" href="{{ route('post', [$data['topic']->slug, $p->slug] ) }}">{{$p->title}} </a></h2>
<h6 class="author">{{$p->author_name }}, {{ date('F j Y', strtotime($p->publish_date)) }}</h6>
				{!! $p->summary !!}
				<p>
				    <a class="btn btn-default col-md-offset-6" role="button" title="{{$p->author_name }} - {{$p->title}}" href="{{route('post', [$data['topic']->slug, $p->slug])}}">Read More...</a>
			   </p>
			</div>
		@endif
	@endforeach
	<div class="col-sm-6 col-md-4 bodyrow">
		<h2>
           <a title="Read More" href=" {{route('topic', $data['topic']->slug)}}">Read More of {{$data['topic']->name}}</a>
        </h2>
		<h4>{!! $data['topic']->description !!}</h4>
		<p>
  	            <a class="btn btn-default" role="button" title="read more of {{$data['topic']->name}}" href="{{route('topic', $data['topic']->slug)}}"> {!! $data['posts']->total() !!} issues online. Read More...</a>
		</p>
	</div>
@endsection
