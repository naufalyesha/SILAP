<!DOCTYPE html>
<html lang="en">

<head>
    <link href="{{ asset('css/welcome.css') }}" rel="stylesheet">
</head>

<body>

    <header>
        <div class="logo">
            <a href="#">SportField</a>
        </div>

        <div class="navlist">
            <li><a href="#home">Beranda</a></li>
            <li><a href="#sewalapangan">Sewa Lapangan</a></li>
            <li><a href="#fields">Daftar Lapangan</a></li>
            <li><a href="#about">Tentang Kami</a></li>
            <li><a href="#Panduan">Panduan</a></li>
        </div>

        <div class="nav-icon">
            <i class="fas fa-user"></i>
            <div class="fas fa-bars"></div>
        </div>
    </header>


    <!-- home section start -->

    <section class="home" id="home">
        <!-- <div class="home-container"> -->
        <div class="home-text">
            <h1>Find the ideal sports <br>venue for your activities.</h1>
            <p>Rent our sports fields now and enjoy a fun sports experience!</p>
            <a href="#" class="btn">Get started</a>
        </div>

        <div class="home-img">
            <img src="{{ asset('images/Sport family-amico (1).png') }}" alt="home">
        </div>
        </div>

    </section>


    <!-- home section end -->

    <!-- fields section starts -->

    <section class="fields" id="fields">

        <h3 class="sub-heading">list of registed</h3>
        <h1 class="heading">sports fields</h1>

        <div class="box-container">
            <div class="box">
                <img src="https://i.pinimg.com/564x/24/4b/7f/244b7f20a24dd87a7d4152fc406e3604.jpg" alt="">
                <h3>Futsal</h3>
                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Assumenda, consectetur?</p>
            </div>
            <div class="box">
                <img src="https://i.pinimg.com/564x/24/4b/7f/244b7f20a24dd87a7d4152fc406e3604.jpg" alt="">
                <h3>Minisoccer</h3>
                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Assumenda, consectetur?</p>
            </div>
            <div class="box">
                <img src="https://i.pinimg.com/564x/24/4b/7f/244b7f20a24dd87a7d4152fc406e3604.jpg" alt="">
                <h3>Badminton</h3>
                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Assumenda, consectetur?</p>
            </div>
            <div class="box">
                <img src="https://i.pinimg.com/564x/24/4b/7f/244b7f20a24dd87a7d4152fc406e3604.jpg" alt="">
                <h3>Basketball</h3>
                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Assumenda, consectetur?</p>
            </div>
            <div class="box">
                <img src="https://i.pinimg.com/564x/24/4b/7f/244b7f20a24dd87a7d4152fc406e3604.jpg" alt="">
                <h3>Football</h3>
                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Assumenda, consectetur?</p>
            </div>
            <div class="box">
                <img src="https://i.pinimg.com/564x/24/4b/7f/244b7f20a24dd87a7d4152fc406e3604.jpg" alt="">
                <h3>Tennis</h3>
                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Assumenda, consectetur?</p>
            </div>
        </div>
        </div>
    </section>


    <!-- fields section end -->

    <section class="about" id="about">
        <h3 class="sub-heading">Tentang Kami</h3>
        <h1 class="heading">SportField</h1>

        <div class="row">

            <div class="image">
                <img src="{{ asset('images/Sport family-amico (1).png') }}" alt="">
            </div>

            <div class="content">
                <h3>Keunggulan Sewa Online</h3>
                <p><strong>Kemudahan Aksesibilitas:</strong> Dengan sewa lapangan online, pengguna dapat mengakses
                    informasi dan melakukan pemesanan kapan saja dan di mana saja melalui platform digital.</p>
                <p><strong>Ketersediaan Informasi yang Lengkap:</strong> Melalui platform online, pengguna dapat melihat
                    informasi lengkap tentang lapangan yang tersedia, termasuk ukuran, fasilitas, harga, dan jam
                    operasional.</p>
                <p><strong>Proses Pemesanan yang Mudah dan Cepat:</strong> Dengan hanya beberapa klik, pengguna dapat
                    melakukan pemesanan lapangan secara langsung melalui platform online.</p>
                <p><strong>Notifikasi dan Pengingat:</strong> Pengguna biasanya menerima notifikasi dan pengingat
                    melalui platform online tentang reservasi yang telah mereka buat.</p>
                <p><strong>Transparansi dan Ulasan Pengguna:</strong> Platform sewa lapangan online seringkali
                    menyediakan sistem ulasan dan rating dari pengguna sebelumnya.</p>
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

        <div class="credit"> copyright | @ 2023 by <span>dde</span>
        </div>
    </section>
</body>

</html>
