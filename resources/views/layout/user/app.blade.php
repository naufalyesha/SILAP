<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SportField</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/styleLandingPage.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sty_detail_lapangan.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .nav-icon {
            position: relative;
            display: inline-block;
        }

        .dropdown-menu {
            display: none;
            position: absolute;
            top: 100%;
            right: 0;
            background-color: white;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .nav-icon:hover .dropdown-menu {
            display: block;
        }

        .dropdown-menu a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-menu a:hover {
            background-color: #f1f1f1;
        }

        .custom-dropdown-item {
            padding: 10px 20px;
            transition: background-color 0.3s ease;
            font-size: 2em;
        }

        .custom-dropdown-item:hover {
            background-color: #f8f9fa;
            /* warna latar belakang saat dihover */
            color: #343a40;
            /* warna teks saat dihover */
        }

        .dropdown-toggle {
            cursor: pointer;
        }

        .nav-icon .dropdown-toggle::after {
            display: none;
            /* Hapus panah dropdown default */
        }
    </style>
</head>

<body>

    <header>
        <div class="logo">
            <a href="#">SportField</a>
        </div>

        <div class="navlist">
            <li><a href="#home">Beranda</a></li>
            <li><a href="#fields">Daftar Lapangan</a></li>
            <li><a href="#about">Tentang Kami</a></li>
            <li><a href="#faq">Faq</a></li>
        </div>

        <div class="nav-icons">
            <!-- Icon Cart -->
            <a href="/transactions" class="nav-link cart-icon">
                <i class="bi bi-cart-fill"></i>
            </a>

            <!-- Icon User -->
            <div class="dropdown show">
                <a class="nav-link user-icon dropdown-toggle" role="button" id="dropdownMenuLink"
                    data-toggle="dropdown" aria-expanded="false" aria-haspopup="true">
                    <i class="fas fa-user"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink">
                    @if (Auth::check())
                        @switch(Auth::user()->role)
                            @case('admin')
                                <li><a href="/admin" class="dropdown-item custom-dropdown-item">Dashboard Admin</a></li>
                            @break

                            @case('vendor')
                                <li><a href="/vendor" class="dropdown-item custom-dropdown-item">Dashboard Vendor</a></li>
                            @break

                            @case('customer')
                                <li><a href="/logout" class="dropdown-item">Logout</a></li>
                            @break

                            @default
                                <li><a href="/" class="dropdown-item custom-dropdown-item">Dashboard</a></li>
                        @endswitch
                    @else
                        <li><a href="/login" class="dropdown-item custom-dropdown-item">Login</a></li>
                    @endif
                </ul>
            </div>
        </div>
    </header>

    @yield('content')

    <section class="footer">

        <div class="box-container">

            <div class="box">
                <h3>locations</h3>
                <a href="#">india</a>
                <a href="#">japan</a>
                <a href="#">russia</a>
                <a href="#">USA</a>
                <a href="#">france</a>
            </div>

            <div class="box">
                <h3>quick links</h3>
                <a href="#">home</a>
                <a href="#">dishes</a>
                <a href="#">about</a>
                <a href="#">menu</a>
                <a href="#">review</a>
                <a href="#">order</a>
            </div>

            <div class="box">
                <h3>contact info</h3>
                <a href="#">+123-456-789</a>
                <a href="#">+123-456-789</a>
                <a href="#">agustinusricad@gmail.com</a>
                <a href="#">Semarang, Indonesia - 50275</a>
            </div>

            <div class="box">
                <h3>follow us</h3>
                <a href="#">facebook</a>
                <a href="#">twitter</a>
                <a href="#">instagram</a>
                <a href="#">linkedin</a>
            </div>
        </div>

        <div class="credit"> Made By | @ 2024 by <span>Naufal & Ricad</span>
        </div>
    </section>
    <script src="{{ asset('js/scriptLandingPage.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
</body>

</html>
