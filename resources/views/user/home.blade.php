@extends('layout/user/app')

@section('content')
    <!-- home section start -->

    {{-- <section class="home" id="home">
        <!-- <div class="home-container"> -->
        <div class="home-text">
            <h1>Penyewaan lapangan secara online</h1>
            <p>Sewa lapangan olahraga sekarang dan nikmati pengalaman olahraga yang menyenangkan!</p>
            <a href="#fields" class="btn">Cari Lapangan</a>
        </div> --}}
    {{-- @extends('layout/user/app') --}}

    {{-- @section('content') --}}

    <!-- home section start -->
    <section class="home" id="home">
        <div class="home-text">
            <h1>Penyewaan lapangan secara online</h1>
            <p>Sewa lapangan olahraga sekarang dan nikmati pengalaman olahraga yang menyenangkan!</p>
            <a href="#fields" class="btn">Cari Lapangan</a>
        </div>

        <div class="home-img">
            <img src="{{ asset('images/1.png') }}" alt="home">
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
                <input type="text" placeholder="Cari nama venue" class="search-input" id="search-name">
            </div>
            <div class="search-wrapper">
                <i class="fa-solid fa-location-dot"></i>
                <select class="search-select" id="search-location">
                    <option value="">Pilih Lokasi</option>
                    @foreach ($locations as $location)
                        <option value="{{ $location->location }}">{{ $location->location }}</option>
                    @endforeach
                </select>
            </div>
            <div class="search-wrapper">
                <i class="fa-solid fa-futbol"></i>
                <select class="search-select" id="search-sport-select">
                    <option value="">Semua</option>
                    <option value="sepak bola">Sepak Bola</option>
                    <option value="futsal">Futsal</option>
                    <option value="basket">Basket</option>
                    <option value="bulu tangkis">Bulu Tangkis</option>
                    <option value="tenis">Tenis</option>
                    <option value="basket">Voli</option>
                    <option value="sepak takraw">Sepak Takraw</option>
                </select>
            </div>
            <button class="search-button" onclick="searchVenues()">Cari venue</button>
        </div>

        <br>
        <div class="venue-grid" id="venue-grid">
            @foreach ($lapangans as $lapangan)
                <div class="venue-card">
                    @php
                        $photos = json_decode($lapangan->photo, true);
                        // dump($lapangan->reviews->pluck('rating'));
                        $ratings = $lapangan->reviews->pluck('rating');
                        $averageRating = $ratings->isNotEmpty() ? $ratings->avg() : 0.0;
                    @endphp
                    @if (!empty($photos))
                        <img src="{{ asset('images/' . $photos[0]) }}" alt="{{ $lapangan->name }}">
                    @else
                        <img src="{{ asset('images/default.jpg') }}" alt="{{ $lapangan->name }}">
                    @endif
                    <div class="venue-info">
                        <p class="venue-type">Venue</p>
                        <h3>{{ $lapangan->name }}</h3>
                        <p class="venue-rating">
                            ⭐
                            @if ($ratings->isNotEmpty())
                                {{ number_format($averageRating, 2) }}
                            @else
                                Belum Ada Rating
                            @endif
                            • {{ $lapangan->location }}
                        </p>
                        <p class="venue-sports">{{ $lapangan->type }}</p>
                        <p class="venue-price">
                            @if ($lapangan->schedules->isNotEmpty())
                                Mulai Rp{{ number_format($lapangan->schedules->first()->price, 0, ',', '.') }} / sesi
                            @else
                                Harga tidak tersedia
                            @endif
                        </p>
                        </br>
                        <a href="{{ route('detailVendor', $lapangan->vendor_id) }}" class="btn btn-primary">Detail
                            Vendor</a>
                    </div>
                </div>
            @endforeach
            {{ $lapangans->links() }}
        </div>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            function searchVenues() {
                const name = document.getElementById('search-name').value;
                const location = document.getElementById('search-location').value;
                const sport = document.getElementById('search-sport-select').value;

                fetch('{{ route('search.venues') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            name,
                            location,
                            sport
                        })
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Tidak ada tempat yang ditemukan atau vendornya dilarang');
                        }
                        return response.json();
                    })
                    .then(data => {
                        const venueGrid = document.getElementById('venue-grid');
                        venueGrid.innerHTML = '';
                        data.forEach(lapangan => {
                            const photos = JSON.parse(lapangan.photo);
                            const photoUrl = photos.length ? '{{ asset('images/') }}/' + photos[0] :
                                '{{ asset('images/default.jpg') }}';

                            venueGrid.innerHTML += `
                                    <div class="venue-card">
                                        <img src="${photoUrl}" alt="${lapangan.name}">
                                        <div class="venue-info">
                                            <p class="venue-type">Venue</p>
                                            <h3>${lapangan.name}</h3>
                                            <a href="{{ route('detailVendor', '') }}/${lapangan.vendor_id}" class="btn btn-primary">Detail Vendor</a>
                                            <p class="venue-rating">⭐ 4.71 • ${lapangan.location}</p>
                                            <p class="venue-sports">${lapangan.type}</p>
                                            <p class="venue-price">
                                                ${lapangan.schedules.length ? 'Mulai Rp' + new Intl.NumberFormat('id-ID').format(lapangan.schedules[0].price) + ' / sesi' : 'Harga tidak tersedia'}
                                            </p>
                                        </div>
                                    </div>
                                `;
                        });
                    })
                    .catch(error => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: error.message,
                        });
                    });
            }
        </script>
    </section>

    <!-- fields section end -->

    <!-- about section start -->

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
                    <div class="container">
                        <div class="content-box">
                            <h3>Hubungi Kami</h3>
                            <p>Jika Anda memiliki pertanyaan atau membutuhkan informasi lebih lanjut, jangan ragu untuk
                                menghubungi kami. Kami dengan senang hati akan membantu Anda.</p>
                            @if ($admin)
                                <p><strong>Email : </strong> {{ $admin->email }}</p>
                                <p><strong>Telepon : </strong> {{ $admin->phone }}</p>
                                <p><strong>Alamat : </strong> {{ $admin->alamat }}</p>
                            @else
                                <p>Informasi admin tidak tersedia.</p>
                            @endif
                            <p>Terima kasih telah memilih SportField sebagai tempat Anda berolahraga. Kami berharap
                                dapat
                                memberikan pengalaman terbaik dan menjadi bagian dari perjalanan olahraga Anda.</p>
                            <a href="{{ route('contact') }}" class="btn btn-primary">Hubungi Kami</a>
                        </div>
                    </div>
                    <!-- about section end -->
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
                    <li>Lapangan tenis</li>
                    <li>Lapangan basket</li>
                    <li>Lapangan voli</li>
                    <li>Lapangan sepak takraw</li>
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

    <script src="{{ asset('js/scriptLandingPage.js') }}"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"></script> --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.querySelectorAll('.faq-question').forEach(item => {
            item.addEventListener('click', event => {
                const currentlyActive = document.querySelector('.faq-question.active');
                if (currentlyActive && currentlyActive !== item) {
                    currentlyActive.classList.toggle('active');
                    currentlyActive.nextElementSibling.style.display = 'none';
                }

                item.classList.toggle('active');
                const answer = item.nextElementSibling;
                if (item.classList.contains('active')) {
                    answer.style.display = 'block';
                } else {
                    answer.style.display = 'none';
                }
            });
        });
    </script>
@endsection
