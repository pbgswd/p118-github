@extends('layouts.dashboard',  ['title_icon' => '<i class="fas fa-list"></i>', 'title' => $data['action'] . ' ' .
    $data['user']->name . ' for ' . $data['committee']->name ])
@section('content')
    <div class='container m-lg-5'>
        <div class="row">
            <div class="col-12">
                <h4>
                    <a href="{{route('user_edit', $data['user']->id)}}">
                        {{$data['user']->name}}
                    </a>
                </h4>
            </div>
        </div>
        <div class="row border border-dark rounded">
            <form method="post" name="manage_committee_members" action="{{ url()->current() }}"
                  enctype="multipart/form-data"
                  class="needs-validation" novalidate>
                {!! csrf_field() !!}
                <div class="col-12 p-3 mb-6">
                    <div class="form-group">
                        <h4>
                            <label for="role" class="mb-2">
                                {{$data['action'] == 'Edit' ? 'Edit': 'Add'}}
                                role for {{$data['user']->name}} in {{$data['committee']->name}}
                            </label>
                        </h4>
                        <select class="form-select" name="role" aria-label="Default select example">
                            @if($data['action'] == 'Add')
                                <option value="" selected>Select a Committee role</option>
                            @endif
                            @foreach($data['committee_roles']['committee_roles'] as $k => $v)
                              @if(isset($data['user']->committee_memberships[0]->pivot->role) && $data['user']->committee_memberships[0]->pivot->role == $v)
                                  <option value="{{$v}}" selected>{{$k}}</option>
                              @else
                                  <option value="{{$v}}">{{$k}}</option>
                              @endif
                            @endforeach
                        </select>

<br />
@if($data['action'] == 'Edit')
<i class="far fa-edit"></i>
@else
<i class="fas fa-user-plus"></i>
@endif
<button type="submit" class="btn btn-secondary">
{{$data['action']}}
</button>

</div>
</div>
</form>
</div>

@if($data['action'] == 'Edit')
<div class="row mt-6">
<div class="col-12 p-3 mt-6">
<form method="post" name="manage_committee_members"
action="{{ route('admin_delete-committee_member',
      [$data['committee']->slug, $data['user']->id]) }}"
enctype="multipart/form-data"
class="needs-validation" novalidate>
{!! csrf_field() !!}
{!! method_field('DELETE') !!}
<div class="form-group">
<h4 class="mt-4 mb-3">
  Delete  {{$data['user']->name}} from {{$data['committee']->name}}
</h4>
<input type="hidden" name="user_id" value="{{$data['user']->id}}" />
<i class="far fa-trash-alt fa-2x"></i>
<input class="btn btn-outline-danger" type="submit" value="Delete" />
</div>
</form>
</div>
</div>
@endif

<div class="row mt-lg-5">
<div class="col-md-12">
<a href="{{route('admin-list-committee-members', $data['committee']->slug)}}">
<i class="far fa-hand-point-left fa-2x"></i> Go back
</a>
</div>
</div>
</div>
@endsection
