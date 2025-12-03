@extends('themes.main')

@section('title', 'Student Profile')

@section('content_header')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                {{-- ✅ Icon added to header --}}
                <h1 class="m-0"><i class="fas fa-user mr-1"></i> Staff Profile</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    {{-- ✅ Icons added to breadcrumbs --}}
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i> Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('staffs') }}"><i class="fas fa-user-tie"></i> Staff</a></li>
                    <li class="breadcrumb-item active"><i class="fas fa-user"></i> Profile</li>
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
                <div class="card card-danger card-outline">
                    <div class="card-body box-profile text-center">

                

                        {{-- ✅ Icons added to name and course --}}
                        <h3 class="profile-username text-center mt-2">
                            <i class="fas fa-user mr-1"></i>{{ $staffs->Fname }} {{ $staffs->Lname }}
                        </h3>
                        <p class="text-muted text-center">
                            <i class="fas fa-briefcase mr-1"></i>{{ $staffs->role }}
                        </p>

                        <a href="{{ route('staffs') }}" class="btn btn-secondary btn-block mt-3">
                            {{-- ✅ Spacing added to existing icon --}}
                            <i class="fas fa-arrow-left mr-1"></i> Back to List
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card card-danger">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title"><i class="fas fa-info-circle mr-1"></i> Staff's Information</h3>
                        <button type="button" class="btn btn-sm btn-danger" onclick="toggleEditMode()" id="editBtn">
                            <i class="fas fa-edit mr-1"></i> Edit
                        </button>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('updateStaff', $staffs->id) }}" id="staffForm">
                            @csrf
                            @method('PUT')
                            
                            <div class="form-group">
                                <label><i class="fas fa-user mr-1"></i> First Name</label>
                                <input type="text" class="form-control" name="Fname" value="{{ $staffs->Fname }}" id="fnameField" readonly required>
                                @error('Fname') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <hr>

                            <div class="form-group">
                                <label><i class="fas fa-user mr-1"></i> Last Name</label>
                                <input type="text" class="form-control" name="Lname" value="{{ $staffs->Lname }}" id="lnameField" readonly required>
                                @error('Lname') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <hr>

                            <div class="form-group">
                                <label><i class="fas fa-envelope mr-1"></i> Email</label>
                                <input type="email" class="form-control" name="email" value="{{ $staffs->email }}" id="emailField" readonly required>
                                @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <hr>

                            <div class="form-group">
                                <label><i class="fas fa-phone mr-1"></i> Contact</label>
                                <input type="text" class="form-control" name="contact" value="{{ $staffs->contact }}" id="contactField" readonly required>
                                @error('contact') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <hr>

                            <div class="form-group">
                                <label><i class="fas fa-briefcase mr-1"></i> Role</label>
                                <select class="form-control" name="role" id="roleField" style="height: auto;" disabled required>
                                    <option value="Chef" {{ $staffs->role == 'Chef' ? 'selected' : '' }}>Chef</option>
                                    <option value="Cleaner" {{ $staffs->role == 'Cleaner' ? 'selected' : '' }}>Cleaner</option>
                                    <option value="Vallet" {{ $staffs->role == 'Vallet' ? 'selected' : '' }}>Vallet</option>
                                    <option value="Receptionist" {{ $staffs->role == 'Receptionist' ? 'selected' : '' }}>Receptionist</option>
                                    <option value="Security" {{ $staffs->role == 'Security' ? 'selected' : '' }}>Security</option>
                                </select>
                                @error('role') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <hr>

                            <div class="form-group" id="saveBtnGroup" style="display: none;">
                                <button type="submit" class="btn btn-success" onclick="return confirmUpdateStaff(event)">
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
        const fields = ['fnameField', 'lnameField', 'emailField', 'contactField', 'roleField'];
        const editBtn = document.getElementById('editBtn');
        const saveBtnGroup = document.getElementById('saveBtnGroup');

        if (isEditMode) {
            // Store original values
            fields.forEach(fieldId => {
                const field = document.getElementById(fieldId);
                originalValues[fieldId] = field.value;
                field.removeAttribute('readonly');
                field.disabled = false;
                field.style.backgroundColor = '#fff';
            });
            editBtn.innerHTML = '<i class="fas fa-times mr-1"></i> Cancel';
            editBtn.classList.remove('btn-danger');
            editBtn.classList.add('btn-secondary');
            saveBtnGroup.style.display = 'block';
        } else {
            // Restore original values
            fields.forEach(fieldId => {
                const field = document.getElementById(fieldId);
                field.value = originalValues[fieldId];
                field.setAttribute('readonly', 'readonly');
                field.disabled = true;
                field.style.backgroundColor = '#e9ecef';
            });
            editBtn.innerHTML = '<i class="fas fa-edit mr-1"></i> Edit';
            editBtn.classList.remove('btn-secondary');
            editBtn.classList.add('btn-danger');
            saveBtnGroup.style.display = 'none';
        }
    }

    function cancelEdit() {
        if (isEditMode) {
            toggleEditMode();
        }
    }

    function confirmUpdateStaff(event) {
        event.preventDefault();
        const form = document.getElementById('staffForm');
        const firstName = form.querySelector('[name="Fname"]').value;
        const lastName = form.querySelector('[name="Lname"]').value;
        
        if (!firstName || !lastName) {
            showSwiftError('Validation Error', 'Please fill in all required fields.');
            return false;
        }
        
        showSwiftConfirm(
            'Update Staff?',
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