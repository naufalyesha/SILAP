<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Detail Transaksi</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb=4">
            <h1>Pesanan Saya</h1>
            <a href="{{ route('home') }}" class="btn btn-primary">Kembali</a>
        </div>

        @if ($transactions->isEmpty())
            <div class="alert alert-info">Belum ada Pesanan.</div>
        @else
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Lapangan</th>
                        <th>Vendor</th>
                        <th>Jadwal</th>
                        <th>Total Harga</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transactions as $transaction)
                        <tr>
                            <td>{{ $transaction->schedule->lapangan->name }}</td>
                            <td>{{ $transaction->schedule->vendor->nama }}</td>
                            <td>{{ \Carbon\Carbon::parse($transaction->schedule->date)->translatedFormat('j F Y') }}
                                {{ \Carbon\Carbon::parse($transaction->schedule->start_time)->format('H.i') }} -
                                {{ \Carbon\Carbon::parse($transaction->schedule->end_time)->format('H.i') }}</td>
                            <td>{{ 'Rp ' . number_format($transaction->price, 0, ',', '.') }}</td>
                            <td>{{ \Carbon\Carbon::parse($transaction->created_at)->translatedFormat('j F Y') }}</td>
                            <td id="status-{{ $transaction->id }}">{{ $transaction->status }}</td>
                            <td>
                                @if ($transaction->schedule->status == 2)
                                    <form id="booking-form-{{ $transaction->id }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-primary">Pesan Sekarang</button>
                                    </form>
                                @endif
                                @if ($transaction->status == 'menunggu')
                                    <form id="cancel-form-{{ $transaction->id }}"
                                        action="{{ route('transactions.cancel') }}" method="POST"
                                        class="d-inline cancel-form">
                                        @csrf
                                        <input type="hidden" name="transaction_id" value="{{ $transaction->id }}">
                                        <button type="submit" class="btn btn-sm btn-warning">Batalkan Pesanan</button>
                                    </form>
                                @endif
                                @if ($transaction->status == 'success')
                                    <form id="cancel-success-form-{{ $transaction->id }}"
                                        action="{{ route('transactions.cancel.success') }}" method="POST"
                                        class="d-inline cancel-success-form">
                                        @csrf
                                        <input type="hidden" name="transaction_id" value="{{ $transaction->id }}">
                                        <button type="submit" class="btn btn-sm btn-warning">Batalkan Pesanan</button>
                                    </form>
                                @endif
                                {{-- Gaperlu Dihapus --}}
                                {{-- @if ($transaction->status == 'success' || $transaction->status == 'dibatalkan')
                                    <form action="{{ route('transactions.destroy', $transaction->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                @endif --}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

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
                            alert('Pembayaran berhasil!');
                            updateTransactionStatus('{{ $transaction->id }}', 'success');
                        },
                        onPending: function(result) {
                            alert('Menunggu pembayaran Anda!');
                            updateTransactionStatus('{{ $transaction->id }}', 'pending');
                        },
                        onError: function(result) {
                            alert('Pembayaran gagal!');
                            updateTransactionStatus('{{ $transaction->id }}', 'error');
                        },
                        onClose: function() {
                            alert('Anda menutup popup tanpa menyelesaikan pembayaran');
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

                $('.cancel-form').on('submit', function(event) {
                    event.preventDefault();
                    if (confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')) {
                        var form = $(this);
                        $.ajax({
                            url: form.attr('action'),
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: form.serialize(),
                            success: function(response) {
                                alert('Pesanan berhasil dibatalkan.');
                                // Refresh halaman setelah pembatalan berhasil
                                window.location.reload();
                            },
                            error: function(xhr) {
                                alert('Terjadi kesalahan saat membatalkan pesanan.');
                                console.log(xhr.responseJSON);
                            }
                        });
                    }
                });

                $('.cancel-success-form').on('submit', function(event) {
                    event.preventDefault();
                    if (confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')) {
                        var form = $(this);
                        $.ajax({
                            url: form.attr('action'),
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: form.serialize(),
                            success: function(response) {
                                alert('Pesanan berhasil dibatalkan.');
                                // Refresh halaman setelah pembatalan berhasil
                                window.location.reload();
                            },
                            error: function(xhr) {
                                alert('Terjadi kesalahan saat membatalkan pesanan.');
                                console.log(xhr.responseJSON);
                            }
                        });
                    }
                });
            @endforeach
        });
    </script>
</body>

</html>
