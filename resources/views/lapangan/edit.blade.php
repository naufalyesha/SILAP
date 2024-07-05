@extends('layout/vendor/app')

@section('content')
<div class="container">
    <h3>Edit Lapangan</h3>
    <form action="{{ route('lapangans.update', $lapangan->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Nama Lapangan</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $lapangan->name }}">
        </div>
        <div class="form-group">
            <label for="location">Lokasi</label>
            <input type="text" class="form-control" id="location" name="location" value="{{ $lapangan->location }}">
        </div>
        <div class="form-group">
            <label for="map">Map</label>
            <input type="url" class="form-control" id="map" name="map" value="{{ $lapangan->map }}">
        </div>
        <div class="form-group">
            <label for="photo">Foto Lapangan</label>
            <input type="file" accept="image/*" class="form-control-file" id="photo" name="photo"
                onchange="previewImage(event)"><br>
            <img id="preview" src="{{ asset('images/' . $lapangan->photo) }}" alt="Preview" style="display: block; width: 400px; height: 400px;">
        </div>
        <div class="form-group">
            <label for="type">Jenis Lapangan</label>
            <select class="form-control" id="type" name="type">
                <option value="">Pilih Jenis Lapangan</option>
                <option value="futsal" {{ $lapangan->type == 'futsal' ? 'selected' : '' }}>Futsal</option>
                <option value="basket" {{ $lapangan->type == 'basket' ? 'selected' : '' }}>Basket</option>
                <option value="tenis" {{ $lapangan->type == 'tenis' ? 'selected' : '' }}>Tenis</option>
                <option value="badminton" {{ $lapangan->type == 'badminton' ? 'selected' : '' }}>Badminton</option>
            </select>
        </div>
        <div class="form-group">
            <label for="description">Deskripsi Lapangan</label>
            <textarea class="form-control" id="description" name="description" rows="3">{{ $lapangan->description }}</textarea>
        </div>
        <div class="form-group">
            <label for="facilities">Fasilitas</label>
            <textarea class="form-control" id="facilities" name="facilities" rows="2">{{ $lapangan->facilities }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('vendor.lapangans') }}" class="btn btn-success">Kembali</a>
    </form>
</div>
@endsection
