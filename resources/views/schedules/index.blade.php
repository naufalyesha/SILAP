@extends('layout.vendor.app')

@section('title')
    <title>Jadwal dan Harga</title>
@endsection

@section('content')
    <div class="container mt-2">
        <div class="mb-3">
            <!-- Tabel untuk menyimpan hasil -->
            <h3>Jadwal Lapangan</h3>
            <a href="{{ route('schedules.create') }}" class="btn btn-primary">Tambah</a>
            <table class="table mt-4">
                <thead>
                    <tr>
                        <th>Lapangan</th>
                        <th>Tersedia</th>
                        <th>Tanggal</th>
                        <th>Mulai</th>
                        <th>Selesai</th>
                        <th>Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="dataTable">
                    @foreach ($schedules as $schedule)
                        <tr>
                            <td>{{ $schedule->lapangan->name }}</td>
                            <td>
                                @if ($schedule->booked == 0)
                                    <span style="color: green;">Tersedia</span>
                                @else
                                    <span style="color: red;">Sudah Dipesan</span>
                                @endif
                            </td>
                            <td>{{ \Carbon\Carbon::parse($schedule->date)->translatedFormat('j F Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($schedule->start_time)->format('H.i') }}</td>
                            <td>{{ \Carbon\Carbon::parse($schedule->end_time)->format('H.i') }}</td>
                            <td>{{ 'Rp ' . number_format($schedule->price, 0, ',', '.') }}</td>
                            <td>
                                <a href="{{ route('schedules.edit', $schedule->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('schedules.destroy', $schedule->id) }}" method="POST"
                                    style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus lapangan ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
