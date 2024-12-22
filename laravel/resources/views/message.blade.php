@extends('layouts.jumbo')
@section('content')
    <div class="row mt-3" style="margin-top: 5rem;">
        <div class="col-12 col-md-6 pl-4">
            <h4>
                <a href="{{route('messages')}}">
                    <i class="far fa-arrow-alt-circle-left"></i>
                    Messages
                </a>
            </h4>
        </div>
        @can('edit articles')
            <div class="text-end">
                <a href="{{route('admin_messages')}}" title="Admin Messages">
                    <i class="fas fa-edit"></i> Admin Messages
                </a>
            </div>
        @endcan
    </div>
    <div class="container mb-6" style="background: rgba(220,220,220,0.8); padding: 1rem;">
        <div class="row border border-dark rounded" style=" margin: 1rem;">
            <div class="col-12 m-6 h-90 w-90 mx-auto" style="padding: 2rem;">

                <div class="d-flex justify-content-center">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            @if($data['next'])
                                <li class="page-item">
                                    <a class="page-link" href="{{ route('message', [$data['next']->id, $data['next']->slug])}}">
                                        Newer Messages
                                    </a>
                                </li>
                            @endif
                            @if ($data['previous'])
                                <li class="page-item">
                                    <a class="page-link" href="{{ route('message', [$data['previous']->id, $data['previous']->slug]) }}">
                                        Older Messages
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </nav>
                </div>
                <h2 class="text-center">
                    <i class="fas fa-envelope-open-text"></i>
                    {{$data['message']->subject}}
                </h2>
                <p class="text-center">Sent: {{$data['message']->updated_at->format('F j Y')}}</p>
                @if($data['message_origin'] != 'message')
                    <p class="text-center">
                        <a href="{{$data['message']->source_url}}">
                          Original post:  {{$data['message']->source_url}}
                        </a>
                    </p>
                @endif
                <div class="p-6">
                    {!! $data['message']->content !!}
                </div>
            </div>
            @if($data['message']->attachments->count() > 0)
                <div class="row mt-4 mb-6 p-2">
                    <h4>
                        <i class="far fa-folder-open"></i>
                        {{$data['message']->attachments->count() . ' ' .
                            Str::plural('Attachment', $data['message']->attachments->count())}}
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
                                <li class="list-group-item"> No attachments</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            @endif
            <div class="row">
                <div class="col-12">
                    <h5>Message {{Str::plural('Category', count($data['message']['messageCategories']))}}:
                        @foreach($data['category_titles'] as $msgcat)
                            {{$msgcat}}@if($loop->remaining),@else.@endif
                        @endforeach
                    </h5>
                    <p class="fw-bold text-center">Update your personal message preferences on your
                        <a href="{{route('member', Auth::id())}}">profile page.</a>
                    </p>
                </div>
            </div>
            <div class="d-flex justify-content-center">
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        @if($data['next'])
                            <li class="page-item">
                                <a class="page-link" href="{{ route('message', [$data['next']->id, $data['next']->slug])}}">
                                    Newer Messages
                                </a>
                            </li>
                        @endif
                        @if ($data['previous'])
                            <li class="page-item">
                                <a class="page-link" href="{{ route('message', [$data['previous']->id, $data['previous']->slug]) }}">
                                    Older Messages
                                </a>
                            </li>
                        @endif
                    </ul>
                </nav>
            </div>
        </div>
    </div>
@endsection
