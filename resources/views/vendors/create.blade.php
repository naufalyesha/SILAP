<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Vendor</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style1.css') }}">
    <!-- <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Registrasi Vendor</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        body, html {
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
        }

        .form-container {
            max-width: 600px; 
            width: 500px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin: 10px 0 5px;
        }

        input, select {
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
    </style> -->
</head>

<body>
    <div class="container">
        <h2 class="text-center">Pendaftaran Vendor</h2>
        <form id="registerForm" method="POST" action="{{ route('createVendors') }}">
            @csrf
            <div class="form-group">
                <label for="storeName"><b>Nama Vendor</b></label>
                <input type="text" placeholder="Masukkan Nama Vendor" class="form-control" id="storeName" name="storeName" required>
            </div>
            <div class="form-group">
                <label for="ownerName"><b>Nama Pemilik</b></label>
                <input type="text" placeholder="Masukkan Nama Pemilik" class="form-control" id="ownerName" name="ownerName" required>
            </div>
            <div class="form-group">
                <label for="phone"><b>Nomor Telepon</b></label>
                <input type="tel" placeholder="Masukkan Nomor Telephone" class="form-control" id="phone" name="phone" required>
            </div>
            <div class="form-group">
                <label for="alamat"><b>Alamat</b></label>
                <input type="text" placeholder="Masukkan Alamat" class="form-control" id="alamat" name="alamat" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Daftar</button>
        </form>
        <div id="message" class="mt-3"></div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>

</html>