<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use Illuminate\Http\Request;

class GuruController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Staff::query();

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('Nama', 'like', "%{$search}%")
                  ->orWhere('NIY', 'like', "%{$search}%");
            });
        }

        $guru = $query->get();

        return view('guru.index', compact('guru'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'NIY' => 'required|string|max:10|unique:Staff,NIY',
            'Nama' => 'required|string|max:60',
            'TempatLahir' => 'required|string|max:30',
            'TanggalLahir' => 'required|date',
            'JenisKelamin' => 'required|string|max:2',
            'PendidikanTerakhir' => 'required|string|max:10',
            'Jabatan' => 'required|string|max:30',
            'NoHP' => 'required|string|max:13',
            'Alamat' => 'required|string|max:255',
        ]);

        Staff::create($validated);

        return redirect()->route('guru.index')->with('success', 'Guru berhasil ditambahkan.');
    }

    public function update(Request $request, $niy)
    {
        $guru = Staff::findOrFail($niy);

        $validated = $request->validate([
            'Nama' => 'required|string|max:60',
            'PendidikanTerakhir' => 'required|string|max:10',
            'Jabatan' => 'required|string|max:30',
            'NoHP' => 'required|string|max:13',
            'Alamat' => 'required|string|max:255',
        ]);

        $guru->update($validated);

        return redirect()->route('guru.index')->with('success', 'Data guru berhasil diubah.');
    }

    public function destroy($niy)
    {
        $guru = Staff::findOrFail($niy);
        $guru->delete();

        return redirect()->route('guru.index')->with('success', 'Guru berhasil dihapus.');
    }
}
