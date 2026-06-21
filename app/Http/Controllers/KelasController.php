<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Jurusan;
use App\Models\Staff;
use App\Models\JadwalPelajaran;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::with(['jurusan', 'siswa', 'jadwalPelajaran.staff'])->get();
        $jurusan = Jurusan::all();
        $guru = Staff::where('Jabatan', 'like', 'Guru%')->get();

        // Map a simulated Wali Kelas for visual completeness based on JadwalPelajaran,
        // or a default from staff if no jadwal exists yet.
        foreach ($kelas as $k) {
            $jadwal = $k->jadwalPelajaran->first();
            $k->wali_kelas = $jadwal ? $jadwal->staff->Nama : 'Sri Sari Alam, S.Pd.';
        }

        return view('kelas.index', compact('kelas', 'jurusan', 'guru'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'KdKelas' => 'required|string|max:6|unique:Kelas,KdKelas',
            'NamaKelas' => 'required|string|max:40',
            'KdJurusan' => 'required|exists:Jurusan,KdJurusan',
        ]);

        Kelas::create($validated);

        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil ditambahkan.');
    }

    public function update(Request $request, $kdKelas)
    {
        $kelas = Kelas::findOrFail($kdKelas);

        $validated = $request->validate([
            'NamaKelas' => 'required|string|max:40',
            'KdJurusan' => 'required|exists:Jurusan,KdJurusan',
        ]);

        $kelas->update($validated);

        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil diubah.');
    }

    public function destroy($kdKelas)
    {
        $kelas = Kelas::findOrFail($kdKelas);
        $kelas->delete();

        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil dihapus.');
    }
}
