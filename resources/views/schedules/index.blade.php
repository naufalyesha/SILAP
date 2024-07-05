@extends('layout.vendor.app')

@section('content')
    <div class="container mt-5">
        <div class="mb-4">
            <!-- Tabel untuk menyimpan hasil -->
            <h3>Jadwal Lapangan</h3>
            <a href="{{ route('schedules.create') }}" class="btn btn-primary">Tambah</a>
            <table class="table mt-4">
                <thead>
                    <tr>
                        <th>Lapangan</th>
                        <th>Tanggal</th>
                        <th>Jam</th>
                        <th>Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="dataTable">
                    @foreach ($schedules as $schedule)
                        <tr>
                            <td>{{ $schedule->lapangan->name }}</td>
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
