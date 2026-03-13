@extends('layouts.dashboard',  ['title_icon' => '<i class="fas fa-paint-brush"></i>', 'title' => 'Customer Lookup'])
@section('content')
<script>
    console.log('inside customer template file');
</script>

<div class="row">
    <div class="col-12 mb-4">
            <a href="{{ route('qbo.customers') }}" class="btn btn-outline-primary" role="button">&larr; All Customers</a>
    </div>
</div>
<div class="row">
    <div class="col-6 mb-4">
        <div class="input-group mb-3">
            <form method="GET" action="{{ route('qbo.customer') }}">
                <input class="form-control"type="email" name="email" placeholder="Enter customer email address"
                       aria-label="Enter customer email address"
                       value="{{ $email ?? '' }}" required>
                <br />
                <input class="btn btn-outline-primary" type="submit" value="Search by email">
            </form>
        </div>
    </div>
</div>
        @if ($email !== null)
            @if ($customer)
                <div class="panel">
                    <div class="detail-row">
                        <span class="detail-label">Name</span>
                        <span class="detail-value">{{ $customer->DisplayName ?? '—' }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Company</span>
                        <span class="detail-value">{{ $customer->CompanyName ?? '—' }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Email</span>
                        <span class="detail-value">{{ $customer->PrimaryEmailAddr->Address ?? '—' }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Phone</span>
                        <span class="detail-value">{{ $customer->PrimaryPhone->FreeFormNumber ?? '—' }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Balance</span>
                        <span class="detail-value">${{ number_format($customer->Balance ?? 0, 2) }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Status</span>
                        <span class="detail-value">
                        @if ($customer->Active === 'true' || $customer->Active === true)
                                <span class="badge badge-active">Active</span>
                            @else
                                <span class="badge badge-inactive">Inactive</span>
                            @endif
                    </span>
                    </div>
                </div>
            @else
                <div class="panel">
                    <div class="not-found">No customer found with email <strong>{{ $email }}</strong>.</div>
                </div>
            @endif
        @endif


    </div>
</div>
<div class="row">
    <div class="col-12">
    </div>
</div>

@endsection
