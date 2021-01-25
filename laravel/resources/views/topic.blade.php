@extends('layouts.jumbo')
@section('content')
    <div class="container border border-dark rounded-lg mt-4 mb-3" style="background: rgba(220,220,220,0.8);">
        <div class="col-12">
            <h1>{{$data['topic']->name}}</h1>
            <a href="{{route('topics')}}">Topics /</a> {{$data['topic']->name}}

            {!! $data['topic']->description !!}
        </div>
        @if ($data['topic']->pages->count() > 0)
            <div class="col-12 border border-dark rounded-lg p-1 mr-1" style="background: rgba(220,220,220,0.8);">
                <h4>Pages in {{$data['topic']->name}}</h4>
            </div>
            @forelse($data['topic']->pages as $page)
                <a href="{{ route('page_show', $page->slug) }}">{{$page['title']}}</a>
                {!! $page['description'] !!}
            @empty
                No pages yet
            @endforelse
        @endif
        @if ($data['topic']->posts->count() > 0)
            <div class="col-12">
                <div class="col-12 border border-dark rounded-lg p-1">
                    <h4>Posts in {{$data['topic']->name}}</h4>
                </div>
                @forelse($data['topic']->posts as $post)
                    <div class=" border border-dark rounded-lg p-1 mr-1 mt-1" style="background: rgba(220,220,220,0.8);">
                        <a href="{{ route('post_show', $post->slug) }}">{{$post['title']}}</a>
                        {!! $post['description'] !!}
                    </div>
                @empty
                    No posts
                @endforelse
            </div>
        @endif
        @if(count($data['topic']->attachments) > 0)
            <div class="col-12">
                <h4>Files</h4>
                <table class="table table-striped table-sm">
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
                                       title="Download {{$ta->file_name}}">{{$ta->file_name}}
                                    </a>
                                </td>
                                <td>
                                    {{ $ta->description}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
