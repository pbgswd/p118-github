@extends('layouts.jumbo')
@section('content')
    <div class="container border border-dark rounded-lg mt-3 mb-3 pt-2" style="background: rgba(220,220,220,0.8);">
        <div class="row">
            <div class="col-12 col-md-6">
                <p>
                    <a href="{{route('topics')}}" title="All Topics">
                        Topics/
                    </a>
                </p>
            </div>
            <div class="col-12 col-md-6 text-md-right">
                <a href="{{route('topic_edit', $data['topic']->slug)}}" title="Edit {{$data['topic']->title}}">
                    <i class="fas fa-edit"></i> Edit
                </a>
            </div>
        </div>

        <div class="col-12 text-center">
            <h1>{{$data['topic']->name}}</h1>
           <p>{!! $data['topic']->description !!}</p>
        </div>
        @if ($data['topic']->pages->count() > 0)
            <div class="row border border-dark rounded-lg p-2" style="background: rgba(220,220,220,0.8);">
                <h4>Pages in {{$data['topic']->name}}</h4>
            </div>
            <div class="row mb-3">
                @forelse($data['topic']->pages as $page)
                    <div class="col-12 col-md-4  p-2">
                        <div class="col border border-dark rounded-lg  w-100 h-100 p-2">
                            <a href="{{ route('page_show', $page->slug) }}">{{$page['title']}}</a>
                            {!! $page['description'] !!}
                        </div>
                    </div>
                @empty
                    No pages yet
                @endforelse
            </div>
        @endif
        @if ($data['topic']->posts->count() > 0)
            <div class="col-12 border border-dark rounded-lg pt-2">
                <h4>Posts in {{$data['topic']->name}}</h4>
            </div>
            <div class="row mb-3">
                @forelse($data['topic']->posts as $post)
                    <div class="col-12 col-md-4 p-2">
                        <div class="border border-dark rounded-lg w-100 h-100 p-2">
                            <h4>
                                <a href="{{ route('post_show', $post->slug) }}">
                                    {{$post['title']}}
                                </a>
                            </h4>
                        </div>
                    </div>
                @empty
                    No posts
                @endforelse
            </div>
        @endif
        @if(count($data['topic']->attachments) > 0)
            <div class="col-12 border border-dark rounded-lg pt-2 pb-2 mb-2 mb-lg-3">
                <h4>
                    <i class="far fa-folder-open"></i>
                    Files
                </h4>
                 <ul class="list-group">
                     @forelse ($data['topic']->attachments as $ta)
                         <li class="list-group-item">
                             <a href="{{route('attachment_download',
                                [$data['topic']->getAttachmentFolder(), $ta->id])}}"
                                title="Download {{$ta->file_name}}">
                                 <i class="fas fa-file-download fa-1x"></i>
                                {{$ta->description ?: $ta->file_name}}
                             </a>
                         </li>
                     @empty
                     @endforelse
                 </ul>
            </div>
        @endif
    </div>
@endsection
