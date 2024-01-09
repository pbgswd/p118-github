@extends('layouts.dashboard')
@section('content')
    <div class='row mb-4'>
        <h3>
            <i class="fas fa-qrcode"></i>
            {{ $data['action'] }} QR Code |  <a href="{{ route('admin_qrcodes_list') }}">List QR Codes
                <i class="far fa-arrow-alt-circle-right"></i> </a>
        </h3>
    </div>
    @if($data['action'] == 'Create')
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <ul>
                    <li>Uses <a href="https://packagist.org/packages/simplesoftwareio/simple-qrcode" target="_blank">
                            SimpleQRCode</a> </li>
                    <li>{{$data['action']}}  a qr code for a url</li>
                    <li>{{$data['action']}} link data</li>
                    <li>{{$data['action']}}  a description, used as alt tag</li>
                    <li>Make a code img like the image on the right</li>
                </ul>
            </div>
            <div class="col-sm-12 col-md-6">
                <img src="data:image/png;base64,
                {!! base64_encode(QrCode::format('png')
                    ->size(300)
                    ->mergeString(Storage::get('public/hvkugrmHIIT9Nlzy0TI2eNTDcbPkCJ5pOdII2XU1.png'), .2)
                    ->generate('https://iatse118.com')); !!}
            " />
                <h4>https://iatse118.com</h4>
            </div>
        </div>
    @endif
    @if($data['action'] == 'Edit')
            <img src="/storage/qrcodes/{!! $data['qrcode']['file'] !!}" alt="{{$data['qrcode']['name']}}" />
        <h4>{{$data['qrcode']['qrdata']}}</h4>
        <h3>
            <a href="{{route('qrcode_download', $data['qrcode']['id'])}}"
               title="download {{$data['qrcode']['name']}}"
                target="_blank">
                Download it
            </a>
        </h3>
    @endif
    <form method="post" name="qrcode" action="{{ url()->current() }}" enctype="multipart/form-data"
          class="needs-validation" novalidate>
        {!! csrf_field() !!}

        <input type="hidden" name="qrcode[qrtype]" value="url" />

        <div class="row mt-lg-3">
            <div class="form-group">
                <div class="col-12">
                    <h4>Data to {{strtolower($data['action'])}}  in QR Code</h4>
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
                <select name="qrcode[qrtype]" class="form-control" id="QRtypeSelect1">
                    <option value="url">URL</option>
                    <option value="email">Email</option>
                    <option value="phoneNumber">Phone Number</option>
                    <option value="SMS">SMS</option>
                    <option value="WiFi">WiFi</option>
                </select>
            </div>
        </div>
-->
        <div class="row p-2 pb-5">

            <div class="col-sm-12 col-md-2">
                <i class="fas fa-edit fa-2x"></i>
                <input class="btn btn-outline-primary" type="submit" value="{{ $data['action'] }}" />
            </div>
        </div>
    </form>

    @if ($data['action'] == 'Edit')
        <div class="row p-2 pb-5">
        <form name="delete" method="POST" action="{{route('admin_qrcode_destroy')}}">
            {!! csrf_field() !!}
            {!! method_field('DELETE') !!}

            <div class="col-12 col-md-8">
                Check to delete
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="id[]" value="{{$data['qrcode']->id}}" />
                    </label>
                </div>
            </div>

            <div class="col-12 col-md-2">
                <i class="far fa-trash-alt fa-2x"></i>
                <input class="btn btn-outline-danger" type="submit" value="Delete Selected">
            </div>
        </form>
    @endif
</div>
@endsection
