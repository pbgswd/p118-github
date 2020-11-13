@extends('layouts.dashboard',  ['title' => '<i class="fas fa-list"></i> Manage Users for ' .
    $data['committee']->name  . ' Committee'])
@section('content')
<div class="container">
    <h4>
        <a href="{{route('admin_committee_show', $data['committee']['slug'])}}">
            <i class="far fa-hand-point-left fa-2x"></i>
            Back to {{$data['committee']['name']}} page
        </a>
    </h4>
    <div class="row border border-dark rounded">
        <div class="col-12 p-lg-3">
            <form method="post" name="search_committee_members"
                  action="{{ url()->current() }}"
                  enctype="multipart/form-data"
                  class="needs-validation" novalidate>
                {!! csrf_field() !!}
                <div class="form-group">
                    <h4>
                        <label for="search">
                            <i class="fas fa-search"></i>
                            Look Up Member to Add or Edit
                        </label>
                        <input type="text" name="search" value="{{$data['query'] ?? '' }}" size="40" required/>
                        <button type="submit" class="btn btn-secondary">Submit</button>
                    </h4>
                </div>
            </form>
        </div>
    </div>
    @if(!empty($data['search']))
        <div class="row border border-dark mt-3  rounded">
            <div class="col-12 p-lg-3">
                <h4>Results from search</h4>
                <div class="table-responsive">
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th>  &nbsp; </th>
                                <th> @sortablelink('name', 'Name') </th>
                                <th> @sortablelink('email', 'Email') </th>
                                <th> Role </th>
                                <th> Action </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data['search'] as $s)
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>
                                        <h4>{{$s->name}}</h4>
                                    </td>
                                    <td>
                                        <a href="mailto:{{$s->email}}">
                                            {{$s->email}}
                                        </a>
                                    </td>
                                    <td>
                                        <h4>
                                            {{$s['committee_memberships'][0]['pivot']['role'] ?? '-'}}
                                        </h4>
                                    </td>
                                    <td>
                                        @if(($s->committee_memberships[0]->id ?? '') != $data['committee']->id)
                                            <a
                                                href="{{route('admin_create_committee_members',
                                                    [$data['committee']['slug'], $s->id])}}" alt="Add" title="Add">
                                                <i class="fas fa-user-plus"></i> Add to Committee
                                            </a>
                                        @else
                                            <a
                                                href="{{route('admin_edit_committee_members',
                                                    [$data['committee']['slug'], $s->id])}}" alt="edit" title="edit">
                                                <i class="far fa-edit"></i> Edit
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">No results</td>
                                </tr>
                            @endforelse
                            <tr>
                                <td colspan="4">&nbsp;</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
    <div class="row border border-dark mt-3 mb-lg-5  rounded">
        <div class="col-12 p-lg-3">
            <h4>
                Current members of {{$data['committee']->name}}
            </h4>
            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th>  &nbsp; </th>
                            <th> @sortablelink('name', 'Name') </th>
                            <th> @sortablelink('email', 'Email') </th>
                            <th> Role </th>
                            <th> Action </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ( $data['committee']['active_committee_members'] as $i )
                            <tr>
                                <td>&nbsp;
                                </td>
                                <td>
                                    <h4>
                                        <a title="{{ $i['name'] }}" href="{{ route('user_edit', $i['id']) }}">
                                            {{ $i['name'] }}
                                        </a>
                                    </h4>
                                </td>
                                <td>
                                    <a href="mailto:{{$i['email']}}">
                                        {{$i['email']}}
                                    </a>
                                </td>
                                <td>
                                    <h4>
                                        {{$i->pivot->role}}
                                    </h4>
                                </td>
                                <td>
                                    <a
                                        href="{{route('admin_edit_committee_members',
                                                [$data['committee']['slug'], $i->id])}}" alt="edit" title="edit">
                                        <i class="far fa-edit"></i> Edit
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">No Members in {{$data['committee']['name']}}</td>
                            </tr>
                            @endforelse
                        <tr>
                            <td colspan="4">&nbsp;</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        @if(count($data['committee']['active_committee_members']) > 0)
        <div class="row mb-lg-5">
            <div class="col">
            </div>
            <div class="col-6">
            </div>
            <div class="col">
            </div>
        </div>
        @endif
        </div>
    <div class="row mt-lg-5 mb-lg-5">
        <div class="col-md-12">
            <a href="{{route('admin_committee_show', $data['committee']['slug'])}}">
                <i class="far fa-hand-point-left fa-2x"></i> Go back
            </a>
        </div>
    </div>
</div>
@endsection
