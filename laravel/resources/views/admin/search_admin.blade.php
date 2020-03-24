@extends('layouts.dashboard',  ['title' => '<i class="fas fa-list"></i> List Search Results'])
@section('content')
<div class="container">
        <h3>
           <span class="badge badge-primary badge-pill">
               {!! $data['results']->count()  !!} Results from search
           </span>

        </h3>
</div>
    <div class="form-group">
        <div class="table-responsive">
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th> @sortablelink('title', 'Title') </th>
                        <th> @sortablelink('access_level', 'Access Level') </th>
                        <th> @sortablelink('live', 'Is Live?') </th>
                        <th> @sortablelink('sort_order', 'Sort Order') </th>
                        <th> @sortablelink('in_menu', 'In Menu?') </th>
                        <th> @sortablelink('allow_comments', 'Allow Comments?') </th>
                        <th> Edit </th>
                        <th> @sortablelink('created_at', 'Created At') </th>
                        <th> @sortablelink('updated_at', 'Updated At') </th>
                    </tr>
                </thead>
                <tbody>
                @foreach ( $data['results'] as $i )
                    <tr>
                        <td>
                            <h4>
                                <a title="{{ $i->title }}" href="{{ $i->url }}">{{ $i->title }}</a>
                            </h4>
                        </td>
                        <td> {{ $i->searchable->access_level }} </td>
                        <td> {!! $i->searchable->live ? "<i class='fas fa-check'></i>" : "<i class='far fa-times-circle'></i>" !!} </td>
                        <td> {{ $i->searchable->sort_order }} </td>
                        <td> {!! $i->searchable->in_menu ? '<i class="fas fa-check"></i>' : '<i class="far fa-times-circle"></i>' !!} </td>
                        <td> {!! $i->searchable->allow_comments ? "<i class='fas fa-check'></i>" : '<i class="far fa-times-circle"></i>' !!} </td>
                        <td>
                            <a href="{{ $i->url }}" title="Edit {{ $i->title }} ">
                                <i class="fas fa-edit"></i>
                            </a>
                        </td>
                        <td> {{ $i->searchable->created_at }} </td>
                        <td> {{ $i->searchable->updated_at }} </td>
                    </tr>
                @endforeach
                    <tr>
                        <td colspan="9">&nbsp;</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <i class="far fa-trash-alt fa-2x"></i>
            <input class="btn btn-outline-danger" type="submit" value="Delete Selected">
        </div>
        <div class="col-6">

        </div>
        <div class="col"></div>
    </div>
    <div class="row mt-lg-5"></div>
</form>

@endsection
