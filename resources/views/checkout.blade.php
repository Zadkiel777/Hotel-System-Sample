<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Bluebird Hotel</title>
    <link rel="icon" href="{{ asset('images/bluebirdlogo.png') }}" type="image/png">
    {{-- Bootstrap 5 & Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        /* Reusing your global styles */
        body {
            min-height: 100vh;
            background: url('{{ asset('images/Luxury Room.jpg') }}') center/cover fixed no-repeat;
            font-family: 'Poppins', sans-serif;
            color: #f8fafc;
        }
        .overlay {
            position: fixed; inset: 0; background: linear-gradient(135deg, rgba(5, 7, 20, 0.95), rgba(10, 20, 40, 0.85)); z-index: 0;
        }
        .page-wrapper { position: relative; z-index: 1; }
        .dashboard-hero { padding-top: 6rem; padding-bottom: 3rem; }
        
        .glass-card {
            background: rgba(17, 24, 39, 0.85); 
            backdrop-filter: blur(20px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.12);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5);
        }
        .text-label { color: #94a3b8; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.05em; }
        
        /* Print Styles */
        @media print {
            .navbar, .btn-section, .overlay { display: none !important; }
            body { background: white !important; color: black !important; }
            .glass-card { background: white !important; border: none !important; color: black !important; box-shadow: none !important; }
            .text-white-50 { color: #666 !important; }
            .text-white { color: #000 !important; }
            /* Hide the payment form when printing */
            form { display: none; } 
        }
    </style>
</head>
<body>
    <div class="overlay"></div>
    <div class="page-wrapper">
        
        <nav class="navbar navbar-expand-lg navbar-dark fixed-top" style="background: rgba(10, 15, 30, 0.95); backdrop-filter: blur(10px);">
            <div class="container">
                <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">
                    <img src="{{ asset('images/bluebirdlogo.png') }}" alt="Bluebird Hotel" height="32" class="me-2">
                    Bluebird Hotel <span class="badge bg-primary ms-2" style="font-size: 0.6em;">ADMIN</span>
                </a>
                <div class="ms-auto">
                        <a href="{{ route('customerDashboard') }}" class="btn btn-sm btn-outline-light rounded-pill px-3">
                            <i class="fas fa-arrow-left me-2"></i> Back
                        </a>
                </div>
            </div>
        </nav>

        <main class="dashboard-hero">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="glass-card p-5">
                            
                            {{-- Header --}}
                            <div class="d-flex justify-content-between align-items-start border-bottom border-secondary border-opacity-25 pb-4 mb-4">
                                <div>
                                    <h2 class="fw-bold mb-1">Guest Checkout</h2>
                                    <p class="text-white-50 mb-0">Invoice Summary & Room Clearance</p>
                                </div>
                                <div class="text-end">
                                    <div class="badge bg-primary bg-opacity-25 text-primary fs-6 px-3 py-2">
                                        Ref #{{ $booking->id }}
                                    </div>
                                    <div class="mt-2 text-label">{{ date('M d, Y') }}</div>
                                </div>
                            </div>

                            {{-- Customer & Stay Info --}}
                            <div class="row g-4 mb-5">
                                <div class="col-md-6">
                                    <div class="p-3 rounded-3" style="background: rgba(0,0,0,0.2);">
                                        <p class="text-label mb-2"><i class="fas fa-user me-2"></i>Billed To</p>
                                        <h5 class="fw-bold mb-1">{{ $booking->Fname }} {{ $booking->Lname }}</h5>
                                        <p class="text-white-50 small mb-0">{{ $booking->email }}</p>
                                        <p class="text-white-50 small">{{ $booking->contact }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="p-3 rounded-3" style="background: rgba(0,0,0,0.2);">
                                        <p class="text-label mb-2"><i class="fas fa-bed me-2"></i>Stay Details</p>
                                        <div class="d-flex justify-content-between mb-1">
                                            <span class="text-white-50">Room:</span>
                                            <span class="fw-bold text-info">{{ $booking->room_number }} ({{ $booking->room_type }})</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-1">
                                            <span class="text-white-50">Check-in:</span>
                                            <span>{{ \Carbon\Carbon::parse($booking->check_in_date)->format('M d, Y') }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <span class="text-white-50">Check-out:</span>
                                            <span>{{ \Carbon\Carbon::parse($booking->check_out_date)->format('M d, Y') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Invoice Table - UPDATED COLORS HERE --}}
                            <div class="table-responsive mb-4">
                                <table class="table" style="--bs-table-bg: transparent; color: white;">
                                    <thead>
                                        <tr style="border-bottom: 1px solid rgba(255,255,255,0.1);">
                                            <th class="text-white">Description</th>
                                            <th class="text-center text-white">Rate</th>
                                            <th class="text-center text-white">Nights</th>
                                            <th class="text-end text-white">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="pt-3 text-white">
                                                <span class="fw-semibold">Room Charges</span>
                                                <div class="small text-white-50">{{ $booking->room_type }} Accomodation</div>
                                            </td>
                                            {{-- CHANGED: Added text-white class to make these visible --}}
                                            <td class="text-center pt-3 text-white">₱{{ number_format($ratePerNight, 2) }}</td>
                                            <td class="text-center pt-3 text-white">{{ $nights }}</td>
                                            <td class="text-end pt-3 text-white">₱{{ number_format($ratePerNight * $nights, 2) }}</td>
                                        </tr>
                                        
                                        <tr style="border-top: 2px solid rgba(255,255,255,0.1);">
                                            <td colspan="3" class="text-end pt-4"><span class="text-label">Subtotal</span></td>
                                            <td class="text-end pt-4 text-white">₱{{ number_format($booking->total_amount, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="text-end border-0"><span class="text-label">Amount Paid</span></td>
                                            <td class="text-end border-0 text-success">- ₱{{ number_format($booking->paid_amount ?? 0, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="text-end border-0"><span class="fs-5 fw-bold text-white">Balance Due</span></td>
                                            <td class="text-end border-0">
                                                @php $balance = $booking->total_amount - ($booking->paid_amount ?? 0); @endphp
                                                <span class="fs-4 fw-bold {{ $balance > 0 ? 'text-warning' : 'text-success' }}">
                                                    ₱{{ number_format($balance, 2) }}
                                                </span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            {{-- Buttons & Actions --}}
                            <div class="btn-section mt-5 d-flex justify-content-between align-items-end">
                                <button onclick="window.print()" class="btn btn-outline-light rounded-pill px-4 mb-3 mb-md-0">
                                    <i class="fas fa-print me-2"></i> Print Invoice
                                </button>

                                <div style="min-width: 300px;">
                                    @if($booking->status === 'Completed')
                                        <button disabled class="btn btn-success px-4 rounded-3 w-100 py-3">
                                            <i class="fas fa-check-circle me-2"></i> Transaction Completed
                                        </button>
                                    @elseif($booking->status === 'Cancelled')
                                        <button disabled class="btn btn-danger px-4 rounded-3 w-100 py-3">
                                            <i class="fas fa-times-circle me-2"></i> Booking Cancelled
                                        </button>
                                    @else
                                        {{-- CHECKOUT FORM WITH PAYMENT OPTION --}}
                                        <form action="{{ route('checkoutBooking', $booking->id) }}" method="POST" onsubmit="return confirm('Confirm checkout? This will record the payment and clear the room.');">
                                            @csrf
                                            
                                            <div class="mb-3 text-start">
                                                <label for="payment_option" class="text-label mb-2" style="font-size: 0.75rem;">Select Payment Method</label>
                                                <select name="payment_option" id="payment_option" class="form-select" required 
                                                        style="background: rgba(0, 0, 0, 0.3); border: 1px solid rgba(255, 255, 255, 0.1); color: #fff;">
                                                    <option value="" disabled selected>Choose option...</option>
                                                    <option value="Cash">Cash</option>
                                                    <option value="Card">Card</option>
                                                </select>
                                            </div>

                                            <button type="submit" class="btn btn-primary btn-lg w-100 shadow-lg" 
                                                    style="background: linear-gradient(135deg, #3b82f6, #6366f1); border:none;">
                                                Pay Balance & Checkout <i class="fas fa-arrow-right ms-2"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>