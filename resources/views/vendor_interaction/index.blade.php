@extends('layout/vendor/app')

@section('content')
    <div class="container mt-5">
        <h3>Interaksi dengan User</h3>
        <div class="card mt-3">
            <div class="card-body">
                <h5 class="card-title">Interaksi Chat</h5>
                <form id="chatForm">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="chatMessage" placeholder="Ketik pesan..." required>
                        <button class="btn btn-primary" type="submit">Kirim</button>
                    </div>
                </form>
                <ul class="list-group" id="chatList">
                    <!-- Chat messages will be dynamically inserted here -->
                </ul>
            </div>
        </div>

    </div>
@endsection
