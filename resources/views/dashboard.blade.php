@extends('layout.app')

@section('title', 'Dashboard')

@section('content')

    <!-- Content Row -->
    <div class="row">

        <!-- Total Orders Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Total Pesanan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totaltransaksi_totals }}</div>
                            <br>
                            <div class="h6 mb-0 font-weight-bold text-gray-800"> Baru: {{ $totalPesananBaru }}</div>
                            <div class="h6 mb-0 font-weight-bold text-gray-800"> Dikonfirmasi:
                                {{ $totalPesananDikonfirmasi }}</div>
                            <div class="h6 mb-0 font-weight-bold text-gray-800"> Dikemas: {{ $totalPesananDikemas }}</div>
                            <div class="h6 mb-0 font-weight-bold text-gray-800"> Dikirim: {{ $totalPesananDikirim }}</div>
                            <div class="h6 mb-0 font-weight-bold text-gray-800"> Diterima: {{ $totalPesananDiterima }}</div>
                            <div class="h6 mb-0 font-weight-bold text-gray-800"> Selesai: {{ $totalPesananSelesai }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-shopping-cart fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Anggota Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-50 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Anggota</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalAnggota }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Products Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-50 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Barang</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalProducts }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-boxes fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Harvest Results Chart -->
        <div class="col-lg-12 mb-2"> <!-- Ubah lebar menjadi 12 untuk menempatkan grafik pada satu baris -->
            <div class="card shadow mb-2">
                <div class="card-header py-2">
                    <h6 class="m-0 font-weight-bold text-primary">Grafik Hasil Panen</h6>
                </div>
                <div class="card-body">
                    <!-- Placeholder for harvest results chart -->
                    <canvas id="harvestChart" style="width: 100%; height: 400px;"></canvas> <!-- Setel lebar dan tinggi canvas -->
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <!-- Tautan CDN Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Script untuk membuat grafik -->
    <script>
        // Sample data for the chart
        var ctx = document.getElementById('harvestChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober'], // Label bulan
                datasets: [{
                    label: 'Hasil Panen Bibit dan Benih (Ton)',
                    data: [65, 59, 80, 81, 56, 55, 40, 30, 35, 41], // Data hasil panen (hanya contoh)
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1,
                    lineTension: 0.2
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
@endpush
