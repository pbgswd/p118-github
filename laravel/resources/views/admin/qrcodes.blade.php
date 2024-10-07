@extends('layouts.dashboard',  ['title_icon' => '<i class="fas fa-qrcode"></i>', 'title' => 'Custom QR Codes'])
@section('content')
    <div class='container'>
        <h3 class="mb-4">
           <span class="badge badge-primary badge-pill">
               {{$data['count']}} {{ Str::plural('QR code', $data['count'])}}
           </span>
            | <a href="{{ route('admin_qrcode_create') }}">
                <i class="fas fa-qrcode"></i>
                Create new qrcode
                <i class="far fa-arrow-alt-circle-right"></i> </a>
        </h3>
    </div>
<div class="row mt-3">
    <form name="delete" method="POST" action="{{route('admin_qrcode_destroy')}}">
        {!! csrf_field() !!}
        {!! method_field('DELETE') !!}
        <div class="form-group mt-3">
            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th> @sortablelink('id','#') </th>
                            <th> type </th>
                            <th> data </th>
                            <th> name </th>
                            <th> Edit </th>
                            <th> @sortablelink('created_at', 'Created At') </th>
                            <th> @sortablelink('updated_at', 'Updated At') </th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse ( $data['qrcodes'] as $f )
                        <tr>
                            <td>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="id[]" value="{{ $f->id }}" />
                                    </label>
                                </div>
                            </td>
                            <td>{{$f->qrtype}}</td>
                            <td>{{$f->qrdata}}</td>
                            <td>{{$f->name}}</td>
                            <td>
                                <a href="{{route('admin_qrcode_edit', $f->id)}}" title="edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                            <td>{{$f->created_at}}</td>
                            <td>{{$f->updated_at}}</td>

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
                        {{ $data['qrcodes']->links() }}
                    </ul>
                </div>
            </div>
            <div class="col"></div>
        </div>
    </form>
    </div>
@endsection
