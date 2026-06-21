@extends('layouts.app')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Top Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
        <!-- Card 1: Siswa Aktif -->
        <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm flex items-center">
            <div class="p-3 bg-blue-50 rounded-lg mr-4">
                <i class="fa-solid fa-users text-blue-500 text-xl"></i>
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Siswa Aktif</p>
                <h3 class="text-2xl font-bold text-slate-800">{{ $siswaAktifCount }}</h3>
                <p class="text-xs text-slate-400 mt-1">terdaftar tahun ini</p>
            </div>
        </div>
        <!-- Card 2: Total Guru -->
        <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm flex items-center">
            <div class="p-3 bg-emerald-50 rounded-lg mr-4">
                <i class="fa-solid fa-graduation-cap text-emerald-500 text-xl"></i>
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Guru</p>
                <h3 class="text-2xl font-bold text-slate-800">{{ $totalGuruCount }}</h3>
                <p class="text-xs text-slate-400 mt-1">tenaga pengajar aktif</p>
            </div>
        </div>
        <!-- Card 3: SPP Terkumpul -->
        <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm flex items-center">
            <div class="p-3 bg-indigo-50 rounded-lg mr-4">
                <i class="fa-solid fa-dollar-sign text-indigo-500 text-xl"></i>
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">SPP JULI 2026</p>
                <h3 class="text-2xl font-bold text-slate-800">Rp {{ number_format($sppTerkumpul, 0, ',', '.') }}</h3>
                <p class="text-xs text-slate-400 mt-1">terkumpul bulan ini</p>
            </div>
        </div>
        <!-- Card 4: Belum Bayar -->
        <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm flex items-center">
            <div class="p-3 bg-orange-50 rounded-lg mr-4">
                <i class="fa-solid fa-triangle-exclamation text-orange-500 text-xl"></i>
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">SPP Belum Bayar</p>
                <h3 class="text-2xl font-bold text-slate-800">{{ $sppBelumBayar }}</h3>
                <p class="text-xs text-slate-400 mt-1">transaksi perlu ditagih</p>
            </div>
        </div>
    </div>
    
    <!-- Charts Middle Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Large Line Chart -->
        <div class="lg:col-span-2 bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h4 class="font-bold text-slate-800">Pemasukan SPP 2026</h4>
                    <p class="text-xs text-slate-400 mt-1">Per bulan (Juta Rp)</p>
                </div>
                <i class="fa-solid fa-chart-line text-blue-500"></i>
            </div>
            <div class="h-[300px]">
                <canvas id="incomeLineChart"></canvas>
            </div>
        </div>
        <!-- Status Pie Chart -->
        <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
            <div>
                <h4 class="font-bold text-slate-800">Status Ketuntasan</h4>
                <p class="text-xs text-slate-400 mt-1">Distribusi nilai siswa</p>
            </div>
            <div class="h-[250px] mt-4 flex items-center justify-center relative">
                <canvas id="statusPieChart"></canvas>
            </div>
            <div class="flex justify-center mt-6 space-x-6 text-xs font-medium">
                <div class="flex items-center">
                    <span class="w-3 h-3 bg-emerald-500 rounded-full mr-2"></span>
                    <span>Tuntas ({{ $tuntasCount }})</span>
                </div>
                <div class="flex items-center">
                    <span class="w-3 h-3 bg-rose-500 rounded-full mr-2"></span>
                    <span>Remedial ({{ $remedialCount }})</span>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bottom Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Bar Chart -->
        <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
            <div>
                <h4 class="font-bold text-slate-800">Jumlah Siswa per Kelas</h4>
                <p class="text-xs text-slate-400 mt-1">Tahun ajaran 2026/2027</p>
            </div>
            <div class="h-[300px] mt-6">
                <canvas id="studentsBarChart"></canvas>
            </div>
        </div>
        <!-- Recent Payments List -->
        <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h4 class="font-bold text-slate-800">Pembayaran SPP Terbaru</h4>
                    <p class="text-xs text-slate-400 mt-1">5 transaksi lunas terakhir</p>
                </div>
                <i class="fa-solid fa-user-check text-emerald-500"></i>
            </div>
            <div class="space-y-4">
                @forelse($pembayaranTerbaru as $p)
                    <div class="flex items-center justify-between py-2 border-b border-slate-50 last:border-0">
                        <div>
                            <p class="text-sm font-bold text-slate-800">{{ $p->siswa->Nama ?? 'Tidak diketahui' }}</p>
                            <p class="text-xs text-slate-400">{{ $p->BulanBayar }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-bold text-slate-800">Rp {{ number_format($p->JumlahBayar, 0, ',', '.') }}</p>
                            <span class="inline-block px-2 py-0.5 bg-emerald-100 text-emerald-600 text-[10px] font-bold rounded uppercase">{{ $p->MetodePembayaran }}</span>
                        </div>
                    </div>
                @empty
                    <p class="text-slate-400 text-xs text-center py-8">Belum ada transaksi pembayaran.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- Chart.js for graphs -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Income Line Chart
    const ctxLine = document.getElementById('incomeLineChart').getContext('2d');
    new Chart(ctxLine, {
        type: 'line',
        data: {
            labels: {!! json_encode(array_keys($monthlyIncome)) !!},
            datasets: [{
                label: 'Total Pemasukan',
                data: {!! json_encode(array_values($monthlyIncome)) !!},
                borderColor: '#2563eb',
                backgroundColor: 'rgba(37, 99, 235, 0.05)',
                fill: true,
                tension: 0.4,
                pointRadius: 4,
                pointBackgroundColor: '#2563eb'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Total: Rp ' + (context.raw * 1000000).toLocaleString('id-ID');
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) { return value + 'M'; }
                    },
                    grid: { borderDash: [5, 5], color: '#f1f5f9' }
                },
                x: {
                    grid: { display: false }
                }
            }
        }
    });

    // Status Pie Chart (Doughnut)
    const ctxPie = document.getElementById('statusPieChart').getContext('2d');
    new Chart(ctxPie, {
        type: 'doughnut',
        data: {
            labels: ['Tuntas', 'Remedial'],
            datasets: [{
                data: [{{ $tuntasCount }}, {{ $remedialCount }}],
                backgroundColor: ['#10b981', '#f43f5e'],
                borderWidth: 0,
                cutout: '75%'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            }
        }
    });

    // Students Bar Chart
    const ctxBar = document.getElementById('studentsBarChart').getContext('2d');
    new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: {!! json_encode($kelasSiswa->pluck('NamaKelas')->values()->all()) !!},
            datasets: [{
                label: 'Jumlah Siswa',
                data: {!! json_encode($kelasSiswa->pluck('siswa_count')->values()->all()) !!},
                backgroundColor: '#2563eb',
                borderRadius: 4,
                barThickness: 20
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 },
                    grid: { borderDash: [5, 5], color: '#f1f5f9' }
                },
                x: {
                    grid: { display: false }
                }
            }
        }
    });
</script>
@endsection
