@extends('themes.main')

@section('title', 'Customers')

@section('content_header')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"><i class="fas fa-users mr-1"></i> Customer Management</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Customers</li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<section class="content">
    <div class="container-fluid">
        @include('layout.partials.alerts')
        <div class="row">
            <div class="col-12">
                <div class="card card-outline card-primary">
                    
                    {{-- Header: Title + Search Bar --}}
                    <div class="card-header">
                        <h3 class="card-title mt-1">
                            <i class="fas fa-list mr-1"></i> Customer List
                        </h3>

                        <div class="card-tools">
                            <form action="{{ route('users') }}" method="GET">
                                <div class="input-group input-group-sm" style="width: 250px;">
                                    <input type="text" name="search" class="form-control float-right" placeholder="Search customers..." value="{{ request('search') }}">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            {{-- Added 'table-sm' for compact rows and 'text-nowrap' --}}
                            <table id="userTable" class="table table-striped table-hover table-sm text-nowrap">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="text-center" style="width: 80px;">Photo</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Contact</th>
                                        <th>Type</th>
                                        <th class="text-center" style="width: 100px;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($customers as $customer)
                                        <tr>
                                            {{-- Photo Column --}}
                                            <td class="text-center align-middle py-2">
                                                @php
                                                    $profileImage = $customer->profile ?? 'dist/img/user2-160x160.jpg';
                                                    $profileSrc = (file_exists(public_path($profileImage))) 
                                                        ? asset($profileImage) 
                                                        : asset('dist/img/user2-160x160.jpg');
                                                @endphp
                                                <img src="{{ $profileSrc }}" 
                                                     alt="User" 
                                                     class="rounded shadow-sm"
                                                     style="width: 40px; height: 40px; object-fit: cover; cursor: pointer;"
                                                     onclick="window.location.href='{{ route('studentProfile', $customer->id) }}'">
                                            </td>

                                            {{-- Name Column --}}
                                            <td class="align-middle font-weight-bold text-primary">
                                                {{ $customer->Fname }} {{ $customer->Lname }}
                                            </td>

                                            {{-- Info Columns --}}
                                            <td class="align-middle">{{ $customer->email }}</td>
                                            <td class="align-middle">{{ $customer->contact }}</td>
                                            
                                            {{-- Type Column (Badge) --}}
                                            <td class="align-middle">
                                                <span class="badge badge-primary px-2">
                                                    {{ $customer->customer_type }}
                                                </span>
                                            </td>

                                            {{-- Action Buttons --}}
                                            <td class="text-center align-middle">
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{ route('studentProfile', $customer->id) }}" 
                                                       class="btn btn-warning text-white" 
                                                       title="View Profile">
                                                        <i class="fas fa-eye"></i>
                                                    </a>

                                                    <form action="{{ route('deleteStudent', $customer->id) }}" method="POST" style="display: inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" 
                                                                class="btn btn-danger" 
                                                                style="border-top-left-radius: 0; border-bottom-left-radius: 0;"
                                                                title="Delete" 
                                                                onclick="return confirmDeleteCustomer(event, '{{ $customer->Fname }} {{ $customer->Lname }}')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-5 text-muted">
                                                <i class="fas fa-users-slash fa-3x mb-3 opacity-50"></i><br>
                                                No customers found.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Pagination --}}
                    @if($customers->hasPages())
                        <div class="card-footer clearfix">
                            <div class="float-right">
                                {{ $customers->links('pagination::simple-bootstrap-5') }}
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
    function confirmDeleteCustomer(event, customerName) {
        event.preventDefault();
        const form = event.target.closest('form');
        
        showSwiftConfirm(
            'Delete Customer?',
            `Are you sure you want to delete <b>${customerName}</b>?`,
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