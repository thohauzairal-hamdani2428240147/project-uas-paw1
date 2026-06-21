<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Staff;
use App\Models\Pembayaran;
use App\Models\Nilai;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $siswaAktifCount = Siswa::count();
        $totalGuruCount = Staff::where('Jabatan', 'like', 'Guru%')->count();
        
        // Sum SPP Terkumpul (for Juli 2026 as per our seeded data)
        $sppTerkumpul = Pembayaran::where('BulanBayar', 'Juli 2026')
            ->whereNotNull('TglBayar')
            ->sum('JumlahBayar');
            
        // Count unpaid SPP
        $sppBelumBayar = Pembayaran::where('MetodePembayaran', 'BelumBayar')->count();

        // 5 Latest payments
        $pembayaranTerbaru = Pembayaran::with('siswa')
            ->whereNotNull('TglBayar')
            ->orderBy('TglBayar', 'desc')
            ->take(5)
            ->get();

        // Data for doughnut chart: Status Ketuntasan
        $tuntasCount = Nilai::where('Keterangan', 'Tuntas')->count();
        $remedialCount = Nilai::where('Keterangan', 'Remedial')->count();

        // Data for bar chart: Jumlah Siswa per Kelas (ordered logically)
        $kelasSiswa = Kelas::withCount('siswa')->orderBy('NamaKelas')->get();
        
        // Monthly Pemasukan SPP for line chart (scaled in millions)
        $monthsMapping = [
            'Juli 2026' => 'Jul 26',
            'Agustus 2026' => 'Agu 26',
            'September 2026' => 'Sep 26',
            'Oktober 2026' => 'Okt 26',
            'November 2026' => 'Nov 26',
            'Desember 2026' => 'Des 26',
            'Januari 2027' => 'Jan 27',
            'Februari 2027' => 'Feb 27',
            'Maret 2027' => 'Mar 27',
            'April 2027' => 'Apr 27',
            'Mei 2027' => 'Mei 27',
            'Juni 2027' => 'Jun 27',
        ];

        $paymentData = Pembayaran::whereNotNull('TglBayar')
            ->where('MetodePembayaran', '!=', 'BelumBayar')
            ->groupBy('BulanBayar')
            ->select('BulanBayar', DB::raw('SUM(JumlahBayar) as total'))
            ->pluck('total', 'BulanBayar')
            ->toArray();

        $monthlyIncome = [];
        foreach ($monthsMapping as $dbMonth => $label) {
            $total = isset($paymentData[$dbMonth]) ? (float)$paymentData[$dbMonth] : 0.0;
            $monthlyIncome[$label] = $total / 1000000.0;
        }

        return view('dashboard', compact(
            'siswaAktifCount',
            'totalGuruCount',
            'sppTerkumpul',
            'sppBelumBayar',
            'pembayaranTerbaru',
            'tuntasCount',
            'remedialCount',
            'kelasSiswa',
            'monthlyIncome'
        ));
    }
}
