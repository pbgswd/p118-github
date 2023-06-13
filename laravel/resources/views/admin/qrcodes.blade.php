@extends('layouts.dashboard')
@section('content')
    <div class='container'>
        <h3>
           <span class="badge badge-primary badge-pill">
               {{$data['qrcodes']->count()}} {{ Str::plural('QR code', $data['qrcodes']->count())}}
           </span>
            | <a href="{{ route('admin_qrcode_create') }}">Create new qrcode
                <i class="far fa-arrow-alt-circle-right"></i> </a>
        </h3>
    </div>

    <form name="delete" method="POST" action="{{route('admin_qrcode_destroy')}}">
        {!! csrf_field() !!}
        {!! method_field('DELETE') !!}
        <div class="form-group">
            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th> @sortablelink('id','#') </th>
                            <th>   </th>
                            <th>   </th>
                            <th>  </th>
                            <th> Edit </th>
                            <th> @sortablelink('created_at', 'Created At') </th>
                            <th> @sortablelink('updated_at', 'Updated At') </th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse ( $data['qrcodes'] as $f )
                        <tr>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="id[]" value="{{ $f->id }}" />
                                </label>
                            </div>
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
@endsection
