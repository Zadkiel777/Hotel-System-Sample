@extends('themes.main')

{{-- Define the page title --}}
@section('title', 'Payment History')

{{-- Content Header Section (Breadcrumbs) --}}
@section('content_header')

<nav class="navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                <i class="fas fa-bars"></i>
            </a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ route('dashboard') }}" class="nav-link">Home</a>
        </li>
    </ul>

    <form class="form-inline ml-3" action="{{ route('payments') }}" method="GET">
        <div class="input-group input-group-sm">
            <input 
                class="form-control form-control-navbar" 
                type="search" 
                name="search" 
                placeholder="Search by Name, Room or ID..."
                aria-label="Search"
                value="{{ request('search') }}">
            <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                    <i class="fas fa-search"></i>
                </button>
                @if(request('search'))
                    <a href="{{ route('payments') }}" class="btn btn-navbar" type="button">
                        <i class="fas fa-times"></i>
                    </a>
                @endif
            </div>
        </div>
    </form>

    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
    </ul>
</nav>


<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"><i class="fas fa-file-invoice-dollar mr-1"></i> Payment History</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active"><i class="fas fa-money-bill-wave"></i> Payments</li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection

{{-- Main Content Block --}}
@section('content')
<section class="content">
    <div class="container-fluid">
        @include('layout.partials.alerts')
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title"><i class="fas fa-list mr-1"></i> List of Transactions</h3>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="paymentTable" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>ID / Reference</th> {{-- ✅ Updated Header --}}
                                        <th><i class="fas fa-user"></i> Payer Name</th>
                                        <th><i class="fas fa-credit-card"></i> Payment Type</th>
                                        <th><i class="fas fa-tag"></i> Amount</th>
                                        <th><i class="fas fa-calendar-alt"></i> Date Paid</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($payments as $payment)
                                        <tr>
                                            {{-- ✅ UPDATED COLUMN: Shows Payment ID + Booking Context --}}
                                            <td>
                                                <strong>#{{ $payment->id }}</strong>
                                                
                                                @if(isset($payment->booking_id) && $payment->booking_id)
                                                    <div style="font-size: 0.9em; margin-top: 4px;">
                                                        <span class="text-muted">
                                                            <i class="fas fa-bookmark"></i> Ref: {{ $payment->booking_id }}
                                                        </span>
                                                        @if(isset($payment->room_number))
                                                            <br>
                                                            <span class="text-primary">
                                                                <i class="fas fa-bed"></i> Room {{ $payment->room_number }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                @endif
                                            </td>
                                            
                                            <td>
                                                @if($payment->Fname)
                                                    <span class="badge bg-primary">Member</span>
                                                    <strong>{{ $payment->Fname }} {{ $payment->Lname }}</strong>
                                                @else
                                                    <span class="badge bg-secondary">Guest</span>
                                                    <span class="text-muted">Walk-in Customer</span>
                                                @endif
                                            </td>

                                            <td>
                                                <span class="badge {{ $payment->payment_option == 'Cash' ? 'badge-success' : 'badge-info' }}">
                                                    {{ $payment->payment_option }}
                                                </span>
                                            </td>

                                            <td>₱{{ number_format($payment->amount, 2) }}</td>

                                            <td>{{ date('M d, Y', strtotime($payment->paid_at)) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">
                                                <i class="fas fa-info-circle mr-1"></i> No payment records found.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-center mt-3">
                            {{ $payments->links('pagination::bootstrap-5') }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection