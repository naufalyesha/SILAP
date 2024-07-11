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
        <h1>{{ $lapangan->name }}</h1>
        <p><strong>Location:</strong> {{ $lapangan->location }}</p>
        <p><strong>Type:</strong> {{ $lapangan->type }}</p>
        <p><strong>Description:</strong> {{ $lapangan->description }}</p>
        <p><strong>Facilities:</strong> {{ $lapangan->facilities }}</p>

        @if ($lapangan->map)
            <p><strong>Map:</strong> {!! $lapangan->map !!}</p>
        @endif

        @if ($lapangan->photo)
            <p><strong>Photos:</strong></p>
            @foreach (json_decode($lapangan->photo, true) as $photo)
                <img src="{{ asset('images/' . $photo) }}" alt="Photo of {{ $lapangan->name }}" class="img-thumbnail"
                    style="max-width: 200px;">
            @endforeach
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
                        <td>{{ \Carbon\Carbon::parse($schedule->date)->translatedFormat('d F Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}</td>
                        <td>{{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}</td>
                        <td>Rp {{ number_format($schedule->price, 0, ',', '.') }}</td>
                        <td>
                            @if ($schedule->booked == 0)
                                <span style="color: green;">Tersedia</span>
                            @else
                                <span style="color: red;">Sudah Dipesan</span>
                            @endif
                        </td>
                        <td>
                            @if ($schedule->booked == 0)
                                <form id="booking-form-{{ $schedule->id }}" action="{{ route('transactions.store') }}"
                                    method="POST">
                                    @csrf
                                    <input type="hidden" name="schedule_id" value="{{ $schedule->id }}">
                                    <input type="hidden" name="price" value="{{ $schedule->price }}">
                                    <button type="submit" class="btn btn-sm btn-primary">Pesan Sekarang</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
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
        </script>
        {{-- <script src="{{ asset('js/script.js') }}"></script> --}}
    </div>
</body>

</html>
