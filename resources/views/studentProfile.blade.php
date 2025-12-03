@extends('themes.main')

@section('title', 'Student Profile')

@section('content_header')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                {{-- ✅ Icon added to header --}}
                <h1 class="m-0"><i class="fas fa-user mr-1"></i> Customer Profile</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    {{-- ✅ Icons added to breadcrumbs --}}
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i> Home</a></li>
                    <li class="breadcrumb-item active"><a href="{{ route('users') }}"><i class="fas fa-users"></i> Customer Profile</a></li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row justify-content-center">

            <div class="col-md-4">
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile text-center">
                        {{-- Profile Picture --}}
                        <div class="text-center mb-3">
                            @php
                                $profileImage = $customers->profile ?? 'dist/img/user2-160x160.jpg';
                                if ($profileImage && file_exists(public_path($profileImage))) {
                                    $profileSrc = asset($profileImage);
                                } else {
                                    $profileSrc = asset('dist/img/user2-160x160.jpg');
                                }
                            @endphp
                            <img class="profile-user-img img-fluid img-circle" 
                                 src="{{ $profileSrc }}" 
                                 alt="Customer profile picture"
                                 id="customerProfileImagePreview"
                                 style="width: 100px; height: 100px; object-fit: cover; border: 3px solid #adb5bd;">
                        </div>

                        {{-- ✅ Icons added to name and course --}}
                        <h3 class="profile-username text-center mt-2">
                            <i class="fas fa-user mr-1"></i>{{ $customers->Fname }} {{ $customers->Lname }}
                        </h3>
                        <p class="text-muted text-center">
                            <i class="fas fa-envelope mr-1"></i>{{ $customers->email }}
                        </p>

                        <a href="{{ route('users') }}" class="btn btn-secondary btn-block mt-3">
                            {{-- ✅ Spacing added to existing icon --}}
                            <i class="fas fa-arrow-left mr-1"></i> Back to List
                        </a>
                    </div>
                </div>
            </div>

            
            <div class="col-md-8">
                <div class="card card-primary">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title"><i class="fas fa-info-circle mr-1"></i> Customer's Information</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('updateCustomer', $customers->id) }}" id="customerForm" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <div class="form-group" id="profilePictureGroup" style="display: none;">
                                <label><i class="fas fa-image mr-1"></i> Profile Picture</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="customerProfilePicture" name="profile_picture" accept="image/*" onchange="previewCustomerProfileImage(this)">
                                    <label class="custom-file-label" for="customerProfilePicture">Choose file</label>
                                </div>
                                <small class="form-text text-muted">Recommended: Square image, max 5MB (JPG, PNG, GIF)</small>
                                @error('profile_picture') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>
                            <hr id="profilePictureHr" style="display: none;">


                            <div class="form-group">
                                <label><i class="fas fa-user mr-1"></i> First Name</label>
                                <input type="text" class="form-control" name="Fname" value="{{ $customers->Fname }}" id="fnameField" readonly required>
                                @error('Fname') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <hr>


                            <div class="form-group">
                                <label><i class="fas fa-user mr-1"></i> Last Name</label>
                                <input type="text" class="form-control" name="Lname" value="{{ $customers->Lname }}" id="lnameField" readonly required>
                                @error('Lname') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <hr>


                            <div class="form-group">
                                <label><i class="fas fa-envelope mr-1"></i> Email</label>
                                <input type="email" class="form-control" name="email" value="{{ $customers->email }}" id="emailField" readonly required>
                                @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <hr>


                            <div class="form-group">
                                <label><i class="fas fa-phone mr-1"></i> Contact</label>
                                <input type="text" class="form-control" name="contact" value="{{ $customers->contact }}" id="contactField" readonly required>
                                @error('contact') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <hr>


                            <div class="form-group">
                                <label><i class="fas fa-birthday-cake mr-1"></i> Date of Birth</label>
                                <input type="date" class="form-control" name="dob" value="{{ $customers->dob }}" id="dobField" readonly required>
                                @error('dob') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <hr>


                            <div class="form-group">
                                <label><i class="fas fa-clock mr-1"></i> Account Created</label>
                                <input type="text" class="form-control" value="{{ $customers->created_at }}" readonly>
                            </div>
                            <hr>


                            <div class="form-group" id="saveBtnGroup" style="display: none;">
                                <button type="submit" class="btn btn-success" onclick="return confirmUpdateCustomer(event)">
                                    <i class="fas fa-save mr-1"></i> Save Changes
                                </button>
                                <button type="button" class="btn btn-secondary" onclick="cancelEdit()">
                                    <i class="fas fa-times mr-1"></i> Cancel
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection

