<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bluebird Hotel Portal</title>

    <link rel="icon" href="{{ asset('images/bluebirdlogo.png') }}" type="image/png">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        /* --- GLOBAL STYLES --- */
        html {
            scroll-behavior: smooth;
        }

        body {
            min-height: 100vh;
            background: url('{{ asset('images/hotel building.jpg') }}') center/cover fixed no-repeat;
            font-family: 'Poppins', sans-serif;
            color: #f8fafc;
        }
        .overlay {
            position: fixed;
            inset: 0;
            background: linear-gradient(120deg, rgba(9, 12, 32, 0.85), rgba(15, 32, 55, 0.7));
            z-index: 0;
        }
        .page-wrapper {
            position: relative;
            z-index: 1;
        }
        .navbar {
            background: rgba(15, 23, 42, 0.75);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }
        .hero-section {
            padding: 5rem 0 3rem;
        }
        .hero-card, .login-card {
            backdrop-filter: blur(18px);
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.18);
            border-radius: 24px;
            box-shadow: 0 25px 65px rgba(7, 12, 27, 0.55);
            padding: 2.5rem;
        }
        .feature-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(96, 165, 250, 0.15);
            color: #60a5fa;
            font-size: 1.25rem;
        }
        .nav-pills .nav-link {
            border-radius: 999px;
            font-weight: 600;
            color: #94a3b8;
        }
        .nav-pills .nav-link.active {
            background: linear-gradient(135deg, #60a5fa, #7c3aed);
        }
        
        /* Form Styling */
        .form-control {
            border-radius: 14px;
            padding: 0.85rem 1rem;
            border: 1px solid rgba(148, 163, 184, 0.6);
            background: rgba(255, 255, 255, 0.9);
        }
        .form-control:focus {
            border-color: #7c3aed;
            box-shadow: 0 0 0 0.2rem rgba(124, 58, 237, 0.25);
        }

        /* Show Password Toggle Styling */
        .input-group-text-toggle {
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(148, 163, 184, 0.6);
            border-left: none;
            border-top-right-radius: 14px !important;
            border-bottom-right-radius: 14px !important;
            cursor: pointer;
            color: #64748b;
            transition: color 0.3s ease;
        }
        .input-group-text-toggle:hover {
            color: #7c3aed;
        }
        .input-group .form-control {
            border-top-right-radius: 0 !important;
            border-bottom-right-radius: 0 !important;
            border-right: none;
        }

        .btn-gradient {
            background: linear-gradient(135deg, #60a5fa, #4338ca);
            border: none;
            border-radius: 14px;
            padding: 0.9rem;
            font-weight: 600;
        }
        .info-section {
            backdrop-filter: blur(12px);
            background: rgba(15, 15, 30, 0.6);
            border-radius: 24px;
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
        footer {
            color: #94a3b8;
        }

        /* --- FLIP CARD STYLES --- */
        .flip-container {
            perspective: 1000px;
            height: 350px;
            cursor: pointer;
        }
        .flip-inner {
            position: relative;
            width: 100%;
            height: 100%;
            text-align: center;
            transition: transform 0.8s;
            transform-style: preserve-3d;
        }
        .flip-container.flipped .flip-inner {
            transform: rotateY(180deg);
        }
        .flip-front, .flip-back {
            position: absolute;
            width: 100%;
            height: 100%;
            -webkit-backface-visibility: hidden;
            backface-visibility: hidden;
            border-radius: 20px;
            overflow: hidden;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }
        .flip-front { display: flex; flex-direction: column; }
        .flip-back {
            transform: rotateY(180deg);
            background: rgba(15, 23, 42, 0.95);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 2rem;
        }
        .room-image-wrapper { flex-grow: 1; overflow: hidden; height: 100%; }
        .room-image-wrapper img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease; }
        .flip-container:hover .flip-front img { transform: scale(1.1); }
        .feature-list-flip { text-align: left; width: 100%; margin-top: 1rem; margin-bottom: 1.5rem; font-size: 0.9rem; color: #cbd5e1; padding-left: 0; }
        .feature-list-flip li { list-style: none; margin-bottom: 0.5rem; }
        .feature-list-flip i { width: 25px; color: #60a5fa; }
    </style>
</head>
<body class="position-relative">
    <div class="overlay"></div>
    <div class="page-wrapper">
    
    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">
                <img src="{{ asset('images/bluebirdlogo.png') }}" alt="Bluebird Hotel Logo" height="30" class="d-inline-block align-text-top me-2">
                Bluebird Hotel
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navMenu">
                <ul class="navbar-nav ms-auto gap-3">
                    <li class="nav-item"><a class="nav-link text-white-50" href="#amenities">Amenities</a></li>
                    <li class="nav-item"><a class="nav-link text-white-50" href="#rooms">Rooms</a></li>
                    <li class="nav-item"><a class="nav-link text-white-50" href="#reviews">Reviews</a></li>
                    <li class="nav-item"><a class="nav-link text-white-50" href="#about">About</a></li>
                    <li class="nav-item"><a class="nav-link text-white-50" href="{{ route('guestbooking') }}">Booking</a></li>
                    <li class="nav-item"><a class="nav-link text-white-50" href="#login">Login</a></li>
                </ul>
            </div>
        </div>
    </nav>

        <div class="container hero-section">
            {{-- Hero & Login --}}
            <div class="row g-4 align-items-center mb-5">
                <div class="col-lg-6">
                    <div class="hero-card text-white">
                        <span class="badge bg-primary bg-opacity-25 text-white rounded-pill px-3 py-2 mb-3">
                            <i class="fas fa-star me-2"></i>Premium Hospitality
                        </span>
                        <h1 class="display-5 fw-bold">Experience Unmatched Luxury & Comfort</h1>
                        <p class="text-white-50 mt-3">
                            Indulge in elegant suites, world-class dining, and rejuvenating wellness facilities designed for the modern traveler seeking a perfect city escape.
                        </p>
                        <div class="row text-white-50 mt-4 g-3">
                            <div class="col-6">
                                <div class="feature-icon mb-2"><i class="fas fa-bed"></i></div>
                                <p class="mb-0 small">Luxury Suites</p>
                            </div>
                            <div class="col-6">
                                <div class="feature-icon mb-2"><i class="fas fa-utensils"></i></div>
                                <p class="mb-0 small">Fine Dining</p>
                            </div>
                            <div class="col-6">
                                <div class="feature-icon mb-2"><i class="fas fa-spa"></i></div>
                                <p class="mb-0 small">Spa & Wellness</p>
                            </div>
                            <div class="col-6">
                                <div class="feature-icon mb-2"><i class="fas fa-concierge-bell"></i></div>
                                <p class="mb-0 small">24/7 Room Service</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6" id="login">
                    <div class="login-card">
                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        <ul class="nav nav-pills justify-content-center mb-4" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#user-login" type="button" role="tab">
                                    <i class="fas fa-user me-1"></i>Customer Login
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#admin-login" type="button" role="tab">
                                    <i class="fas fa-user-shield me-1"></i>Admin Login
                                </button>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade" id="admin-login" role="tabpanel">
                                <form action="{{ route('auth_user') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="login_type" value="admin">
                                    <div class="mb-3">
                                        <label class="form-label text-white-50">Email Address</label>
                                        <input type="email" name="email" class="form-control" placeholder="Enter Admin Email" required>
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label text-white-50">Password</label>
                                        <div class="input-group">
                                            <input type="password" name="password" id="admin_pass" class="form-control" placeholder="Enter Password" required>
                                            <span class="input-group-text input-group-text-toggle toggle-password" data-target="admin_pass">
                                                <i class="fas fa-eye"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-gradient w-100 text-white">
                                        <i class="fas fa-right-to-bracket me-2"></i>Sign in as Admin
                                    </button>
                                </form>
                            </div>
                            <div class="tab-pane fade show active" id="user-login" role="tabpanel">
                                <form action="{{ route('auth_user') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="login_type" value="customer">
                                    <div class="mb-3">
                                        <label class="form-label text-white-50">Email Address</label>
                                        <input type="email" name="email" class="form-control" placeholder="Enter Customer Email" required>
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label text-white-50">Password</label>
                                        <div class="input-group">
                                            <input type="password" name="password" id="customer_pass" class="form-control" placeholder="Enter Password" required>
                                            <span class="input-group-text input-group-text-toggle toggle-password" data-target="customer_pass">
                                                <i class="fas fa-eye"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-gradient w-100 text-white mb-3">
                                        <i class="fas fa-right-to-bracket me-2"></i>Sign in as Customer
                                    </button>
                                </form>
                                <a href="{{ route('register') }}" class="btn btn-outline-light w-100 rounded-4">
                                    <i class="fas fa-user-plus me-2"></i>Create an Account
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Amenities --}}
            <div class="info-section mt-5 p-4" id="amenities">
                <div class="row g-4">
                    <div class="col-lg-4">
                        <h4 class="fw-bold">World-Class Amenities</h4>
                        <p class="text-white-50">From executive lounges to heated pools, enjoy a curated selection of services for a seamless stay.</p>
                    </div>
                    <div class="col-lg-8">
                        <div class="row g-3 text-white-50">
                            <div class="col-md-4">
                                <p class="mb-2"><i class="fas fa-door-open me-2 text-warning"></i>Executive Suites</p>
                                <p class="mb-2"><i class="fas fa-swimmer me-2 text-info"></i>Infinity Pool</p>
                                <p class="mb-0"><i class="fas fa-glass-cheers me-2 text-primary"></i>Sky Bar & Lounge</p>
                            </div>
                            <div class="col-md-4">
                                <p class="mb-2"><i class="fas fa-dumbbell me-2 text-danger"></i>Fitness Center</p>
                                <p class="mb-2"><i class="fas fa-briefcase me-2 text-secondary"></i>Business Center</p>
                                <p class="mb-0"><i class="fas fa-tv me-2 text-success"></i>Smart Entertainment</p>
                            </div>
                            <div class="col-md-4">
                                <p class="mb-2"><i class="fas fa-coffee me-2 text-warning"></i>Breakfast Buffet</p>
                                <p class="mb-2"><i class="fas fa-wifi me-2 text-success"></i>High-Speed WiFi</p>
                                <p class="mb-0"><i class="fas fa-clock me-2 text-primary"></i>24/7 Concierge</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ROOMS SECTION (FLIP CARDS) --}}
            <div class="info-section mt-5 p-4" id="rooms">
                <div class="text-center mb-4">
                    <h4 class="fw-bold">Luxurious Accommodations</h4>
                    <p class="text-white-50">Explore our collection of elegantly appointed rooms.</p>
                </div>
                <div class="row g-4">
                    {{-- Room 1 --}}
                    <div class="col-md-4">
                        <div class="flip-container" onclick="this.classList.toggle('flipped')">
                            <div class="flip-inner">
                                <div class="flip-front">
                                    <div class="room-image-wrapper">
                                        <img src="{{ asset('images/Deluxe Room.jpg') }}" alt="Deluxe Room">
                                    </div>
                                    <div class="p-3 text-center bg-transparent mt-auto position-absolute bottom-0 w-100" style="background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);">
                                        <h5 class="fw-bold mb-1">Deluxe Room</h5>
                                    </div>
                                </div>
                                <div class="flip-back">
                                    <h5 class="fw-bold text-white mb-3">Deluxe Amenities</h5>
                                    <ul class="list-unstyled feature-list-flip">
                                        <li><i class="fas fa-bed"></i> 1 Queen Sized Bed</li>
                                        <li><i class="fas fa-wifi"></i> High-Speed Wifi</li>
                                        <li><i class="fas fa-tv"></i> 42" Smart TV</li>
                                        <li><i class="fas fa-wind"></i> Air Conditioning</li>
                                    </ul>
                                    <p>Only For ₱3000 Per Night </p>
                                    <a href="{{ route('guestbooking') }}" class="btn btn-gradient btn-sm w-100 mt-2">Book Now</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Room 2 --}}
                    <div class="col-md-4">
                        <div class="flip-container" onclick="this.classList.toggle('flipped')">
                            <div class="flip-inner">
                                <div class="flip-front">
                                    <div class="room-image-wrapper">
                                        <img src="{{ asset('images/Luxury Room.jpg') }}" alt="Luxury Room">
                                    </div>
                                    <div class="p-3 text-center bg-transparent mt-auto position-absolute bottom-0 w-100" style="background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);">
                                        <h5 class="fw-bold mb-1">Luxury Suite</h5>
                                    </div>
                                </div>
                                <div class="flip-back">
                                    <h5 class="fw-bold text-white mb-3">Luxury Amenities</h5>
                                    <ul class="list-unstyled feature-list-flip">
                                        <li><i class="fas fa-bed"></i> 1 King Sized Bed</li>
                                        <li><i class="fas fa-hot-tub"></i> Private Jacuzzi</li>
                                        <li><i class="fas fa-wine-glass"></i> Mini Bar</li>
                                        <li><i class="fas fa-concierge-bell"></i> Room Service</li>
                                    </ul>
                                    <p>Only For ₱4000 Per Night </p>
                                    <a href="{{ route('guestbooking') }}" class="btn btn-gradient btn-sm w-100 mt-2">Book Now</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Room 3 --}}
                    <div class="col-md-4">
                        <div class="flip-container" onclick="this.classList.toggle('flipped')">
                            <div class="flip-inner">
                                <div class="flip-front">
                                    <div class="room-image-wrapper">
                                        <img src="{{ asset('images/Standard room.jpg') }}" alt="Standard Room">
                                    </div>
                                    <div class="p-3 text-center bg-transparent mt-auto position-absolute bottom-0 w-100" style="background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);">
                                        <h5 class="fw-bold mb-1">Standard Room</h5>
                                    </div>
                                </div>
                                <div class="flip-back">
                                    <h5 class="fw-bold text-white mb-3">Standard Amenities</h5>
                                    <ul class="list-unstyled feature-list-flip">
                                        <li><i class="fas fa-bed"></i> 1 Double Bed</li>
                                        <li><i class="fas fa-shower"></i> Hot & Cold Shower</li>
                                        <li><i class="fas fa-wifi"></i> Free Wifi</li>
                                        <li><i class="fas fa-fan"></i> Ceiling Fan</li>
                                    </ul>
                                    <p>Only For ₱2000 Per Night </p>
                                    <a href="{{ route('guestbooking') }}" class="btn btn-gradient btn-sm w-100 mt-2">Book Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Reviews --}}
            <div class="info-section mt-5 p-4" id="reviews">
                <div class="text-center mb-4">
                    <h4 class="fw-bold">Guest Experiences</h4>
                </div>
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="p-3 border border-light border-opacity-10 rounded-4 h-100 bg-white bg-opacity-10">
                            <div class="text-warning mb-2">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                            </div>
                            <p class="fst-italic text-white-50">"The view from the luxury suite was breathtaking."</p>
                            <div class="d-flex align-items-center mt-3">
                                <div class="bg-primary bg-opacity-25 rounded-circle p-2 me-2 text-white"><i class="fas fa-user"></i></div>
                                <div><h6 class="mb-0 fw-bold fs-6">Sarah Jenkins</h6></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 border border-light border-opacity-10 rounded-4 h-100 bg-white bg-opacity-10">
                            <div class="text-warning mb-2">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                            </div>
                            <p class="fst-italic text-white-50">"Absolutely loved the infinity pool. The food was 5-star."</p>
                            <div class="d-flex align-items-center mt-3">
                                <div class="bg-success bg-opacity-25 rounded-circle p-2 me-2 text-white"><i class="fas fa-user"></i></div>
                                <div><h6 class="mb-0 fw-bold fs-6">Michael Chen</h6></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 border border-light border-opacity-10 rounded-4 h-100 bg-white bg-opacity-10">
                            <div class="text-warning mb-2">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                            </div>
                            <p class="fst-italic text-white-50">"Clean, modern, and very secure."</p>
                            <div class="d-flex align-items-center mt-3">
                                <div class="bg-danger bg-opacity-25 rounded-circle p-2 me-2 text-white"><i class="fas fa-user"></i></div>
                                <div><h6 class="mb-0 fw-bold fs-6">Jessica Doe</h6></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- About --}}
            <div class="info-section mt-5 p-4" id="about">
                <div class="row align-items-center g-4">
                    <div class="col-lg-6">
                        <h4 class="fw-bold mb-3">About Bluebird Hotel</h4>
                        <p class="text-white-50">Landmark of luxury and comfort in the heart of the city.</p>
                        <div class="mt-4">
                            <a href="{{ route('guestbooking') }}" class="btn btn-outline-light rounded-pill px-4">Book Your Stay</a>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="row g-3 text-center">
                            <div class="col-6">
                                <div class="p-3 border border-light border-opacity-10 rounded-3 bg-dark bg-opacity-25 h-100">
                                    <i class="fas fa-utensils text-warning mb-2 fs-4"></i>
                                    <h5 class="fw-bold text-white mb-0">3</h5>
                                    <small class="text-white-50">Restaurants</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-3 border border-light border-opacity-10 rounded-3 bg-dark bg-opacity-25 h-100">
                                    <i class="fas fa-star text-warning mb-2 fs-4"></i>
                                    <h5 class="fw-bold text-white mb-0">4.9</h5>
                                    <small class="text-white-50">Rating</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <footer class="text-center mt-5">
                <small>© {{ date('Y') }} Bluebird Hotel Portal. All Rights Reserved.</small>
            </footer>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle Password Logic
        document.querySelectorAll('.toggle-password').forEach(span => {
            span.addEventListener('click', function() {
                const targetId = this.getAttribute('data-target');
                const passwordInput = document.getElementById(targetId);
                const icon = this.querySelector('i');

                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    icon.classList.replace('fa-eye', 'fa-eye-slash');
                } else {
                    passwordInput.type = 'password';
                    icon.classList.replace('fa-eye-slash', 'fa-eye');
                }
            });
        });
    </script>
</body>
</html>