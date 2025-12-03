@extends('themes.main')

{{-- 1. DEFINE PAGE TITLE --}}
@section('title', 'User Profile')

{{-- 2. DEFINE CONTENT HEADER (Breadcrumbs) --}}
@section('content_header')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"><i class="fas fa-id-card"></i> Profile</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i> Home</a></li>
                    <li class="breadcrumb-item active"><i class="fas fa-user"></i> User Profile</li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection

{{-- 3. DEFINE MAIN CONTENT --}}
@section('content')
{{-- ✅ WRAPPERS ADDED HERE to prevent sidebar overlap --}}
<section class="content">
    <div class="container-fluid">
        
        {{-- Your existing content row --}}
        <div class="row">
            {{-- Left Column: User Card --}}
            <div class="col-md-3">
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        {{-- Profile Picture --}}
                        <div class="text-center mb-3">
                            @php
                                $profileImage = $admin->profile ?? 'dist/img/user2-160x160.jpg';
                                if ($profileImage && file_exists(public_path($profileImage))) {
                                    $profileSrc = asset($profileImage);
                                } else {
                                    $profileSrc = asset('dist/img/user2-160x160.jpg');
                                }
                            @endphp
                            <img class="profile-user-img img-fluid img-circle" 
                                src="{{ $profileSrc }}"
                                alt="User profile picture"
                                id="profileImagePreview"
                                style="width: 100px; height: 100px; object-fit: cover; border: 3px solid #adb5bd;">
                        </div>
                        
                        {{-- Display the logged-in user's Name --}}
                        <h3 class="profile-username text-center">
                            <i class="fas fa-user mr-1"></i> {{ $admin->name }}
                        </h3>

                        {{-- Display the logged-in user's Role --}}
                        <p class="text-muted text-center">
                            <i class="fas fa-user-shield mr-1"></i> {{ $admin->role ?? 'N/A' }}
                        </p>

                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b><i class="fas fa-envelope mr-1"></i> Email</b> <a class="float-right">{{ $admin->email }}</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Right Column: Account Settings Tabs --}}
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link active" href="#settings" data-toggle="tab"><i class="fas fa-cog mr-1"></i> Settings</a></li>
                            <li class="nav-item"><a class="nav-link" href="#activity" data-toggle="tab"><i class="fas fa-history mr-1"></i> Activity</a></li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            
                            {{-- Settings Tab --}}
                            <div class="tab-pane active" id="settings">
                                <form class="form-horizontal" method="POST" action="{{ route('updateProfile') }}" id="profileForm" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group row">
                                        <label for="profilePicture" class="col-sm-2 col-form-label"><i class="fas fa-image"></i> Profile Picture</label>
                                        <div class="col-sm-10">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="profilePicture" name="profile_picture" accept="image/*" onchange="previewProfileImage(this)">
                                                <label class="custom-file-label" for="profilePicture">Choose file</label>
                                            </div>
                                            <small class="form-text text-muted">Recommended: Square image, max 5MB (JPG, PNG, GIF)</small>
                                            @error('profile_picture') <span class="text-danger d-block">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputName" class="col-sm-2 col-form-label"><i class="fas fa-user-tag"></i> Name</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="inputName" name="name" placeholder="Name" value="{{ $admin->name }}" required>
                                            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail" class="col-sm-2 col-form-label"><i class="fas fa-envelope"></i> Email</label>
                                        <div class="col-sm-10">
                                            <input type="email" class="form-control" id="inputEmail" name="email" placeholder="Email" value="{{ $admin->email }}" required>
                                            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputRole" class="col-sm-2 col-form-label"><i class="fas fa-user-shield"></i> Role</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="inputRole" value="{{ $admin->role ?? 'N/A' }}" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="offset-sm-2 col-sm-10">
                                            <button type="submit" class="btn btn-success" onclick="return confirmUpdateProfile(event)"><i class="fas fa-save mr-1"></i> Save Changes</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            {{-- Activity Tab --}}
                            <div class="tab-pane" id="activity">
                                @if(isset($activities) && $activities->count() > 0)
                                    <ul class="timeline timeline-inverse">
                                        @php
                                            $currentDate = null;
                                        @endphp
                                        @foreach($activities as $activity)
                                            @php
                                                $activityDate = \Carbon\Carbon::parse($activity->created_at)->format('M d, Y');
                                                $showDateLabel = ($currentDate !== $activityDate);
                                                $currentDate = $activityDate;
                                                
                                                // Determine icon and color based on action
                                                $icon = 'history';
                                                $color = 'primary';
                                                if (strpos($activity->action, 'Login') !== false) {
                                                    $icon = 'sign-in-alt';
                                                    $color = 'success';
                                                } elseif (strpos($activity->action, 'Logout') !== false) {
                                                    $icon = 'sign-out-alt';
                                                    $color = 'danger';
                                                } elseif (strpos($activity->action, 'Profile') !== false) {
                                                    $icon = 'user-edit';
                                                    $color = 'info';
                                                } elseif (strpos($activity->action, 'Customer') !== false) {
                                                    $icon = 'user-plus';
                                                    $color = 'primary';
                                                } elseif (strpos($activity->action, 'Staff') !== false) {
                                                    $icon = 'user-tie';
                                                    $color = 'primary';
                                                } elseif (strpos($activity->action, 'Room') !== false) {
                                                    $icon = 'door-open';
                                                    $color = 'primary';
                                                }
                                            @endphp
                                            
                                            @if($showDateLabel)
                                                <li class="time-label">
                                                    <span class="bg-{{ $color }}">
                                                        {{ $activityDate }}
                                                    </span>
                                                </li>
                                            @endif
                                            
                                            <li>
                                                <i class="fas fa-{{ $icon }} bg-{{ $color }}"></i>
                                                <div class="timeline-item">
                                                    <span class="time">
                                                        <i class="far fa-clock"></i> 
                                                        {{ \Carbon\Carbon::parse($activity->created_at)->format('h:i A') }}
                                                    </span>
                                                    <h3 class="timeline-header">
                                                        <strong>{{ $activity->action }}</strong>
                                                    </h3>
                                                    <div class="timeline-body">
                                                        @if($activity->description)
                                                            {{ $activity->description }}
                                                        @else
                                                            {{ $activity->action }} performed
                                                        @endif
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                        <li>
                                            <i class="far fa-clock bg-gray"></i>
                                        </li>
                                    </ul>
                                @else
                                    <div class="text-center py-5">
                                        <i class="fas fa-history fa-3x text-muted mb-3"></i>
                                        <p class="text-muted"><i class="fas fa-info-circle mr-1"></i> No recent activity to show.</p>
                                        <small class="text-muted">Your activities will appear here once you start using the system.</small>
                                    </div>
                                @endif
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>{{-- End .container-fluid --}}
</section>{{-- End .content --}}
@endsection

@section('styles')
<style>
    .timeline {
        position: relative;
        margin: 0 0 30px 0;
        padding: 0;
        list-style: none;
    }
    .timeline:before {
        content: '';
        position: absolute;
        top: 0;
        bottom: 0;
        left: 40px;
        width: 2px;
        margin-left: -1.5px;
        background-color: #dee2e6;
    }
    .timeline > li {
        position: relative;
        margin-bottom: 20px;
    }
    .timeline > li:before,
    .timeline > li:after {
        content: " ";
        display: table;
    }
    .timeline > li:after {
        clear: both;
    }
    .timeline > li > .timeline-item {
        position: relative;
        -webkit-border-radius: 0.25rem;
        border-radius: 0.25rem;
        background-color: #fff;
        border: 1px solid #dee2e6;
        padding: 10px 15px;
        margin-left: 60px;
        margin-right: 15px;
        box-shadow: 0 1px 1px rgba(0,0,0,0.1);
    }
    .timeline > li > i {
        position: absolute;
        left: 15px;
        top: 0;
        width: 30px;
        height: 30px;
        font-size: 15px;
        line-height: 30px;
        text-align: center;
        color: #fff;
        background: #6c757d;
        border-radius: 50%;
        z-index: 100;
    }
    .timeline > li > .time-label > span {
        padding: 5px 10px;
        display: inline-block;
        border-radius: 4px;
        color: #fff;
        font-weight: 600;
    }
    .timeline > li .time {
        color: #999;
        float: right;
        padding: 10px;
        font-size: 12px;
    }
    .timeline > li .timeline-header {
        margin: 0;
        color: #495057;
        border-bottom: 1px solid #dee2e6;
        padding-bottom: 10px;
        margin-bottom: 10px;
    }
    .timeline > li .timeline-body,
    .timeline > li .timeline-footer {
        padding: 10px;
    }
    .timeline > li .timeline-body {
        color: #6c757d;
    }
    .bg-success { background-color: #28a745 !important; }
    .bg-danger { background-color: #dc3545 !important; }
    .bg-info { background-color: #17a2b8 !important; }
    .bg-primary { background-color: #007bff !important; }
    .bg-gray { background-color: #6c757d !important; }
</style>
@endsection

@section('scripts')
<script src="{{ asset('js/swift-alerts.js') }}"></script>
<script>
    function previewProfileImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            const maxSize = 5 * 1024 * 1024; // 5MB
            
            if (input.files[0].size > maxSize) {
                showSwiftError('File Too Large', 'Image size must be less than 5MB.');
                input.value = '';
                return;
            }
            
            reader.onload = function(e) {
                document.getElementById('profileImagePreview').src = e.target.result;
            };
            
            reader.readAsDataURL(input.files[0]);
            
            // Update file input label
            const label = input.nextElementSibling;
            label.textContent = input.files[0].name;
        }
    }
    
    function confirmUpdateProfile(event) {
        event.preventDefault();
        const form = document.getElementById('profileForm');
        const name = form.querySelector('[name="name"]').value;
        const email = form.querySelector('[name="email"]').value;
        
        if (!name || !email) {
            showSwiftError('Validation Error', 'Please fill in all required fields.');
            return false;
        }
        
        showSwiftConfirm(
            'Update Profile?',
            'Are you sure you want to update your profile information?',
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