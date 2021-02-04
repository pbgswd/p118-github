@extends('layouts.dashboard',  ['title' => '<i class="fas fa-list"></i> List agreements'])
@section('content')
<div class="container">
        <h3>
           <span class="badge badge-primary badge-pill">
               {{$data['count']}}
           </span>
            agreements. | <a href="{{ route('agreement_create') }}">Create new agreement
                <i class="far fa-arrow-alt-circle-right"></i> </a>
        </h3>
</div>
    @if($data['count'] < 1)
    No agreements defined yet
    @else
<form name="delete" method="POST" action="{{route('agreement_destroy')}}">
    {!! csrf_field() !!}
    {!! method_field('DELETE') !!}
    <div class="form-group">
        <div class="table-responsive">
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th> @sortablelink('id','#') </th>
                        <th> @sortablelink('title', 'Title') </th>
                        <th> @sortablelink('access_level', 'Access Level') </th>
                        <th> @sortablelink('live', 'Is Live?') </th>
                        <th> @sortablelink('from', 'From') </th>
                        <th> @sortablelink('until', 'Until') </th>
                        <th> Edit </th>
                        <th> @sortablelink('created_at', 'Created At') </th>
                        <th> @sortablelink('updated_at', 'Updated At') </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ( $data['agreements'] as $a )
                        <tr>
                            <td>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="id[]" value="{{$a->id}}" />
                                    </label>
                                </div>
                            </td>
                            <td>
                                <h4>
                                    <a title="{{ $a->title }}" href="{{ route('agreement_edit', $a->id) }}">
                                        {{ $a->title }}
                                    </a>
                                    @if(\Carbon\Carbon::parse($a->until)->isPast())
                                        <i>(Not current)</i>
                                    @endif
                                </h4>
                            </td>
                            <td> {{ $a->access_level }} </td>
                            <td>
                                {!! $a->live ? "<i class='fas fa-check'></i>"
                                    : "<i class='far fa-times-circle'></i>" !!}
                            </td>
                            <td>{{$a->from->format('F j Y')}}</td>
                            <td>{{$a->until->format('F j Y')}}</td>
                            <td>
                                <a href="{{ route('agreement_edit', $a->id) }}" title="Edit {{ $a->title }} ">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                            <td> {{ $a->created_at->format('F j Y H:i:s') }} </td>
                            <td> {{ $a->updated_at->format('F j Y H:i:s') }} </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="10">&nbsp;</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row mb-lg-5">
        <div class="col">
            <i class="far fa-trash-alt fa-2x"></i>
            <input class="btn btn-outline-danger" type="submit" value="Delete Selected">
        </div>
        <div class="col-6">
            <div class="list-group">
                <ul class="pagination">
                     {{ $data['agreements']->links() }}
                </ul>
            </div>
        </div>
        <div class="col"></div>
    </div>
</form>
@endif
@endsection
