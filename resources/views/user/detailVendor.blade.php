<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SportField Detail</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    {{-- <link rel="stylesheet" href="{{ asset('css/style.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('css/detailVendor.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>

    <header>
        <i class="fas fa-arrow-left back-icon"></i>
        <div class="logo">
            <a href="{{ Auth::check() ? route('home') : url('/') }}">SportField</a>
        </div>
    </header>

    <main>
        <!-- Vendor detail start -->
        <div class="vendor-info">
            <div class="vendor-profil">
                <div class="vendor-prof">
                    <img src="{{ asset('image/profile.jpeg') }}" alt="">
                    <p><strong>{{ $vendor->nama }}</strong></p>
                </div>
            </div>
            <div class="vendor-detail">
                <table class="large-text">
                    <tr>
                        <td><strong>Kota</strong></td>
                        <td><strong> : </strong></td>
                        <td> {{ $vendor->kota }}</td>
                    </tr>
                    <tr>
                        <td><strong>Nomor Telepon </td>
                        <td><strong> : </strong> </td>
                        <td>{{ $vendor->phone }}</strong></td>
                    </tr>
                    <tr>
                        <td><strong>Alamat</strong></td>
                        <td><strong> : </strong></td>
                        <td>{{ $vendor->alamat }}</td>
                    </tr>
                </table>
            </div>
            <div class="vendor-venue">
                <button onclick="window.open('{{ $vendor->google_map_link }}', '_blank')" class="detail-location">
                    <div class="location-map">
                        <div class="location-map-container">
                        </div>
                        <i class="fa-solid fa-location-dot"></i>
                        <p>Buka Peta</p>
                    </div>
                </button>
            </div>
        </div>
    </main>

    <!-- Daftar lapangan start -->

    <div class="list-field">
        <h3 class="heading">Daftar Lapangan</h3>
        <div class="venue-grid">
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
                        <p class="venue-type">{{ $lapangan->vendor->nama }}</p>
                        <h3>{{ $lapangan->name }}</h3>
                        <p class="venue-rating">⭐
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
                                Mulai
                                Rp{{ number_format($lapangan->schedules->first()->price, 0, ',', '.') }}
                                / sesi
                            @else
                                Harga tidak tersedia
                            @endif
                        </p>
                        </br>
                        <a href="{{ route('detailLapangan', $lapangan->id) }}" class="btn btn-detail-lapangan">Detail
                            Lapangan</a>
                    </div>
                </div>
            @endforeach
            {{ $lapangans->links() }}
        </div>
    </div>

    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            const backIcon = document.querySelector('.back-icon');
            const isLoggedIn = @json(auth()->check());

            backIcon.addEventListener('click', function() {
                if (isLoggedIn) {
                    window.location.href = '{{ route('home') }}';
                } else {
                    window.location.href = '{{ route('readLapangan') }}';
                }
            });
        });
    </script>
</body>

</html>
