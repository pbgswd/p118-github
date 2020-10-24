@extends('layouts.dashboard',  ['title' => '<i class="fas fa-list"></i> add edit  ' .
     $data['user']->name . ' for ' . $data['committee']->name ])
@section('content')
    <div class='container m-lg-5'>
        <div class="row border border-dark">
            <div class="col-12 p-lg-3">
                <form method="post" name="manage_committee_members"
                      action="{{ url()->current() }}"
                      enctype="multipart/form-data"
                      class="needs-validation" novalidate>
                    {!! csrf_field() !!}
                    <div class="form-group">
                        <h4>
                            <label for="role">Select role for {{$data['user']->name}} in {{$data['committee']->name}}</label>
                                <div class="form-group">
                                    {{ select_options($data['committee_roles'],
                                        old('role', 'Member'),
                                        ['name' => 'role',
                                        'class' => 'form-control',
                                        'placeholder' => 'Role'], $selected = ''
                                        )
                                    }}
                                </div>
                            <br />
                            <button type="submit" class="btn btn-secondary">{{$data['action']}}</button>
                        </h4>
                    </div>
                </form>
            </div>
            @if($data['action'] == 'Edit')
                <div class="col-md-12">
                    <form method="post" name="manage_committee_members"
                          action="{{ route('admin_delete-committee_member',
                                    [$data['committee']->slug, $data['user']->id]) }}"
                          enctype="multipart/form-data"
                          class="needs-validation" novalidate>
                        {!! csrf_field() !!}
                        {!! method_field('DELETE') !!}
                        <i class="far fa-trash-alt fa-2x"></i>
                        <div class="form-group">
                            Delete  {{$data['user']->name}} from {{$data['committee']->name}}
                            (sets status to 'Past Member').
                            <input class="btn btn-outline-danger" type="submit" value="Delete" />
                        </div>
                    </form>
                </div>
            @endif
        </div>
    </div>
@endsection
