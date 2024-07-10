<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
        body,
        html {
            height: 100%;
            margin: 0;
            font-family: Arial, sans-serif;
            background-image: url('https://images.unsplash.com/photo-1629217855633-79a6925d6c47?q=80&w=1470&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            width: 350px;
            text-align: center;
        }

        .card h2 {
            margin-bottom: 25px;
            color: #333;
        }

        .card img {
            width: 100px;
            height: auto;
            margin-bottom: 20px;
        }

        .card input[type="email"],
        .card input[type="password"] {
            width: 100%;
            padding: 15px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 10px;
            box-sizing: border-box;
        }

        .card button {
            background-color: #4CAF50;
            color: white;
            padding: 15px 20px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
            margin-bottom: 10px;
        }

        .card button:hover {
            background-color: #45a049;
        }

        .card .register-btn {
            background-color: #008CBA;
        }

        .card .register-btn:hover {
            background-color: #007BB5;
        }

        .card a {
            display: block;
            margin-top: 15px;
            color: #333;
            text-decoration: none;
        }

        .card a:hover {
            text-decoration: underline;
        }

        .logo a {
            color: #184796;
            font-size: 35px;
            letter-spacing: 1px;
            font-weight: 600;
        }
    </style>
</head>

<body>
    <div class="card">
        <div class="logo">
            <a href="/">SportField</a>
        </div>
        <h2>Login</h2>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if ($message = Session::get('failed'))
            <div class="alert alert-danger">
                {{ $message }}
            </div>
        @endif
        <form action="{{ route('login-process') }}" method="post">
            @csrf
            <input type="email" value="{{ old('email') }}" name="email" placeholder="Email">
            @error('email')
                <small>{{ $message }}</small>
            @enderror
            <input type="password" name="password" placeholder="Password">
            @error('password')
                <small>{{ $message }}</small>
            @enderror
            <button type="submit">Login</button>
        </form>
        <button class="register-btn" onclick="location.href='/register'">Register</button>
        <a href="{{ route('forgot-password') }}">Forgot Password?</a>
        <a href="/">Continue as Guest!</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if ($message = Session::get('failed'))
        <script>
            Swal.fire(' {{ $message }} ');
        </script>
    @endif
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('success') }}',
            });
        </script>
    @endif

</body>

</html>
