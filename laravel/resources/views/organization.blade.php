@extends('layouts.jumbo')
@section('content')
    <div class="jumbotron">
        <div class="container border border-dark rounded pb-3" style="background: rgba(220,220,220,0.8);">
            <div class="row pt-2">
                <div class="col-12 col-md-6">
                    <h4>
                        <a href="{{route('organizations')}}"><i class="far fa-arrow-alt-circle-left"></i>
                            Organizations
                        </a>
                    </h4>

                </div>
                @can('edit articles')
                    <div class="col-12 col-md-6 text-end">
                        <a href="{{route('organization_edit', $data['organization']->slug)}}"
                           title="Edit {{$data['organization']->name}}">
                            <i class="fas fa-edit"></i> Admin Edit
                        </a>
                    </div>
                @endcan
            </div>
            @if($data['organization']->image)
                <div class="row mb-2">
                    <div class="col-12 text-center d-flex align-items-center justify-content-center">
                        <picture>
                            <source srcset="{{asset('storage/public/'. $data['organization']->image)}}"
                                    media="(min-width: 577px)">
                            <img srcset="{{asset('storage/public/'.$data['organization']->thumb)}}"
                                 alt="{{$data['organization']->name}}"
                                 class="rounded img-fluid d-block">
                        </picture>
                    </div>
                </div>
            @endif
            <div class="row mt-2">
                <div class="col-12 text-center">
                    <h1>
                        {{$data['organization']->name}}
                    </h1>
                </div>
            </div>
            @if($data['organization']->url)
                <div class="row mt-2">
                    <div class="col-12 text-center">
                        <p>
                            <a href="{{$data['organization']->url}}" title="{{$data['organization']->name}}"
                               target="_blank">
                                <i class="fas fa-external-link-alt"></i>
                                {{$data['organization']->url}}
                            </a>
                        </p>
                    </div>
                </div>
                <a id="agreements"></a>
            @endif
            <div class="col-12">
                <p>{!! $data['organization']->description !!}</p>
            </div>
            @if ($data['agreements']->count() > 0)
                <div class="row border border-dark rounded mb-3 mx-2 p-2">
                    <div class="col-12">
                        <h4>
                            Agreements with {{$data['organization']->name}}
                        </h4>
                    </div>
                    @if($data['agreements']->count() > 1)
                        <div class="col-6">
                            Order by: @sortablelink('title', 'Title')
                        </div>
                        <div class="col-6">
                            @sortablelink('until', 'End Date')
                        </div>
                    @endif
                    <div class="col-12 mx-2">
                        <ul class="list-group list-group-flush">
                            @forelse($data['agreements'] as $va)
                                <li class="list-group-item">
                                    {!! (\Carbon\Carbon::parse($va->until)->isPast()) ? "<i>(Not current)</i>" : '' !!}
                                    <a title="View {{ $va->title }}" href="{{route('agreement_show', $va->id)}}">
                                        {{ $va->title }}
                                    </a>
                                    {{$va->from->format('F j Y')}} - {{$va->until->format('F j Y')}}
                                </li>
                                <ul>
                                    @forelse($va->attachments as $att)
                                        <li>
                                            <a href="{{route('attachment_download', [$att->subfolder, $att->id])}}"
                                               title="Download {{$att->file_name}}" target="_blank">
                                                <i class="fas fa-file-download fa-1x"></i>
                                                {{$att->file_name}} {{$att->description ? : ''}}
                                            </a>
                                        </li>
                                    @empty
                                        <li>No attached files</li>
                                    @endforelse
                                </ul>
                            @empty
                                <li></li>
                            @endforelse
                        </ul>
                        <div class="col-12 d-flex justify-content-center">
                            <div class="list-group text-center">
                                <ul class="pagination text center">
                                    {{ $data['agreements']->links() }}
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if(count($data['organization']->attachments) > 0)
                <div class="col-12 mt-3">
                    <h4>
                        <i class="far fa-folder-open"></i>
                        Files
                    </h4>
                    @foreach ($data['organization']->attachments as $pa)
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <a href="{{route('attachment_download',
                                        [$data['organization']->getAttachmentFolder(), $pa->id])}}"
                                   title="Download {{$pa->file_name}}">
                                    <i class="far fa-file"></i>
                                    {{$pa->description ? : $pa->file_name}}
                                </a>
                            </li>
                        </ul>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection
