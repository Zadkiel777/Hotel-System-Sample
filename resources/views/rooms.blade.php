@extends('themes.main')

{{-- Define the page title --}}
@section('title', 'Rooms')

@section('content_header')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"><i class="fas fa-bed mr-1"></i> Rooms Management</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Rooms</li>
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
                    {{-- Header with Title, Search, and Add Button --}}
                    <div class="card-header">
                        <h3 class="card-title mt-1">
                            <i class="fas fa-list mr-1"></i> Room List
                        </h3>

                        <div class="card-tools d-flex">
                            {{-- Search Form moved here for better context --}}
                            <form action="{{ route('rooms') }}" method="GET" class="mr-2">
                                <div class="input-group input-group-sm" style="width: 200px;">
                                    <input type="text" name="search" class="form-control float-right" placeholder="Search rooms..." value="{{ request('search') }}">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>

                            <a href="{{ route('addroom') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus mr-1"></i> Add Room
                            </a>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            {{-- Added 'table-sm' for compact rows and 'text-nowrap' to prevent ugly line breaks --}}
                            <table id="userTable" class="table table-striped table-hover table-sm text-nowrap">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="text-center" style="width: 80px;">Image</th>
                                        <th>Room No.</th>
                                        <th>Type</th>
                                        <th>Status</th>
                                        <th class="text-center" style="width: 120px;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($room as $rooms)
                                        <tr>
                                            {{-- Image Column: Reduced size and removed bulky thumbnail border --}}
                                            <td class="text-center align-middle py-2">
                                                @if(!empty($rooms->picture))
                                                    <img src="{{ asset($rooms->picture) }}" 
                                                         alt="Room" 
                                                         class="rounded shadow-sm"
                                                         style="width: 40px; height: 40px; object-fit: cover;">
                                                @else
                                                    <img src="{{ asset('images/default_room.png') }}" 
                                                        alt="Default" 
                                                        class="rounded shadow-sm"
                                                        style="width: 40px; height: 40px; object-fit: cover;">
                                                @endif
                                            </td>
                                            
                                            {{-- Data Columns: Added align-middle to center text vertically --}}
                                            <td class="align-middle font-weight-bold text-primary">
                                                {{ $rooms->room_number }}
                                            </td>
                                            
                                            <td class="align-middle">
                                                @php 
                                                $typecolor = match(strtolower($rooms->room_type)) {
                                                    'standard' => 'danger',
                                                    'deluxe' => 'primary',
                                                    'luxury' => 'warning',
                                                    default => 'info',
                                                };
                                                @endphp
                                                <span class="badge badge-{{ $typecolor }} px-2 py-1">
                                                    {{ $rooms->room_type }}
                                            </td>
                                            
                                            {{-- Status Column --}}
                                            <td class="align-middle">
                                                @php
                                                    $statusClass = match(strtolower($rooms->status)) {
                                                        'available' => 'success',
                                                        'occupied' => 'danger',
                                                        'under maintenance' => 'warning',
                                                        'unavailable' => 'secondary',
                                                        default => 'info',
                                                    };
                                                @endphp
                                                <span class="badge badge-{{ $statusClass }} px-2 py-1">
                                                    {{ $rooms->status }}
                                                </span>
                                            </td>

                                            {{-- Action Buttons --}}
                                            <td class="text-center align-middle">
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{ route('editRoom', $rooms->id) }}" class="btn btn-info" title="Edit">
                                                        <i class="fas fa-pen"></i>
                                                    </a>
                                                    
                                                    {{-- Delete Button wrapped in form --}}
                                                    <form action="{{ route('deleteRoom', $rooms->id) }}" method="POST" style="display: inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger" title="Delete" 
                                                                style="border-top-left-radius: 0; border-bottom-left-radius: 0;"
                                                                onclick="return confirmDeleteRoom(event, '{{ $rooms->room_number }}')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-5 text-muted">
                                                <i class="fas fa-inbox fa-3x mb-3 opacity-50"></i><br>
                                                No rooms found.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div> {{-- End .card-body --}}

                    {{-- Pagination Footer --}}
                    @if($room->hasPages())
                        <div class="card-footer clearfix">
                            <div class="float-right">
                                {{ $room->links('pagination::simple-bootstrap-5') }}
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
    function confirmDeleteRoom(event, roomNumber) {
        event.preventDefault();
        const form = event.target.closest('form');
        
        showSwiftConfirm(
            'Delete Room?',
            `Are you sure you want to delete room <b>${roomNumber}</b>?`,
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