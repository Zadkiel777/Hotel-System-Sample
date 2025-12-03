<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account - Bluebird Hotel</title>

    <link rel="icon" href="{{ asset('images/bluebirdlogo.png') }}" type="image/png">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    
    <style>
        body {
            min-height: 100vh;
            /* Matches homepage background */
            background: url('{{ asset('images/Luxury Room.jpg') }}') center/cover fixed no-repeat;
            font-family: 'Poppins', sans-serif;
            color: #f8fafc;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px 15px;
        }

        /* Dark overlay for readability */
        .overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(120deg, rgba(9, 12, 32, 0.85), rgba(15, 32, 55, 0.7));
            z-index: 0;
        }

        .page-wrapper {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 900px;
        }

        /* Glassmorphism Card Style */
        .glass-card {
            backdrop-filter: blur(20px);
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.18);
            border-radius: 24px;
            box-shadow: 0 25px 65px rgba(7, 12, 27, 0.55);
            padding: 2.5rem;
        }

        /* Form Inputs matching theme */
        .form-control {
            border-radius: 0 14px 14px 0; /* Rounded right side */
            padding: 0.85rem 1rem;
            border: 1px solid rgba(148, 163, 184, 0.6);
            background: rgba(255, 255, 255, 0.9);
            color: #333;
        }

        .form-control:focus {
            border-color: #7c3aed;
            box-shadow: 0 0 0 0.2rem rgba(124, 58, 237, 0.25);
        }

        /* Input Group Icons */
        .input-group-text {
            border-radius: 14px 0 0 14px; /* Rounded left side */
            background: rgba(96, 165, 250, 0.2); /* Light blue tint */
            border: 1px solid rgba(148, 163, 184, 0.6);
            border-right: none;
            color: #60a5fa;
        }

        .form-label {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
            font-weight: 400;
        }

        .section-header {
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding-bottom: 15px;
            margin-bottom: 25px;
            text-align: center;
        }

        /* Profile Upload Area */
        .profile-upload {
            border: 2px dashed rgba(255, 255, 255, 0.3);
            border-radius: 18px;
            padding: 1.5rem;
            background: rgba(0, 0, 0, 0.2);
            transition: all 0.3s;
        }
        
        .profile-upload:hover {
            border-color: #60a5fa;
            background: rgba(0, 0, 0, 0.3);
        }

        .avatar-preview {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        }

        /* Buttons */
        .btn-gradient {
            background: linear-gradient(135deg, #60a5fa, #4338ca);
            border: none;
            border-radius: 14px;
            padding: 0.9rem;
            font-weight: 600;
            color: white;
            transition: transform 0.2s;
        }

        .btn-gradient:hover {
            transform: translateY(-2px);
            color: white;
        }

        .btn-outline-light {
            border-radius: 14px;
            padding: 0.9rem;
        }

        .error-message {
            color: #ff8a80; /* Light red for dark background */
            font-size: 0.85rem;
            margin-top: 0.25rem;
            display: block;
        }
    </style>
</head>
<body class="position-relative">

    <div class="overlay"></div>

    <div class="page-wrapper">
        <div class="glass-card">
            
            <div class="section-header">
                <span class="badge bg-primary bg-opacity-25 text-white border border-primary border-opacity-25 rounded-pill px-3 py-2 mb-3">
                    <i class="fas fa-crown me-1"></i> Join Bluebird Membership
                </span>
                <h2 class="fw-bold text-white">Create Account</h2>
                <p class="text-white-50 mb-0">Join us to unlock exclusive rates and manage your bookings.</p>
            </div>

            <form method="POST" action="{{ route('save_user') }}" enctype="multipart/form-data">
                @csrf

                <div class="profile-upload mb-4">
                    <div class="d-flex flex-column flex-md-row align-items-center justify-content-center gap-4">
                        <img id="previewImg" src="https://ui-avatars.com/api/?name=User&background=60a5fa&color=fff" alt="Preview" class="avatar-preview">
                        <div class="text-center text-md-start">
                            <label class="form-label text-white fw-semibold">Profile Photo</label>
                            <div class="d-flex flex-column">
                                <label for="profilePicture" class="btn btn-outline-light btn-sm rounded-pill px-4 mb-2">
                                    <i class="fas fa-camera me-2"></i>Choose Image
                                </label>
                                <input type="file" name="profile_picture" id="profilePicture" accept="image/*" class="d-none" onchange="previewProfileImage(this)">
                                <small class="text-white-50" id="fileLabelText">Max 5MB (JPG, PNG)</small>
                            </div>
                            @error('profile_picture') <span class="error-message">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label">First Name</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                            <input type="text" name="Fname" class="form-control" placeholder="Enter first name" required value="{{ old('Fname') }}">
                        </div>
                        @error('Fname') <span class="error-message">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Last Name</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                            <input type="text" name="Lname" class="form-control" placeholder="Enter last name" required value="{{ old('Lname') }}">
                        </div>
                        @error('Lname') <span class="error-message">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Email Address</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            <input type="email" name="email" class="form-control" placeholder="customer@email.com" required value="{{ old('email') }}">
                        </div>
                        @error('email') <span class="error-message">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input type="password" name="password" class="form-control" placeholder="Choose a password" required>
                        </div>
                        @error('password') <span class="error-message">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label">Contact Number</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                            <input type="text" name="contact" class="form-control" placeholder="09XX-XXX-XXXX" required value="{{ old('contact') }}">
                        </div>
                        @error('contact') <span class="error-message">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Date of Birth</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-birthday-cake"></i></span>
                            <input type="date" name="dob" class="form-control" required value="{{ old('dob') }}">
                        </div>
                        @error('dob') <span class="error-message">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-between">
                    <a href="{{ route('main') }}" class="btn btn-outline-light w-100" onclick="return confirmBack(event)">
                        <i class="fas fa-arrow-left me-2"></i>Back to Home
                    </a>
                    <button type="submit" class="btn btn-gradient w-100" onclick="return confirmCustomerSave(event)">
                        <i class="fas fa-check-circle me-2"></i>Create Account
                    </button>
                </div>

            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/swift-alerts.js') }}"></script>
    <script>
        // --- Image Preview Logic ---
        function previewProfileImage(input) {
            const previewImg = document.getElementById('previewImg');
            const fileLabelText = document.getElementById('fileLabelText');
            const maxSize = 5 * 1024 * 1024; // 5MB

            if (input.files && input.files[0]) {
                if (input.files[0].size > maxSize) {
                    if(typeof showSwiftError === 'function') {
                        showSwiftError('File Too Large', 'Image size must be less than 5MB.');
                    } else {
                        alert('Image size must be less than 5MB.');
                    }
                    input.value = '';
                    previewImg.src = 'https://ui-avatars.com/api/?name=User&background=60a5fa&color=fff';
                    fileLabelText.textContent = 'Max 5MB (JPG, PNG)';
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    fileLabelText.textContent = input.files[0].name;
                };
                reader.readAsDataURL(input.files[0]);
            } else {
                previewImg.src = 'https://ui-avatars.com/api/?name=User&background=60a5fa&color=fff';
                fileLabelText.textContent = 'Max 5MB (JPG, PNG)';
            }
        }
        
        // --- Confirmation Logic ---
        function confirmCustomerSave(event) {
            event.preventDefault();
            const form = event.target.closest('form');
            const firstName = form.querySelector('[name="Fname"]').value;
            const email = form.querySelector('[name="email"]').value;

            if (!firstName || !email) {
                if(typeof showSwiftError === 'function') {
                    showSwiftError('Validation Error', 'Please fill in all required fields.');
                } else {
                    alert('Please fill in all required fields.');
                }
                return false;
            }

            if(typeof showSwiftConfirm === 'function') {
                showSwiftConfirm(
                    'Confirm Registration',
                    `Create account for ${firstName}?`,
                    function() { form.submit(); }
                );
            } else {
                if(confirm(`Create account for ${firstName}?`)) {
                    form.submit();
                }
            }
            return false;
        }

        function confirmBack(event) {
            event.preventDefault();
            const url = event.target.href;
            
            if(typeof showSwiftConfirm === 'function') {
                showSwiftConfirm(
                    'Go Back?',
                    'Any unsaved changes will be lost.',
                    function() { window.location.href = url; }
                );
            } else {
                if(confirm('Any unsaved changes will be lost.')) {
                    window.location.href = url;
                }
            }
            return false;
        }

        // --- FLASH MESSAGES ---

        // 1. Standard Success
        @if(session('success'))
            var msg = '{{ session("success") }}';
            var title = 'Success!';
            
            // Check if the message is about account creation
            if (msg.toLowerCase().includes('created') || msg.toLowerCase().includes('account')) {
                title = 'Welcome Aboard!';
            }

            if(typeof showSwiftSuccess === 'function') {
                showSwiftSuccess(title, msg);
            } else { 
                alert(msg); 
            }
        @endif

        // 2. Standard Error
        @if(session('error'))
            if(typeof showSwiftError === 'function') {
                showSwiftError('Error', '{{ session("error") }}');
            } else { alert('{{ session("error") }}'); }
        @endif

        // 3. NEW: Account Created Specific Alert
        @if(session('account_created'))
            if(typeof showSwiftSuccess === 'function') {
                // Customized Title for New Accounts
                showSwiftSuccess('Welcome to Bluebird!', '{{ session("account_created") }}');
            } else { 
                alert('{{ session("account_created") }}'); 
            }
        @endif
    </script>
</body>
</html>