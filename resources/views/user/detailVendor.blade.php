<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SportField Detail</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    <div class="container">
        <div class="container">
            <div class="row">
                <div class="col-md-10">
                    {{-- Detail vendor start --}}
                    <div class="container mt-5">
                        <div class="card">
                            <div class="card-body">
                                <h2 class="card-title">{{ $vendor->nama }}</h2>
                                <p class="card-text"><strong>Alamat: </strong> {{ $vendor->alamat }}</p>
                                <p class="card-text"><strong>Kota: </strong> {{ $vendor->kota }}</p>
                                <p class="card-text"><strong>Nomor Telepon: </strong> {{ $vendor->phone }}</p>
                                <p class="card-text"><strong>Link Google Map: </strong> {{ $vendor->google_map_link }}
                                </p>

                                <div class="list-fields">
                                    <h4>Daftar Lapangan</h4>
                                    <div class="row">
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
                                                        <img src="{{ asset('images/' . $photos[0]) }}"
                                                            alt="{{ $lapangan->name }}">
                                                    @else
                                                        <img src="{{ asset('images/default.jpg') }}"
                                                            alt="{{ $lapangan->name }}">
                                                    @endif
                                                    <div class="venue-info">
                                                        <p class="venue-type">{{ $lapangan->vendor->nama }}</p>
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
                                                                Mulai
                                                                Rp{{ number_format($lapangan->schedules->first()->price, 0, ',', '.') }}
                                                                / sesi
                                                            @else
                                                                Harga tidak tersedia
                                                            @endif
                                                        </p>
                                                        </br>
                                                        <a href="{{ route('detailLapangan', $lapangan->id) }}"
                                                            class="btn btn-primary">Detail Lapangan</a>
                                                    </div>
                                                </div>
                                            @endforeach
                                            {{ $lapangans->links() }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Detail vendor end --}}
                </div>
            </div>
        </div>
    </div>
</body>

</html>
