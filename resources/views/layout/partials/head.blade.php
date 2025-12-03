<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bluebird Hotel | @yield('title', 'Dashboard')</title>

    <link rel="icon" type="image/png" href="{{ asset('images/bluebirdlogo.png') }}">

    <link rel="stylesheet" href="{{ asset('https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback') }}">
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/jqvmap/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2/sweetalert2.min.css') }}">
    
    {{-- Custom Admin Styles --}}
    <style>
        /* Modern Admin Interface Enhancements */
        :root {
            --primary-color: #667eea;
            --secondary-color: #764ba2;
            --success-color: #10b981;
            --danger-color: #ef4444;
            --warning-color: #f59e0b;
            --info-color: #3b82f6;
            --dark-color: #1f2937;
            --light-color: #f9fafb;
        }

        /* Enhanced Cards */
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            margin-bottom: 1.5rem;
        }

        .card:hover {
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.12);
            transform: translateY(-2px);
        }

        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 12px 12px 0 0 !important;
            padding: 1rem 1.5rem;
            border-bottom: none;
        }

        .card-header .card-title {
            margin: 0;
            font-weight: 600;
            font-size: 1.1rem;
        }

        .card-header .card-title i {
            margin-right: 8px;
        }

        /* Enhanced Small Boxes */
        .small-box {
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .small-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .small-box .inner h3 {
            font-weight: 700;
            font-size: 2.2rem;
        }

        .small-box .icon {
            opacity: 0.3;
            font-size: 70px;
        }

        /* Enhanced Tables */
        .table {
            border-radius: 8px;
            overflow: hidden;
        }

        .table thead {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .table thead th {
            border: none;
            padding: 1rem;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }

        .table thead th i {
            margin-right: 6px;
        }

        .table tbody tr {
            transition: all 0.2s ease;
        }

        .table tbody tr:hover {
            background-color: #f8f9ff;
            transform: scale(1.01);
        }

        .table tbody td {
            padding: 1rem;
            vertical-align: middle;
        }

        /* Enhanced Buttons */
        .btn {
            border-radius: 8px;
            font-weight: 500;
            padding: 0.5rem 1rem;
            transition: all 0.3s ease;
            border: none;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .btn-sm {
            padding: 0.375rem 0.75rem;
            font-size: 0.875rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .btn-success {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        }

        .btn-danger {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        }

        .btn-warning {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        }

        .btn-info {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        }

        /* Enhanced Form Controls */
        .form-control {
            border-radius: 8px;
            border: 2px solid #e5e7eb;
            padding: 0.625rem 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        /* Enhanced Content Header */
        .content-header {
            background: white;
            padding: 1.5rem 0;
            margin-bottom: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .content-header h1 {
            font-weight: 700;
            color: #1f2937;
            font-size: 1.75rem;
        }

        /* Enhanced Breadcrumbs */
        .breadcrumb {
            background: transparent;
            padding: 0;
            margin: 0;
        }

        .breadcrumb-item a {
            color: #667eea;
            text-decoration: none;
        }

        .breadcrumb-item.active {
            color: #6b7280;
        }

        /* Enhanced Navbar */
        .navbar-white {
            background: white !important;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            border-radius: 12px;
            margin-bottom: 1rem;
        }

        /* Enhanced Profile Images */
        .img-circle {
            transition: all 0.3s ease;
        }

        .img-circle:hover {
            transform: scale(1.1);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }

        /* Enhanced Pagination */
        .pagination {
            border-radius: 8px;
        }

        .page-link {
            border-radius: 6px;
            margin: 0 2px;
            border: 2px solid #e5e7eb;
            color: #667eea;
        }

        .page-link:hover {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-color: #667eea;
        }

        .page-item.active .page-link {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-color: #667eea;
        }

        /* Enhanced Alerts */
        .alert {
            border-radius: 10px;
            border: none;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        /* Enhanced Sidebar User Panel */
        .user-panel .image img {
            transition: all 0.3s ease;
        }

        .user-panel .image img:hover {
            transform: scale(1.1);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }

        /* Smooth Animations */
        * {
            transition: background-color 0.2s ease, color 0.2s ease;
        }

        /* Enhanced Empty States */
        .table tbody tr td.text-center {
            padding: 3rem 1rem;
            color: #9ca3af;
        }

        /* Modern Scrollbar */
        ::-webkit-scrollbar {
            width: 10px;
            height: 10px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
        }

        /* Enhanced Search Input */
        .form-control-navbar {
            border-radius: 20px;
            border: 2px solid #e5e7eb;
        }

        .form-control-navbar:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        /* Enhanced Card Body */
        .card-body {
            padding: 1.5rem;
        }

        /* Responsive Improvements */
        @media (max-width: 768px) {
            .card {
                margin-bottom: 1rem;
            }
            
            .small-box {
                margin-bottom: 1rem;
            }
        }
    </style>
    
    {{-- Hook for any page-specific styles --}}
    @yield('styles')
</head>