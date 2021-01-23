@extends('layouts.jumbo')
@section('content')
<div class="jumbotron">
    <div class="container border border-dark rounded-lg" style="background: rgba(220,220,220,0.8);">
        <div class="row mb-lg-5">
                <div  class="col-12">
                    <h1>{{$data['page']->title}}</h1>
                </div>
                <div class="col-12">
                    <h2>{!! $data['page']->description !!}</h2>
                </div>
                <div class="col-12">
                    {!! $data['page']->content !!}
                 </div>
                @if(count($data['page']->attachments) > 0)
                    <div class="col-md-12">
                        <h4>Files</h4>
                        <table class="table table-striped table-sm">
                            <thead>
                            <tr>
                                <th> File </th>
                                <th> Description </th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($data['page']->attachments as $pa)
                                    <tr>
                                        <td>
                                            <a href="{{route('attachment_download',
                                                [$data['page']->getAttachmentFolder(), $pa->id])}}"
                                                title="Download {{$pa->file_name}}">
                                                <i class="far fa-file"></i>
                                                {{$pa->file_name}}
                                            </a>
                                        </td>
                                        <td>
                                            {{$pa->description}}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
                @if ($data['page']->tagNames != '')
                    <div class="col-md-12">
                        Tags: {{join(', ', $data['page']->tagNames())}}
                    </div>
                @endif

        </div>
    </div>
</div>
@endsection
