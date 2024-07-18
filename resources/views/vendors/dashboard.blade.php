@extends('layout/vendor/app')

@section('title')
    <title>Dasbor Vendor</title>
@endsection

@section('content')
    <main class="content px-3 py-2">
        <div class="container-fluid">
            <div class="mb-3">
                <h4>Dasbor Vendor</h4>
            </div>
            <div class="row">
                <div class="col-12 col-md-6 d-flex">
                    <div class="card flex-fill border-0 illustration">
                        <div class="card-body p-0 d-flex flex-fill">
                            <div class="row g-0 w-100">
                                <div class="col-6">
                                    <div class="p-3 m-1">
                                        <h4>Total Earnings</h4>
                                        <p class="mb-0">IDR {{ number_format($totalEarnings, 2) }}</p>
                                    </div>
                                </div>
                                <div class="col-6 align-self-end text-end">
                                    <img src="{{ asset('image/earnings.jpg') }}" class="img-fluid illustration-img"
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
                                        {{ $totalTransactions }}
                                    </h4>
                                    <p class="mb-2">
                                        Total Transactions
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

            <!-- Transaction Statuses -->
            <div class="row">
                @foreach ($transactionStatuses as $status => $total)
                    <div class="col-lg-3 col-md-6">
                        <div class="card text-white bg-primary mb-3">
                            <div class="card-header">{{ ucfirst($status) }}</div>
                            <div class="card-body">
                                <h5 class="card-title">{{ $total }} Total</h5>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Monthly Earnings and Transactions -->
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">Monthly Earnings</div>
                        <div class="card-body">
                            <canvas id="monthlyEarningsChart" class="chart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">Monthly Transactions</div>
                        <div class="card-body">
                            <canvas id="monthlyTransactionsChart" class="chart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pending Transactions -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">Pending Transactions</div>
                        <div class="card-body">
                            <ul>
                                @foreach ($pendingTransactions as $transaction)
                                    <li>Transaction ID: {{ $transaction->id }}, Amount: IDR
                                        {{ number_format($transaction->price, 2) }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Transactions -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">Recent Transactions</div>
                        <div class="card-body">
                            <ul>
                                @foreach ($recentTransactions as $transaction)
                                    <li>Transaction ID: {{ $transaction->id }}, Amount: IDR
                                        {{ number_format($transaction->price, 2) }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const monthlyEarnings = @json($monthlyEarnings);
        const monthlyTransactions = @json($monthlyTransactions);

        const ctxEarnings = document.getElementById('monthlyEarningsChart').getContext('2d');
        const earningsChart = new Chart(ctxEarnings, {
            type: 'bar',
            data: {
                labels: Object.keys(monthlyEarnings),
                datasets: [{
                    label: 'Monthly Earnings',
                    data: Object.values(monthlyEarnings),
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
        });

        const ctxTransactions = document.getElementById('monthlyTransactionsChart').getContext('2d');
        const transactionsChart = new Chart(ctxTransactions, {
            type: 'line',
            data: {
                labels: Object.keys(monthlyTransactions),
                datasets: [{
                    label: 'Monthly Transactions',
                    data: Object.values(monthlyTransactions),
                    backgroundColor: 'rgba(153, 102, 255, 0.2)',
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 1
                }]
            },
        });
    </script>
@endsection
