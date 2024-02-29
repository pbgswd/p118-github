@extends('layouts.jumbo')

@section('content')
    <h1>test</h1>
    <div class="row mt-3">
        <div class="col-12 col-md-6 pl-4">
            <h4>
                <a href="{{route('messages')}}">
                    <i class="far fa-arrow-alt-circle-left"></i>
                    Messages
                </a>
            </h4>
        </div>
        @can('edit articles')
            <div class="col-12 col-md-6 text-md-right pr-4">
                <a href="{{route('admin_message_edit', $data['message']->id)}}"
                   title="Edit {{$data['message']->subject}}">
                    <i class="fas fa-edit"></i> Admin Edit
                </a>
            </div>
        @endcan
    </div>



    <div class="row m-6">
        <div class="col-12 m-6 p-6 p-10 d-flex align-items-center justify-content-center">
            <i class="fas fa-scroll"></i>
            {{$data['message']->subject}}
        </div>
    </div>

        <div class="container mb-6" style="background: rgba(220,220,220,0.8);">
        <div class="row m-6 border border-dark rounded p-6">


            <div class="col-12 m-6 p-6">

                    <i class="fas fa-scroll"></i>
                    {{$data['message']->subject}}


                    From: {{$data['message']->updated_at->format('F j Y')}}

                <p>Sent by: {{$data['message']['user']->name}}</p>
                <p> {{$data['message']->type}}</p>
                <p>{{$data['message']->name}}</p>
                <div class="col p-6">
                    {!! $data['message']->content !!}
                </div>
            </div>
        </div>

            @if($data['message']->attachments->count() > 0)
                <div class="row mt-4 mb-6 p-2">
                    <h4>
                        <i class="far fa-folder-open"></i>
                        Message Attachments
                    </h4>
                    <div class="col-12 mb-6">
                        <ul class="list-group mb-6">
                            @forelse($data['message']->attachments as $att)
                                <li class="list-group-item">
                                    <a href="{{route('attachment_download', [$att->subfolder, $att->id])}}"
                                       title="Download {{$att->file_name}}" target="_blank">
                                        <i class="fas fa-file-download fa-1x"></i>
                                        {{$att->description ? : $att->file_name}}
                                    </a>
                                </li>
                            @empty
                                <li class="list-group-item"> No attachments </li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            @endif
    </div>
</div>
@endsection
