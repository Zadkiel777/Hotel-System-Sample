@extends('themes.main')

{{-- Define the page title --}}
@section('title', 'Admins')

{{-- Content Header Section (Breadcrumbs) --}}
@section('content_header')

{{-- ✅ This is the corrected line --}}
<nav class="navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                <i class="fas fa-bars"></i>
            </a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ route('dashboard') }}" class="nav-link">Home</a>
        </li>
    </ul>

    <!-- Search form -->
    <form class="form-inline ml-3" action="{{ route('admins') }}" method="GET">
        <div class="input-group input-group-sm">
            <input 
                class="form-control form-control-navbar" 
                type="search" 
                name="search" 
                placeholder="Search admins..."
                aria-label="Search"
                value="{{ request('search') }}">
            <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                    <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    </form>

    <!-- Right navbar icons -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
    </ul>
</nav>


<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                {{-- ✅ Icon added to header --}}
                <h1 class="m-0"><i class="fas fa-user-shield mr-1"></i> List of Admins</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    {{-- ✅ Icons added to breadcrumbs --}}
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i> Home</a></li>
                    <li class="breadcrumb-item active"><i class="fas fa-user-shield"></i> Admins</li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection

{{-- Main Content Block --}}
@section('content')
{{-- ✅ Content wrappers added to prevent sidebar overlap --}}
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    {{-- Header --}}
                    <div class="card-header d-flex justify-content-between align-items-center">
                        {{-- ✅ Icon added to card title --}}
                        <h3 class="card-title"><i class="fas fa-list mr-1"></i> Lists of Admins</h3>
                    </div>

                    <div class="table-responsive">

        {{-- ✅ Added 'table-hover' for a nice row highlight on mouseover --}}
        <table id="adminTable" class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th><i class="fas fa-image"></i> Profile</th>
                    <th><i class="fas fa-user"></i> Name</th>
                    <th><i class="fas fa-envelope"></i> Email</th>
                    <th><i class="fas fa-user-shield"></i> Role</th>
                    <th style="width: 120" class="text-center">
                        <i class="fas fa-tools"></i> Action
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($admins as $admin)
                    <tr>
                        <td>
                            @php
                                $profileImage = $admin->profile ?? 'dist/img/user2-160x160.jpg';
                                if ($profileImage && file_exists(public_path($profileImage))) {
                                    $profileSrc = asset($profileImage);
                                } else {
                                    $profileSrc = asset('dist/img/user2-160x160.jpg');
                                }
                            @endphp
                            <img src="{{ $profileSrc }}" 
                                 alt="Profile" 
                                 class="img-circle elevation-2" 
                                 style="width: 40px; height: 40px; object-fit: cover;">
                        </td>
                        <td>{{ $admin->name }}</td>
                        <td>{{ $admin->email }}</td>
                        <td><span class="badge badge-primary">{{ $admin->role ?? 'Admin' }}</span></td>
                        <td>
                            {{-- ✅ Centered the buttons in the 'Action' column --}}
                            <div class="d-flex justify-content-center" style="gap: 10px;">
                                @if($admin->id == session('id'))
                                    <a href="{{ route('profile') }}"
                                        class="btn btn-info btn-sm">
                                        <i class="fas fa-user"></i> My Profile
                                    </a>
                                @else
                                    <span class="text-muted">
                                        <i class="fas fa-info-circle"></i> View Only
                                    </span>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">
                            <i class="fas fa-info-circle mr-1"></i> No admins found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div> {{-- End .table-responsive --}}

    <div class="d-flex justify-content-center mt-3">
        {{ $admins->links('pagination::bootstrap-5') }}
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
    // Show success/error messages
    @if(session('success'))
        showSwiftSuccess('Success!', '{{ session("success") }}');
    @endif
    
    @if(session('error'))
        showSwiftError('Error', '{{ session("error") }}');
    @endif
</script>
@endsection

