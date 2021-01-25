@extends('layouts.jumbo')
@section('content')

    <div class="container border border-dark rounded-lg pt-lg-2 mb-3 mt-5" style="background: rgba(220,220,220,0.8);">

        <div class="row">
            @foreach ($data['post']->topics as $topic)
                <div class="col-12">
                    <a href="{{route('topics')}}">Topics/</a>
                    <a href="{{ route('topic_show', $topic->slug)}}">{{$topic->name}}/</a>
                </div>
            @endforeach
        </div>


        <div class="col-12">
            <h1 class="display-5">{{$data['post']->title}}</h1>
        </div>
        <div class="col-12">
            <h3>{!! $data['post']->description !!}</h3>
        </div>
        <div class="col-12">
            {!! $data['post']->content !!}


            @if(count($data['post']->attachments) > 0)
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
                            @foreach ($data['post']->attachments as $pa)
                                <tr>
                                    <td>
                                        <a href="{{route('attachment_download',
                                            [$data['post']->getAttachmentFolder(), $pa->id])}}"
                                           title="Download {{$pa->file_name}}">
                                            <i class="far fa-file"></i>
                                            {{$pa->file_name}}
                                        </a>
                                    </td>
                                    <td>
                                        {{ $pa->description}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            @endif
        </div>
                @if(!empty($data['post']->tagNames()))
                    <div class="row p-2">
                        Tags: {{join(', ', $data['post']->tagNames())}}
                    </div>
                @endif




@endsection




