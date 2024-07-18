@extends('layout/user/app')

@section('content')
    <style>
        .container {
            padding: 150px 150px 0 150px;
            margin: 0 150px 0 150px;
            height: 690px;
        }

        input,
        textarea {
            text-transform: none;
            padding: 12px 20px;
            font-size: 15px;
        }

        input[type=text],
        input[type=email],
        select {
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        textarea {
            width: 100%;
            box-sizing: border-box;
            border: 2px solid #ccc;
            border-radius: 4px;
            background-color: #f8f8f8;
            font-size: 16px;
            resize: none;
        }

        /* Additional styles */
        .form-group {
            margin-bottom: 15px;
        }

        label {
            font-weight: 500;
            font-size: 15px
        }

        .form-control {
            padding: 12px 20px;
            border-radius: 0;
            box-shadow: none;
        }

        .btn-primary {
            background-color: #004085;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #004085;
            border-color: #004085;
        }

        .alert-success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
        }
    </style>
    <div class="container">
        <h2>Hubungi Kami</h2>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <form action="{{ route('contact-process') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Nama</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan nama..."
                    required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan email..."
                    required>
            </div>
            <div class="form-group">
                <label for="message">Pesan</label>
                <textarea class="form-control" id="message" name="message" rows="4" placeholder="Masukkan pesan..." required></textarea>
            </div>
            <button type="submit" class="btn btn-primary btn-lg">Kirim</button>
        </form>
    </div>
@endsection
