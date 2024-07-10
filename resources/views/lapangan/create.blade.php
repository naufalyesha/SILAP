@extends('layout/vendor/app')

@section('title')
    <title>Data Lapangan</title>
@endsection

@section('content')
    <div class="mb-4">
        <div class="container">
            <h3>Tambah Lapangan</h3>
            <form id="lapanganForm" action="{{ route('lapangans.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="name">Nama Lapangan</label>
                    <input type="text" class="form-control" id="name" name="name">
                </div>
                <div class="form-group">
                    <label for="location">Lokasi</label>
                    <input type="text" class="form-control" id="location" name="location" value="{{ auth()->user()->kota }}">
                </div>
                <div class="form-group">
                    <label for="map">Peta</label>
                    <input type="url" class="form-control" id="map" name="map" value="{{ auth()->user()->google_map_link }}">
                </div>
                <div class="form-group">
                    <label for="photo">Foto Lapangan</label>
                    <input type="file" accept="image/*" class="form-control-file" id="photo" name="photo[]" multiple
                        onchange="previewImages(event)"><br>
                    <div id="preview"></div>
                </div>
                <div class="form-group">
                    <label for="type">Jenis Lapangan</label>
                    <select class="form-control" id="type" name="type">
                        <option value="">Pilih Jenis Lapangan</option>
                        <option value="sepak bola">Sepak Bola</option>
                        <option value="futsal">Futsal</option>
                        <option value="basket">Basket</option>
                        <option value="bulu tangkis">Bulu Tangkis</option>
                        <option value="tenis">Tenis</option>
                        <option value="basket">Voli</option>
                        <option value="sepak takraw">Sepak Takraw</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="description">Deskripsi Lapangan</label>
                    <textarea class="form-control" id="description" name="description" rows="3"
                        placeholder="Masukkan Deskripsi Lapangan"></textarea>
                </div>
                <div class="form-group">
                    <label for="facilities">Fasilitas</label>
                    <textarea class="form-control" id="facilities" name="facilities" rows="2"
                        placeholder="Masukkan Fasilitas Lapangan"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Tambah</button>
                <a href="{{ route('vendor.lapangans') }}" class="btn btn-success">Kembali</a>
            </form>
        </div>
    </div>

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
@endsection
