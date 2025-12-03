<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Staff</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        body {
            min-height: 100vh;
            background: radial-gradient(circle at top, #4c6ef5, #0b1f4d 70%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px 15px;
            font-family: 'Inter', 'Segoe UI', sans-serif;
        }
        .glass-card {
            width: 100%;
            max-width: 640px;
            backdrop-filter: blur(18px);
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.15);
            box-shadow: 0 20px 60px rgba(10, 20, 60, 0.4);
            border-radius: 24px;
        }
        .card-body {
            padding: 2.5rem;
        }
        .form-label {
            font-weight: 600;
            color: #0b1f4d;
        }
        .form-control,
        .form-select {
            border-radius: 12px;
            padding: 0.85rem 1rem;
        }
        .form-control:focus,
        .form-select:focus {
            border-color: #4c6ef5;
            box-shadow: 0 0 0 0.2rem rgba(76, 110, 245, 0.2);
        }
        .input-group-text {
            border-radius: 12px 0 0 12px;
            background: rgba(76, 110, 245, 0.1);
            border-right: none;
        }
        .btn-gradient {
            background: linear-gradient(135deg, #4c6ef5 0%, #8c54ff 100%);
            border: none;
            border-radius: 12px;
            font-weight: 600;
            letter-spacing: 0.5px;
            padding: 0.9rem 1.25rem;
        }
        .btn-outline-light {
            border-radius: 12px;
            border-width: 2px;
            font-weight: 600;
        }
        .error-message {
            color: #dc3545;
            font-size: 0.85rem;
            margin-top: 0.35rem;
        }
        .page-title span {
            color: #a5b4fc;
            font-weight: 500;
            font-size: 0.95rem;
        }
    </style>
</head>
<body>
    <div class="glass-card text-white">
        <div class="card-body">
            <div class="text-center mb-4">
                <div class="mb-2">
                    <span class="badge bg-primary bg-opacity-25 text-primary px-3 py-2 rounded-pill">
                        <i class="fas fa-user-tie me-1"></i> Bluebird Hotel
                    </span>
                </div>
                <h2 class="page-title fw-bold mb-0">Add New Staff</h2>
                <span>Complete the information below to onboard a staff member.</span>
            </div>

            <form method="POST" action="{{ route('save_staff') }}" class="text-dark">
                @csrf

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label"><i class="fas fa-user me-2 text-primary"></i>First Name</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                            <input type="text" name="Fname" class="form-control" placeholder="Enter first name" required value="{{ old('Fname') }}">
                        </div>
                        @error('Fname') <span class="error-message">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label"><i class="fas fa-user me-2 text-primary"></i>Last Name</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                            <input type="text" name="Lname" class="form-control" placeholder="Enter last name" required value="{{ old('Lname') }}">
                        </div>
                        @error('Lname') <span class="error-message">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="row g-3 mt-1">
                    <div class="col-md-6">
                        <label class="form-label"><i class="fas fa-envelope me-2 text-primary"></i>Email Address</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-envelope-open-text"></i></span>
                            <input type="email" name="email" class="form-control" placeholder="Enter email address" required value="{{ old('email') }}">
                        </div>
                        @error('email') <span class="error-message">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label"><i class="fas fa-phone me-2 text-primary"></i>Contact Number</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                            <input type="text" name="contact" class="form-control" placeholder="09XX-XXX-XXXX" required value="{{ old('contact') }}">
                        </div>
                        @error('contact') <span class="error-message">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="mt-3">
                    <label class="form-label"><i class="fas fa-user-gear me-2 text-primary"></i>Role</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-briefcase"></i></span>
                        <select name="role" class="form-select" required>
                            <option value="">Select staff role</option>
                            <option value="Chef" {{ old('role') == 'Chef' ? 'selected' : '' }}>Chef</option>
                            <option value="Cleaner" {{ old('role') == 'Cleaner' ? 'selected' : '' }}>Cleaner</option>
                            <option value="Valet" {{ old('role') == 'Valet' ? 'selected' : '' }}>Valet</option>
                            <option value="Receptionist" {{ old('role') == 'Receptionist' ? 'selected' : '' }}>Receptionist</option>
                            <option value="Security" {{ old('role') == 'Security' ? 'selected' : '' }}>Security</option>
                        </select>
                    </div>
                    @error('role') <span class="error-message">{{ $message }}</span> @enderror
                </div>

                <div class="d-flex flex-column flex-md-row gap-3 mt-4">
                    <button type="submit" class="btn btn-gradient text-white w-100" onclick="return confirmStaffSave(event)">
                        <i class="fas fa-save me-2"></i>Save Staff
                    </button>
                    <a href="{{ route('staffs') }}" class="btn btn-outline-light w-100" onclick="return confirmBack(event)">
                        <i class="fas fa-arrow-left me-2"></i>Back to list
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script src="{{ asset('js/swift-alerts.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function confirmStaffSave(event) {
            event.preventDefault();
            const form = event.target.closest('form');
            const firstName = form.querySelector('[name="Fname"]').value;
            const lastName = form.querySelector('[name="Lname"]').value;
            const email = form.querySelector('[name="email"]').value;

            if (!firstName || !lastName || !email) {
                showSwiftError('Validation Error', 'Please fill in all required fields.');
                return false;
            }

            showSwiftConfirm(
                'Confirm Save',
                `Are you sure you want to add ${firstName} ${lastName}?`,
                function() { form.submit(); }
            );
            return false;
        }

        function confirmBack(event) {
            event.preventDefault();
            showSwiftConfirm(
                'Go Back?',
                'Any unsaved changes will be lost. Continue?',
                function() { window.location.href = '{{ route("staffs") }}'; }
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
</body>
</html>

