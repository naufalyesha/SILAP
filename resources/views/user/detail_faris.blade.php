<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
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
            <p><strong>Photo:</strong></p>
            <img src="{{ asset('image/' . $lapangan->photo) }}" alt="Photo of {{ $lapangan->name }}">
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
                                <form id="booking-form-{{ $schedule->id }}">
                                    @csrf
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
    </div>
</body>

</html>
