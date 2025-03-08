@extends('layouts.dashboard',  ['title_icon' => ' <i class="fas fa-edit"></i>', 'title' => $data["action"] .' Executive role for '. $data["user"]->name ])
@section('content')
<div class="container">
    <form method="post" name="executive" action="{{ url()->current() }}"
          enctype="multipart/form-data" class="needs-validation" novalidate>
        {!! csrf_field() !!}
        <div class="row mt-3">
            <div class="col-sm-12 col-md-3 text-left">
                <h5>
                    <a href="{{route('admin_executives_list')}}">
                        <i class="far fa-arrow-alt-circle-left"></i>
                        Executives list
                    </a>
                </h5>
            </div>
            @if($data['action'] == 'Edit')
                <div class="col-sm-12 col-md-4 text-right">
                    <h5>
                        <a href="{{route('admin_executive_create', $data['user']->id)}}">
                            Assign new Executive Role <i class="far fa-arrow-alt-circle-right"></i>
                        </a>
                    </h5>
                </div>
            @endif
        </div>
        <div class="row mt-3">
            <div class="col-sm-12 col-md-4 mb-6 text-left">
                <h3>
                    <a title="admin edit page for {{ $data['user']->name }}"
                       href="{{ route('user_edit', $data['user']->id) }}">
                        {{$data['user']->name}}
                    </a>
                </h3>
            </div>
        </div>
        <div class="row mt-4">
            <div class="form-group">
                <div class="col-sm-12 col-md-6">
                    <label for="exampleFormControlSelect1">
                        <h4>Title & Email</h4>
                    </label>
                    <select class="form-control mt-3" id="exampleFormControlSelect1" name="executive[executive_id]" required>
                        @if($data['action'] == 'Create')
                            <option value="">Select Executive Role</option>
                        @endif
                         @foreach($data['roles'] as $r)
                            <option value="{{$r->id}}"
                                    @if( $data['action'] == 'Edit')
                                        @if ($data['assigned_role']->executive_id == $r->id )
                                            selected
                                        @endif
                                    @endif
                                        >{{$r->title}} | {{$r->email}}</option>
                         @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="row my-3 mt-4">
            <div class="form-group">
                <div class="col-12">
                    <h4>
                        <i class="fas fa-calendar-alt"></i>
                        Start date of Term {{$data['action'] == 'Edit' ? '' : '(Suggested: Today)'}}
                    </h4>
                </div>
                <div class="col-12 mt-4">
                    <input
                        type="date"
                        name="executive[start_date]"
                        class="form-control"
                        data-provide="datepicker"
                        data-date-format="yyyy-mm-dd"
                        style='width: 300px;'
                        value="{{$data['action'] == 'Edit' ? $data['assigned_role']->start_date->toDateString() : \Carbon\Carbon::now()->toDateString()}}"
                            required>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="form-group">
                <div class="col-12 mt-4">
                    <h4>
                        <i class="fas fa-calendar-alt"></i>
                        End date of Term {{$data['action'] == 'Edit' ? '' : '(Suggested: +3 years)'}}
                    </h4>
                </div>
                <div class="col-12 mt-4">
                    <input
                        type='date'
                        name="executive[end_date]"
                        class="form-control"
                        id="pdate"
                        data-provide="datepicker"
                        data-date-format="yyyy-mm-dd"
                        style='width: 300px;'
                        value="{{ $data['action'] == 'Edit' ? $data['assigned_role']->end_date->toDateString() : \Carbon\Carbon::now()->add('3 year')->toDateString() }}"
                            required>
                </div>
            </div>
        </div>

        <div class="row my-3">
            <div class="col-sm mt-4">
                <i class="fas fa-edit fa-2x"></i>
                <input class="btn btn-outline-primary" type="submit" value="{{ $data['action'] }}" />
            </div>
    </form>
        <div class="col-sm"> &nbsp;</div>
        @if ($data['action'] == 'Edit')
             <div class="col-sm" style="float:right">
                 <form name="delete" method="POST" action="{{route('admin_executive_destroy')}}">
                     {!! csrf_field() !!}
                     {!! method_field('DELETE') !!}
                     <input type="hidden" name="id[]" value="{{$data['assigned_role']->id}}" />
                     <i class="far fa-trash-alt fa-2x"></i>
                     <input class="btn btn-outline-danger" type="submit" value="Delete Executive Member role">
                 </form>
             </div>
        @endif
    </div>
</div>
@endsection
