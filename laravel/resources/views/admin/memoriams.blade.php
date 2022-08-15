@extends('layouts.dashboard')
@section('content')
    <div class='container'>
        <div class="row">
            <div class="col-12 col-md-6">
                <h3>
                   <span class="badge badge-primary badge-pill">
                       {{$data['memoriam']->count()}} {{ Str::plural('Memoriam', $data['memoriam']->count())}}
                   </span>
                    | <a href="{{ route('admin_memoriam_create') }}">Create new Memoriam
                        <i class="far fa-arrow-alt-circle-right"></i> </a>
                </h3>
            </div>
            <div class="col-12 col-md-6 text-right">
                <a href="{{route('memoriam_list')}}">
                    <i class="far fa-eye"></i>
                    View on website</a>
            </div>

        </div>


    </div>
    <form name="delete" method="POST" action="{{route('admin_memoriam_destroy')}}">
        {!! csrf_field() !!}
        {!! method_field('DELETE') !!}
        <div class="form-group">
            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th> @sortablelink('id','#') </th>
                            <th> @sortablelink('title', 'Title') </th>
                            <th> @sortablelink('live', 'Is Live?') </th>
                            <th> @sortablelink('date', 'Date') </th>
                            <th> Edit </th>
                            <th> @sortablelink('created_at', 'Created At') </th>
                            <th> @sortablelink('updated_at', 'Updated At') </th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse ( $data['memoriam'] as $mem )
                        <tr>
                            <td>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="ids[]" value="{{$mem->id}}" />
                                    </label>
                                </div>
                            </td>
                            <td>
                                @if($mem->image)
                                <img src="{{asset('storage/'. $data['folder'] .'/'.
                                    $data['tn_str'].$mem->image)}}" class="rounded" />
                                @endif
                                <h4>
                                    <a title="{{ $mem->title }}" href="{{ route('admin_memoriam_edit', $mem->slug) }}">
                                        {{ $mem->title }}
                                    </a>
                                </h4>
                            </td>
                            <td>
                                {!! $mem->live ? "<i class='fas fa-check'></i>"
                                        : "<i class='far fa-times-circle'></i>" !!}
                            </td>
                            <td>{{$mem->date->format('F j Y') ?? ''}}</td>
                            <td>
                                <a href="{{ route('admin_memoriam_edit', $mem->id) }}" title="Edit {{ $mem->title }} ">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                            <td> {{ $mem->created_at->format('F j Y H:i:s') }} </td>
                            <td> {{ $mem->updated_at->format('F j Y H:i:s') }} </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10">
                                None created yet
                            </td>
                        </tr>
                    @endforelse
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
                        {{ $data['memoriam']->links() }}
                    </ul>
                </div>
            </div>
            <div class="col"></div>
        </div>
    </form>
@endsection
