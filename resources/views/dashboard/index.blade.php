@extends('layouts.app')

@section('content')
<style>
    .dashboard-wrapper {
        width: 100%;
        overflow-x: hidden;
    }

    .dashboard-card {
        border-radius: 6px;
        padding: 18px;
        color: #fff;
        min-height: 118px;
        box-shadow: 0 4px 10px rgba(0,0,0,.12);
    }

    .dashboard-card .icon {
        font-size: 38px;
        opacity: .95;
    }

    .dashboard-card h2 {
        font-size: 32px;
        font-weight: 800;
        margin: 0;
        color: #fff;
    }

    .dashboard-card p {
        margin: 0;
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;
        color: #fff;
    }

    .dashboard-card small {
        font-size: 12px;
        color: rgba(255,255,255,.9);
    }

    .bg-blue { background: #3498db; }
    .bg-green { background: #20b89a; }
    .bg-red { background: #d9534f; }
    .bg-darkblue { background: #1f2d3d; }
    .bg-orange { background: #f39c12; }
    .bg-purple { background: #6f42c1; }
    .bg-teal { background: #17a2b8; }
    .bg-gray { background: #5d6d7e; }
</style>

<div class="dashboard-wrapper">
    <div class="row g-3">

        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
            <div class="dashboard-card bg-blue">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p>Total Inventory</p>
                        <h2>{{ number_format($totalProducts) }}</h2>
                        <small>Inventory products</small>
                    </div>
                    <i class="fas fa-boxes icon"></i>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
            <div class="dashboard-card bg-green">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p>Total Items</p>
                        <h2>{{ number_format($totalItems) }}</h2>
                        <small>Registered items</small>
                    </div>
                    <i class="fas fa-list icon"></i>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
            <div class="dashboard-card bg-orange">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p>Total Daily Usage</p>
                        <h2>{{ number_format($totalDailyUsage) }}</h2>
                        <small>Used stocks</small>
                    </div>
                    <i class="fas fa-chart-line icon"></i>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
            <div class="dashboard-card bg-darkblue">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p>Critical Products</p>
                        <h2>{{ number_format($criticalProducts) }}</h2>
                        <small>Need attention</small>
                    </div>
                    <i class="fas fa-exclamation-triangle icon"></i>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
            <div class="dashboard-card bg-red">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p>Out of Stocks</p>
                        <h2>{{ number_format($outOfStocks) }}</h2>
                        <small>Unavailable products</small>
                    </div>
                    <i class="fas fa-times-circle icon"></i>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
            <div class="dashboard-card bg-purple">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p>Total Stock</p>
                        <h2>{{ number_format($totalStock) }}</h2>
                        <small>Current inventory</small>
                    </div>
                    <i class="fas fa-warehouse icon"></i>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
            <div class="dashboard-card bg-teal">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p>Total Item Value</p>
                        <h2>₱{{ number_format($totalItemValue, 2) }}</h2>
                        <small>Inventory value</small>
                    </div>
                    <i class="fas fa-coins icon"></i>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
            <div class="dashboard-card bg-gray">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p>Total Users</p>
                        <h2>{{ number_format($totalUsers) }}</h2>
                        <small>System users</small>
                    </div>
                    <i class="fas fa-users icon"></i>
                </div>
            </div>
        </div>

    </div>
    <div class="row mt-4">

    <div class="col-lg-12 col-md-12 mb-4">
        <div class="card shadow border-0">
            <div class="card-body">
                <h6 class="font-weight-bold mb-0">DAILY USAGE CHART</h6>
                <small>Total usage per date</small>

                <div style="height: 280px;">
                    <canvas id="usageChart"></canvas>
                </div>
            </div>
        </div>
    </div>

 
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const usageLabels = @json($usageLabels);
    const usageValues = @json($usageValues);

    new Chart(document.getElementById('usageChart'), {
        type: 'line',
        data: {
            labels: usageLabels,
            datasets: [{
                label: 'Daily Usage',
                data: usageValues,
                borderColor: '#3498db',
                backgroundColor: 'rgba(52, 152, 219, 0.18)',
                fill: true,
                tension: 0.35,
                pointRadius: 5,
                pointBackgroundColor: '#3498db'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });

    new Chart(document.getElementById('classificationChart'), {
        type: 'doughnut',
        data: {
            labels: ['Class A', 'Class B', 'Class C'],
            datasets: [{
                data: [
                    {{ $classA }},
                    {{ $classB }},
                    {{ $classC }}
                ],
                backgroundColor: [
                    '#3498db',
                    '#20b89a',
                    '#d9534f'
                ],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '65%'
        }
    });
</script>
    </div>
</div>
@endsection