@section('scripts')
<script src="{{ asset('js/swift-alerts.js') }}"></script>
<script>
    let originalValues = {};
    let isEditMode = false;

    function toggleEditMode() {
        isEditMode = !isEditMode;
        const fields = ['fnameField', 'lnameField', 'emailField', 'contactField', 'dobField'];
        const editBtn = document.getElementById('editBtn');
        const saveBtnGroup = document.getElementById('saveBtnGroup');
        const profilePictureGroup = document.getElementById('profilePictureGroup');
        const profilePictureHr = document.getElementById('profilePictureHr');

        if (isEditMode) {
            // Store original values
            fields.forEach(fieldId => {
                const field = document.getElementById(fieldId);
                originalValues[fieldId] = field.value;
                field.removeAttribute('readonly');
                field.removeAttribute('disabled');
                field.style.backgroundColor = '#fff';
            });
            // Show profile picture upload field
            profilePictureGroup.style.display = 'block';
            profilePictureHr.style.display = 'block';
            editBtn.innerHTML = '<i class="fas fa-times mr-1"></i> Cancel';
            editBtn.classList.remove('btn-primary');
            editBtn.classList.add('btn-secondary');
            saveBtnGroup.style.display = 'block';
        } else {
            // Restore original values
            fields.forEach(fieldId => {
                const field = document.getElementById(fieldId);
                field.value = originalValues[fieldId];
                field.setAttribute('readonly', 'readonly');
                if (field.tagName === 'SELECT') {
                    field.setAttribute('disabled', 'disabled');
                }
                field.style.backgroundColor = '#e9ecef';
            });
            // Hide profile picture upload field and reset it
            profilePictureGroup.style.display = 'none';
            profilePictureHr.style.display = 'none';
            const profileInput = document.getElementById('customerProfilePicture');
            if (profileInput) {
                profileInput.value = '';
                const label = profileInput.nextElementSibling;
                if (label) label.textContent = 'Choose file';
            }
            editBtn.innerHTML = '<i class="fas fa-edit mr-1"></i> Edit';
            editBtn.classList.remove('btn-secondary');
            editBtn.classList.add('btn-primary');
            saveBtnGroup.style.display = 'none';
        }
    }
    
    function previewCustomerProfileImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            const maxSize = 5 * 1024 * 1024; // 5MB
            
            if (input.files[0].size > maxSize) {
                showSwiftError('File Too Large', 'Image size must be less than 5MB.');
                input.value = '';
                return;
            }
            
            reader.onload = function(e) {
                document.getElementById('customerProfileImagePreview').src = e.target.result;
            };
            
            reader.readAsDataURL(input.files[0]);
            
            // Update file input label
            const label = input.nextElementSibling;
            if (label) label.textContent = input.files[0].name;
        }
    }

    function cancelEdit() {
        if (isEditMode) {
            toggleEditMode();
        }
    }

    function confirmUpdateCustomer(event) {
        event.preventDefault();
        const form = document.getElementById('customerForm');
        const firstName = form.querySelector('[name="Fname"]').value;
        const lastName = form.querySelector('[name="Lname"]').value;
        
        if (!firstName || !lastName) {
            showSwiftError('Validation Error', 'Please fill in all required fields.');
            return false;
        }
        
        showSwiftConfirm(
            'Update Customer?',
            `Are you sure you want to update ${firstName} ${lastName}'s information?`,
            function() {
                form.submit();
            }
        );
        
        return false;
    }
    
    // Show success/error messages
    @if(session('success'))
        showSwiftSuccess('Success!', '{{ session("success") }}');
    @endif
    
    @if(session('error'))
        showSwiftError('Error', '{{ session("error") }}');
    @endif
</script>
@endsection