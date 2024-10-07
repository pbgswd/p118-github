@extends('layouts.dashboard',  ['title_icon' => '<i class="fas fa-list"></i>', 'title' => ' List organizations'])
@section('content')
<div class="container">
        <h3>
           <span class="badge badge-primary badge-pill">
               {!! count($data['organizations'])  !!}
           </span>
            organizations. | <a href="{{ route('organization_create') }}">Create new organization <i class="far fa-arrow-alt-circle-right"></i> </a>
        </h3>
</div>

    @if(count($data['organizations']) < 1)
    No organizations
    @else
<form name="delete" method="POST" action="{{route('organization_destroy')}}">
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
                        <th> Edit </th>
                        <th> @sortablelink('created_at', 'Created At') </th>
                        <th> @sortablelink('updated_at', 'Updated At') </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ( $data['organizations'] as $org )
                        <tr>
                            <td>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="id[]" value="{{$org->id}}" />
                                    </label>
                                </div>
                            </td>
                            <td>
                                <h4>
                                    <a title="{{ $org->name }}" href="{{ route('organization_edit', $org->slug) }}">
                                        {{ $org->name }}
                                    </a>
                                </h4>
                                <h6>
                                    {{$org->all_agreements->count() ?? 0}}
                                    {{Str::plural('Agreement', $org->all_agreements->count() ?? 0)}}
                                    <br />
                                    {{$org->attachments->count() ?? 0}}
                                    {{Str::plural('Attachment', $org->attachments->count() ?? 0)}}
                                </h6>
                            </td>
                            <td> {{ $org->access_level }} </td>
                            <td>
                                {!! $org->live ? "<i class='fas fa-check'></i>"
                                    : "<i class='far fa-times-circle'></i>" !!}
                            </td>
                            <td>
                                <a href="{{ route('organization_edit', $org->slug) }}" title="Edit {{ $org->name }} ">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                            <td> {{ $org->created_at->format('F j Y H:i:s') }} </td>
                            <td> {{ $org->updated_at->format('F j Y H:i:s') }} </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="8">&nbsp;</td>
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
            <div class="list-group">
                <ul class="pagination">
                     {{ $data['organizations']->links() }}
                </ul>
            </div>
        </div>
        <div class="col"></div>
    </div>



    <div class="row" style="margin-top:6em;"></div>
</form>
@endif
@endsection
