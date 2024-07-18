@extends('layout/admin/app')

@section('title')
    <title>Dasbor Admin</title>
@endsection

@section('content')
    <main class="content px-3 py-2">
        <div class="container-fluid">
            <div class="mb-3">
                <h4>Dasbor Admin</h4>
            </div>
            <div class="row">
                <div class="col-12 col-md-6 d-flex">
                    <div class="card flex-fill border-0 illustration">
                        <div class="card-body p-0 d-flex flex-fill">
                            <div class="row g-0 w-100">
                                <div class="col-6">
                                    <div class="p-3 m-1">
                                        <h4>Selamat Datang, Admin</h4>
                                        <p class="mb-0">Dasbor Admin</p>
                                    </div>
                                </div>
                                <div class="col-6 align-self-end text-end">
                                    <img src="{{ asset('image/image.jpeg') }}" class="img-fluid illustration-img"
                                        alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <div class="col-12 col-md-6 d-flex">
                    <div class="card flex-fill border-0">
                        <div class="card-body py-4">
                            <div class="d-flex align-items-start">
                                <div class="flex-grow-1">
                                    <h4 class="mb-2">
                                        IDR 78.00
                                    </h4>
                                    <p class="mb-2">
                                        Total Earnings
                                    </p>
                                    <div class="mb-0">
                                        <span class="badge text-success me-2">
                                            +9.0%
                                        </span>
                                        <span class="text-muted">
                                            Since Last Month
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>

            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Jumlah Customer</h5>
                            <p class="card-text">{{ $customerCount }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Jumlah Vendor</h5>
                            <p class="card-text">{{ $vendorCount }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 mt-4">
                <div class="card-header">
                    <h5 class="card-title">Top 10 Vendor</h5>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nama Vendor</th>
                                <th scope="col">Jumlah Lapangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($topVendors as $vendor)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $vendor->nama }}</td>
                                    <td>{{ $vendor->lapangans_count }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
@endsection
