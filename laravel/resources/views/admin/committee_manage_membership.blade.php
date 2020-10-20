@extends('layouts.dashboard',  ['title' => '<i class="fas fa-list"></i> add edit  ' .
     $data['user']->name .
     ' for ' .
    $data['committee']->name ])
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
                            <label for="role">Select role</label>

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
                            <button type="submit" class="btn btn-secondary">Submit</button>
                        </h4>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
