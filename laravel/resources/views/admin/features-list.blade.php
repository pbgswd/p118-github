@extends('layouts.dashboard')
@section('content')
    <div class='container'>
        <h3>
           <span class="badge badge-primary badge-pill">
               {{$data['features']->count()}} {{ Str::plural('Feature', $data['features']->count())}}
           </span>
            | <a href="{{ route('admin_feature_create') }}">Create new Feature
                <i class="far fa-arrow-alt-circle-right"></i> </a>
        </h3>
    </div>
    <form name="delete" method="POST" action="{{route('admin_feature_destroy')}}">
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
                    @forelse ( $data['features'] as $f )
                        <tr>
                            <td>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="id[]" value="{{$f->id}}" />
                                    </label>
                                </div>
                            </td>
                            <td>
                                @if($f->image)
                                <img src="{{asset('storage/public/'.
                                    $data['thumbs']['tn_str'].$f->image)}}" class="rounded" />
                                @endif
                                <h4>
                                    <a title="{{ $f->title }}" href="{{ route('admin_feature_edit', $f->slug) }}">
                                        {{ $f->title }}
                                    </a>
                                </h4>
                            </td>
                            <td>
                                {!! $f->live ? "<i class='fas fa-check'></i>"
                                        : "<i class='far fa-times-circle'></i>" !!}
                            </td>
                            <td>{{$f->date->format('F j Y') ?? ''}}</td>
                            <td>
                                <a href="{{ route('admin_bylaw_edit', $f->id) }}" title="Edit {{ $f->title }} ">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                            <td> {{ $f->created_at->format('F j Y H:i:s') }} </td>
                            <td> {{ $f->updated_at->format('F j Y H:i:s') }} </td>
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
                        {{ $data['features']->links() }}
                    </ul>
                </div>
            </div>
            <div class="col"></div>
        </div>
    </form>
@endsection
