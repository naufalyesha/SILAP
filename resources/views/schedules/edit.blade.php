@extends('layout.vendor.app')

@section('content')
    <div class="container mt-5">
        <div class="mb-4">
            <h3>Edit Jadwal</h3>
            <form action="{{ route('schedules.update', $schedules->id) }}" method="POST">
                @csrf
                @method('PUT')
                <!-- Lapangan -->
                <div class="form-group">
                    <label for="lapangan">Lapangan</label>
                    <select class="form-control" id="lapangan" name="lapangan_id">
                        @foreach ($lapangans as $lapangan)
                            <option value="{{ $lapangan->id }}"
                                {{ $schedules->lapangan_id == $lapangan->id ? 'selected' : '' }}>
                                {{ $lapangan->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <!-- Tanggal -->
                <div class="form-group">
                    <label for="date">Tanggal</label>
                    <input type="date" class="form-control" id="date" name="date" value="{{ $schedules->date }}">
                </div>
                <!-- Jam Masuk -->
                <div class="form-group">
                    <label for="start_time">Jam Masuk</label>
                    <input type="time" class="form-control" id="start_time" name="start_time"
                        value="{{ old('start_time', date('H:i', strtotime($schedules->start_time))) }}">
                </div>

                <!-- Jam Keluar -->
                <div class="form-group">
                    <label for="end_time">Jam Keluar</label>
                    <input type="time" class="form-control" id="end_time" name="end_time"
                        value="{{ old('end_time', date('H:i', strtotime($schedules->end_time))) }}">
                </div>

                <!-- Harga -->
                <div class="form-group">
                    <label for="price">Harga</label>
                    <input type="text" class="form-control" id="price" name="price"
                        value="{{ $schedules->price }}">
                </div>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
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
    </script>
@endsection
