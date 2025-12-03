@extends('themes.main')

{{-- Define the page title --}}
@section('title', ' Customers ')

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
    <form class="form-inline ml-3" action="{{ route('users') }}" method="GET">
        <div class="input-group input-group-sm">
            <input 
                class="form-control form-control-navbar" 
                type="search" 
                name="search" 
                placeholder="Search Customers..."
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
                <h1 class="m-0"><i class="fas fa-users mr-1"></i> Customers</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    {{-- ✅ Icons added to breadcrumbs --}}
                    <li class="breadcrumb-item active"><i class="fas fa-users"></i> Customers</li>
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
        @include('layout.partials.alerts')
        <div class="row">
            <div class="col-12">
                <div class="card">
                    {{-- Header with "Add Student" button --}}
                    <div class="card-header d-flex justify-content-between align-items-center">
                        {{-- ✅ Icon added to card title --}}
                        <h3 class="card-title"><i class="fas fa-list mr-1"></i> Lists of Customers</h3>
                    </div>

                    <div class="card-body">

    {{-- ✅ This wrapper makes the table scroll on small screens --}}
    <div class="table-responsive">

        {{-- ✅ Added 'table-hover' for a nice row highlight on mouseover --}}
        <table id="userTable" class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th style="width: 80px;"><i class="fas fa-image"></i> Photo</th>
                    <th><i class="fas fa-user"></i> Name</th>
                    <th><i class="fas fa-envelope"></i> Email</th>
                    <th><i class="fas fa-phone"></i> Contact</th>
                    <th><i class="fas fa-user-tag"></i> Type</th>

                    {{-- ✅ Centered the 'Action' header text --}}
                    <th style="width: 120" class="text-center">
                        <i class="fas fa-tools"></i> Action
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($customers as $customer)
                    <tr>
                        <td class="text-center">
                            @php
                                $profileImage = $customer->profile ?? 'dist/img/user2-160x160.jpg';
                                if ($profileImage && file_exists(public_path($profileImage))) {
                                    $profileSrc = asset($profileImage);
                                } else {
                                    $profileSrc = asset('dist/img/user2-160x160.jpg');
                                }
                            @endphp
                            <img src="{{ $profileSrc }}" 
                                 alt="{{ $customer->Fname }} {{ $customer->Lname }}" 
                                 class="img-circle elevation-2" 
                                 style="width: 50px; height: 50px; object-fit: cover; cursor: pointer;"
                                 onclick="window.location.href='{{ route('studentProfile', $customer->id) }}'"
                                 title="Click to view profile">
                        </td>
                        <td>{{ $customer->Fname }} {{ $customer->Lname }}</td>
                        <td>{{ $customer->email }}</td>
                        <td>{{ $customer->contact }}</td>
                        <td>{{ $customer->customer_type }}</td>
                        <td>
                            {{-- ✅ Centered the buttons in the 'Action' column --}}
                            <div class="d-flex justify-content-center" style="gap: 10px;">
                                <a href="{{ route('studentProfile', $customer->id) }}"
                                    class="btn btn-warning btn-sm">
                                    <i class="fas fa-eye"></i> View
                                </a>

                                <form
                                    action="{{ route('deleteStudent', $customer->id) }}"
                                    method="POST"
                                    class="delete-customer-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirmDeleteCustomer(event, '{{ $customer->Fname }} {{ $customer->Lname }}')">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">
                            <i class="fas fa-info-circle mr-1"></i> No customers found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div> {{-- End .table-responsive --}}

    <div class="d-flex justify-content-center mt-3">
        {{ $customers->links('pagination::simple-bootstrap-5') }}
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
    function confirmDeleteCustomer(event, customerName) {
        event.preventDefault();
        const form = event.target.closest('form');
        
        showSwiftConfirm(
            'Delete Customer?',
            `Are you sure you want to delete ${customerName}? This action cannot be undone.`,
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