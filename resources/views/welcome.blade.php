<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SportField</title>
    <link rel="stylesheet" href="{{ asset('css/styleLandingPage.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
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

        <div class="nav-icon dropdown">
            <i class="fas fa-user dropdown-toggle" id="dropdownMenuButton" data-bs-toggle="dropdown"
                aria-expanded="false"></i>
            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                @if (Auth::check())
                    @switch(Auth::user()->role)
                        @case('admin')
                            <a href="/admin" class="dropdown-item custom-dropdown-item">Dashboard Admin</a>
                        @break

                        @case('vendor')
                            <a href="/vendor" class="dropdown-item custom-dropdown-item">Dashboard Vendor</a>
                        @break

                        @case('customer')
                            <a href="/home" class="dropdown-item custom-dropdown-item">Your Page</a>
                        @break

                        @default
                            <a href="/" class="dropdown-item custom-dropdown-item">Dashboard</a>
                    @endswitch
                    <a href="{{ route('logout') }}" class="dropdown-item custom-dropdown-item"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                @else
                    <a href="/login" class="dropdown-item custom-dropdown-item">Login</a>
                @endif
            </div>
        </div>


    </header>


    <!-- home section start -->

    <section class="home" id="home">
        <!-- <div class="home-container"> -->
        <div class="home-text">
            <h1>Penyewaan lapangan secara online</h1>
            <p>Rent our sports fields now and enjoy a fun sports experience!</p>
            <a href="#fields" class="btn">Cari Lapangan</a>
        </div>

        <div class="home-img">
            <img src="{{ asset('image/1.jpg') }}" alt="home">
        </div>
        </div>

    </section>

    <!-- home section end -->

    <!-- fields section starts -->

    <section class="fields" id="fields">

        <h3 class="sub-heading">Venue yang terdaftar</h3>
        <h1 class="heading">Lapangan Olahraga</h1>

        <div class="search-container">
            <div class="search-wrapper">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" placeholder="Cari nama venue" class="search-input">
            </div>
            <div class="search-wrapper">
                <i class="fa-solid fa-location-dot"></i>
                <input type="text" placeholder="Lokasi" class="search-input">
            </div>
            <div class="search-wrapper">
                <i class="fa-solid fa-futbol"></i>
                <input type="text" placeholder="Olahraga" class="search-input">
                <select class="search-select">
                    <option value="football">Football</option>
                    <option value="basketball">Basketball</option>
                    <option value="tennis">Tennis</option>
                    <option value="badminton">Badminton</option>
                </select>
            </div>
            <button class="search-button">Cari venue</button>
        </div>

        <br>
        <div class="venue-grid">
            <div class="venue-card">
                <img src="{{ asset('image/2.jpg') }}" alt="Lapangan Generasi Baru">
                <div class="venue-info">
                    <p class="venue-type">Venue</p>
                    <h3>Lapangan Generasi Baru</h3>
                    <p class="venue-rating">⭐ 4.71 • Kota Jakarta Pusat</p>
                    <p class="venue-sports">⚽ Futsal • 🏀 Basketball</p>
                    <p class="venue-price">Mulai Rp215,000 / sesi</p>
                </div>
            </div>
            <div class="venue-card">
                <img src="{{ asset('image/2.jpg') }}" alt="Hall Bulu Tangkis Pasar Jatiwaras">
                <div class="venue-info">
                    <p class="venue-type">Venue</p>
                    <h3>Hall Bulu Tangkis Pasar Jatiwaras</h3>
                    <p class="venue-rating">⭐ 4.81 • Kota Jakarta Pusat</p>
                    <p class="venue-sports">🏸 Badminton • 🏓 Tenis Meja</p>
                    <p class="venue-price">Mulai Rp30,000 / sesi</p>
                </div>
            </div>
            <div class="venue-card">
                <img src="{{ asset('image/2.jpg') }}" alt="Mansion Sports Box Sunter">
                <div class="venue-info">
                    <p class="venue-type">Venue</p>
                    <h3>Mansion Sports Box Sunter</h3>
                    <p class="venue-rating">⭐ 4.87 • Kota Jakarta Utara</p>
                    <p class="venue-sports">🏸 Badminton</p>
                    <p class="venue-price">Mulai Rp70,000 / sesi</p>
                </div>
            </div>
            <div class="venue-card">
                <img src="{{ asset('image/2.jpg') }}" alt="Mansion Sports Box Sunter">
                <div class="venue-info">
                    <p class="venue-type">Venue</p>
                    <h3>Mansion Sports Box Sunter</h3>
                    <p class="venue-rating">⭐ 4.87 • Kota Jakarta Utara</p>
                    <p class="venue-sports">🏸 Badminton</p>
                    <p class="venue-price">Mulai Rp70,000 / sesi</p>
                </div>
            </div>
            <div class="venue-card">
                <img src="{{ asset('image/2.jpg') }}" alt="Mansion Sports Box Sunter">
                <div class="venue-info">
                    <p class="venue-type">Venue</p>
                    <h3>Mansion Sports Box Sunter</h3>
                    <p class="venue-rating">⭐ 4.87 • Kota Jakarta Utara</p>
                    <p class="venue-sports">🏸 Badminton</p>
                    <p class="venue-price">Mulai Rp70,000 / sesi</p>
                </div>
            </div>
            <div class="venue-card">
                <img src="{{ asset('image/2.jpg') }}" alt="Mansion Sports Box Sunter">
                <div class="venue-info">
                    <p class="venue-type">Venue</p>
                    <h3>Mansion Sports Box Sunter</h3>
                    <p class="venue-rating">⭐ 4.87 • Kota Jakarta Utara</p>
                    <p class="venue-sports">🏸 Badminton</p>
                    <p class="venue-price">Mulai Rp70,000 / sesi</p>
                </div>
            </div>
            <div class="venue-card">
                <img src="{{ asset('image/2.jpg') }}" alt="Mansion Sports Box Sunter">
                <div class="venue-info">
                    <p class="venue-type">Venue</p>
                    <h3>Mansion Sports Box Sunter</h3>
                    <p class="venue-rating">⭐ 4.87 • Kota Jakarta Utara</p>
                    <p class="venue-sports">🏸 Badminton</p>
                    <p class="venue-price">Mulai Rp70,000 / sesi</p>
                </div>
            </div>
            <div class="venue-card">
                <img src="{{ asset('image/2.jpg') }}" alt="Mansion Sports Box Sunter">
                <div class="venue-info">
                    <p class="venue-type">Venue</p>
                    <h3>Mansion Sports Box Sunter</h3>
                    <p class="venue-rating">⭐ 4.87 • Kota Jakarta Utara</p>
                    <p class="venue-sports">🏸 Badminton</p>
                    <p class="venue-price">Mulai Rp70,000 / sesi</p>
                </div>
            </div>
            <div class="venue-card">
                <img src="{{ asset('image/2.jpg') }}" alt="Mansion Sports Box Sunter">
                <div class="venue-info">
                    <p class="venue-type">Venue</p>
                    <h3>Mansion Sports Box Sunter</h3>
                    <p class="venue-rating">⭐ 4.87 • Kota Jakarta Utara</p>
                    <p class="venue-sports">🏸 Badminton</p>
                    <p class="venue-price">Mulai Rp70,000 / sesi</p>
                </div>
            </div>
        </div>
        </div>
    </section>


    <!-- fields section end -->

    <section class="about" id="about">
        <h3 class="sub-heading">Tentang Kami</h3>
        <h1 class="heading">SportField</h1>

        <div class="row">

            <!--   -->

            <div class="content">
                <div class="content">
                    <div class="content-box">
                        <h3>Selamat datang di SportField!</h3>
                        <p>Kami adalah penyedia layanan penyewaan lapangan olahraga yang berdedikasi untuk memberikan
                            pengalaman terbaik bagi Anda. Dengan berbagai jenis lapangan yang tersedia, kami berkomitmen
                            untuk memenuhi kebutuhan olahraga Anda, baik untuk latihan rutin, pertandingan, maupun acara
                            khusus.</p>
                    </div>
                    <div class="content-box">
                        <h3>Misi Kami</h3>
                        <p>Kami percaya bahwa olahraga adalah bagian penting dari gaya hidup sehat dan kebersamaan
                            komunitas. Misi kami adalah menyediakan fasilitas lapangan berkualitas tinggi yang mudah
                            diakses
                            oleh semua orang. Kami berusaha untuk menciptakan lingkungan yang menyenangkan dan mendukung
                            untuk semua pengguna lapangan kami.</p>
                    </div>
                    <div class="content-box">
                        <h3>Visi Kami</h3>
                        <p>Visi kami adalah menjadi penyedia layanan penyewaan lapangan terbaik dan terpercaya di lokasi
                            Anda, dengan terus meningkatkan kualitas fasilitas dan pelayanan kami. Kami ingin menjadi
                            tempat
                            pilihan utama bagi para penggemar olahraga untuk beraktivitas dan bersosialisasi.</p>
                    </div>
                    <div class="content-box">
                        <h3>Mengapa Memilih Kami?</h3>
                        <ul>
                            <li><strong>Kualitas Lapangan:</strong> Kami menawarkan lapangan dengan kondisi terbaik,
                                baik
                                dari segi perawatan maupun fasilitas pendukung.</li>
                            <li><strong>Kemudahan Pemesanan:</strong> Sistem pemesanan online kami dirancang untuk
                                memudahkan Anda dalam memilih dan memesan lapangan sesuai kebutuhan.</li>
                            <li><strong>Harga Terjangkau:</strong> Kami menyediakan berbagai pilihan harga yang
                                kompetitif
                                dengan berbagai promo menarik.</li>
                            <li><strong>Layanan Pelanggan:</strong> Tim kami siap membantu Anda dengan segala pertanyaan
                                dan
                                kebutuhan Anda, memastikan pengalaman Anda bersama kami selalu memuaskan.</li>
                        </ul>
                    </div>
                    <div class="content-box">

                        <h3>Hubungi Kami</h3>
                        <p>Jika Anda memiliki pertanyaan atau membutuhkan informasi lebih lanjut, jangan ragu untuk
                            menghubungi kami. Kami dengan senang hati akan membantu Anda.</p>
                        <p>Email: info@namaperusahaan.com</p>
                        <p>Telepon: (123) 456-7890</p>
                        <p>Alamat: Jl. Contoh No. 123, Kota Contoh, Indonesia</p>
                        <p>Terima kasih telah memilih SportField sebagai tempat Anda berolahraga. Kami berharap dapat
                            memberikan pengalaman terbaik dan menjadi bagian dari perjalanan olahraga Anda.</p>
                    </div>
                </div>

            </div>

    </section>
    <section class="faq" id="faq">

        <h2 class="heading">FAQ</h2>

        <div class="faq-item">
            <h3 class="faq-question">Bagaimana cara memesan lapangan?</h3>
            <div class="faq-answer">
                <p>Untuk memesan lapangan, Anda dapat mengikuti langkah-langkah berikut:</p>
                <ol>
                    <li>Kunjungi halaman "Pencarian dan Pemesanan" di website kami.
                    </li>
                    <li>Pilih jenis lapangan, tanggal, dan waktu yang Anda inginkan.
                    </li>
                    <li>Klik "Cari" untuk melihat ketersediaan lapangan.</li>
                    <li>Pilih lapangan yang tersedia dan lanjutkan dengan mengisi informasi pemesanan.</li>
                    <li>Lakukan pembayaran melalui sistem pembayaran online yang tersedia.</li>
                    <li>Anda akan menerima konfirmasi pemesanan melalui email.</li>
                </ol>
            </div>
        </div>

        <div class="faq-item">
            <h3 class="faq-question">Apa saja jenis lapangan yang tersedia?</h3>
            <div class="faq-answer">
                <p>Kami menyediakan berbagai jenis lapangan untuk memenuhi kebutuhan Anda, termasuk:</p>
                <ol>
                    <li>Lapangan sepak bola.</li>
                    <li>Lapangan futsal</li>
                    <li>Lapangan bulu tangkis</li>
                    <li>Lapangan tenis.</li>
                    <li>Lapangan basket</li>
                    <li>mini soccer</li>
                </ol>
            </div>
        </div>
        <div class="faq-item">
            <h3 class="faq-question">Bagaimana cara membayar pemesanan?</h3>
            <div class="faq-answer">
                <p>Kami menerima pembayaran melalui beberapa metode berikut:</p>
                <ol>
                    <li>Virtual Account</li>
                </ol>
            </div>
        </div>
        <div class="faq-item">
            <h3 class="faq-question">Bagaimana saya tahu pemesanan saya sudah dikonfirmasi?</h3>
            <div class="faq-answer">
                <p>Setelah Anda menyelesaikan proses pembayaran, Anda akan menerima email konfirmasi yang berisi detail
                    pemesanan Anda. Pastikan untuk memeriksa kotak masuk email Anda dan folder spam/junk.</p>
            </div>
        </div>
        <div class="faq-item">
            <h3 class="faq-question">Apakah saya perlu membuat akun untuk memesan lapangan?</h3>
            <div class="faq-answer">
                <p>Ya, Anda perlu membuat akun untuk memesan lapangan. Akun pengguna memudahkan Anda untuk mengelola
                    pemesanan, melihat riwayat pemesanan, dan menikmati promosi eksklusif.</p>
            </div>
        </div>
    </section>

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
</body>

</html>
>>>>>>> 2b74281d19b81fef71d8d75f9578824222c5cf11
