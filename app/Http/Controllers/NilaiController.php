<?php

namespace App\Http\Controllers;

use App\Models\Nilai;
use App\Models\Siswa;
use App\Models\MataPelajaran;
use Illuminate\Http\Request;

class NilaiController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $semester = $request->input('semester');

        $query = Nilai::with(['siswa', 'mataPelajaran']);

        if ($search) {
            $query->whereHas('siswa', function($q) use ($search) {
                $q->where('Nama', 'like', "%{$search}%")
                  ->orWhere('NISN', 'like', "%{$search}%");
            });
        }

        if ($semester && $semester != 'Semua Semester') {
            $query->where('Semester', $semester);
        }

        $nilai = $query->get();
        $siswa = Siswa::all();
        $mapel = MataPelajaran::all();

        return view('nilai.index', compact('nilai', 'siswa', 'mapel'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'NISN' => 'required|exists:Siswa,NISN',
            'KdMapel' => 'required|exists:MataPelajaran,KdMapel',
            'Semester' => 'required|string|max:10',
            'nilaiUTS' => 'required|numeric|min:0|max:100',
            'nilaiUAS' => 'required|numeric|min:0|max:100',
            'nilaiTugas' => 'required|numeric|min:0|max:100',
        ]);

        // Calculate Nilai Akhir: 30% Tugas + 30% UTS + 40% UAS
        $nilaiAkhir = (0.30 * $validated['nilaiTugas']) + (0.30 * $validated['nilaiUTS']) + (0.40 * $validated['nilaiUAS']);
        $validated['nilaiAkhir'] = round($nilaiAkhir, 2);

        // Determine Keterangan based on Mapel KKM
        $mapelItem = MataPelajaran::findOrFail($validated['KdMapel']);
        $validated['Keterangan'] = $validated['nilaiAkhir'] >= $mapelItem->KKM ? 'Tuntas' : 'Remedial';

        // Check if grade already exists for this composite PK
        $exists = Nilai::where('NISN', $validated['NISN'])
            ->where('KdMapel', $validated['KdMapel'])
            ->where('Semester', $validated['Semester'])
            ->exists();

        if ($exists) {
            // Update instead of insert
            Nilai::where('NISN', $validated['NISN'])
                ->where('KdMapel', $validated['KdMapel'])
                ->where('Semester', $validated['Semester'])
                ->update([
                    'nilaiUTS' => $validated['nilaiUTS'],
                    'nilaiUAS' => $validated['nilaiUAS'],
                    'nilaiTugas' => $validated['nilaiTugas'],
                    'nilaiAkhir' => $validated['nilaiAkhir'],
                    'Keterangan' => $validated['Keterangan']
                ]);
        } else {
            Nilai::create($validated);
        }

        return redirect()->route('nilai.index')->with('success', 'Nilai siswa berhasil dicatat.');
    }

    public function destroy(Request $request)
    {
        $nisn = $request->input('nisn');
        $kdMapel = $request->input('kd_mapel');
        $semester = $request->input('semester');

        Nilai::where('NISN', $nisn)
            ->where('KdMapel', $kdMapel)
            ->where('Semester', $semester)
            ->delete();

        return redirect()->route('nilai.index')->with('success', 'Data nilai berhasil dihapus.');
    }
}
