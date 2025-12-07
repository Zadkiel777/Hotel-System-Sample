@extends('themes.main')

@section('title', 'Booked Rooms')

@section('content_header')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"><i class="fas fa-calendar-check mr-1"></i> Booked Rooms</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Bookings</li>
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
            <div class="col-12">
                <div class="card card-outline card-primary">
                    
                    {{-- Header: Title & Search --}}
                    <div class="card-header">
                        <h3 class="card-title mt-1">
                            <i class="fas fa-list mr-1"></i> Transaction List
                        </h3>

                        <div class="card-tools">
                            <form action="{{ route('bookedRooms') }}" method="GET">
                                <div class="input-group input-group-sm" style="width: 250px;">
                                    <input type="text" name="search" class="form-control float-right" placeholder="Search customer or room..." value="{{ request('search') }}">
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
                            <table id="bookingTable" class="table table-striped table-hover table-sm text-nowrap">
                                <thead class="thead-light">
                                    <tr>
                                        <th style="width: 50px;">ID</th>
                                        <th>Customer</th>
                                        <th>Room Details</th>
                                        <th>Stay Dates</th>
                                        <th>Status</th>
                                        <th class="text-center" style="width: 140px;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($bookings as $booking)
                                        <tr>
                                            {{-- ID --}}
                                            <td class="align-middle text-center">{{ $booking->id }}</td>

                                            {{-- Customer Name & Type --}}
                                            <td class="align-middle">
                                                <div class="font-weight-bold text-primary">
                                                    {{ $booking->Fname }} {{ $booking->Lname }}
                                                </div>
                                                @php
                                                    $type = strtolower($booking->customer_type ?? 'guest');
                                                    $typeBadge = ($type === 'member') ? 'primary' : 'secondary';
                                                @endphp
                                                <small class="badge badge-{{ $typeBadge }}">
                                                    {{ ucfirst($type) }}
                                                </small>
                                            </td>

                                            {{-- Room Details --}}
                                            <td class="align-middle">
                                                <i class="fas fa-bed text-muted mr-1"></i> 
                                                <strong>Room {{ $booking->room_number }}</strong>
                                                <div class="text-muted small pl-4">{{ $booking->room_type }}</div>
                                            </td>

                                            {{-- Stay Dates --}}
                                            <td class="align-middle">
                                                <div class="d-flex flex-column small">
                                                    <span><span class="text-muted" style="width: 30px; display:inline-block;">In:</span> <strong>{{ date('M d, Y', strtotime($booking->check_in_date)) }}</strong></span>
                                                    <span><span class="text-muted" style="width: 30px; display:inline-block;">Out:</span> <strong>{{ date('M d, Y', strtotime($booking->check_out_date)) }}</strong></span>
                                                </div>
                                            </td>

                                            {{-- Status Badge --}}
                                            <td class="align-middle">
                                                @php
                                                    $status = strtolower($booking->status);
                                                    $badgeColor = match($status) {
                                                        'confirmed' => 'success',
                                                        'pending' => 'warning',
                                                        'cancelled' => 'danger',
                                                        'occupied' => 'primary',
                                                        default => 'secondary',
                                                    };
                                                @endphp
                                                <span class="badge badge-{{ $badgeColor }} px-2 py-1">
                                                    {{ ucfirst($booking->status) }}
                                                </span>
                                            </td>

                                            {{-- Actions --}}
                                            <td class="text-center align-middle">
                                                <div class="btn-group btn-group-sm">
                                                    {{-- View Button --}}
                                                    <a href="{{ route('viewBooking', $booking->id) }}" 
                                                       class="btn btn-info" 
                                                       title="View Details">
                                                        <i class="fas fa-eye"></i>
                                                    </a>

                                                    {{-- Cancel Form --}}
                                                    <form action="{{ route('bookings.updateStatus', $booking->id) }}" method="POST" style="display: inline-block;">
                                                        @csrf
                                                        <input type="hidden" name="status" value="Cancelled">
                                                        <button type="submit" 
                                                                class="btn btn-danger" 
                                                                title="Cancel Booking"
                                                                style="border-top-left-radius: 0; border-bottom-left-radius: 0;"
                                                                onclick="return confirmCancelBooking(event)">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-5 text-muted">
                                                <i class="fas fa-calendar-times fa-3x mb-3 opacity-50"></i><br>
                                                No bookings found.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Pagination --}}
                    @if($bookings->hasPages())
                        <div class="card-footer clearfix">
                            <div class="float-right">
                                {{ $bookings->links('pagination::simple-bootstrap-5') }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script src="{{ asset('js/swift-alerts.js') }}"></script>
<script>
    function confirmCancelBooking(event) {
        event.preventDefault();
        const form = event.target.closest('form');
        
        showSwiftConfirm(
            'Cancel Booking?',
            'Are you sure you want to cancel this booking? This action cannot be undone.',
            function() {
                form.submit();
            }
        );
        return false;
    }

    @if(session('success'))
        showSwiftSuccess('Success!', '{{ session("success") }}');
    @endif
    
    @if(session('error'))
        showSwiftError('Error', '{{ session("error") }}');
    @endif
</script>
@endsection