@extends('layouts.jumbo')
@section('content')
    <div class="container border border-dark rounded-lg p-2 mt-3" style="background: rgba(220,220,220,0.8);">
        <div class="row">
            <div class="col-0 col-md-4"></div>
            <div class="col-md-4 text-center">
                <a href="{{ route('committee', $data['committeepost']->committee->slug) }}">
                    @if(null !== $data['committeepost']->committee->image)
                        <img src="{{ asset('storage/committees/'. $data['committeepost']->committee->image)}}"
                            class="border rounded-lg img-fluid mb-2" />
                    @endif
                    <h4>
                        {{$data['committeepost']->committee->name}}
                    </h4>
               </a>
            </div>
            @can('manage committee')
                <div class="col-12 col-md-4 text-right">
                    <a href="{{route('admin_committee_post_edit',
                        [$data['committeepost']->committee->slug, $data['committeepost']->slug])}}"
                       title="Edit {{$data['committeepost']->title}}">
                        <i class="fas fa-edit"></i> Admin Edit
                    </a>
                </div>
            @endcan
        </div>
        <div class="row mt-3">
            <div class="col-12">
                <h1 class="text-center">
                    {{$data['committeepost']->title}}
                </h1>
                <h5>
                    By {{$data['committeepost']->creator->name}},
                    {{ \Carbon\Carbon::parse($data['committeepost']->updated_at)->format(' F j, Y') }}
                </h5>
                {!! $data['committeepost']->content !!}
            </div>
        </div>
        @if(count($data['committeepost']->attachments) > 0)
            <div class="row">
                <div class="col-12 mt-3">
                    <h4>
                        <i class="far fa-folder-open"></i>
                        Files
                    </h4>
                    <ul class="list-group">
                        @foreach ($data['committeepost']->attachments as $pa)
                            <ul class="list-group-item">
                                <a href="{{route('attachment_download',
                                [$data['committeepost']->getAttachmentFolder(), $pa->id])}}"
                                   title="Download {{$pa->file_name}}">
                                    <i class="far fa-file"></i>
                                    {{ $pa->description ?: $pa->file_name}}
                                </a>
                            </ul>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
        @if($data['canManage'] == 1)
            <div class="col-12 p-4">
                <h5>
                    <a href="{{route('committee_post_edit_form', [$data['committeepost']->committee->slug,
                        $data['committeepost']->slug])}}">
                        <i class="far fa-edit"></i> Edit Post
                    </a>
                </h5>
            </div>
        @endif
    </div>
</div>
@endsection
