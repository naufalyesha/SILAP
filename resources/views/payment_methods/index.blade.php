@extends('layout/vendor/app')

@section('content')
    <div class="container mt-5">
        <h3>Metode Pembayaran</h3>
        <div class="card mt-3">
            <div class="card-body">
                <h5 class="card-title">Daftar Metode Pembayaran</h5>
                <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal"
                    data-bs-target="#addPaymentMethodModal">
                    Tambah Metode Pembayaran
                </button>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nama Bank</th>
                            <th scope="col">Nomor Rekening</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="paymentMethodsList">
                        <!-- Payment methods will be dynamically inserted here -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="addPaymentMethodModal" tabindex="-1" aria-labelledby="addPaymentMethodModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPaymentMethodModalLabel">Tambah Metode Pembayaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addPaymentMethodForm">
                        <div class="form-group">
                            <label for="bankName">Nama Bank</label>
                            <input type="text" class="form-control" id="bankName" required>
                        </div>
                        <div class="form-group">
                            <label for="accountNumber">Nomor Rekening</label>
                            <input type="text" class="form-control" id="accountNumber" required>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">Tambah</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
