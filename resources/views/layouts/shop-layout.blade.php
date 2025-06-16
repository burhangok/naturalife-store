<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'LifeNatura') }} - LifeNatura Temsilcilik Yönetim Paneli</title>

    <!-- Tabler Core -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@latest/dist/css/tabler.min.css">
    <!-- Tabler Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/v/bs5/dt-2.3.1/sb-1.8.2/datatables.min.css">
    <link href="https://cdn.datatables.net/v/bs5/dt-2.3.1/b-3.2.3/b-html5-3.2.3/b-print-3.2.3/sb-1.8.2/datatables.min.css" rel="stylesheet" integrity="sha384-Ho/rr2OZWb83fsinwvYD3kH08lJ5DP2avapJEoNIRNTLLhK1GRKHzD08bIk+uelt" crossorigin="anonymous">

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/v/bs5/dt-2.3.1/sb-1.8.2/datatables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>

        <!-- Font Awesome (integrity attribute kaldırıldı) -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Custom Styles -->
    @stack('styles')
</head>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Check for success message
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'İşlem Başarılı!',
                text: "{{ session('success') }}",
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Kapat'
            });
        @endif

        // Check for errors
        @if ($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Hata!',
                html: `
                    <ul style="text-align: left; list-style-type: none; padding-left: 0;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                `,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Kapat'
            });
        @endif
    });
</script>
<body>
    @php
    $customer = auth()->guard('customer')->user();
    $existingAffiliate = \App\Models\Affiliate::where('customer_id', $customer->id)->first();
