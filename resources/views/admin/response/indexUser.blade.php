@extends('layout/admin/app')

@section('title')
    <title>Pengaduan</title>
@endsection

@section('content')
    <main class="content px-3 py-2">
        <div class="container-fluid">
            <div class="mb-3">
                <h4>Pesan dari Pelanggan</h4>
            </div>
            <div class="row">
            </div>
            <!-- Table Element -->
            <div class="card border-0">
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Email</th>
                                <th scope="col">Pesan</th>
                                <th scope="col">Tanggal</th>
                                <th scope="col">Pukul</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($messages as $index => $message)
                                <tr>
                                    <th scope="row">{{ $index + 1 }}</th>
                                    <td>{{ $message->name }}</td>
                                    <td>{{ $message->email }}</td>
                                    <td>{{ $message->message }}</td>
                                    <td>{{ \Carbon\Carbon::parse($message->created_at)->translatedFormat('j F Y') }}
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($message->created_at)->translatedFormat('H.i') }}
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.response-user.delete', $message->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus pesan ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">Tidak ada pesan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <!-- Pagination links -->
                    {{ $messages->links() }}
                </div>
            </div>
        </div>
    </main>
@endsection
