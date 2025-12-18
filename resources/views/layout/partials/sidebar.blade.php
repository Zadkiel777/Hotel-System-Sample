<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ route('dashboard') }}" class="brand-link" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 1rem;">
        <img src="{{ asset('images/bluebirdlogo.png') }}" alt="AdminLTE Logo"
             class="brand-image img-circle elevation-3" style="opacity: 1; box-shadow: 0 4px 12px rgba(0,0,0,0.2);">
        <span class="brand-text font-weight-bold" style="color: white; font-size: 1.1rem;">Bluebird Hotel</span>
    </a>

    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex" style="padding: 1rem; background: rgba(255,255,255,0.05); border-radius: 10px; margin: 1rem;">
            <div class="image">
                @php
                    $profileImage = session('profile') ?? 'dist/img/user2-160x160.jpg';
                    // Check if the profile path exists, if not use default
                    if ($profileImage && file_exists(public_path($profileImage))) {
                        $profileSrc = asset($profileImage);
                    } else {
                        $profileSrc = asset('dist/img/user2-160x160.jpg');
                    }
                @endphp
                <img src="{{ $profileSrc }}" class="img-circle elevation-2" alt="User Image" style="width: 45px; height: 45px; object-fit: cover; border: 2px solid rgba(255,255,255,0.3);">
            </div>
            <div class="info" style="margin-left: 10px;">
                <a href="{{ route('profile') }}" class="d-block" style="color: white; font-weight: 600; font-size: 0.95rem;">{{ session('name') }}</a>
                <small style="color: rgba(255,255,255,0.7); font-size: 0.8rem;">Administrator</small>
            </div>
        </div>


        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                
                {{-- Dashboard --}}
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" 
                        class="nav-link {{ Route::is('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-desktop"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                {{-- Students --}}
                <li class="nav-item">
                    <a href="{{ route('bookedRooms') }}"
                       class="nav-link {{ Route::is('bookedRooms') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-calendar-plus"></i>
                        <p>Booked Rooms</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('users') }}"
                       class="nav-link {{ Route::is('users') || Route::is('studentProfile') || Route::is('students.create') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Customers</p>
                    </a>
                </li>

                {{-- Profile --}}
                <li class="nav-item">
                    <a href="{{ route('payments') }}" 
                       class="nav-link {{ Route::is('payments') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-file-invoice-dollar"></i>
                        <p>Payment History</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('rooms') }}"
                       class="nav-link {{ Route::is('rooms') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-bed"></i>
                        <p>Rooms</p>
                    </a>
                </li>

                {{-- Logout --}}
                <li class="nav-item">
                    <a href="{{ route('logout') }}" class="nav-link"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Logout</p>
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>

            </ul>
        </nav>
    </div>
</aside>
