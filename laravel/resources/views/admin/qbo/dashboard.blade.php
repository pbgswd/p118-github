@extends('layouts.dashboard',  ['title_icon' => '<i class="fas fa-paint-brush"></i>', 'title' => 'QBO Dashboard. Members Dues'])
@section('content')
<script>
    console.log('inside admin-blank.blade the template file');
</script>
<div class="row">
    <div class="col-12">
        <div class="page-header">

            <img src="https://iatse118.com/public/download/2243" class="rounded"
                 title="qb-logo-on-ice-100-bkg-photo.svg" />
        </div>
        @if (session('status'))
            <div class="status-message">
                {{ session('status') }}
            </div>
        @endif
        @if (!$qboConnected)
            <div class="status-message status-warning">
                QuickBooks is not connected. <a href="{{ route('qbo.connect') }}">Reconnect now</a>.
            </div>
        @endif
        @if (session('qbo_error'))
            <div class="status-message status-warning">
                {{ session('qbo_error') }}
            </div>
        @endif
    </div>
</div>
<div class="row">
    <div class="col-12 mt-4">
        <a class="btn btn-outline-primary mr-6" href="{{ url('/admin') }}" role="button">Admin homepage</a>
        <a href="{{ route('qbo.connect') }}" class="btn btn-outline-primary mr-6" role="button">qbo connect</a>
        <a href="{{ route('qbo.callback') }}" class="btn btn-outline-primary mr-6" role="button">qbo callback</a>
        <a href="{{ route('qbo.customers') }}" class="btn btn-outline-primary" role="button">qbo customers</a>
    </div>
</div>
<div class="row">
    <div class="col-12">
    </div>
</div>
@endsection
