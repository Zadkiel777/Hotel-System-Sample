@extends('themes.main')

@section('title', 'Add Room')

@section('content_header')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"><i class="fas fa-plus mr-1"></i> Add Room</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('rooms') }}">Rooms</a></li>
                    <li class="breadcrumb-item active">Add</li>
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
            {{-- Centered and widened card for better layout --}}
            <div class="col-lg-8 offset-lg-2">
                <div class="card card-primary shadow-sm">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-bed mr-1"></i> Room Details</h3>
                    </div>
                    
                    {{-- Form Start --}}
                    <form method="POST" action="{{ route('save_room') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            
                            {{-- ROW 1: Room Details (3 Columns) --}}
                            <div class="row">
                                {{-- Room Number --}}
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="room_number">Room Number <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-door-open"></i></span>
                                            </div>
                                            <input type="text" class="form-control" id="room_number" name="room_number" 
                                                   placeholder="e.g. 101" value="{{ old('room_number') }}" required>
                                        </div>
                                        @error('room_number')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Room Type --}}
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="room_type">Room Type <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-th-large"></i></span>
                                            </div>
                                            {{-- Style height:auto fixes the squashed input issue --}}
                                            <select class="form-control" id="room_type" name="room_type" style="height: auto;" required>
                                                <option value="" disabled selected>Select Type</option>
                                                <option value="Single" {{ old('room_type') == 'Single' ? 'selected' : '' }}>Single</option>
                                                <option value="Double" {{ old('room_type') == 'Double' ? 'selected' : '' }}>Double</option>
                                                <option value="Family" {{ old('room_type') == 'Family' ? 'selected' : '' }}>Family</option>
                                            </select>
                                        </div>
                                        @error('room_type') 
                                            <span class="text-danger small">{{ $message }}</span> 
                                        @enderror
                                    </div>
                                </div>

                                {{-- Status --}}
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="status">Status <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-info-circle"></i></span>
                                            </div>
                                            {{-- Style height:auto fixes the squashed input issue --}}
                                            <select class="form-control" id="status" name="status" style="height: auto;" required>
                                                <option value="" disabled selected>Select Status</option>
                                                <option value="Available" {{ old('status') == 'Available' ? 'selected' : '' }}>Available</option>
                                                <option value="Occupied" {{ old('status') == 'Occupied' ? 'selected' : '' }}>Occupied</option>
                                                <option value="Under Maintenance" {{ old('status') == 'Under Maintenance' ? 'selected' : '' }}>Maintenance</option>
                                                <option value="Unavailable" {{ old('status') == 'Unavailable' ? 'selected' : '' }}>Unavailable</option>
                                            </select>
                                        </div>
                                        @error('status')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <hr class="my-3">

                            {{-- ROW 2: Image Upload --}}
                            <div class="form-group mb-0">
                                <label for="picture">Room Image</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="picture" name="picture" accept="image/*">
                                        <label class="custom-file-label" for="picture">Choose file...</label>
                                    </div>
                                </div>
                                <small class="text-muted">Supported formats: JPG, PNG, JPEG.</small>
                                @error('picture')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                        
                        {{-- Footer Buttons --}}
                        <div class="card-footer d-flex justify-content-between">
                            <a href="{{ route('rooms') }}" class="btn btn-default" onclick="return confirmBack(event)">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-primary px-4" onclick="return confirmSaveRoom(event)">
                                <i class="fas fa-save mr-1"></i> Save Room
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
{{-- External Scripts --}}
<script src="{{ asset('js/swift-alerts.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>

<script>
    // Initialize custom file input to show filename selection
    $(document).ready(function () {
        bsCustomFileInput.init();
    });

    // Confirmation Logic for Saving
    function confirmSaveRoom(event) {
        event.preventDefault();
        const form = event.target.closest('form');
        
        // Grab values for validation
        const roomNumber = form.querySelector('[name="room_number"]').value;
        const roomType = form.querySelector('[name="room_type"]').value;
        const status = form.querySelector('[name="status"]').value;
        
        // Simple JS validation
        if (!roomNumber || !roomType || !status) {
            showSwiftError('Missing Information', 'Please fill in all required fields marked with *.');
            return false;
        }
        
        // SweetAlert Confirmation
        showSwiftConfirm(
            'Create Room?',
            `Are you sure you want to add Room <b>${roomNumber}</b> to the system?`,
            function() {
                form.submit();
            }
        );
    }
    
    // Logic for Back Button
    function confirmBack(event) {
        // You can add a confirmation check here if you want to prevent accidental navigation
        // For now, we allow standard link behavior or direct redirect
        // event.preventDefault();
        // window.location.href = '{{ route("rooms") }}';
    }

    // Server-side Session Alerts
    @if(session('success'))
        showSwiftSuccess('Success!', '{{ session("success") }}');
    @endif
    
    @if(session('error'))
        showSwiftError('Error', '{{ session("error") }}');
    @endif
</script>
@endsection