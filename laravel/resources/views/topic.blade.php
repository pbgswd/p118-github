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
                @can(['edit articles'])
                    <a href="{{route('topic_edit', $data['topic']->slug)}}" title="Edit {{$data['topic']->title}}">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                @endcan
            </div>
        </div>
        <div class="row">
            <div class="col-12 text-center">
                <h1>{{$data['topic']->name}}</h1>
               <p>{!! $data['topic']->description !!}</p>
            </div>
        </div>

        @if($data['layout'] == 1)
            @if ($data['topic']->pages->count() > 0)
                <div class="row">
                    @forelse($data['topic']->pages as $page)
                        <div class="col-12 col-md-4 p-1">
                            <div class="col border border-dark rounded h-100 w-100 pt-1 text-center d-flex
                            align-items-center justify-content-center">
                                <h4>
                                    <a href="{{ route('page_show', $page->slug) }}">
                                        {{$page['title']}}
                                    </a>
                                </h4>
                            </div>
                        </div>
                    @empty
                        No pages yet
                    @endforelse
                </div>
            @endif

            @if ($data['topic']->posts->count() > 0)
                <div class="row mt-3">
                    @forelse($data['topic']->posts as $post)
                        <div class="col-12 col-md-4 p-1">
                            <div class="col border border-dark rounded h-100 w-100 pt-1 text-center d-flex
                            align-items-center justify-content-center">
                                <h5>
                                    <a href="{{ route('post_show', $post->slug) }}">
                                        {{$post['title']}}
                                    </a>
                                </h5>
                            </div>
                        </div>
                    @empty
                        No posts
                    @endforelse
                </div>
            @endif
        @else
            <div class="row mt-3 h-100">
                <div class="col-12 col-md-6 p-2 h-100">
                    <div class="col border border-dark rounded h-100 pt-2">
                        <h5>Pages in {{$data['topic']->name}}</h5>
                        <ul class="list-group mb-3">
                            @forelse($data['topic']->pages as $page)
                                <li class="list-group-item">
                                    <a href="{{ route('page_show', $page->slug) }}">
                                        {{$page['title']}}
                                    </a>
                                </li>
                            @empty
                                <li class="list-group-item">
                                    No entry
                                </li>
                            @endforelse
                        </ul>
                    </div>
                </div>
                <div class="col-12 col-md-6 p-2">
                    <div class="col border border-dark rounded pt-2">
                        <h5>Posts in {{$data['topic']->name}}</h5>
                        <ul class="list-group mb-3">
                            @forelse($data['topic']->posts as $post)
                            <li class="list-group-item">
                                <a href="{{ route('post_show', $post->slug) }}">
                                    {{$post['title']}}
                                </a>
                            </li>
                            @empty
                                <li class="list-group-item">
                                    No entry
                                </li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        @endif
        @if(count($data['topic']->attachments) > 0)
            <div class="row d-flex align-items-center justify-content-center p-2">
                <div class="col-12 border border-dark rounded-lg pt-2 pb-2 m-2">
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
