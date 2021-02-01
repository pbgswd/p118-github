@extends('layouts.jumbo')
@section('content')
    <div class="container border border-dark rounded-lg mt-3 mb-3 pt-2" style="background: rgba(220,220,220,0.8);">

        <div class="col-12">
            <p>
                <a href="{{route('topics')}}" title="All Topics">
                    Topics/
                </a>
            </p>
        </div>
        <div class="col-12">
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
            <div class="col-12 border border-dark rounded-lg pt-2 mb-2 mb-lg-3">
                <h4>
                    <i class="far fa-folder-open"></i>
                    Files for {{$data['topic']->name}}
                </h4>
                <div class="table-responsive">
                    <table class="table-striped table">
                        <thead>
                            <tr>
                                <th> File </th>
                                <th> Description </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data['topic']->attachments as $ta)
                                <tr>
                                    <td>
                                        <a href="{{route('attachment_download',
                                            [$data['topic']->getAttachmentFolder(), $ta->id])}}"
                                           title="Download {{$ta->description ?? $ta->file_name}}">
                                            {{$ta->description ?? $ta->file_name}}
                                        </a>
                                    </td>
                                    <td>
                                        {{$ta->description}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif


    </div>
@endsection
