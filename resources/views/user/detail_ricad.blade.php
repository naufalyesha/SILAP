<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SportField</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/style_detail_lapangan.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
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

    <div class="container-book">
        <div class="container">
            <h1 class="heading"> {{ $lapangan->name }}</h1>
            <h1 class="sub-heading">{{ $lapangan->vendor->nama }}</h1>
            <div class="content">
                <div class="image-container">
                    <img src="{{ asset('images/' . $lapangan->photo) }}" alt="Photo of {{ $lapangan->name }}">
                </div>
                <div class="details">
                    <h2>{{ $lapangan->type }}</h2>
                    <p id="deskripsi"><strong>Deskripsi :</strong> {{ $lapangan->description }}</p>
                    <p id="deskripsi"><strong>Fasilitas: </strong> {{ $lapangan->facilities }}</p>
                    <button onclick="window.location.href='{{ $lapangan->map }}'" class="detail-location">
                        <div class="location">
                            <p><strong>Lokasi : </strong>{{ $lapangan->location }}</p>
                        </div>
                        <div class="location-map">
                            <i class="fa-solid fa-location-dot"></i>
                            <p>Buka Peta</p>
                        </div>
                    </button>
                    {{-- <button class="btn-schedule">Jadwal Tersedia</button> --}}
                    <h3 class="btn-schedule"><strong>Jadwal Tersedia</strong></h3>
                    <div class="calendar-container">
                        @foreach ($lapangan->schedules->groupBy('date') as $date => $schedules)
                            <div class="day" data-date="{{ $date }}">
                                {{ \Carbon\Carbon::parse($date)->format('D') }}<br>{{ \Carbon\Carbon::parse($date)->format('d M') }}
                            </div>
                        @endforeach
                        <div class="calendar-icon"><i class="fas fa-calendar-alt"></i></div>
                    </div>
                    <div class="schedule">
                        @foreach ($lapangan->schedules as $schedule)
                            <button class="schedule-btn @if ($schedule->booked) booked @endif"
                                data-date="{{ $schedule->date }}" style="display: none;">
                                {{ $schedule->start_time }} - {{ $schedule->end_time }}<br>Rp{{ $schedule->price }}
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- start section ulasan  -->

    <section class="ulasan">
        <h1 class="heading">Ulasan</h1>
        <h3 class="sub-heading">Berikan Kami Penilaian </h3>
        <form action="" method="post" class="container-ulasan">
            <span>Tambahkan Ulasan</span>
            <div class="rating">
                <span class="rating-star" data-value="5">&#9733;</span>
                <span class="rating-star" data-value="4">&#9733;</span>
                <span class="rating-star" data-value="3">&#9733;</span>
                <span class="rating-star" data-value="2">&#9733;</span>
                <span class="rating-star" data-value="1">&#9733;</span>
            </div>
            <div class="input">
                <textarea name="ulasan" placeholder="tambahkan ulasan" id="ulasan" cols="10" rows="5"></textarea>
            </div>
            <input type="submit" value="Kirim" class="btn">
            <div class="card-ulasan">
                <i class="fas fa-quote-right"></i>
                <div class="user">
                    <img src="image/U-patrick1.jpg" alt="">
                    <div class="user-info">
                        <h3>Nama User</h3>
                        <div class="stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                </div>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Alias ad enim ex. Recusandae at quos
                    incidunt totam cum quas labore tenetur accusantium! Dicta recusandae nam totam porro
                    perspiciatis saepe repellendus!</p>
            </div>
            </div>
        </form>
    </section>

    <!-- end section ulasan  -->

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7H7X39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>

    <!-- Custom JavaScript -->
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            @foreach ($lapangan->schedules as $schedule)
                $('#booking-form-{{ $schedule->id }}').on('submit', function(event) {
                    event.preventDefault();
                    $.ajax({
                        url: '{{ route('transactions.store') }}',
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            schedule_id: '{{ $schedule->id }}',
                            price: '{{ $schedule->price }}',
                        },
                        success: function(response) {
                            var redirectUrl = '{{ route('transactions.index') }}';
                            window.location.href = redirectUrl;
                        },
                        error: function(xhr) {
                            console.log(xhr.responseJSON, null, 4);
                        }
                    });
                });
            @endforeach
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            // Rating Star Logic
            const stars = document.querySelectorAll('.rating-star');
            stars.forEach(star => {
                star.addEventListener('click', () => {
                    stars.forEach(s => s.classList.remove('selected'));
                    star.classList.add('selected');
                    let previousSibling = star.previousElementSibling;
                    while (previousSibling) {
                        previousSibling.classList.add('selected');
                        previousSibling = previousSibling.previousElementSibling;
                    }
                });
                star.addEventListener('mouseover', () => {
                    star.classList.add('hover');
                    let previousSibling = star.previousElementSibling;
                    while (previousSibling) {
                        previousSibling.classList.add('hover');
                        previousSibling = previousSibling.previousElementSibling;
                    }
                });
                star.addEventListener('mouseout', () => {
                    stars.forEach(s => s.classList.remove('hover'));
                });
            });

            // Show/Hide Schedule Buttons
            const scheduleButton = document.querySelector('.btn-schedule');
            const scheduleButtons = document.querySelectorAll('.schedule-btn');
            const dayButtons = document.querySelectorAll('.day');

            scheduleButton.addEventListener('click', () => {
                scheduleButtons.forEach(btn => btn.style.display = 'none');
                dayButtons.forEach(day => day.classList.remove('selected'));
            });

            dayButtons.forEach(day => {
                day.addEventListener('click', () => {
                    const selectedDate = day.getAttribute('data-date');
                    scheduleButtons.forEach(btn => {
                        if (btn.getAttribute('data-date') === selectedDate) {
                            btn.style.display = 'block';
                        } else {
                            btn.style.display = 'none';
                        }
                    });
                    dayButtons.forEach(d => d.classList.remove('selected'));
                    day.classList.add('selected');
                });
            });
        });
    </script>
</body>

</html>
