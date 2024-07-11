@extends('layout/vendor/app')

@section('title')
    <title>Data Lapangan</title>
@endsection

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
                <input type="file" accept="image/*" class="form-control-file" id="photo" name="photo[]"
                    onchange="previewImage(event)"><br>
                @php
                    $photos = json_decode($lapangan->photo, true);
                @endphp
                @if (!empty($photos))
                    @foreach ($photos as $photo)
                        <img src="{{ asset('images/' . $photo) }}" alt="Preview"
                            style="display: inline; width: 100px; margin: 5px;">
                    @endforeach
                @else
                    <span>No photos available</span>
                @endif
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
        <script>
            function previewImages(event) {
                var preview = document.getElementById('preview');
                preview.innerHTML = '';
                for (var i = 0; i < event.target.files.length; i++) {
                    var file = event.target.files[i];
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        var img = document.createElement('img');
                        img.src = e.target.result;
                        img.style.width = '100px';
                        img.style.margin = '5px';
                        preview.appendChild(img);
                    };
                    reader.readAsDataURL(file);
                }
            }
        </script>
    </div>
@endsection
