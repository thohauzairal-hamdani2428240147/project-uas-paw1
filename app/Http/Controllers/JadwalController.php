<?php

namespace App\Http\Controllers;

use App\Models\JadwalPelajaran;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\Staff;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function index(Request $request)
    {
        $kelasId = $request->input('kelas_id');
        $query = JadwalPelajaran::with(['kelas', 'mataPelajaran', 'staff']);

        if ($kelasId && $kelasId != 'Semua Kelas') {
            $query->where('KdKelas', $kelasId);
        }

        $jadwal = $query->orderByRaw("FIELD(Hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat')")
            ->orderBy('JamMulai', 'asc')
            ->get();
            
        $kelas = Kelas::all();
        $mapel = MataPelajaran::all();
        $guru = Staff::where('Jabatan', 'like', 'Guru%')->get();

        return view('jadwal.index', compact('jadwal', 'kelas', 'mapel', 'guru'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'KdJadwal' => 'required|string|max:6|unique:JadwalPelajaran,KdJadwal',
            'Hari' => 'required|string|max:10',
            'JamMulai' => 'required',
            'JamSelesai' => 'required',
            'KdStaff' => 'required|exists:Staff,NIY',
            'KdMapel' => 'required|exists:MataPelajaran,KdMapel',
            'KdKelas' => 'required|exists:Kelas,KdKelas',
        ]);

        // Standardize time formatting
        $validated['JamMulai'] = str_replace('.', ':', $validated['JamMulai']);
        $validated['JamSelesai'] = str_replace('.', ':', $validated['JamSelesai']);

        JadwalPelajaran::create($validated);

        return redirect()->route('jadwal.index')->with('success', 'Jadwal pelajaran berhasil ditambahkan.');
    }

    public function update(Request $request, $kdJadwal)
    {
        $jadwal = JadwalPelajaran::findOrFail($kdJadwal);

        $validated = $request->validate([
            'Hari' => 'required|string|max:10',
            'JamMulai' => 'required',
            'JamSelesai' => 'required',
            'KdStaff' => 'required|exists:Staff,NIY',
            'KdMapel' => 'required|exists:MataPelajaran,KdMapel',
            'KdKelas' => 'required|exists:Kelas,KdKelas',
        ]);

        $validated['JamMulai'] = str_replace('.', ':', $validated['JamMulai']);
        $validated['JamSelesai'] = str_replace('.', ':', $validated['JamSelesai']);

        $jadwal->update($validated);

        return redirect()->route('jadwal.index')->with('success', 'Jadwal pelajaran berhasil diubah.');
    }

    public function destroy($kdJadwal)
    {
        $jadwal = JadwalPelajaran::findOrFail($kdJadwal);
        $jadwal->delete();

        return redirect()->route('jadwal.index')->with('success', 'Jadwal pelajaran berhasil dihapus.');
    }
}
