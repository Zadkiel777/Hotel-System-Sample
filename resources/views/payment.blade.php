@extends('themes.main')

@section('title', 'Payment History')

@section('content_header')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"><i class="fas fa-file-invoice-dollar mr-1"></i> Payment History</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Payments</li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<section class="content">
    <div class="container-fluid">
        @include('layout.partials.alerts')
        <div class="row">
            <div class="col-12">
                <div class="card card-outline card-primary">
                    
                    {{-- Header: Title & Search --}}
                    <div class="card-header">
                        <h3 class="card-title mt-1">
                            <i class="fas fa-list mr-1"></i> Transaction List
                        </h3>

                        <div class="card-tools">
                            <form action="{{ route('payments') }}" method="GET">
                                <div class="input-group input-group-sm" style="width: 250px;">
                                    <input type="text" name="search" class="form-control float-right" placeholder="Search Name, Room or ID..." value="{{ request('search') }}">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            {{-- Table: Compact, Striped, Hover, No-Wrap --}}
                            <table id="paymentTable" class="table table-striped table-hover table-sm text-nowrap">
                                <thead class="thead-light">
                                    <tr>
                                        <th style="width: 80px;">ID</th>
                                        <th>Reference</th>
                                        <th>Payer Name</th>
                                        <th>Payment Type</th>
                                        <th>Amount</th>
                                        <th>Date Paid</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($payments as $payment)
                                        <tr>
                                            {{-- Payment ID --}}
                                            <td class="align-middle text-center font-weight-bold">
                                                #{{ $payment->id }}
                                            </td>

                                            {{-- Reference (Booking/Room) --}}
                                            <td class="align-middle">
                                                @if(isset($payment->booking_id) && $payment->booking_id)
                                                    <div class="small">
                                                        <i class="fas fa-bookmark text-muted mr-1"></i> Ref: <strong>{{ $payment->booking_id }}</strong>
                                                    </div>
                                                @endif
                                                @if(isset($payment->room_number))
                                                    <div class="small text-primary">
                                                        <i class="fas fa-bed mr-1"></i> Room {{ $payment->room_number }}
                                                    </div>
                                                @endif
                                                @if(!isset($payment->booking_id) && !isset($payment->room_number))
                                                    <span class="text-muted small">N/A</span>
                                                @endif
                                            </td>

                                            {{-- Payer Name --}}
                                            <td class="align-middle">
                                                @if($payment->Fname)
                                                    <div class="font-weight-bold text-dark">
                                                        {{ $payment->Fname }} {{ $payment->Lname }}
                                                    </div>
                                                @else
                                                    <div class="font-weight-bold text-secondary">Guest Customer</div>
                                                    <small class="badge badge-secondary">Walk-in</small>
                                                @endif
                                            </td>

                                            {{-- Payment Type --}}
                                            <td class="align-middle">
                                                @php
                                                    $method = $payment->payment_option;
                                                    $badgeClass = ($method == 'Cash') ? 'success' : 'info';
                                                    $icon = ($method == 'Cash') ? 'fa-money-bill-wave' : 'fa-credit-card';
                                                @endphp
                                                <span class="badge badge-{{ $badgeClass }} px-2 py-1">
                                                    <i class="fas {{ $icon }} mr-1"></i> {{ $method }}
                                                </span>
                                            </td>

                                            {{-- Amount --}}
                                            <td class="align-middle">
                                                <h5 class="text-success font-weight-bold mb-0">
                                                    ₱{{ number_format($payment->amount, 2) }}
                                                </h5>
                                            </td>

                                            {{-- Date --}}
                                            <td class="align-middle">
                                                <div class="small text-muted">
                                                    <i class="far fa-calendar-alt mr-1"></i>
                                                    {{ date('M d, Y', strtotime($payment->paid_at)) }}
                                                </div>
                                                <div class="small text-muted">
                                                    <i class="far fa-clock mr-1"></i>
                                                    {{ date('h:i A', strtotime($payment->paid_at)) }}
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-5 text-muted">
                                                <i class="fas fa-file-invoice-dollar fa-3x mb-3 opacity-50"></i><br>
                                                No payment records found.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Pagination --}}
                    @if($payments->hasPages())
                        <div class="card-footer clearfix">
                            <div class="float-right">
                                {{ $payments->links('pagination::simple-bootstrap-5') }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection