@extends('layouts.dashboard',  ['title_icon' => '<i class="fas fa-paint-brush"></i>', 'title' => 'QuickBooks Customers - Members info'])
@section('content')
<script>
    console.log('inside customers template file');
</script>

<div class="row">
    <div class="col-12">
        <img src="https://iatse118.com/public/download/2243" class="img-thumbnail" style="width:10em;"
             title="qb-logo-on-ice-100-bkg-photo.svg" />
        <p class="subtitle">Customer list synced from your QBO sandbox.</p>
    </div>
</div>
<div class="row">
    <div class="col-12 mb-4">
        <a href="{{ route('qbo.dashboard') }}" class="btn btn-outline-primary" role="button">&larr; Dashboard</a>
        @if (session('status'))
            <div class="status-message">
                {{ session('status') }}
            </div>
        @endif
    </div>
</div>

            <div class="table-responsive">
                @if (count($customers) > 0)
                    <div class="table align-middle">
                        <table>
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Balance</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($customers as $customer)
                                <tr>
                                    <td>{{ $customer->DisplayName ?? '—' }}</td>
                                    <td>
                                        <a href="{{route('qbo.customer', ['email' => $customer->PrimaryEmailAddr->Address ?? ''] )}}">
                                            {{ $customer->PrimaryEmailAddr->Address ?? '<span class="text-muted">—</span>' }}
                                        </a>
                                    </td>
                                    <td>{{ $customer->PrimaryPhone->FreeFormNumber ?? '<span class="text-muted">—</span>' }}</td>
                                    <td>${{ number_format($customer->Balance ?? 0, 2) }}</td>
                                    <td>
                                        @if ($customer->Active === 'true' || $customer->Active === true)
                                            <span class="badge badge-active">Active</span>
                                        @else
                                            <span class="badge badge-inactive">Inactive</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="customer-count">
                        {{ count($customers) }} customer{{ count($customers) !== 1 ? 's' : '' }} found
                    </div>
                @else
                    <div class="empty-state">
                        <p>No customers found in your QuickBooks account.</p>
                        <a href="{{ route('qbo.connect') }}" class="btn-primary">Reconnect to QuickBooks</a>
                    </div>
                @endif
            </div>

<div class="row">
    <div class="col-12">
        placeholder
    </div>
</div>

@endsection
