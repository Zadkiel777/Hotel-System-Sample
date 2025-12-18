@extends('themes.main')

@section('title', 'Booking Details')

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
</nav>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"><i class="fas fa-calendar-check mr-1"></i> Booking Details</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i> Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('bookedRooms') }}"><i class="fas fa-calendar-check"></i> Booked Rooms</a></li>
                    <li class="breadcrumb-item active"><i class="fas fa-eye"></i> View</li>
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
                <!-- Booking Information Card -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-info-circle mr-1"></i> Booking Information</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <strong><i class="fas fa-hashtag mr-1"></i> Booking ID:</strong>
                                <p class="text-muted">#{{ $booking->id }}</p>
                            </div>
                            <div class="col-md-6">
                                <strong><i class="fas fa-info-circle mr-1"></i> Status:</strong>
                                <p>
                                    @php
                                        $badgeColor = 'badge-secondary';
                                        if($booking->status == 'Confirmed') $badgeColor = 'badge-success';
                                        if($booking->status == 'Pending') $badgeColor = 'badge-warning';
                                        if($booking->status == 'Cancelled') $badgeColor = 'badge-danger';
                                        if($booking->status == 'Occupied') $badgeColor = 'badge-primary';
                                    @endphp
                                    <span class="badge {{ $badgeColor }}">{{ ucfirst($booking->status) }}</span>
                                </p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <strong><i class="fas fa-tools mr-1"></i> Actions:</strong>
                                <div class="mt-2 d-flex flex-wrap" style="gap: 6px;">
                                    {{-- Confirm --}}
                                    @if($booking->status === 'Pending')
                                        <form action="{{ route('bookings.updateStatus', $booking->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <input type="hidden" name="status" value="Confirmed">
                                            <button type="submit" class="btn btn-success btn-sm">
                                                <i class="fas fa-check"></i> Confirm
                                            </button>
                                        </form>
                                    @endif

                                    {{-- Check-in --}}
                                    @if(in_array($booking->status, ['Confirmed', 'Pending']))
                                        <form action="{{ route('bookings.updateStatus', $booking->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <input type="hidden" name="status" value="Occupied">
                                            <button type="submit" class="btn btn-primary btn-sm">
                                                <i class="fas fa-door-open"></i> Check-in
                                            </button>
                                        </form>
                                    @endif

                                    {{-- Check-out --}}
                                    @if($booking->status === 'Occupied')
                                        <form action="{{ route('bookings.updateStatus', $booking->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <input type="hidden" name="status" value="Completed">
                                            <button type="submit" class="btn btn-info btn-sm">
                                                <i class="fas fa-door-closed"></i> Check-out
                                            </button>
                                        </form>
                                    @endif

                                    {{-- Cancel --}}
                                    @if(!in_array($booking->status, ['Cancelled', 'Completed']))
                                        <form action="{{ route('bookings.updateStatus', $booking->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to cancel this booking?');">
                                            @csrf
                                            <input type="hidden" name="status" value="Cancelled">
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fas fa-times"></i> Cancel
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <strong><i class="fas fa-calendar-alt mr-1"></i> Check-in Date:</strong>
                                <p class="text-muted">{{ date('F d, Y', strtotime($booking->check_in_date)) }}</p>
                            </div>
                            <div class="col-md-6">
                                <strong><i class="fas fa-calendar-alt mr-1"></i> Check-out Date:</strong>
                                <p class="text-muted">{{ date('F d, Y', strtotime($booking->check_out_date)) }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <strong><i class="fas fa-dollar-sign mr-1"></i> Total Amount:</strong>
                                <p class="text-muted">₱ {{ number_format($booking->total_amount ?? 0, 2) }}</p>
                            </div>
                            <div class="col-md-6">
                                <strong><i class="fas fa-clock mr-1"></i> Booking Date:</strong>
                                <p class="text-muted">{{ date('F d, Y h:i A', strtotime($booking->created_at)) }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Customer Information Card -->
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-user mr-1"></i> Customer Information</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <strong><i class="fas fa-user mr-1"></i> Name:</strong>
                                <p class="text-muted">{{ $booking->Fname }} {{ $booking->Lname }}</p>
                            </div>
                            <div class="col-md-6">
                                <strong><i class="fas fa-envelope mr-1"></i> Email:</strong>
                                <p class="text-muted">{{ $booking->email }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <strong><i class="fas fa-phone mr-1"></i> Contact:</strong>
                                <p class="text-muted">{{ $booking->contact }}</p>
                            </div>
                            <div class="col-md-6">
                                <strong><i class="fas fa-birthday-cake mr-1"></i> Date of Birth:</strong>
                                <p class="text-muted">{{ $booking->dob ? date('F d, Y', strtotime($booking->dob)) : 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Room Information Card -->
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-bed mr-1"></i> Room Information</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <strong><i class="fas fa-door-open mr-1"></i> Room Number:</strong>
                                <p class="text-muted">Room {{ $booking->room_number }}</p>
                            </div>
                            <div class="col-md-6">
                                <strong><i class="fas fa-th-large mr-1"></i> Room Type:</strong>
                                <p class="text-muted">{{ $booking->room_type }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <strong><i class="fas fa-clipboard-check mr-1"></i> Room Status:</strong>
                                <p>
                                    @php
                                        $roomBadgeColor = 'badge-secondary';
                                        if($booking->room_status == 'Available') $roomBadgeColor = 'badge-success';
                                        if($booking->room_status == 'Occupied') $roomBadgeColor = 'badge-primary';
                                        if($booking->room_status == 'Unavailable') $roomBadgeColor = 'badge-danger';
                                    @endphp
                                    <span class="badge {{ $roomBadgeColor }}">{{ $booking->room_status }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Information Card & Form -->
                <div class="card card-warning">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title"><i class="fas fa-credit-card mr-1"></i> Payment Information</h3>
                    </div>
                    <div class="card-body">
                        @if($booking->payment_id)
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <strong><i class="fas fa-money-bill-wave mr-1"></i> Payment Option:</strong>
                                    <p class="text-muted">{{ $booking->payment_option }}</p>
                                </div>
                                <div class="col-md-6">
                                    <strong><i class="fas fa-dollar-sign mr-1"></i> Amount Paid:</strong>
                                    <p class="text-muted">₱ {{ number_format($booking->payment_amount ?? 0, 2) }}</p>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <strong><i class="fas fa-calendar-check mr-1"></i> Payment Date:</strong>
                                    <p class="text-muted">{{ $booking->paid_at ? date('F d, Y h:i A', strtotime($booking->paid_at)) : 'N/A' }}</p>
                                </div>
                            </div>
                            <hr>
                        @endif

                        {{-- Record / Update Payment --}}
                        <form action="{{ route('bookings.storePayment', $booking->id) }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="payment_option"><i class="fas fa-credit-card mr-1"></i> Payment Option</label>
                                        <select name="payment_option" id="payment_option" class="form-control" required>
                                            <option value="">Select</option>
                                            @php
                                                $options = ['Cash', 'Card'];
                                                $selectedOption = old('payment_option', $booking->payment_option ?? '');
                                            @endphp
                                            @foreach($options as $option)
                                                <option value="{{ $option }}" {{ $selectedOption === $option ? 'selected' : '' }}>
                                                    {{ $option }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('payment_option')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="amount"><i class="fas fa-tag mr-1"></i> Amount (₱)</label>
                                        <input
                                            type="number"
                                            step="0.01"
                                            min="0"
                                            name="amount"
                                            id="amount"
                                            class="form-control"
                                            value="{{ old('amount', $booking->payment_amount ?? $booking->total_amount ?? 0) }}"
                                            required
                                        >
                                        @error('amount')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-save mr-1"></i>
                                {{ $booking->payment_id ? 'Update Payment' : 'Record Payment' }}
                            </button>
                        </form>
                    </div>
                </div>

                <div class="card-footer">
                    <a href="{{ route('bookedRooms') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left mr-1"></i> Back to Booked Rooms
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script src="{{ asset('js/swift-alerts.js') }}"></script>
<script>
    @if(session('success'))
        showSwiftSuccess('Success!', '{{ session("success") }}');
    @endif
    
    @if(session('error'))
        showSwiftError('Error', '{{ session("error") }}');
    @endif
</script>
@endsection

