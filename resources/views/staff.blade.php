@extends('themes.main')

{{-- Define the page title --}}
@section('title', 'Staff')

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

    {{-- Header with "Add Student" button --}}
                    <div class="card-header d-flex justify-content-between align-items-center">
                        {{-- ✅ Icon added to card title --}}
                        <a href="{{ route('addstaff') }}" class="btn btn-primary btn-sm">
                            {{-- ✅ Spacing added to existing icon --}}
                            <i class="fas fa-user-tie mr-1"></i> Add staff
                        </a>
                    </div>

    <!-- Search form -->
    <form class="form-inline ml-3" action="{{ route('staffs') }}" method="GET">
        <div class="input-group input-group-sm">
            <input 
                class="form-control form-control-navbar" 
                type="search" 
                name="search" 
                placeholder="Search staff details..."
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
                <h1 class="m-0"><i class="fas fa-user-tie mr-1"></i> List of Staff</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    {{-- ✅ Icons added to breadcrumbs --}}
                    <li class="breadcrumb-item active"><i class="fas fa-user-tie"></i> Staff</li>
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
                    {{-- Header with "Add Student" button --}}
                    <div class="card-header d-flex justify-content-between align-items-center">
                        {{-- ✅ Icon added to card title --}}
                        <h3 class="card-title"><i class="fas fa-list mr-1"></i> Lists of Staff</h3>
                    </div>

                    <div class="table-responsive">

        {{-- ✅ Added 'table-hover' for a nice row highlight on mouseover --}}
        <table id="userTable" class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th><i class="fas fa-user"></i> Name</th>
                    <th><i class="fas fa-envelope"></i> Email</th>
                    <th><i class="fas fa-phone"></i> Contact</th>
                    <th><i class="fas fa-briefcase"></i> Role</th>

                    {{-- ✅ Centered the 'Action' header text --}}
                    <th style="width: 120" class="text-center">
                        <i class="fas fa-tools"></i> Action
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($staffs as $staff)
                    <tr>
                        <td>{{ $staff->Fname }} {{ $staff->Lname }}</td>
                        <td>{{ $staff->email }}</td>
                        <td>{{ $staff->contact }}</td>
                        <td>{{ $staff->role }}</td>
                        <td>
                            {{-- ✅ Centered the buttons in the 'Action' column --}}
                            <div class="d-flex justify-content-center" style="gap: 10px;">
                                <a href="{{ route('staffProfile', $staff->id) }}"
                                    class="btn btn-warning btn-sm">
                                    <i class="fas fa-eye"></i> View
                                </a>
                                

                                <form
                                    action="{{ route('deleteStaff', $staff->id) }}"
                                    method="POST"
                                    class="delete-staff-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirmDeleteStaff(event, '{{ $staff->Fname }} {{ $staff->Lname }}')">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">
                            <i class="fas fa-info-circle mr-1"></i> No staff's found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div> {{-- End .table-responsive --}}

    <div class="d-flex justify-content-center mt-3">
        {{ $staffs->links('pagination::bootstrap-5') }}
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
    function confirmDeleteStaff(event, staffName) {
        event.preventDefault();
        const form = event.target.closest('form');
        
        showSwiftConfirm(
            'Delete Staff?',
            `Are you sure you want to delete ${staffName}? This action cannot be undone.`,
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