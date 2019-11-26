@extends('layouts.dashboard',  ['title' => '<i class="fas fa-list"></i> Bulk add users to ' . $data['committee']->name ])
@section('content')
<div class="container">
        <h3>
           <span class="badge badge-primary badge-pill">
               {!! $data['users']->total()  !!}
           </span>
            Members. <a href="{{route('committee_show', $data['committee']->slug)}}">Return to {{$data['committee']->name}} page</a>
        </h3>
</div>
    <form method="post" name="committee-bulk-add" action="{{ url()->current() }}" enctype="multipart/form-data" class="needs-validation" novalidate>
    {!! csrf_field() !!}
    <input type="hidden" name="committee[id]" value="{{$data['committee']->id}}" />
    <input type="hidden" name="committee[slug]" value="{{$data['committee']->slug}}" />
    <div class="form-group">
        <div class="table-responsive">
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th> @sortablelink('id','#') </th>
                        <th> @sortablelink('name', 'Name') </th>
                        <th> @sortablelink('email', 'Email') </th>
                        <th> Role </th>
                    </tr>
                </thead>
                <tbody>
                @foreach ( $data['users'] as $i )
                    <tr>
                        <td>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="member[member][id][]" value="{{ $i->id }}" />
                                </label>
                            </div>
                        </td>
                        <td>
                            <h4>
                                <a title="{{ $i->name }}" href="#">{{ $i->name }}</a>
                            </h4>
                        </td>
                        <td> {{ $i->email }} </td>
                        <td>
                            <div class="form-group">
                                {{ select_options($data['committee_levels'], old('member.role', 'member'), ['name' => 'member[role]', 'class' => 'form-control', 'placeholder' => 'Role']) }}
                            </div>
                        </td>
                    </tr>
                @endforeach
                    <tr>
                        <td colspan="4">&nbsp;</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    @if($data['users']->total() > 0)
    <div class="row">
        <div class="col">
            <i class="far fa-trash-alt fa-2x"></i>
            <input class="btn btn-outline-success" type="submit" value="Add Selected">
        </div>
        <div class="col-6">
            <div class="list-group">
                <ul class="pagination">
                    {!! $data['users']->links() !!}
                </ul>
            </div>
        </div>
        <div class="col"></div>
    </div>
    @endif
    <div class="row" style="margin-top:6em;"></div>
</form>
@endsection
