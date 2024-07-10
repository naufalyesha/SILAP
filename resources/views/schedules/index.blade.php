@extends('layout.vendor.app')

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
                            <td>{{ $schedule->date }}</td>
                            <td>{{ $schedule->start_time }}</td>
                            <td>{{ $schedule->end_time }}</td>
                            <td>{{ $schedule->price }}</td>
                            <td>
                                <a href="{{ route('schedules.edit', $schedule->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                <form action="{{ route('schedules.destroy', $schedule->id) }}" method="POST"
                                    style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
