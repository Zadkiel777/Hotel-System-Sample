@extends('themes.main')

@section('title', 'Staff')

@section('content_header')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"><i class="fas fa-user-tie mr-1"></i> Staff Management</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Staff</li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-outline card-primary">
                    
                    {{-- Header: Title, Search, and Add Button --}}
                    <div class="card-header">
                        <h3 class="card-title mt-1">
                            <i class="fas fa-list mr-1"></i> Staff List
                        </h3>

                        <div class="card-tools d-flex">
                            {{-- Search Form --}}
                            <form action="{{ route('staffs') }}" method="GET" class="mr-2">
                                <div class="input-group input-group-sm" style="width: 250px;">
                                    <input type="text" name="search" class="form-control float-right" placeholder="Search staff..." value="{{ request('search') }}">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>

                            {{-- Add Button --}}
                            <a href="{{ route('addstaff') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-user-plus mr-1"></i> Add Staff
                            </a>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            {{-- Table: Compact (table-sm) and vertically aligned --}}
                            <table id="userTable" class="table table-striped table-hover table-sm text-nowrap">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Contact</th>
                                        <th>Role</th>
                                        <th class="text-center" style="width: 100px;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($staffs as $staff)
                                        <tr>
                                            {{-- Name Column --}}
                                            <td class="align-middle font-weight-bold text-primary">
                                                {{ $staff->Fname }} {{ $staff->Lname }}
                                            </td>

                                            {{-- Info Columns --}}
                                            <td class="align-middle">{{ $staff->email }}</td>
                                            <td class="align-middle">{{ $staff->contact }}</td>
                                            
                                            {{-- Role Column (Badge) --}}
                                            <td class="align-middle">
                                                @php
                                                    // Optional: Color code based on role text
                                                    $badgeClass = stripos($staff->role, 'admin') !== false ? 'danger' : 'info';
                                                @endphp
                                                <span class="badge badge-{{ $badgeClass }} px-2">
                                                    {{ $staff->role }}
                                                </span>
                                            </td>

                                            {{-- Action Buttons --}}
                                            <td class="text-center align-middle">
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{ route('staffProfile', $staff->id) }}" 
                                                       class="btn btn-warning text-white" 
                                                       title="View Profile">
                                                        <i class="fas fa-eye"></i>
                                                    </a>

                                                    <form action="{{ route('deleteStaff', $staff->id) }}" method="POST" style="display: inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" 
                                                                class="btn btn-danger" 
                                                                style="border-top-left-radius: 0; border-bottom-left-radius: 0;"
                                                                title="Delete" 
                                                                onclick="return confirmDeleteStaff(event, '{{ $staff->Fname }} {{ $staff->Lname }}')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-5 text-muted">
                                                <i class="fas fa-user-tie fa-3x mb-3 opacity-50"></i><br>
                                                No staff members found.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Pagination Footer --}}
                    @if($staffs->hasPages())
                        <div class="card-footer clearfix">
                            <div class="float-right">
                                {{ $staffs->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                    @endif
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
            `Are you sure you want to delete <b>${staffName}</b>? This action cannot be undone.`,
            function() {
                form.submit();
            }
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
@endsection