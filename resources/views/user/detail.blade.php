<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SportField</title>
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
        <div class="row">
            <div class="col-md-10">

                {{-- detail vendor start --}}

                <div class="container mt-5">
                    <div class="card">
                        <div class="card-body">
                            <h2 class="card-title">NAMA VENDOR</h2>
                            <p class="card-text"><strong>Alamat: </strong> {{ $lapangan->location }}</p>
                            <p class="card-text"><strong>Kota: </strong></p>
                            <p class="card-text"><strong>Nomor Telepon: </strong></p>
                            <p class="card-text"><strong>Link Google Map: </strong></p>
                            <div class="list-fields">
                                <h4>Daftar Lapangan</h4>
                                <!-- Additional content for Daftar Lapangan can be added here -->
                                <div class="row">
                                    <!-- Example field 1 -->
                                    <div class="col-md-3">
                                        <div class="card mb-4 shadow-sm">
                                            <img src="path/to/lapangan1.jpg" class="card-img-top" alt="Lapangan 1">
                                            <div class="card-body">
                                                <p class="card-text">Lapangan Futsal 1</p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Example field 2 -->
                                    <div class="col-md-4">
                                        <div class="card mb-4 shadow-sm">
                                            <img src="{{ asset('images/' . $lapangan->photo) }}" class="card-img-top"
                                                alt="Lapangan 2">
                                            <div class="card-body">
                                                <p class="card-text"> Lapangan Futsal 2</p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Example field 3 -->
                                    <div class="col-md-4">
                                        <div class="card mb-4 shadow-sm">
                                            <img src="path/to/lapangan3.jpg" class="card-img-top" alt="Lapangan 3">
                                            <div class="card-body">
                                                <p class="card-text">Lapangan Basket 1</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- detail vendor end --}}

                    <h1>{{ $lapangan->name }}</h1>
                    <p><strong>Location:</strong> {{ $lapangan->location }}</p>
                    <p><strong>Type:</strong> {{ $lapangan->type }}</p>
                    <p><strong>Description:</strong> {{ $lapangan->description }}</p>
                    <p><strong>Facilities:</strong> {{ $lapangan->facilities }}</p>

                    @if ($lapangan->map)
                        <p><strong>Map:</strong> {!! $lapangan->map !!}</p>
                    @endif

                    @if ($lapangan->photo)
                        <p><strong>Photo:</strong></p>
                        <img src="{{ asset('images/' . $lapangan->photo) }}" alt="Photo of {{ $lapangan->name }}"
                            width="300px">
                    @endif
                    <h2>Available Schedules</h2>
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
                            @foreach ($lapangan->schedules as $schedule)
                                <tr>
                                    <td>{{ $schedule->date }}</td>
                                    <td>{{ $schedule->start_time }}</td>
                                    <td>{{ $schedule->end_time }}</td>
                                    <td>{{ $schedule->price }}</td>
                                    <td>
                                        @if ($schedule->booked == 0)
                                            <span style="color: green;">Tersedia</span>
                                        @else
                                            <span style="color: red;">Sudah Dipesan</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($schedule->booked == 0)
                                            <form id="booking-form-{{ $schedule->id }}"
                                                action="{{ route('transactions.store') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="schedule_id" value="{{ $schedule->id }}">
                                                <input type="hidden" name="price" value="{{ $schedule->price }}">
                                                <button type="submit" class="btn btn-sm btn-primary">Pesan
                                                    Sekarang</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row"></div>








        </div>



        <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
        </script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
            integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7H7X39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
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
            });


            <
            script src = "{{ asset('js/script.js') }}" >
        </>
</body>

</html>
