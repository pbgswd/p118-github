@extends('layouts.dashboard')
@section('content')
    <div class='container'>
        <h3>
            {{ $data['action'] }} A QR Code |  <a href="{{ route('admin_qrcodes_list') }}">List qr codes
                <i class="far fa-arrow-alt-circle-right"></i> </a>
        </h3>
    </div>

    <ul>
        <li>Uses <a href="https://packagist.org/packages/simplesoftwareio/simple-qrcode" target="_blank">
                SimpleQRCode</a> </li>
        <li>Create any qr code, text or URL</li>
        <li>Add data</li>
        <li>Add a description for reference later</li>
        <li>Hit Create button to generate qr code</li>
        <li>Type is hard coded to url</li>
    </ul>

    <div class="row mt-lg-3 p-6 mb-3">
        <img src="data:image/png;base64,
            {!! base64_encode(QrCode::format('png')
                ->size(200)
                ->mergeString(Storage::get('public/pXtRRslxfpjHCyakkCXrufsP43qtBN4EwkXxjnQz.png'), .2)
                ->generate('https://iatse118.com')); !!}
        " />
    </div>
    @if($data['action'] == 'Edit')
        <h2>Qr code</h2>
            {!! QrCode::size(200)->generate($data['qrcode']->qrdata) !!}
        <h3>{{$data['qrcode']->qrdata}}</h3>
    @endif

    <form method="post" name="qrcode" action="{{ url()->current() }}" enctype="multipart/form-data"
          class="needs-validation" novalidate>
        {!! csrf_field() !!}

        <input type="hidden" name="qrcode[qrtype]" value="url" />

        <div class="row mt-lg-3">
            <div class="form-group">
                <div class="col-12">
                    <h4>Data to add in QR Code</h4>
                </div>
                <div class="col-12">
                    <input type="text" class="form-control"  placeholder="https://....." name="qrcode[qrdata]"
                           value="{{ old('qrcode.qrdata', $data['qrcode']->qrdata)}}" size="80" required/>
                </div>
            </div>
        </div>

        <div class="row mt-lg-3">
            <div class="form-group">
                <div class="col-12">
                    <h4>Descriptive name for this QR Code</h4>
                </div>
                <div class="col-12">
                    <input type="text" class="form-control"  placeholder="name for it....." name="qrcode[name]"
                           value="{{ old('qrcode.name', $data['qrcode']->name)}}" size="80" required/>
                </div>
            </div>
        </div>



<!--
        <div class="row mt-lg-3">
            <div class="form-group">
                <label for="exampleFormControlSelect1">QR type</label>
                <select name="qrcode[qrType]" class="form-control" id="QRtypeSelect1">
                    <option value="url">URL</option>
                    <option value="email">Email</option>
                    <option value="phoneNumber">Phone Number</option>
                    <option value="SMS">SMS</option>
                    <option value="WiFi">WiFi</option>
                </select>
            </div>
        </div>
-->

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
                <input type="checkbox" name="id[]" value="{{$data['qrcode']->id}}" />
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
