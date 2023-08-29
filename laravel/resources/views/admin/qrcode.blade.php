@extends('layouts.dashboard')
@section('content')
    <div class='container'>
        <h3>
          Create A QR Code |  <a href="{{ route('admin_qrcodes_list') }}">List qr codes
                <i class="far fa-arrow-alt-circle-right"></i> </a>
        </h3>
    </div>

<ul>
    <li>Select type of QR Code</li>
    <li>Add data</li>
    <li>Hit Create button to generate qr code</li>
</ul>

    <form method="post" name="qrcode" action="{{ url()->current() }}" enctype="multipart/form-data"
          class="needs-validation" novalidate>
        {!! csrf_field() !!}

        <div class="row mt-lg-3">
            <div class="form-group">
                <div class="col-12">
                    <h4>URL to create</h4>
                </div>
                <div class="col-12">
                    <input type="text" class="form-control"  placeholder="https://....." name="qrcode[url]"
                           value="{{ old('qrcode.url', $data['qrcode']->url)}}" size="80" required/>
                </div>
            </div>
        </div>

        <div class="col-6">
            <div class="col-lg-2">
                <h4>Status</h4>
            </div>
            <div class="col-sm">
                <label>
                    <input name="qrcode[live]" type="hidden" value="0" />
                    <input name="qrcode[live]" type="checkbox" value="1"
                        {{ checked(old('qrcode.live', $data['qrcode']->live)) }} />
                    Check now to make Live
                </label>
                <p>ie.: Draft or Published.</p>
            </div>
        </div>
        <div class="row p-2">
            <div class="col-12 col-md-6">
                <i class="fas fa-edit fa-2x"></i>
                <input class="btn btn-outline-primary" type="submit" value="{{ $data['action'] }}" />
            </div>
    </form>


    @if ($data['action'] == 'Edit')
    <form name="delete" method="POST" action="{{route('admin_qrcode_destroy')}}">
        {!! csrf_field() !!}
        {!! method_field('DELETE') !!}
        <div class="form-group">
        Check to delete

        <div class="checkbox">
            <label>
                <input type="checkbox" name="id[]" value="" />
            </label>
        </div>



        <div class="row mb-lg-5">
            <div class="col">
                <i class="far fa-trash-alt fa-2x"></i>
                <input class="btn btn-outline-danger" type="submit" value="Delete Selected">
            </div>
            <div class="col-6">

            </div>
            <div class="col"></div>
        </div>
    </form>
    @endif
@endsection
