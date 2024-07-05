<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bootstrap Vendor Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/ae360af17e.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{ asset('/css/jadwalharga.css') }}">
    <link rel="stylesheet" href="{{ asset('css/styleVendor.css') }}">
</head>

<body>
    <div class="wrapper">
        <aside id="sidebar" class="js-sidebar">
            <!-- Content For Sidebar -->
            <div class="h-100">
                <div class="sidebar-logo">
                    <a href="{{ route('vendor') }}">Silap</a>
                </div>
                <ul class="sidebar-nav">
                    <li class="sidebar-header">
                        Vendor Elements
                    </li>
                    <li class="sidebar-item">
                        <a href="{{ route('vendor') }}" class="sidebar-link collapsed">
                            <i class="fa-solid fa-list pe-2"></i>
                            Dashboard
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="{{ route('vendor.lapangans') }}" class="sidebar-link collapsed"
                            data-bs-target="#pages"><i class="fa-regular fa-square-caret-up"></i>
                            Post Lapangan
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="{{ route('schedules.index') }}" class="sidebar-link collapsed" data-bs-target="#posts"><i
                                class="fa-regular fa-calendar"></i>
                            Jadwal & Harga
                        </a>
                        <ul id="posts" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                        </ul>
                    </li>
                    <li class="sidebar-item">
                        <a href="{{ route('finance_reports.index') }}" class="sidebar-link collapsed" data-bs-target="#auth"><i
                                class="fa-regular fa-flag"></i>
                            Laporan
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="{{ route('payment_methods.index') }}" class="sidebar-link" data-bs-target="#auth"><i
                                class="fa-regular fa-credit-card"></i>
                            Metode Pembayaran
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="{{ route('vendor_interactions.index') }}" class="sidebar-link" data-bs-target="#auth"><i
                                class="fa-regular fa-comments"></i>
                            Interaksi User
                        </a>
                    </li>
                </ul>
            </div>
        </aside>

        <div class="main">
            <nav class="navbar navbar-expand px-3 border-bottom">
                <button class="btn" id="sidebar-toggle" type="button">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="navbar-collapse navbar">
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a href="#" data-bs-toggle="dropdown" class="nav-icon pe-md-0">
                                <img src="{{ asset('image/profile.jpeg') }}" class="avatar img-fluid rounded"
                                    alt="">
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a href="#" class="dropdown-item">Profile</a>
                                <a href="#" class="dropdown-item">Setting</a>
                                <a href="/logout" class="dropdown-item">Logout</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
            
            @yield('content')

            
            <a href="#" class="theme-toggle">
                <i class="fa-regular fa-moon"></i>
                <i class="fa-regular fa-sun"></i>
            </a>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('js/script.js') }}"></script>
</body>

</html>
