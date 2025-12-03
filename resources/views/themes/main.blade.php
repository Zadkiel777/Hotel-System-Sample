<!DOCTYPE html>
<html lang="en">

{{-- 1. HEAD Partial --}}
@include('layout.partials.head')

<body class="hold-transition sidebar-mini layout-fixed">
    {{-- Auth Check - This logic should ideally be in Middleware or a Controller but we keep it here for file structure completeness --}}
    @if (session('id') == null)
        {{ unauthorize() }}
    @endif

    <div class="wrapper">

        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="AdminLTELogo" height="60" width="60">
        </div>


        {{-- 3. SIDEBAR Partial --}}
        @include('layout.partials.sidebar')

        {{-- 4. CONTENT WRAPPER: This is where the extending page content goes --}}
        <div class="content-wrapper">
            {{-- @yield('content_header') is often used here for the breadcrumbs --}}
            @yield('content_header') 
            
            <section class="content">
                <div class="container-fluid">
                    {{-- THIS IS THE MAIN CONTENT SECTION --}}
                    @yield('content')
                </div>
            </section>
        </div>
        {{-- /.content-wrapper --}}

        {{-- 5. FOOTER Partial (includes the control sidebar) --}}
        @include('layout.partials.footer')

    </div>
    {{-- ./wrapper --}}

    {{-- 6. SCRIPT Partial --}}
    @include('layout.partials.script')

</body>
</html>