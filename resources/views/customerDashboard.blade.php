<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Stays - Bluebird Hotel</title>

    <link rel="icon" href="{{ asset('images/bluebirdlogo.png') }}" type="image/png">

    {{-- Bootstrap 5 & Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        body {
            min-height: 100vh;
            background: url('{{ asset('images/Luxury Room.jpg') }}') center/cover fixed no-repeat;
            font-family: 'Poppins', sans-serif;
            color: #f8fafc;
        }

        .overlay {
            position: fixed;
            inset: 0;
            background: linear-gradient(120deg, rgba(9, 12, 32, 0.9), rgba(15, 32, 55, 0.75));
            z-index: 0;
        }

        .page-wrapper {
            position: relative;
            z-index: 1;
        }

        .navbar {
            background: rgba(15, 23, 42, 0.9);
            backdrop-filter: blur(14px);
            border-bottom: 1px solid rgba(148, 163, 184, 0.25);
        }

        .navbar-brand img {
            border-radius: 50%;
        }

        .nav-link {
            font-weight: 500;
            color: #e5e7eb !important;
        }

        .nav-link.active,
        .nav-link:hover {
            color: #60a5fa !important;
        }

        .dashboard-hero {
            padding-top: 4.5rem;
            padding-bottom: 2rem;
        }

        .glass-card {
            backdrop-filter: blur(18px);
            background: rgba(15, 23, 42, 0.82);
            border-radius: 24px;
            border: 1px solid rgba(148, 163, 184, 0.35);
            box-shadow: 0 24px 60px rgba(15, 23, 42, 0.9);
        }

        .stat-pill {
            background: linear-gradient(135deg, rgba(96, 165, 250, 0.15), rgba(129, 140, 248, 0.15));
            border-radius: 18px;
            padding: 0.6rem 1rem;
            border: 1px solid rgba(148, 163, 184, 0.4);
            color: #e5e7eb;
            font-size: 0.9rem;
        }

        .stat-icon {
            width: 42px;
            height: 42px;
            border-radius: 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(15, 23, 42, 0.9);
            color: #60a5fa;
        }

        .btn-gradient {
            background: linear-gradient(135deg, #60a5fa, #7c3aed);
            border: none;
            border-radius: 14px;
            padding: 0.8rem 1.4rem;
            font-weight: 600;
        }

        .btn-gradient:hover {
            filter: brightness(1.05);
            transform: translateY(-1px);
        }

        .section-title {
            font-size: 1.05rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: #9ca3af;
        }

        .table-dark-custom {
            --bs-table-bg: rgba(15, 23, 42, 0.9);
            --bs-table-border-color: rgba(55, 65, 81, 0.9);
            color: #e5e7eb;
        }

        .badge-soft {
            border-radius: 999px;
            padding: 0.35rem 0.75rem;
            font-size: 0.75rem;
        }

        footer {
            color: #9ca3af;
        }
    </style>
</head>
<body>
    <div class="overlay"></div>
    <div class="page-wrapper">
        {{-- Top Nav --}}
        <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
            <div class="container">
                <a class="navbar-brand fw-semibold" href="{{ route('main') }}">
                    <img src="{{ asset('images/bluebirdlogo.png') }}" alt="Bluebird Hotel" height="32" class="me-2">
                    Bluebird Hotel
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#customerNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="customerNav">
                    <ul class="navbar-nav ms-auto align-items-lg-center gap-2 gap-lg-3">
                        <li class="nav-item">
                            <a class="nav-link active" href="#overview"><i class="fas fa-gauge-high me-1"></i>Overview</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#bookings"><i class="fas fa-calendar-check me-1"></i>My Bookings</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#profile"><i class="fas fa-user-circle me-1"></i>Profile</a>
                        </li>
                        <li class="nav-item ms-lg-2">
                            <a href="{{ route('memberBooking') }}" class="btn btn-sm btn-gradient">
                                <i class="fas fa-bed me-1"></i> Book a Room
                            </a>
                        </li>
                        @if(session('customer_id'))
                            <li class="nav-item ms-lg-1">
                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button class="btn btn-sm btn-outline-light rounded-pill" type="submit">
                                        <i class="fas fa-right-from-bracket me-1"></i>Logout
                                    </button>
                                </form>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        <main class="dashboard-hero">
            <div class="container">
                {{-- Flash messages --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                {{-- Overview + Quick stats --}}
                <section id="overview" class="mb-4">
                    <div class="row g-4 align-items-center">
                        <div class="col-lg-5">
                            <div class="glass-card p-4 p-md-5 h-100">
                                <p class="text-uppercase small text-secondary mb-2">Welcome</p>
                                <h2 class="fw-bold mb-2">
                                    Hello,
                                    <span class="text-primary">
                                        {{ session('name') ?? 'Valued Guest' }}
                                    </span>
                                </h2>
                                <p class="mb-3" style="color:#cbd5f5;">
                                    Manage your upcoming stays, review past visits, and book your next escape
                                    with just a few clicks.
                                </p>
                                <div class="d-flex flex-wrap gap-2">
                                    <span class="stat-pill">
                                        <i class="fas fa-shield-heart me-2 text-primary"></i>
                                        Secure booking portal
                                    </span>
                                    <span class="stat-pill">
                                        <i class="fas fa-clock-rotate-left me-2 text-info"></i>
                                        View history anytime
                                    </span>
                                </div>
                                <div class="mt-4 d-flex flex-wrap gap-2">
                                    <a href="{{ route('memberBooking') }}" class="btn btn-gradient">
                                        <i class="fas fa-calendar-plus me-2"></i>New Booking
                                    </a>
                                    <a href="#bookings" class="btn btn-outline-light rounded-pill">
                                        <i class="fas fa-calendar-day me-2"></i>View My Bookings
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <div class="glass-card p-3 h-100">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="stat-icon">
                                                <i class="fas fa-calendar-check"></i>
                                            </span>
                                            <span class="badge badge-soft bg-success bg-opacity-25 text-success">
                                                Upcoming
                                            </span>
                                        </div>
                                        <p class="text-muted mb-1 small">Next Stay</p>
                                        @if($nextBooking)
                                            <h5 class="mb-0">
                                                Room {{ $nextBooking->room_number }} ({{ $nextBooking->room_type }})
                                            </h5>
                                            <small class="text-secondary">
                                                {{ \Carbon\Carbon::parse($nextBooking->check_in_date)->format('M d, Y') }}
                                                – {{ \Carbon\Carbon::parse($nextBooking->check_out_date)->format('M d, Y') }}
                                            </small>
                                        @else
                                            <h5 class="mb-0">No upcoming stays</h5>
                                            <small class="text-secondary">Book now to schedule your next visit.</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="glass-card p-3 h-100">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="stat-icon">
                                                <i class="fas fa-star"></i>
                                            </span>
                                            <span class="badge badge-soft bg-warning bg-opacity-25 text-warning">
                                                Perks
                                            </span>
                                        </div>
                                        <p class="text-muted mb-1 small">Member Status</p>
                                        <h5 class="mb-0">Guest</h5>
                                        <small class="text-secondary">Sign up to unlock special member offers.</small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="glass-card p-3 h-100">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="stat-icon">
                                                <i class="fas fa-wallet"></i>
                                            </span>
                                            <span class="badge badge-soft bg-info bg-opacity-25 text-info">
                                                Billing
                                            </span>
                                        </div>
                                        <p class="text-muted mb-1 small">Outstanding Balance</p>
                                        <h5 class="mb-0">₱0.00</h5>
                                        <small class="text-secondary">All payments are currently settled.</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                {{-- Bookings section (placeholder for now) --}}
                <section id="bookings" class="mt-4">
                    <div class="glass-card p-4 p-md-5">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <p class="section-title mb-1">My Bookings</p>
                                <h4 class="mb-0">Upcoming & Past Stays</h4>
                            </div>
                            <a href="{{ route('memberBooking') }}" class="btn btn-sm btn-gradient">
                                <i class="fas fa-plus me-1"></i> New Booking
                            </a>
                        </div>
                        <p class="text-secondary mb-3">
                            Once you book with the email you used during registration, your stays can be
                            linked here in the future. For now, please keep the confirmation sent by reception.
                        </p>

                        <div class="table-responsive">
                            <table class="table table-dark table-dark-custom align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th scope="col"><i class="fas fa-hashtag me-1"></i> Reference</th>
                                        <th scope="col"><i class="fas fa-bed me-1"></i> Room</th>
                                        <th scope="col"><i class="fas fa-calendar-day me-1"></i> Dates</th>
                                        <th scope="col"><i class="fas fa-circle-info me-1"></i> Status</th>
                                        <th scope="col" class="text-end"><i class="fas fa-ellipsis-h"></i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($bookings as $booking)
                                        <tr>
                                            <td>#{{ $booking->id }}</td>
                                            <td>
                                                Room {{ $booking->room_number }}<br>
                                                <small class="text-secondary">{{ $booking->room_type }}</small>
                                            </td>
                                            <td>
                                                <small>In:</small> {{ \Carbon\Carbon::parse($booking->check_in_date)->format('M d, Y') }}<br>
                                                <small>Out:</small> {{ \Carbon\Carbon::parse($booking->check_out_date)->format('M d, Y') }}
                                            </td>
                                            <td>
                                                @php
                                                    $badgeColor = 'badge-secondary';
                                                    if($booking->status === 'Confirmed') $badgeColor = 'badge-success';
                                                    if($booking->status === 'Pending') $badgeColor = 'badge-warning';
                                                    if($booking->status === 'Cancelled') $badgeColor = 'badge-danger';
                                                    if($booking->status === 'Occupied') $badgeColor = 'badge-primary';
                                                    if($booking->status === 'Completed') $badgeColor = 'badge-info';
                                                @endphp
                                                <span class="badge {{ $badgeColor }}">{{ ucfirst($booking->status) }}</span>
                                            </td>
                                            <td class="text-end">
                                                <a href="{{ route('customer.viewBooking', $booking->id) }}" class="btn btn-sm btn-outline-light">
                                                    <i class="fas fa-eye me-1"></i> View
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-4 text-secondary">
                                                <i class="fas fa-folder-open fa-lg mb-2 d-block"></i>
                                                You don't have any stays linked to this portal yet.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>

                {{-- Profile section (simple read-only for now) --}}
                <section id="profile" class="mt-4 mb-4 mb-md-5">
                    <div class="glass-card p-4 p-md-5">
                        <p class="section-title mb-1">Profile</p>
                        <h4 class="mb-3">Your Contact Details</h4>
                        <p class="text-secondary mb-4">
                            For changes to your registered email or contact number, please reach out to the front desk
                            so we can update our records for you.
                        </p>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label text-secondary small">Full Name</label>
                                <div class="form-control bg-dark bg-opacity-50 text-white border-0">
                                    {{ session('name') ?? 'Guest User' }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-secondary small">Email Address</label>
                                <div class="form-control bg-dark bg-opacity-50 text-white border-0">
                                    {{ session('email') ?? 'Not available' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <footer class="text-center mt-4 mb-3">
                    <small>© {{ date('Y') }} Bluebird Hotel. Crafted for a seamless guest experience.</small>
                </footer>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


