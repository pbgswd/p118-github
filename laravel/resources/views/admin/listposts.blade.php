@extends('layouts.dashboard',  ['title' => '<i class="fas fa-list"></i> List Posts'])
@section('content')
<div class="container">
    <h3>
       <span class="badge badge-primary badge-pill">
           {!! $data['posts']->total()  !!}
       </span>
        posts. |
        <a href="{{ route('post_create') }}">Create new post
            <i class="far fa-arrow-alt-circle-right"></i>
        </a>
    </h3>
</div>
<form name="delete" method="POST" action="{{route('post_destroy')}}">
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
                        <th> @sortablelink('front_page', 'Front Page') </th>
                        <th> @sortablelink('landing_page', 'Landing Page') </th>
                        <th> Edit </th>
                        <th> @sortablelink('created_at', 'Created At') </th>
                        <th> @sortablelink('updated_at', 'Updated At') </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ( $data['posts'] as $i )
                        <tr>
                            <td>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="ids[]" value="{{ $i->id }}" />
                                    </label>
                                </div>
                            </td>
                            <td>
                                <h4>
                                    <a title="{{ $i->title }}" href="{{ route('post_edit', $i->slug) }}">
                                        {{ $i->title }}
                                    </a>
                                </h4>
                                <h6>
                                    Topics:
                                    @forelse($i->topics as $t)
                                        {{$t->name}}{{$loop->last ? '' : ","}}
                                    @empty
                                        no topics
                                    @endforelse
                                </h6>
                                {{$i->attachments->count()}} {{Str::plural('Attachment', $i->attachments->count())}} <br />
                                <h6>
                                    Added by:
                                    <a href="{{route('member', $i->user->id)}}" target="_blank">
                                        {{$i->user->name}}
                                    </a>
                                </h6>
                            </td>
                            <td> {{ $i->access_level }} </td>
                            <td>
                                {!! $i->live ? "<i class='fas fa-check'></i>" :
                                    "<i class='far fa-times-circle'></i>" !!}
                            </td>
                            <td>
                                {!! $i->front_page ? '<i class="fas fa-check"></i>' :
                                    '<i class="far fa-times-circle"></i>' !!}
                            </td>
                            <td>
                                {!! $i->landing_page ? "<i class='fas fa-check'></i>" :
                                    '<i class="far fa-times-circle"></i>' !!}
                            </td>
                            <td>
                                <a href="{{ route('post_edit', $i->slug) }}" title="Edit {{ $i->name }} ">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                            <td> {{ $i->created_at->format('F j Y H:i:s') }} </td>
                            <td> {{ $i->updated_at->format('F j Y H:i:s') }} </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col">
            <i class="far fa-trash-alt fa-2x"></i>
            <input class="btn btn-outline-danger" type="submit" value="Delete Selected">
        </div>
        <div class="col-6">
            <div class="list-group">
                <ul class="pagination">
                    {!! $data['posts']->links() !!}
                </ul>
            </div>
        </div>
        <div class="col"></div>
    </div>
</form>
@endsection
