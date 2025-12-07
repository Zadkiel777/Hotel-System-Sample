@extends('themes.main')

@section('title', 'Staff Profile')

@section('content_header')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"><i class="fas fa-user-tie mr-2 text-primary"></i> Staff Profile</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i> Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('staffs') }}">Staff</a></li>
                    <li class="breadcrumb-item active">Profile</li>
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

            {{-- LEFT COLUMN: Profile Card (Red Theme) --}}
            <div class="col-md-4">
                <div class="card card-primary card-outline shadow-sm">
                    <div class="card-body box-profile">
                        <div class="text-center position-relative mb-3">
                            {{-- Profile Image Logic --}}
                            @php
                                $profileImage = $staffs->profile ?? 'dist/img/user2-160x160.jpg';
                                if ($profileImage && file_exists(public_path($profileImage))) {
                                    $profileSrc = asset($profileImage);
                                } else {
                                    $profileSrc = asset('dist/img/user2-160x160.jpg');
                                }
                            @endphp
                            
                            <div class="d-inline-block position-relative">
                                <img class="profile-user-img img-fluid img-circle shadow-sm" 
                                     src="{{ $profileSrc }}" 
                                     alt="Staff profile picture"
                                     id="staffProfileImagePreview"
                                     style="width: 120px; height: 120px; object-fit: cover; border: 3px solid #fff; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
                                
                                {{-- Camera Overlay (Visible only in Edit Mode) --}}
                                <div id="imageEditOverlay" onclick="triggerFileInput()" 
                                     style="display: none; position: absolute; bottom: 5px; right: 5px; background: #4035dc; color: white; border-radius: 50%; width: 35px; height: 35px; text-align: center; line-height: 35px; cursor: pointer; border: 2px solid white; box-shadow: 0 2px 4px rgba(0,0,0,0.2);">
                                    <i class="fas fa-camera" style="font-size: 14px;"></i>
                                </div>
                            </div>
                        </div>

                        <h3 class="profile-username text-center font-weight-bold">
                            {{ $staffs->Fname }} {{ $staffs->Lname }}
                        </h3>

                        <div class="text-center mb-4">
                            <span class="badge badge-primary px-3 py-2">{{ $staffs->role }}</span>
                        </div>

                        <a href="{{ route('staffs') }}" class="btn btn-default btn-block">
                            <i class="fas fa-arrow-left mr-1"></i> Back to List
                        </a>
                    </div>
                </div>
            </div>

            {{-- RIGHT COLUMN: Staff Information --}}
            <div class="col-md-8">
                <div class="card card-danger card-outline shadow-sm border-top-0">
                    {{-- Header: Red Background, White Text --}}
                    <div class="card-header bg-danger d-flex justify-content-between align-items-center">
                        <h3 class="card-title text-white"><i class="fas fa-info-circle mr-1"></i> Staff's Information</h3>
                        <button type="button" class="btn btn-sm btn-light text-black font-weight-bold shadow-none" id="editBtn" onclick="toggleEditMode()">
                            <i class="fas fa-edit mr-1"></i> Edit
                        </button>
                    </div>
                    
                    <div class="card-body">
                        <form method="POST" action="{{ route('updateStaff', $staffs->id) }}" id="staffForm" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            {{-- Hidden File Input --}}
                            <input type="file" id="staffProfilePicture" name="profile_picture" accept="image/*" style="display: none;" onchange="previewStaffProfileImage(this)">
                            @error('profile_picture') <div class="alert alert-danger mt-2">{{ $message }}</div> @enderror
                            
                            {{-- Row 1: Names --}}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="small text-muted mb-1">First Name</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-light border-0 icon-box"><i class="fas fa-user"></i></span>
                                            </div>
                                            <input type="text" class="form-control bg-light border-0 editable-field" name="Fname" value="{{ $staffs->Fname }}" id="fnameField" readonly required>
                                        </div>
                                        @error('Fname') <span class="text-danger small">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="small text-muted mb-1">Last Name</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-light border-0 icon-box"><i class="fas fa-user"></i></span>
                                            </div>
                                            <input type="text" class="form-control bg-light border-0 editable-field" name="Lname" value="{{ $staffs->Lname }}" id="lnameField" readonly required>
                                        </div>
                                        @error('Lname') <span class="text-danger small">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>

                            <hr class="my-2 dashed-hr">

                            {{-- Row 2: Contact Info --}}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="small text-muted mb-1">Email</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-light border-0 icon-box"><i class="fas fa-envelope"></i></span>
                                            </div>
                                            <input type="email" class="form-control bg-light border-0 editable-field" name="email" value="{{ $staffs->email }}" id="emailField" readonly required>
                                        </div>
                                        @error('email') <span class="text-danger small">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="small text-muted mb-1">Contact</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-light border-0 icon-box"><i class="fas fa-phone"></i></span>
                                            </div>
                                            <input type="text" class="form-control bg-light border-0 editable-field" name="contact" value="{{ $staffs->contact }}" id="contactField" readonly required>
                                        </div>
                                        @error('contact') <span class="text-danger small">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>

                            <hr class="mt-0 mb-3 dashed-hr">

                            {{-- Row 3: Role --}}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="small text-muted mb-1">Role</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-light border-0 icon-box"><i class="fas fa-briefcase"></i></span>
                                            </div>
                                            <select class="form-control bg-light border-0 editable-field" name="role" id="roleField" disabled required>
                                                <option value="Chef" {{ $staffs->role == 'Chef' ? 'selected' : '' }}>Chef</option>
                                                <option value="Cleaner" {{ $staffs->role == 'Cleaner' ? 'selected' : '' }}>Cleaner</option>
                                                <option value="Vallet" {{ $staffs->role == 'Vallet' ? 'selected' : '' }}>Vallet</option>
                                                <option value="Receptionist" {{ $staffs->role == 'Receptionist' ? 'selected' : '' }}>Receptionist</option>
                                                <option value="Security" {{ $staffs->role == 'Security' ? 'selected' : '' }}>Security</option>
                                            </select>
                                        </div>
                                        @error('role') <span class="text-danger small">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- Save Buttons --}}
                            <div class="row mt-4" id="saveBtnGroup" style="display: none;">
                                <div class="col-12 text-right">
                                    <hr>
                                    <button type="button" class="btn btn-default mr-2" onclick="cancelEdit()">
                                        <i class="fas fa-times mr-1"></i> Cancel
                                    </button>
                                    <button type="submit" class="btn btn-success px-4" onclick="return confirmUpdateStaff(event)">
                                        <i class="fas fa-save mr-1"></i> Save Changes
                                    </button>
                                </div>
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

    // Trigger file input
    function triggerFileInput() {
        document.getElementById('staffProfilePicture').click();
    }

    function toggleEditMode() {
        isEditMode = !isEditMode;
        
        // Elements
        const editBtn = document.getElementById('editBtn');
        const saveBtnGroup = document.getElementById('saveBtnGroup');
        const imageOverlay = document.getElementById('imageEditOverlay');
        const editableFields = document.querySelectorAll('.editable-field');
        const iconBoxes = document.querySelectorAll('.icon-box');

        if (isEditMode) {
            // ENTER EDIT MODE
            imageOverlay.style.display = 'block';
            saveBtnGroup.style.display = 'block';
            editBtn.style.display = 'none';

            editableFields.forEach(field => {
                originalValues[field.id] = field.value;
                
                // Handle Select vs Input
                if (field.tagName === 'SELECT') {
                    field.disabled = false;
                } else {
                    field.removeAttribute('readonly');
                }
                
                // Styling
                field.classList.remove('bg-light', 'border-0');
                field.classList.add('bg-white', 'border');
            });

            iconBoxes.forEach(icon => {
                icon.classList.remove('bg-light', 'border-0');
                icon.classList.add('bg-white', 'border', 'border-right-0');
            });

        } else {
            // EXIT EDIT MODE
            imageOverlay.style.display = 'none';
            saveBtnGroup.style.display = 'none';
            editBtn.style.display = 'block';

            editableFields.forEach(field => {
                if(originalValues[field.id] !== undefined) {
                    field.value = originalValues[field.id];
                }
                
                if (field.tagName === 'SELECT') {
                    field.disabled = true;
                } else {
                    field.setAttribute('readonly', 'readonly');
                }
                
                // Styling
                field.classList.add('bg-light', 'border-0');
                field.classList.remove('bg-white', 'border');
            });

            iconBoxes.forEach(icon => {
                icon.classList.add('bg-light', 'border-0');
                icon.classList.remove('bg-white', 'border', 'border-right-0');
            });

            // Reset File
            const profileInput = document.getElementById('staffProfilePicture');
            if (profileInput) profileInput.value = '';
        }
    }

    function previewStaffProfileImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            // 5MB Limit
            if (input.files[0].size > 5 * 1024 * 1024) {
                showSwiftError('File Too Large', 'Image size must be less than 5MB.');
                input.value = '';
                return;
            }
            reader.onload = function(e) {
                document.getElementById('staffProfileImagePreview').src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function cancelEdit() {
        if (isEditMode) toggleEditMode();
    }

    function confirmUpdateStaff(event) {
        event.preventDefault();
        const form = document.getElementById('staffForm');
        const fName = document.getElementById('fnameField').value;
        const lName = document.getElementById('lnameField').value;
        
        if (!fName || !lName) {
            showSwiftError('Validation Error', 'First and Last name are required.');
            return false;
        }
        
        showSwiftConfirm(
            'Update Staff?',
            `Are you sure you want to update ${fName} ${lName}'s information?`,
            function() {
                form.submit();
            }
        );
        return false;
    }
    
    // Alerts
    @if(session('success'))
        showSwiftSuccess('Success!', '{{ session("success") }}');
    @endif
    
    @if(session('error'))
        showSwiftError('Error', '{{ session("error") }}');
    @endif
</script>
@endsection