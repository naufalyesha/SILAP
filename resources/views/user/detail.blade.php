<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SportField Detail</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min. css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/detail_lapangan.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>

    <header>
        <i class="fas fa-arrow-left back-icon" data-vendor-id="{{ $lapangan->vendor_id }}"></i>
        <div class="logo">
            <a href="{{ Auth::check() ? route('home') : url('/') }}">SportField</a>
        </div>
    </header>

    <div class="container">
        <div class="field">
            @if ($lapangan)
                <div class="fieldInfo">
                    <div class="detailFields">
                        <div class="fields">
                            <h1>{{ $lapangan->name }}</h1>
                            <p><strong>Location:</strong> {{ $lapangan->location }}</p>
                            <p><strong>Type:</strong> {{ $lapangan->type }}</p>
                            <p><strong>Description:</strong> {{ $lapangan->description }}</p>
                            <p><strong>Facilities:</strong> {{ $lapangan->facilities }}</p>

                            @if ($lapangan->map)
                                <p><strong>Map:</strong> {!! $lapangan->map !!}</p>
                            @endif
                        </div>
                    </div>

                    <div class="img-fields">
                        @if ($lapangan->photo)
                            <p><strong>Photos:</strong></p>
                            @foreach (json_decode($lapangan->photo, true) as $photo)
                                <img src="{{ asset('images/' . $photo) }}" alt="Photo of {{ $lapangan->name }}"
                                    class="img-thumbnail" style="max-width: 200px;">
                            @endforeach
                        @endif
                    </div>



                </div>
                <div class="schedule">
                    <h2 class="heading">Available Schedules</h2>
                    @if ($lapangan->schedules->isEmpty())
                        <p>Belum ada jadwal</p>
                    @else
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Start Time</th>
                                    <th>End Time</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($schedules as $schedule)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($schedule->date)->translatedFormat('d F Y') }}
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}</td>
                                        <td>Rp {{ number_format($schedule->price, 0, ',', '.') }}</td>
                                        <td>
                                            @if ($schedule->status == 0)
                                                <span style="color: green;">Tersedia</span>
                                            @elseif ($schedule->status == 2)
                                                <span style="color: orange;">Sedang Dipesan</span>
                                            @elseif ($schedule->status == 1)
                                                <span style="color: red;">Sudah Dipesan</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($schedule->status == 0)
                                                @if (Auth::check())
                                                    <form id="booking-form-{{ $schedule->id }}"
                                                        action="{{ route('transactions.store') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="schedule_id"
                                                            value="{{ $schedule->id }}">
                                                        <input type="hidden" name="price"
                                                            value="{{ $schedule->price }}">
                                                        <button type="submit" class="btn btn-sm btn-primary">Pesan
                                                            Sekarang</button>
                                                    </form>
                                                @else
                                                    <a href="{{ route('login') }}" class="btn btn-sm btn-primary">Pesan
                                                        Sekarang</a>
                                                @endif
                                            @endif
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>


                <!-- Formulir Input Ulasan -->
                <div class="tambah_ulasan">
                    <h2 class="heading" id="tambah_ulasan">Tambah Ulasan</h2>
                    <form id="review-form" action="{{ route('reviews.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="lapangan_id" value="{{ $lapangan->id }}">
                        <div class="form-group">
                            <label for="rating">Rating:</label>
                            <select class="form-control" id="rating" name="rating">
                                <option value="5">⭐⭐⭐⭐⭐ </option>
                                <option value="4">⭐⭐⭐⭐ </option>
                                <option value="3">⭐⭐⭐</option>
                                <option value="2">⭐⭐ </option>
                                <option value="1">⭐ </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="review">Ulasan:</label>
                            <br>
                            <textarea class="form-control long-textarea" id="review" name="review" rows="3" cols=""></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit Ulasan</button>
                    </form>
                </div>

                <!-- Tampilkan Ulasan -->
                <div class="ulasan">
                    <h2 class="heading">Ulasan</h2>
                    @if ($reviews->isEmpty())
                        <p>Belum ada ulasan.</p>
                    @else
                        @foreach ($reviews as $review)
                            <div class="review">
                                <p><strong>{{ $review->user->name }}</strong> - {{ $review->rating }} / 5</p>
                                <p>{{ $review->review }}</p>
                                <p><small>{{ $review->created_at->format('d M Y H:i') }}</small></p>
                            </div>
                        @endforeach

                        <!-- Tambahkan Paginasi -->
                        {{ $reviews->links() }}
                    @endif
                @else
                    <p>Data lapangan tidak ditemukan.</p>
                </div>
            @endif
        </div>
    </div>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7H7X39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            @foreach ($lapangan->schedules as $schedule)
                $('#booking-form-{{ $schedule->id }}').on('submit', function(event) {
                    event.preventDefault();
                    var form = $(this);
                    $.ajax({
                        url: form.attr('action'),
                        method: form.attr('method'),
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: form.serialize(), // Serialize form data
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

            $('#review-form').on('submit', function(event) {
                event.preventDefault();
                var form = $(this);
                $.ajax({
                    url: form.attr('action'),
                    method: form.attr('method'),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: form.serialize(),
                    success: function(response) {
                        swal({
                            title: "Success!",
                            text: response.message,
                            icon: "success",
                            button: "OK",
                        }).then((value) => {
                            location.reload();
                        });
                    },
                    error: function(xhr) {
                        var response = xhr.responseJSON;
                        swal({
                            title: "Error!",
                            text: response.message,
                            icon: "error",
                            button: "OK",
                        });
                    }
                });
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const backIcon = document.querySelector('.back-icon');
            const vendorId = backIcon.getAttribute('data-vendor-id');

            backIcon.addEventListener('click', function() {
                const vendorDetailUrl = `/detail-vendor/${vendorId}`;
                window.location.href = vendorDetailUrl;
            });
        });
    </script>
</body>

</html>
