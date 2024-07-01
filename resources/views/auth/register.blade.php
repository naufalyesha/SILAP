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
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h1>Registrasi</h1>
            <form action="{{ route('register-process') }}" method="POST">
                @csrf
                <label for="nama">Username</label>
                <input type="text" id="nama" name="nama" value="{{ old('nama') }}">
                @error('nama')
                    <small>{{ $message }}</small>
                @enderror
                
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}">
                @error('email')
                    <small>{{ $message }}</small>
                @enderror
                
                <label for="password">Password</label>
                <input type="password" id="password" name="password">
                @error('password')
                    <small>{{ $message }}</small>
                @enderror
                <button type="submit">Daftar</button>                
            </form>
            <button class="login-btn" onclick="location.href='/login'">Back to Login</button>
        </div>
    </div>
</body>
</html>
