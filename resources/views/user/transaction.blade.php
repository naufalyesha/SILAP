<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Transaction Detail</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    <div class="container">
        <a href="{{ route('home') }}" class="btn btn-primary">Kembali</a>
        <h1>My Orders</h1>
        @if ($transactions->isEmpty())
            <p>No orders found.</p>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th>Lapangan</th>
                        <th>Schedule</th>
                        <th>Total Price</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transactions as $transaction)
                        <tr>
                            <td>{{ $transaction->schedule->lapangan->name }}</td>
                            <td>{{ $transaction->schedule->date }} {{ $transaction->schedule->start_time }} -
                                {{ $transaction->schedule->end_time }}</td>
                            <td>{{ $transaction->price }}</td>
                            <td>{{ $transaction->created_at->format('d-m-Y') }}</td>
                            <td id="status-{{ $transaction->id }}">{{ $transaction->status }}</td>
                            <td>
                                @if ($transaction->schedule->booked == 0)
                                    <form id="booking-form-{{ $transaction->id }}">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-primary">Pesan Sekarang</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
        <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
        </script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                @foreach ($transactions as $transaction)
                    $('#booking-form-{{ $transaction->id }}').on('submit', function(event) {
                        event.preventDefault();
                        snap.pay('{{ $transaction->snap_token }}', {
                            onSuccess: function(result) {
                                alert('Payment success!');
                                // Perbarui status transaksi
                                updateTransactionStatus('{{ $transaction->id }}', 'success');
                            },
                            onPending: function(result) {
                                alert('Waiting for your payment!');
                                // Perbarui status transaksi
                                updateTransactionStatus('{{ $transaction->id }}', 'pending');
                            },
                            onError: function(result) {
                                alert('Payment failed!');
                                // Perbarui status transaksi
                                updateTransactionStatus('{{ $transaction->id }}', 'failed');
                            },
                            onClose: function() {
                                alert('You closed the popup without finishing the payment');
                            }
                        });
                    });

                    function updateTransactionStatus(transactionId, status) {
                        $.ajax({
                            url: '{{ route('midtrans.notification') }}',
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {
                                transaction_id: transactionId,
                                status: status,
                            },
                            success: function(response) {
                                $('#status-' + transactionId).text(status);
                                window.location.href = '{{ route('transactions.index') }}';
                            },
                            error: function(xhr) {
                                console.log(xhr.responseJSON);
                            }
                        });
                    }
                @endforeach
            });
        </script>
    </div>
</body>

</html>
