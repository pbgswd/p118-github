@extends('layouts.dashboard', ['title' => ' <i class="fas fa-users"></i> View Committee \'' .
    $data['committee']->name .'\''])
@section('content')
    <div class="container">
        <h5>
            <a href="{{ route('committees_list') }}" title="return to list of committees">
                <i class="far fa-arrow-alt-circle-left"></i>
                List of Committees
            </a>
        </h5>
        <div class="row">
            @if(null !== $data['committee']->image)
                <div class="col-12 mt-3 mb-3">
                    <img src="{{ asset('storage/committees/'.$data['committee']->image)}}"
                         class="border rounded img-fluid" />
                </div>
            @endif
            <div class="col-12 col-md-4">
               <h4 class="font-weight-bold">{{$data['committee']->name}}</h4>
            </div>
            <div class="col-12 col-md-4 text-md-center">
                @if($data['canManage'] == 1)
                    <h5>
                        <a href="{{ route('committee_edit', $data['committee']->slug) }}"
                           title="Edit {{ $data['committee']->name }}">
                            <i class="fas fa-edit"></i>
                            Edit {{ $data['committee']->name }}
                        </a>
                    </h5>
                @endif
            </div>
            <div class="col-12 col-md-4 text-md-right">
                <h5>
                    <a href="{{ route('committee', $data['committee']->slug) }}"
                       title="View {{$data['committee']->name }} on {{env('APP_NAME')}}" target="_blank">
                        <i class="fas fa-eye"></i>
                        View {{$data['committee']->name }} on website.
                    </a>
                </h5>
            </div>
        </div>
        <div class="row">
            <div class="col-12 mt-4 mb-4">
                {!! $data['committee']->description !!}
            </div>
        </div>
        <div class="row mt-2 mb-5">
            <div class="col-12 col-md-6">
                Primary Committee Email:
                <a href="mailto:{{$data['committee']->email }}">
                    <i class="far fa-envelope"></i> &nbsp;
                    {{$data['committee']->email}}
                </a>
            </div>
             <div class="col-12 col-md-6 text-md-right">
                 Committee entry created by:
                 <i class="far fa-user"></i>
                 <a href="{{route('user_edit', $data['committee']->creator->id)}}">
                     {{$data['committee']->creator->name }}
                 </a>
            </div>
        </div>
        <div class="row mt-2 mb-5">
            <div class="col-12 col-md-6">
                <h5>
                    Committee Status:
                    @if($data['committee']->live == 1)
                        this committee is live
                    @else
                        not enabled live.
                    @endif
                </h5>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-12">
                <h5 class="pb-3">
                    <i class="fas fa-users"></i>
                    {{$data['committee']->active_committee_members->count()}} active
                    {{Str::plural('member', $data['committee']->active_committee_members->count())}}
                    in {{$data['committee']->name}}
                </h5>
                @if($data['canManage'] == 1)
                    <h5>
                        <a href="{{route('admin-list-committee-members', $data['committee']->slug)}}">
                            <i class="fas fa-users"></i>
                            List, Add, Edit Committee Members & Roles
                        </a>
                    </h5>
                @endif
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-12 col-md-6">
                <h4>Committee Membership Roles</h4>
                <ul class="list-group">
                    @forelse ($data['committee']['executives'] as $exec)
                        <li class="list-group-item">
                            {{$exec->pivot->role}}:
                            <a href="{{route('user_edit', $exec->id)}}">
                                {{$exec->name}}
                            </a>
                        </li>
                    @empty
                        <li class="list-group-item">No roles defined yet</li>
                    @endforelse
                </ul>
            </div>
        @if($data['canManage'] == 1)
            <div class="col-12 col-md-6 text-md-right">
                <h5>
                    <a href="{{route('committee_posts_list', $data['committee']->slug)}}">
                        <i class="far fa-folder-open"></i>
                        {{$data['committee']->posts->count()}}
                        {{Str::plural('post', $data['committee']->posts->count())}}
                        in {{ $data['committee']->name }}
                    </a> |
                    <a href="{{route('admin_committee_post', $data['committee']->slug)}}">
                        Add New Post
                    </a>
                </h5>
            </div>
        @endif
    </div>
</div>
@endsection
