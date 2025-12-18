@extends('themes.main')

@section('title', 'Customer Profile')

@section('content_header')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"><i class="fas fa-user-circle mr-2 text-primary"></i> Customer Profile</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i> Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('users') }}">Customers</a></li>
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

            {{-- LEFT COLUMN: Profile Card --}}
            <div class="col-md-4">
                <div class="card card-primary card-outline shadow-sm">
                    <div class="card-body box-profile">
                        <div class="text-center mb-3">
                            @php
                                $profileImage = $customers->profile ?? 'dist/img/user2-160x160.jpg';
                                if ($profileImage && file_exists(public_path($profileImage))) {
                                    $profileSrc = asset($profileImage);
                                } else {
                                    $profileSrc = asset('dist/img/user2-160x160.jpg');
                                }
                            @endphp
                            
                            <img class="profile-user-img img-fluid img-circle shadow-sm" 
                                 src="{{ $profileSrc }}" 
                                 alt="Customer profile picture"
                                 style="width: 120px; height: 120px; object-fit: cover; border: 3px solid #fff; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
                        </div>

                        <h3 class="profile-username text-center font-weight-bold">
                            {{ $customers->Fname }} {{ $customers->Lname }}
                        </h3>

                        <p class="text-muted text-center mb-1">
                            <i class="fas fa-envelope mr-1"></i> {{ $customers->email }}
                        </p>

                        <div class="text-center mb-3">
                            <span class="badge badge-info px-3 py-2">{{ $customers->customer_type }}</span>
                        </div>

                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b>Account Created</b> <a class="float-right text-muted">{{ \Carbon\Carbon::parse($customers->created_at)->format('M d, Y') }}</a>
                            </li>
                        </ul>

                        <a href="{{ route('users') }}" class="btn btn-default btn-block">
                            <i class="fas fa-arrow-left mr-1"></i> Back to List
                        </a>
                    </div>
                </div>
            </div>

            {{-- RIGHT COLUMN: Details (Read Only) --}}
            <div class="col-md-8">
                <div class="card card-primary card-outline shadow-sm">
                    <div class="card-header bg-white border-bottom-0">
                        <h3 class="card-title text-white"><i class="fas fa-id-card mr-1"></i> Personal Information</h3>
                    </div>
                    
                    <div class="card-body">
                        {{-- Row 1: Name --}}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small text-muted mb-1">First Name</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-light border-0"><i class="fas fa-user"></i></span>
                                        </div>
                                        <input type="text" class="form-control bg-light border-0" value="{{ $customers->Fname }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small text-muted mb-1">Last Name</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-light border-0"><i class="fas fa-user"></i></span>
                                        </div>
                                        <input type="text" class="form-control bg-light border-0" value="{{ $customers->Lname }}" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="my-2">

                        {{-- Row 2: Contact Info --}}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small text-muted mb-1">Email Address</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-light border-0"><i class="fas fa-envelope"></i></span>
                                        </div>
                                        <input type="text" class="form-control bg-light border-0" value="{{ $customers->email }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small text-muted mb-1">Phone Number</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-light border-0"><i class="fas fa-phone"></i></span>
                                        </div>
                                        <input type="text" class="form-control bg-light border-0" value="{{ $customers->contact }}" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="my-2">

                        {{-- Row 3: DOB & Type --}}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small text-muted mb-1">Date of Birth</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-light border-0"><i class="fas fa-birthday-cake"></i></span>
                                        </div>
                                        <input type="text" class="form-control bg-light border-0" value="{{ $customers->dob }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small text-muted mb-1">Customer Type</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-light border-0"><i class="fas fa-tag"></i></span>
                                        </div>
                                        <input type="text" class="form-control bg-light border-0" value="{{ $customers->customer_type }}" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

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
    // Only keeping flash messages in case we arrived here from a redirect
    @if(session('success'))
        showSwiftSuccess('Success!', '{{ session("success") }}');
    @endif
    
    @if(session('error'))
        showSwiftError('Error', '{{ session("error") }}');
    @endif
</script>
@endsection