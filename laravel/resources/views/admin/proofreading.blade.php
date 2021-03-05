@extends('layouts.dashboard')
@section('content')
<div class='container m-lg-5'>
    <div class="row border border-primary rounded mb-3">
        <div class='col-12 col-md-6 p-3'>
            <h3>
                <a href="{{route('admin_proofreader')}}">
                    <i class="fas fa-glasses"></i>
                Proofreader
                </a>
            </h3>
        </div>
        <div class='col-12 col-md-6 text-right p-3'>
            <h3>
                <a href="{{route('admin_proofreader_sync')}}">
                    <button type="button" class="btn btn-primary">
                        <i class="fas fa-database"></i>
                        Sync Content Data with<br />
                        Proofreader table<br />
                        before you begin.
                    </button>

                </a>
            </h3>
        </div>
    </div>

    <form method="post" action="{{route('admin_proofreader')}}">
        @csrf
        <div class="row d-fle justify-content-around border border-dark rounded-lg pb-2">
            <div class="col-12 pt-2">
                <h5>
                    <label for="validationDefault04">
                       Filter Proofreading List By Content Type
                    </label>
                </h5>
            </div>
            <div class="col-12 col-md-9 mb-2">
                <select class="custom-select" name="type" id="content_type" required>
                    <option selected disabled value="">Choose Type</option>
                    @foreach($data['menu'] as $item)
                        <option value="{{$item['name']}}">
                            {{$item['title']}}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 col-md-3">
                <button class="btn btn-primary" type="submit">Submit</button>
            </div>
        </div>
    </form>

    @if($data['entries']->count() > 0)
        <div class="row">
            <div class='col-12 p-3'>
                <h3>
                    {{$data['entries'][0]->content_title}}
                </h3>
            </div>
        </div>

        @forelse($data['entries'] as $row)
            <div class="row border border-primary rounded mb-3 p-1">
                <div class='col-10 p-3
                @if($row->proofread_at !== null &&
                   ( \Carbon\Carbon::parse($row->proofread_at) <
                    \Carbon\Carbon::parse($row->content_updated_at))
                ))

                @endif
                '>
                    <h5>
                        {{$row->title}}
                        <a href="{{$row->admin_link}}" target="_blank">
                            Admin
                            <i class="fas fa-edit"></i>
                        </a> |
                        <a href="{{$row->pub_link}}" target="_blank">
                            Public
                            <i class="fas fa-external-link-alt"></i>
                        </a>
                        <br />
                        Last Updated:
                        {{ \Carbon\Carbon::parse($row->content_updated_at)->format(' F j, Y H:i:s') }}
                        @if($row->proofread_at)
                            <br />
                            Last Proofread:
                            {{\Carbon\Carbon::parse($row->proofread_at)->format('F j Y H:i:s') ?? 'Never'}}
                            <br />
                            By:
                            {{$row->user->name ?? ''}}
                        @else
                            <br/>
                            <span class="font-weight-bolder">
                                Has never been proofread
                            </span>
                        @endif
                        @if($row->proofread_at !== null &&
                               (\Carbon\Carbon::create($row->proofread_at)) <
                                \Carbon\Carbon::create($row->content_updated_at))
                            <br />
                            <div class="font-weight-bolder text-warning bg-secondary mt-3 p-2 rounded">
                                <i>
                                    This content needs to be proofread AGAIN due to updates.
                                </i>
                            </div>
                        @endif
                        <br />
                    </h5>

                </div>
                <div class="col-2 d-flex align-self-center">
                    @if($row->proofread_at !== null &&
                        (\Carbon\Carbon::create($row->proofread_at)) >
                        \Carbon\Carbon::create($row->content_updated_at))
                        <button class="btn btn-outline-success">
                            Done
                        </button>
                    @else
                        <form method="post" action="/admin/proofreading/{{$row->id}}/update" />
                            @csrf
                            <input name="pr[id]" value="{{$row->id}}" type="hidden" />
                            <input name="pr[type]" value="{{$row->content_type}}" type="hidden" />
                            <input name="type" value="{{$row->content_type}}" type="hidden" />
                            <button class="btn btn-primary" type="submit">
                                Mark as Done
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        @empty
            <div class='col-12 pb-3'>
                <h5>No data</h5>
            </div>
        @endforelse
    @endif
</div>
@endsection
