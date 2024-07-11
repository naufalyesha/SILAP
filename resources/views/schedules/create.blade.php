@extends('layout/vendor/app')

@section('title')
    <title>Jadwal dan Harga</title>
@endsection

@section('content')
    <div class="container mt-5">
        <div class="mb-4">
            <h3>Jadwal dan Harga</h3>
            <form id="crudForm" action="{{ route('schedules.store') }}" method="POST">
                @csrf
                <!-- Lapangan -->
                <div class="form-group">
                    <label for="lapangan">Lapangan</label>
                    <select class="form-control" id="lapangan" name="lapangan_id">
                        <option value="">Pilih Lapangan</option>
                        @foreach ($lapangans as $lapangan)
                            <option value="{{ $lapangan->id }}">{{ $lapangan->name }}</option>
                        @endforeach
                    </select>
                </div>
                <!-- Tanggal -->
                <div class="mb-3">
                    <label for="date" class="form-label">Tanggal</label>
                    <input type="date" class="form-control" id="date" name="date">
                </div>
                <!-- Jam Masuk -->
                <div class="mb-3">
                    <label for="start_time" class="form-label">Jam Masuk</label>
                    <input type="time" class="form-control" id="start_time" name="start_time">
                </div>
                <!-- Jam Keluar -->
                <div class="mb-3">
                    <label for="end_time" class="form-label">Jam Keluar</label>
                    <input type="time" class="form-control" id="end_time" name="end_time">
                </div>
                <!-- Harga -->
                <div class="mb-3">
                    <label for="price" class="form-label">Harga (Rp)</label>
                    <input type="number" class="form-control" id="price" name="price" placeholder="Contoh : 70000">
                </div>

                <!-- Tombol Aksi -->
                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="{{ route('schedules.index') }}" class="btn btn-success">Kembali</a>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if ($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ $errors->first() }}',
            });
        @endif

        // document.getElementById('price').addEventListener('input', function(e) {
        //     var value = e.target.value.replace(/\D/g, '');
        //     e.target.value = new Intl.NumberFormat('id-ID', {
        //         style: 'currency',
        //         currency: 'IDR'
        //     }).format(value).replace(/[Rp\s,]/g, '');
        // });
    </script>
@endsection
