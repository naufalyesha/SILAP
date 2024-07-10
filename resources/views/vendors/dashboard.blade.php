@extends('layout/vendor/app')

@section('title')
    <title>Dashboard Vendor</title>

@section('content')
    <main class="content px-3 py-2">
        <div class="container-fluid">
            <div class="mb-3">
                <h4>Vendor Dashboard</h4>
            </div>
            <div class="row">
                <div class="col-12 col-md-6 d-flex">
                    <div class="card flex-fill border-0 illustration">
                        <div class="card-body p-0 d-flex flex-fill">
                            <div class="row g-0 w-100">
                                <div class="col-6">
                                    <div class="p-3 m-1">
                                        <h4>Welcome Back</h4>
                                        <p class="mb-0">Vendor Dashboard</p>
                                    </div>
                                </div>
                                <div class="col-6 align-self-end text-end">
                                    <img src="{{ asset('image/customer-support.jpg') }}" class="img-fluid illustration-img"
                                        alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 d-flex">
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
                </div>
            </div>
        </div>
    </main>
    <div class="container mt-5">
        <div class="mb-4">
            <div class="row">
                <div class="col-12">
                    <h1 class="my-1">Laporan</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="card text-white bg-primary mb-3">
                        <div class="card-header">Total Sewa</div>
                        <div class="card-body">
                            <h5 class="card-title">124 Total</h5>
                            <p class="card-text">108 Total</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card text-white bg-warning mb-3">
                        <div class="card-header">On Going</div>
                        <div class="card-body">
                            <h5 class="card-title">32 Total</h5>
                            <p class="card-text">112 Total</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card text-white bg-success mb-3">
                        <div class="card-header">Complete</div>
                        <div class="card-body">
                            <h5 class="card-title">114 Total</h5>
                            <p class="card-text">102 Total</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">Revenue Analytics</div>
                        <div class="card-body">
                            <canvas id="revenueChart" class="chart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">Sales Analytics</div>
                        <div class="card-body">
                            <canvas id="salesChart" class="chart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Rp</h5>
                            <p class="card-text">Hari Ini</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Rp</h5>
                            <p class="card-text">Minggu Ini</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Rp</h5>
                            <p class="card-text">Bulan Ini</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Ipsum is simply dummy printing</h5>
                            <p class="card-text">There are many variations of passages of Lorem
                                Ipsum
                                available.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">How to manage your Clients in Proper way</h5>
                            <p class="card-text">Top priority project of August 2020</p>
                        </div>
                    </div>
                </div>
            </div>



            <div class="mb-4">
                <h2>Laporan Keuangan Hasil Penyewaan Lapangan</h2>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Pendapatan</h5>
                        <p class="card-text">Total Pendapatan: Rp 50,000,000</p>
                    </div>
                </div>
                <div class="card mt-3">
                    <div class="card-body">
                        <h5 class="card-title">Pengeluaran</h5>
                        <p class="card-text">Biaya Operasional: Rp 20,000,000</p>
                        <p class="card-text">Biaya Pemeliharaan: Rp 10,000,000</p>
                        <p class="card-text">Biaya Lain-lain: Rp 5,000,000</p>
                        <p class="card-text">Total Pengeluaran: Rp 35,000,000</p>
                    </div>
                </div>
                <div class="card mt-3">
                    <div class="card-body">
                        <h5 class="card-title">Laba Bersih</h5>
                        <p class="card-text">Total Laba Bersih: Rp 15,000,000</p>
                    </div>
                </div>
                <div class="card mt-3">
                    <div class="card-body">
                        <h5 class="card-title">Total Penyewa Lapangan</h5>
                        <p class="card-text">Total Penyewa: 200</p>
                    </div>
                </div>
            </div>
            <div class="mb-4">
                <h2>Chart Pendapatan vs Pengeluaran</h2>
                <canvas id="myChart" width="400" height="200"></canvas>
            </div>
        </div>
    </div>

    <script>
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        const revenueChart = new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Revenue',
                    data: [12, 19, 3, 5, 2, 3, 10, 20, 15, 25, 30, 35],
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                }]
            }
        });

        const salesCtx = document.getElementById('salesChart').getContext('2d');
        const salesChart = new Chart(salesCtx, {
            type: 'doughnut',
            data: {
                labels: ['On time', 'On store', 'Marketing'],
                datasets: [{
                    label: 'Sales',
                    data: [10, 20, 30],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)'
                    ],
                    borderWidth: 1
                }]
            }
        });

        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Pendapatan', 'Biaya Operasional', 'Biaya Pemeliharaan', 'Biaya Lain-lain', 'Laba Bersih'],
                datasets: [{
                    label: 'Jumlah (Rp)',
                    data: [50000000, 20000000, 10000000, 5000000, 15000000],
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)'
                    ],
                    borderColor: [
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endsection
