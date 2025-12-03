@extends('themes.main')

{{-- Define the page title that goes into the <title> tag in head.blade.php --}}
@section('title', 'Dashboard')

{{-- This section replaces the content-header section in the master layout --}}
@section('content_header')

    <nav class="navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                    <i class="fas fa-bars"></i>
                </a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="#" class="nav-link">Contact</a>
            </li>
        </ul>

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
                    <h1 class="m-0">
                        <i class="fas fa-desktop mr-1"></i> Dashboard
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}">
                                <i class="fas fa-home"></i> Home
                            </a>
                        </li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection


{{-- This is the ONE main content block --}}
@section('content')
<section class="content">
    <div class="container-fluid">
        
        {{-- Your small boxes row --}}
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{$allrooms}}/{{$totalAvailableRooms}}</h3>
                        <p><i class="fas fa-bed mr-1"></i> Booked Rooms</p>
                        <small style="color: rgba(255,255,255,0.8);">
                            <i class="fas fa-info-circle mr-1"></i> {{$totalAvailableRooms - $allrooms}} rooms available
                        </small>
                    </div>
                    <div class="icon">
                        <i class="fas fa-calendar-plus"></i>
                    </div>
                    <a href="{{ route('bookedRooms') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            
             <div class="col-lg-3 col-6">
                <div class="small-box bg-primary">
                    <div class="inner">
                        <h3>{{$totalcustomers}}</h3>
                        <p><i class="nav-icon fas fa-users"></i> Customers</p>
                    </div>
                    <div class="icon">
                        <i class="nav-icon fas fa-users"></i>
                    </div>
                    <a href="{{ route('users') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>


            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{$totalstaffs}}</h3>
                        <p><i class="nav-icon fas fa-user-tie"></i> Total Staff</p>
                    </div>
                    <div class="icon">
                        <i class="nav-icon fas fa-user-tie"></i>
                    </div>
                    <a href="{{ route('staffs') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>


            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>₱ {{$totalprofit}}</h3>
                        <p><i class="fas fa-chart-line"></i> Total Profit</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-chart-pie"></i>
                    </div>
                    {{-- Missing footer here, but adding for consistency --}}
                   <a href="{{ route('payments') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>{{-- End .row --}}
        <br>

        {{-- Chart Row --}}
        <div class="row">
            {{-- I've wrapped your chart in a column to control its width --}}
            <div class="col-md-6">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Rooms</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        {{-- 
                            This is the fix for the size.
                            We put the canvas in a wrapper div that has a defined height.
                        --}}
                        <div style="height: 250px; position: relative;">
                            <canvas id="donutChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            {{-- You could add another chart in a <div class="col-md-6"> here --}}

            <div class="card card-success">
              <div class="card-header">
                <h3 class="card-title">Profit</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <div class="chart">
                  <canvas id="lineChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card --> 
        </div>{{-- End .row --}}

    </div>{{-- End .container-fluid --}}
</section>{{-- End .content --}}
@endsection

{{-- Inject the dashboard-specific scripts --}}
@section('scripts')
    {{-- Make sure Chart.js library is loaded. It's OK to have it here. --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    {{-- Swift Alerts Demo - Show welcome message on page load --}}
    <script>
        // Show welcome alert when dashboard loads (only once per session)
        window.addEventListener('load', function() {
            if (!sessionStorage.getItem('dashboardWelcomeShown')) {
                setTimeout(function() {
                    showSwiftSuccess('Welcome!', 'Welcome to the Dashboard. All systems are operational.');
                    sessionStorage.setItem('dashboardWelcomeShown', 'true');
                }, 500);
            }
        });
        
        // Only prevent navigation for placeholder links (href="#")
        // Allow actual route links to navigate normally
        document.querySelectorAll('.small-box-footer[href="#"]').forEach(function(link) {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const boxText = this.closest('.small-box').querySelector('p').textContent.trim();
                showSwiftAlert('Information', `You clicked on: ${boxText}`, 'info');
            });
        });
    </script>
    
    {{-- Your other theme scripts --}}
    <script src="{{ asset('dist/js/demo.js') }}"></script>
    <script src="{{ asset('dist/js/pages/dashboard.js') }}"></script>

    {{-- ✅ YOUR CHART SCRIPT MOVED HERE --}}
    <script>
        const ctx = document.getElementById('donutChart').getContext('2d');
    
        const donutChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: @json($roomlabels), // from controller
                datasets: [{
                    data: @json($roomdata), // from controller
                    backgroundColor: ['#ff0000ff', '#a112f3ff', '#0431fbff'], // Add more colors if you have more data
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false // <-- This is the key!
            }
        });
    </script>

    {{-- ✅ 2. THIS IS THE NEW SCRIPT FOR YOUR LINE CHART --}}
    <script>
        // Get the canvas element
        const lineCtx = document.getElementById('lineChart').getContext('2d');

        // Create the chart
        const lineChart = new Chart(lineCtx, {
            type: 'line',
            data: {
                // Data from your controller
                labels: @json($profitlabels), 
                datasets: [{
                    label: 'Profit', // Label for the legend
                    data: @json($profitdata),  // Data from your controller
                    backgroundColor: 'rgba(0, 123, 255, 0.1)', // Light blue fill under line
                    borderColor: 'rgba(0, 123, 255, 1)',     // Solid blue line
                    borderWidth: 2,
                    tension: 0.3 // Makes the line slightly curved
                }]
            },
            options: {
                responsive: true,
                // This is the key to respecting your canvas container's height
                maintainAspectRatio: false, 
                scales: {
                    y: {
                        beginAtZero: true, // Start the Y-axis at 0
                        ticks: {
                            // Ensure Y-axis ticks are whole numbers (e.g., 1, 2, 3)
                            precision: 0 
                        }
                    }
                }
            }
        });
    </script>
@endsection