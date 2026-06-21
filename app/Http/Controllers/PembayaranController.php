<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Siswa;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');

        $query = Pembayaran::with('siswa');

        if ($search) {
            $query->whereHas('siswa', function($q) use ($search) {
                $q->where('Nama', 'like', "%{$search}%")
                  ->orWhere('NISN', 'like', "%{$search}%");
            });
        }

        if ($status && $status != 'Semua Status') {
            if ($status == 'Lunas') {
                $query->whereNotNull('TglBayar')->where('MetodePembayaran', '!=', 'BelumBayar');
            } else {
                $query->where(function($q) {
                    $q->whereNull('TglBayar')->orWhere('MetodePembayaran', 'BelumBayar');
                });
            }
        }

        $pembayaran = $query->orderBy('KdPembayaran', 'desc')->get();
        $siswa = Siswa::all();

        // Calculate card values
        $totalTerkumpul = Pembayaran::whereNotNull('TglBayar')
            ->where('MetodePembayaran', '!=', 'BelumBayar')
            ->sum('JumlahBayar');
        $belumBayarCount = Pembayaran::where(function($q) {
            $q->whereNull('TglBayar')->orWhere('MetodePembayaran', 'BelumBayar');
        })->count();

        // Auto-generate next code
        $lastCode = Pembayaran::max('KdPembayaran');
        $nextNumber = $lastCode ? (int)substr($lastCode, 1) + 1 : 1;
        $nextCode = 'P' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);

        return view('pembayaran.index', compact(
            'pembayaran',
            'siswa',
            'totalTerkumpul',
            'belumBayarCount',
            'nextCode'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'KdPembayaran' => 'required|string|max:6|unique:Pembayaran,KdPembayaran',
            'NISN' => 'required|exists:Siswa,NISN',
            'BulanBayar' => 'required|string|max:15',
            'MetodePembayaran' => 'required|string|max:15',
            'JumlahBayar' => 'required|numeric',
        ]);

        $validated['TglBayar'] = $validated['MetodePembayaran'] !== 'BelumBayar' ? now()->format('Y-m-d') : null;

        Pembayaran::create($validated);

        return redirect()->route('pembayaran.index')->with('success', 'Pembayaran SPP berhasil dicatat.');
    }

    public function destroy($kdPembayaran)
    {
        $pembayaran = Pembayaran::findOrFail($kdPembayaran);
        $pembayaran->delete();

        return redirect()->route('pembayaran.index')->with('success', 'Transaksi pembayaran berhasil dihapus.');
    }
}
