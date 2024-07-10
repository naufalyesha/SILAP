<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Registrasi</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        body,
        html {
            height: 100%;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            background: url('https://images.unsplash.com/photo-1543351611-58f69d7c1781?q=80&w=1374&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D') no-repeat center center fixed;
            background-size: cover;
        }

        .container {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 600px;
            margin: 20px;
        }

        .form-container {
            width: 100%;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin: 10px 0 5px;
        }

        input,
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        .login-btn {
            background-color: #35ba00;
            margin-top: 10px;
        }

        .login-btn:hover {
            background-color: #007BB5;
        }

        .hidden {
            display: none;
        }

        @media (max-width: 600px) {
            .container {
                padding: 15px;
            }

            input,
            select,
            button {
                padding: 12px;
            }

            h1 {
                font-size: 24px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="form-container">
            <h1>Registrasi</h1>
            <form action="{{ route('register-process') }}" method="POST">
                @csrf
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}">
                @error('email')
                    <small>{{ $message }}</small>
                @enderror

                <label for="nama">Nama</label>
                <input type="text" id="nama" name="nama" value="{{ old('nama') }}">
                @error('nama')
                    <small>{{ $message }}</small>
                @enderror

                <label for="alamat">Alamat</label>
                <input type="text" id="alamat" name="alamat" value="{{ old('alamat') }}">
                @error('alamat')
                    <small>{{ $message }}</small>
                @enderror

                <label for="phone">Nomor Telepon</label>
                <input type="text" id="phone" name="phone" value="{{ old('phone') }}">
                @error('phone')
                    <small>{{ $message }}</small>
                @enderror

                <label for="role">Daftar Sebagai</label>
                <select id="role" name="role" onchange="toggleGoogleMapLink()">
                    <option value="customer">Pelanggan</option>
                    <option value="vendor">Vendor</option>
                </select>
                @error('role')
                    <small>{{ $message }}</small>
                @enderror

                <div id="google-map-link-container" class="hidden">
                    <label for="google_map_link">Tautan Google Map</label>
                    <input type="text" id="google_map_link" name="google_map_link"
                        value="{{ old('google_map_link') }}">
                    @error('google_map_link')
                        <small>{{ $message }}</small>
                    @enderror
                </div>

                <div id="kota-container" class="hidden">
                    <label for="kota">Kota/Kabupaten</label>
                    <select id="kota" name="kota" class="form-control">
                        <option value="">Pilih Kota/Kabupaten</option>
                        <option value="Kota Semarang">Kota Semarang</option>
                        <option value="Kota Surakarta (Solo)">Kota Surakarta (Solo)</option>
                        <option value="Kota Magelang">Kota Magelang</option>
                        <option value="Kota Salatiga">Kota Salatiga</option>
                        <option value="Kota Pekalongan">Kota Pekalongan</option>
                        <option value="Kota Tegal">Kota Tegal</option>
                        <option value="Kabupaten Cilacap">Kabupaten Cilacap</option>
                        <option value="Kabupaten Kebumen">Kabupaten Kebumen</option>
                        <option value="Kabupaten Purbalingga">Kabupaten Purbalingga</option>
                        <option value="Kabupaten Banjarnegara">Kabupaten Banjarnegara</option>
                        <option value="Kabupaten Wonosobo">Kabupaten Wonosobo</option>
                        <option value="Kabupaten Temanggung">Kabupaten Temanggung</option>
                        <option value="Kabupaten Kendal">Kabupaten Kendal</option>
                        <option value="Kabupaten Batang">Kabupaten Batang</option>
                        <option value="Kabupaten Demak">Kabupaten Demak</option>
                        <option value="Kabupaten Jepara">Kabupaten Jepara</option>
                        <option value="Kabupaten Pati">Kabupaten Pati</option>
                        <option value="Kabupaten Kudus">Kabupaten Kudus</option>
                        <option value="Kabupaten Rembang">Kabupaten Rembang</option>
                        <option value="Kabupaten Blora">Kabupaten Blora</option>
                        <option value="Kabupaten Grobogan">Kabupaten Grobogan</option>
                        <option value="Kabupaten Sragen">Kabupaten Sragen</option>
                        <option value="Kabupaten Boyolali">Kabupaten Boyolali</option>
                        <option value="Kabupaten Klaten">Kabupaten Klaten</option>
                        <option value="Kabupaten Sukoharjo">Kabupaten Sukoharjo</option>
                        <option value="Kabupaten Wonogiri">Kabupaten Wonogiri</option>
                        <option value="Kabupaten Karanganyar">Kabupaten Karanganyar</option>
                        <option value="Kabupaten Purwodadi">Kabupaten Purwodadi</option>
                        <option value="Kabupaten Ambarawa">Kabupaten Ambarawa</option>
                        <option value="Kabupaten Ungaran">Kabupaten Ungaran</option>
                        <option value="Kabupaten Brebes">Kabupaten Brebes</option>
                        <option value="Kabupaten Pemalang">Kabupaten Pemalang</option>
                        <option value="Kabupaten Tegal">Kabupaten Tegal</option>
                    </select>
                    
                    @error('kota')
                        <small>{{ $message }}</small>
                    @enderror
                </div>

                <label for="password">Password</label>
                <input type="password" id="password" name="password">
                @error('password')
                    <small>{{ $message }}</small>
                @enderror

                <button type="submit">Daftar</button>
            </form>
            <button class="login-btn" onclick="location.href='/login'">Masuk</button>
        </div>
    </div>

    <script>
        function toggleHiddenForms() {
            var role = document.getElementById('role').value;
            var googleMapLinkContainer = document.getElementById('google-map-link-container');
            var kotaContainer = document.getElementById('kota-container');

            if (role === 'vendor') {
                googleMapLinkContainer.classList.remove('hidden');
                kotaContainer.classList.remove('hidden');
            } else {
                googleMapLinkContainer.classList.add('hidden');
                kotaContainer.classList.add('hidden');
            }
        }

        // Event listener to handle role change
        document.getElementById('role').addEventListener('change', toggleHiddenForms);

        // Initial call to set the correct state based on the initial role value
        toggleHiddenForms();
    </script>

</body>

</html>
