@extends('layout/vendor/app')

@section('content')
    <div class="container">
        <h3>Daftar Lapangan</h3>
        <a href="{{ route('lapangans.create') }}" class="btn btn-primary">Tambah</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Lokasi</th>
                    <th>Foto</th>
                    <th>Jenis Lapangan</th>
                    <th>Deskripsi Lapangan</th>
                    <th>Fasilitas</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="lapanganList">
                @foreach ($lapangan as $l)
                    <tr>
                        <td>{{ $l->name }}</td>
                        <td>{{ $l->location }}</td>
                        <td>
                            <img src="{{ asset('images/' . $l->photo) }}" alt="{{ $l->name }}" width="100">
                        </td>
                        <td>{{ $l->type }}</td>
                        <td>{{ $l->description }}</td>
                        <td>{{ $l->facilities }}</td>
                        <td>
                            <a href="{{ route('lapangans.edit', $l->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('lapangans.destroy', $l->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus lapangan ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $lapangan->links() }} <!-- Menampilkan pagination jika lebih dari 5 item -->
    </div>
@endsection
