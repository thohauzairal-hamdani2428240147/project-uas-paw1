<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\OrangTua;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $kelasId = $request->input('kelas_id');

        $query = Siswa::with(['kelas', 'orangTua']);

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('Nama', 'like', "%{$search}%")
                  ->orWhere('NISN', 'like', "%{$search}%");
            });
        }

        if ($kelasId && $kelasId != 'Semua Kelas') {
            $query->where('KdKelas', $kelasId);
        }

        $siswa = $query->get();
        $kelas = Kelas::all();
        
        // Auto-generate next OT code for view convenience
        $lastOtCode = OrangTua::max('KdOrangTua');
        $nextOtNumber = $lastOtCode ? (int)substr($lastOtCode, 2) + 1 : 1;
        $nextOtCode = 'OT' . str_pad($nextOtNumber, 4, '0', STR_PAD_LEFT);

        return view('siswa.index', compact('siswa', 'kelas', 'nextOtCode'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'NISN' => 'required|string|size:10|unique:Siswa,NISN',
            'Nama' => 'required|string|max:60',
            'JenisKelamin' => 'required|string|max:2',
            'TempatLahir' => 'required|string|max:25',
            'TanggalLahir' => 'required|date',
            'Agama' => 'required|string|max:25',
            'Kewarganegaraan' => 'required|string|max:20',
            'AnakKeBRP' => 'required|integer',
            'JumlahSaudaraKandung' => 'required|integer',
            'JumlahSaudaraTiri' => 'nullable|integer',
            'AnakYatimPiatu' => 'nullable|string|max:20',
            'JurusanPilihan' => 'nullable|string|max:30',
            'UkuranBajuBatik' => 'required|string|max:2',
            'UkuranBajuOlahraga' => 'required|string|max:2',
            'PenerimaBantuan' => 'nullable|string|max:50',
            'Alamat' => 'required|string|max:255',
            'NoHP' => 'required|string|max:13',
            'TinggalBersama' => 'required|string|max:30',
            'AsalSekolahSMP' => 'required|string|max:50',
            'TahunLulusSMP' => 'required|string|size:4',
            'KdKelas' => 'required|exists:Kelas,KdKelas',
            
            // Parent info
            'KdOrangTua' => 'required|string|max:6',
            'NamaIbu' => 'required|string|max:60',
            'TempatLahirIbu' => 'required|string|max:30',
            'TanggalLahirIbu' => 'required|date',
            'AgamaIbu' => 'required|string|max:25',
            'KewarganegaraanIbu' => 'required|string|max:20',
            'PekerjaanIbu' => 'required|string|max:30',
            'AlamatIbu' => 'required|string|max:255',
            'NamaAyah' => 'nullable|string|max:60',
            'PekerjaanAyah' => 'nullable|string|max:30',
            'AlamatAyah' => 'nullable|string|max:255',
        ], [
            'NISN.unique' => 'NISN tersebut sudah terdaftar di sistem. Silakan gunakan NISN siswa lainnya.',
            'NISN.size' => 'NISN harus terdiri dari tepat 10 digit angka.',
            'NISN.required' => 'NISN wajib diisi.',
            'TahunLulusSMP.size' => 'Tahun lulus SMP harus terdiri dari 4 digit angka.',
        ], [
            'NISN' => 'NISN',
            'Nama' => 'Nama Siswa',
            'JenisKelamin' => 'Jenis Kelamin',
            'TahunLulusSMP' => 'Tahun Lulus SMP',
        ]);

        // 1. Create or Find Parent info
        $parent = OrangTua::updateOrCreate(
            ['KdOrangTua' => $validated['KdOrangTua']],
            [
                'NamaAyah' => $request->input('NamaAyah'),
                'PekerjaanAyah' => $request->input('PekerjaanAyah'),
                'AlamatAyah' => $request->input('AlamatAyah') ?? $validated['Alamat'] ?? null,
                'NamaIbu' => $validated['NamaIbu'],
                'TempatLahirIbu' => $validated['TempatLahirIbu'],
                'TanggalLahirIbu' => $validated['TanggalLahirIbu'],
                'AgamaIbu' => $validated['AgamaIbu'],
                'KewarganegaraanIbu' => $validated['KewarganegaraanIbu'],
                'PekerjaanIbu' => $validated['PekerjaanIbu'],
                'AlamatIbu' => $validated['AlamatIbu'],
            ]
        );

        // 2. Create Student
        Siswa::create([
            'NISN' => $validated['NISN'],
            'Nama' => $validated['Nama'],
            'JenisKelamin' => $validated['JenisKelamin'],
            'TempatLahir' => $validated['TempatLahir'],
            'TanggalLahir' => $validated['TanggalLahir'],
            'Agama' => $validated['Agama'],
            'Kewarganegaraan' => $validated['Kewarganegaraan'],
            'AnakKeBRP' => $validated['AnakKeBRP'],
            'JumlahSaudaraKandung' => $validated['JumlahSaudaraKandung'],
            'JumlahSaudaraTiri' => $request->input('JumlahSaudaraTiri') ?? 0,
            'AnakYatimPiatu' => $request->input('AnakYatimPiatu') ?? 'Tidak',
            'JurusanPilihan' => $request->input('JurusanPilihan'),
            'UkuranBajuBatik' => $validated['UkuranBajuBatik'],
            'UkuranBajuOlahraga' => $validated['UkuranBajuOlahraga'],
            'PenerimaBantuan' => $request->input('PenerimaBantuan'),
            'Alamat' => $validated['Alamat'],
            'NoHP' => $validated['NoHP'],
            'TinggalBersama' => $validated['TinggalBersama'],
            'AsalSekolahSMP' => $validated['AsalSekolahSMP'],
            'TahunLulusSMP' => $validated['TahunLulusSMP'],
            'KdKelas' => $validated['KdKelas'],
            'KdOrangTua' => $parent->KdOrangTua,
        ]);

        return redirect()->route('siswa.index')->with('success', 'Siswa berhasil ditambahkan.');
    }

    public function update(Request $request, $nisn)
    {
        $siswa = Siswa::findOrFail($nisn);

        $validated = $request->validate([
            'Nama' => 'required|string|max:60',
            'JenisKelamin' => 'required|string|max:2',
            'TempatLahir' => 'required|string|max:25',
            'TanggalLahir' => 'required|date',
            'Agama' => 'required|string|max:25',
            'Kewarganegaraan' => 'required|string|max:20',
            'Alamat' => 'required|string|max:255',
            'NoHP' => 'required|string|max:13',
            'AsalSekolahSMP' => 'required|string|max:50',
            'KdKelas' => 'required|exists:Kelas,KdKelas',
        ]);

        $siswa->update($validated);

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil diubah.');
    }

    public function destroy($nisn)
    {
        $siswa = Siswa::findOrFail($nisn);
        $siswa->delete();

        return redirect()->route('siswa.index')->with('success', 'Siswa berhasil dihapus.');
    }
}
