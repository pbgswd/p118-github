@extends('layouts.dashboard',  ['title' => '<i class="fas fa-list"></i> List Posts for ' . $data['committee']->name])
@section('content')
<div class="container">
    <div class="row mb-lg-2">
        <div class="col-4">
            <a href="{{ route('admin_committee_show', $data['committee']->slug) }}"
               title="Back to admin {{$data['committee']->name}} view">
                <i class="fas fa-arrow-circle-left"></i> Back
            </a>
        </div>
        <div class="col-4">
           <span class="badge badge-primary badge-pill">
               {!!  $data['posts']->count()  !!}
               {{Str::plural('Post', $data['posts']->count())}}
           </span>
        </div>
        <div class="col-4">
            <a href="{{route('admin_committee_post', $data['committee']->slug)}}">
                <i class="fas fa-pen-square"></i>
                Add New Post in  {{$data['committee']->name}}
            </a>
        </div>
    </div>
</div>
<div class="container">
    <form name="delete" method="POST" action="{{route('committee_post_destroy', $data['committee']->slug)}}">
        {!! csrf_field() !!}
        {!! method_field('DELETE') !!}
        <div class="form-group">
            <div class="table-responsive-lg">
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th> @sortablelink('id','#') </th>
                            <th> @sortablelink('title', 'Title') </th>
                            <th> @sortablelink('live', 'Is Live?') </th>
                            <th> @sortablelink('sticky', 'Sticky') </th>
                            <th> Edit </th>
                            <th> @sortablelink('created_at', 'Created At') </th>
                            <th> @sortablelink('updated_at', 'Updated At') </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ( $data['posts'] as $p )
                            <tr>
                                <td>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="id[]" value="{{$p->id}}" />
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <h5>
                                        <a title="{{ $p->title}}"
                                           href="{{ route('admin_committee_post_edit',
                                                    [$data['committee']->slug, $p->slug]) }}">
                                            {{ $p->title}}
                                        </a>
                                    </h5>
                                </td>
                                <td>
                                    {!! $p->live ? "<i class='fas fa-check'></i>" :
                                            "<i class='far fa-times-circle'></i>" !!}
                                </td>
                                <td>
                                    {!! $p->sticky ? '<i class="fas fa-check"></i>' :
                                        '<i class="far fa-times-circle"></i>' !!}
                                </td>
                                <td>
                                    <a href="{{ route('admin_committee_post_edit',
                                                [$data['committee']->slug, $p->slug]) }}"
                                       title="Edit {{ $p->title }}">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                                <td> {{ $p->created_at->format('F j Y H:i:s') }} </td>
                                <td> {{ $p->updated_at->format('F j Y H:i:s') }} </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">&nbsp
                                    No posts in {{$data['committee']->name}}
                                </td>
                            </tr>
                        @endforelse
                        <tr>
                            <td colspan="7">&nbsp;</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row mb-lg-5 mt-lg-5">
            <div class="col">
                @if( $data['posts']->count() > 0)
                    <i class="far fa-trash-alt fa-2x"></i>
                    <input class="btn btn-outline-danger" type="submit" value="Delete Selected">
                @endif
            </div>
            <div class="col-6">
                <div class="list-group">
                    <ul class="pagination">
                         {{ $data['posts']->links() }}
                    </ul>
                </div>
            </div>
            <div class="col"></div>
        </div>
    </form>
</div>
@endsection
