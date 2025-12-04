@extends('themes.main')

{{-- Define the page title --}}
@section('title', 'Booked Rooms')

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

    <form class="form-inline ml-3" action="{{ route('bookedRooms') }}" method="GET">
        <div class="input-group input-group-sm">
            <input 
                class="form-control form-control-navbar" 
                type="search" 
                name="search" 
                placeholder="Search customer or room..."
                aria-label="Search"
                value="{{ request('search') }}">
            <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                    <i class="fas fa-search"></i>
                </button>
                @if(request('search'))
                <a href="{{ route('bookedRooms') }}" class="btn btn-navbar">
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
                {{-- Updated Icon and Title --}}
                <h1 class="m-0"><i class="fas fa-calendar-check mr-1"></i> Booked Rooms</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    {{-- Updated Breadcrumb --}}
                    <li class="breadcrumb-item active"><i class="fas fa-calendar-check"></i> Booked Rooms</li>
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
        <div class="row">
            <div class="col-12">
                <div class="card">
                    {{-- Header --}}
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title"><i class="fas fa-list mr-1"></i> List of Transactions</h3>
                    </div>

                    {{-- Table --}}
                    <div class="table-responsive">
                        <table id="bookingTable" class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th><i class="fas fa-hashtag"></i> ID</th>
                                    <th><i class="fas fa-user"></i> Customer Name</th>
                                    <th><i class="fas fa-bed"></i> Room Details</th>
                                    <th><i class="fas fa-calendar-alt"></i> Stay Dates</th>
                                    <th><i class="fas fa-info-circle"></i> Status</th>
                                    <th style="width: 150px" class="text-center">
                                        <i class="fas fa-tools"></i> Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($bookings as $booking)
                                    <tr>
                                        <td>{{ $booking->id }}</td>
                                        <td>
                                            <strong>{{ $booking->Fname }} {{ $booking->Lname }}</strong><br>
                                            @php
                                                $type = strtolower($booking->customer_type ?? 'guest');
                                            @endphp
                                            @if($type === 'member')
                                                <span class="badge badge-primary">Member</span>
                                            @else
                                                <span class="badge badge-secondary">Guest</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge badge-info">Room {{ $booking->room_number }}</span>
                                            <br>
                                            <small class="text-muted">{{ $booking->room_type }}</small>
                                        </td>
                                        <td>
                                            <small>In:</small> {{ date('M d, Y', strtotime($booking->check_in_date)) }}
                                            <br>
                                            <small>Out:</small> {{ date('M d, Y', strtotime($booking->check_out_date)) }}
                                        </td>
                                        <td>
                                            {{-- Logic for Status Color --}}
                                            @php
                                                $badgeColor = 'badge-secondary';
                                                if($booking->status == 'Confirmed') $badgeColor = 'badge-success';
                                                if($booking->status == 'Pending') $badgeColor = 'badge-warning';
                                                if($booking->status == 'Cancelled') $badgeColor = 'badge-danger';
                                                if($booking->status == 'Occupied') $badgeColor = 'badge-primary';
                                            @endphp
                                            <span class="badge {{ $badgeColor }}">{{ ucfirst($booking->status) }}</span>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center" style="gap: 5px;">
                                                <a href="{{ route('viewBooking', $booking->id) }}" class="btn btn-primary btn-sm">
                                                    <i class="fas fa-eye"></i> View
                                                </a>

                                                {{-- Cancel Booking Form --}}
                                                <form action="{{ route('bookings.updateStatus', $booking->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this booking?');">
                                                    @csrf
                                                    <input type="hidden" name="status" value="Cancelled">
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        <i class="fas fa-times"></i> Cancel
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">
                                            <i class="fas fa-folder-open mr-1"></i> No booked rooms found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div> {{-- End .table-responsive --}}

                    {{-- Pagination --}}
                    <div class="d-flex justify-content-center mt-3">
                        {{ $bookings->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection