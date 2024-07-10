@extends('layout/vendor/app')

@section('title')
    <title>Data Lapangan</title>
@endsection

@section('content')
    <div class="container">
        <div class="container-fluid">
            <h3>Daftar Lapangan</h3>
        </div>
        <a href="{{ route('lapangans.create') }}" class="btn btn-primary">Tambah</a>
        <br>
        <br>
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
                            @if (!empty($l->photo))
                                @php
                                    $photos = json_decode($l->photo, true);
                                @endphp
                                @if (!empty($photos))
                                    <img src="{{ asset('images/' . $photos[0]) }}" alt="{{ $l->name }}" width="100">
                                @else
                                    <span>No photo available</span>
                                @endif
                            @else
                                <span>No photo available</span>
                            @endif
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
