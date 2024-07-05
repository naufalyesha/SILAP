@extends('layout/vendor/app')

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
                        @foreach($lapangans as $lapangan)
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
                    <label for="price" class="form-label">Harga</label>
                    <input type="number" class="form-control" id="price" name="price">
                </div>

                <!-- Tombol Aksi -->
                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="{{ route('schedules.index') }}" class="btn btn-success">Kembali</a>
            </form>            
        </div>
    </div>
@endsection
