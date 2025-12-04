@extends('themes.main')

@section('title', 'My Booking')

@section('content_header')
<nav class="navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                <i class="fas fa-bars"></i>
            </a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ route('customerDashboard') }}" class="nav-link">My Dashboard</a>
        </li>
    </ul>
</nav>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"><i class="fas fa-receipt mr-1"></i> Booking Summary</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('customerDashboard') }}"><i class="fas fa-home"></i> Dashboard</a></li>
                    <li class="breadcrumb-item active"><i class="fas fa-receipt"></i> Booking</li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card card-primary">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title"><i class="fas fa-info-circle mr-1"></i> Booking Details</h3>
                        <span class="badge badge-light">
                            Ref: #{{ $booking->id }}
                        </span>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <strong><i class="fas fa-user mr-1"></i> Name:</strong>
                                <p class="text-muted mb-0">{{ $booking->Fname }} {{ $booking->Lname }}</p>
                                <small class="text-muted">{{ $booking->email }}</small>
                            </div>
                            <div class="col-md-6">
                                <strong><i class="fas fa-phone mr-1"></i> Contact:</strong>
                                <p class="text-muted mb-0">{{ $booking->contact }}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <strong><i class="fas fa-bed mr-1"></i> Room:</strong>
                                <p class="text-muted mb-0">
                                    Room {{ $booking->room_number }} ({{ $booking->room_type }})
                                </p>
                            </div>
                            <div class="col-md-6">
                                <strong><i class="fas fa-clipboard-check mr-1"></i> Status:</strong>
                                <p class="mb-0">
                                    @php
                                        $badgeColor = 'badge-secondary';
                                        if($booking->status == 'Confirmed') $badgeColor = 'badge-success';
                                        if($booking->status == 'Pending') $badgeColor = 'badge-warning';
                                        if($booking->status == 'Cancelled') $badgeColor = 'badge-danger';
                                        if($booking->status == 'Occupied') $badgeColor = 'badge-primary';
                                        if($booking->status == 'Completed') $badgeColor = 'badge-info';
                                    @endphp
                                    <span class="badge {{ $badgeColor }}">{{ ucfirst($booking->status) }}</span>
                                </p>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-4">
                                <strong><i class="fas fa-calendar-alt mr-1"></i> Check-in:</strong>
                                <p class="text-muted mb-0">{{ date('M d, Y', strtotime($booking->check_in_date)) }}</p>
                            </div>
                            <div class="col-md-4">
                                <strong><i class="fas fa-calendar-alt mr-1"></i> Check-out:</strong>
                                <p class="text-muted mb-0">{{ date('M d, Y', strtotime($booking->check_out_date)) }}</p>
                            </div>
                            <div class="col-md-4">
                                <strong><i class="fas fa-moon mr-1"></i> Nights:</strong>
                                <p class="text-muted mb-0">{{ $booking->nights }}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <strong><i class="fas fa-tag mr-1"></i> Rate per Night:</strong>
                                <p class="text-muted mb-0">₱ {{ number_format($booking->rate_per_night, 2) }}</p>
                            </div>
                            <div class="col-md-6">
                                <strong><i class="fas fa-receipt mr-1"></i> Total Amount:</strong>
                                <p class="text-muted mb-0">₱ {{ number_format($booking->total_amount, 2) }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <a href="{{ route('customerDashboard') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left mr-1"></i> Back to My Bookings
                        </a>
                        <div>
                            @if(in_array($booking->status, ['Pending', 'Confirmed']))
                                <form action="{{ route('customer.cancelBooking', $booking->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to cancel this booking?');">
                                    @csrf
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fas fa-times mr-1"></i> Cancel Booking
                                    </button>
                                </form>
                            @endif
                            <button class="btn btn-outline-primary ml-2" onclick="window.print();">
                                <i class="fas fa-print mr-1"></i> Print
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection


