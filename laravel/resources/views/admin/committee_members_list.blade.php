@extends('layouts.dashboard',  ['title' => '<i class="fas fa-list"></i> Managing Users for Committees ' .
    $data['committee']->name ])
@section('content')
<div class="container">
    <h3>
       <span class="badge badge-primary badge-pill">
           {!! $data['committee']['active_committee_members']->count() !!}
       </span>
        {{ Str::plural('Member', $data['committee']['active_committee_members']->count()) }}.
        <a href="{{route('admin_committee_show', $data['committee']['slug'])}}">
            Return to {{$data['committee']['name']}} page
        </a>
    </h3>
    <div class="row border border-dark">
        <div class="col-12 p-lg-3">
            <form method="post" name="search_committee_members"
                  action="{{ url()->current() }}"
                  enctype="multipart/form-data"
                  class="needs-validation" novalidate>
                {!! csrf_field() !!}
                <div class="form-group">
                    <h4>
                        <label for="search">Look Up Member</label>
                        <input type="text" name="search" value="" size="40" required/>
                        <button type="submit" class="btn btn-secondary">Submit</button>
                    </h4>
                </div>
            </form>
        </div>
    </div>
    @if(!empty($data['search']))
        <div class="row border border-dark mt-3">
            <div class="col-12 p-lg-3">
                <h4>Results from search</h4>
                <div class="table-responsive">
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th>  &nbsp; </th>
                                <th> @sortablelink('name', 'Name') </th>
                                <th> @sortablelink('email', 'Email') </th>
                                <th> Edit </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data['search'] as $s)
                                <tr>
                                    <td> &nbsp;</td>
                                    <td><h4>{{$s->name}}</h4> </td>
                                    <td> {{$s->email}}</td>
                                    <td>
                                        slug: {{$data['committee']['slug']}} user id: {{$s->id}}
                                        <a
                                            href="{{route('admin_create_committee_members',
                                                [$data['committee']['slug'], $s->id])}}">
                                            Add / Edit
                                        </a>
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
    <div class="row border border-dark mt-3 mb-lg-5">
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
                            <th> Edit </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ( $data['committee']['active_committee_members'] as $i )
                            <tr>
                                <td>
                                    &nbsp;
                                </td>
                                <td>
                                    <h4>
                                        <a title="{{ $i['name'] }}" href="{{ route('user_edit', $i['id']) }}">
                                            {{ $i['name'] }}
                                        </a>
                                    </h4>
                                </td>
                                <td> {{ $i['email'] }} </td>
                                <td>
                                    {{$i['committee_memberships'][0]['pivot']['role']}}
                                </td>
                                <td>Edit</td>
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
</div>
@endsection