@endphp
    <div class="page">
        <!-- Horizontal Top Navigation -->
        <header class="navbar navbar-expand-md d-print-none">
            <div class="container-xl">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu" aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
                    <a href="{{ route('admin.affiliatemodule.admin.dashboard') }}">
                        <img src="https://lifenatura.eu/themes/shop/default/build/assets/Logo-1-Life-Natura.png" width="110" height="32" alt="LifeNatura" class="navbar-brand-image">

                    </a>
                </h1>

                <div class="navbar-nav flex-row order-md-last">
                    <!-- Theme switch button -->
                    <div class="nav-item d-none d-md-flex me-3">
                        <div class="btn-list">
                            <a href="#" class="btn btn-outline-primary" id="theme-toggle">
                                <i class="ti ti-moon d-none" id="dark-icon"></i>
                                <i class="ti ti-sun" id="light-icon"></i>
                            </a>
                        </div>
                    </div>

                    <!-- User dropdown -->
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
                            <span class="avatar avatar-sm" style="background-image: url(https://eu.ui-avatars.com/api/?name=Admin&background=random)"></span>
                            <div class="d-none d-xl-block ps-2">
                                <div> {{ $customer->getNameAttribute() }}</div>
                                <div class="mt-1 small text-muted">{{$customer->email}}</div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="collapse navbar-collapse" id="navbar-menu">

                </div>
            </div>
        </header>

        <!-- Horizontal Menu -->
        <header class="navbar-expand-md">
            <div class="collapse navbar-collapse" id="navbar-menu">
                <div class="navbar">
                    <div class="container-xl">
                        <ul class="navbar-nav">


                            <li class="nav-item">
                                <a class="nav-link  {{ request()->is('customer/affiliatemodule/profile*') ? 'active' : '' }}" href="{{ route('shop.customers.affiliatemodule.profile',$existingAffiliate) }}">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <i class="ti ti-user-circle"></i>
                                    </span>
                                    <span class="nav-link-title">Profilim</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link  {{ request()->is('admin/affiliatemodule/admin/myaffiliates*') ? 'active' : '' }}" href="{{ route('shop.customers.affiliatemodule.myaffiliates') }}">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <i class="ti ti-user-circle"></i>
                                    </span>
                                    <span class="nav-link-title">Temsilcilerim</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link  {{ request()->is('admin/affiliatemodule/admin/payments*') ? 'active' : '' }}" href="{{ route('shop.customers.affiliatemodule.payments') }}">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <i class="ti ti-file-invoice"></i>
                                    </span>
                                    <span class="nav-link-title">Ödemelerim</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link  {{ request()->is('scustomers/affiliatemodule/commissions*') ? 'active' : '' }}" href="{{ route('shop.customers.affiliatemodule.commissions',$existingAffiliate) }}">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <i class="ti ti-cash"></i>
                                    </span>
                                    <span class="nav-link-title">Komisyonlarım</span>
                                </a>
                            </li>


                            <li class="nav-item">
                                <a class="nav-link" href="{{route('shop.customers.account.profile.index')}}">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <i class="ti ti-user    "></i>
                                    </span>
                                    <span class="nav-link-title">Müşteri Profilim</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('shop.home.index')}}">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <i class="ti ti-shopping-cart"></i>
                                    </span>
                                    <span class="nav-link-title">Alışverişe Devam Et</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </header>

        <div class="page-wrapper">
            <!-- Page header -->
            <div class="page-header d-print-none">
                <div class="container-xl">
                    <div class="row g-2 align-items-center">
                        <div class="col">
                            <h2 class="page-title">
                                @yield('title', 'Anasayfa')
                            </h2>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Page body -->
            <div class="page-body">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>

            <!-- Footer -->
            <footer class="footer footer-transparent d-print-none">
                <div class="container-fluid">
                    <div class="row text-center align-items-center flex-row-reverse">
                        <div class="col-lg-auto ms-lg-auto">
                            <ul class="list-inline list-inline-dots mb-0">
                                <li class="list-inline-item">
                                    <a href="#" class="link-secondary">Yardım</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-12 col-lg-auto mt-3 mt-lg-0">
                            <ul class="list-inline list-inline-dots mb-0">
                                <li class="list-inline-item">
                                    Copyright &copy; {{ date('Y') }}
                                    <a href="." class="link-secondary">{{ config('app.name', 'LifeNatura') }}</a>.
                                    Tüm hakları saklıdır.
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- Tabler Core -->
    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@latest/dist/js/tabler.min.js"></script>

    <!-- Dark Mode Script -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Theme toggle functionality
            const themeToggle = document.getElementById('theme-toggle');
            const darkIcon = document.getElementById('dark-icon');
            const lightIcon = document.getElementById('light-icon');
            const htmlElement = document.documentElement;

            // Check for saved theme preference or use default
            const savedTheme = localStorage.getItem('theme') || 'light';
            setTheme(savedTheme);

            // Toggle theme on button click
            themeToggle.addEventListener('click', function(e) {
                e.preventDefault();
                const currentTheme = htmlElement.getAttribute('data-bs-theme');
                const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
                setTheme(newTheme);
                localStorage.setItem('theme', newTheme);
            });

            // Function to set theme and update icons
            function setTheme(theme) {
                htmlElement.setAttribute('data-bs-theme', theme);

                if (theme === 'dark') {
                    darkIcon.classList.remove('d-none');
                    lightIcon.classList.add('d-none');
                } else {
                    darkIcon.classList.add('d-none');
                    lightIcon.classList.remove('d-none');
                }
            }
        });
    </script>
<script>
    $(document).ready(function() {
         $('table.dataListTable').DataTable({

             // Opsiyonel ayarlar
             "bLengthChange": false,
             pageLength: 50,

             language: {
                 search: "Ara:",
                 lengthMenu: "_MENU_ kayıt göster",
                 info: "_START_ - _END_ arası _TOTAL_ kayıttan gösteriliyor",
                 paginate: {
                     first: "İlk",
                     last: "Son",
                     next: "Sonraki",
                     previous: "Önceki"
                 }
             },


         });

     });
         </script>
    <!-- Custom Scripts -->
    @stack('scripts')
</body>
</html>
