<?php

namespace App\Http\Controllers;

use App\Models\MataPelajaran;
use Illuminate\Http\Request;

class MataPelajaranController extends Controller
{
    public function index()
    {
        $mapel = MataPelajaran::all();
        return view('mapel.index', compact('mapel'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'KdMapel' => 'required|string|max:10|unique:MataPelajaran,KdMapel',
            'NamaMapel' => 'required|string|max:30',
            'NamaBuku' => 'nullable|string|max:50',
            'KKM' => 'required|numeric|min:0|max:100',
        ]);

        MataPelajaran::create($validated);

        return redirect()->route('mapel.index')->with('success', 'Mata pelajaran berhasil ditambahkan.');
    }

    public function update(Request $request, $kdMapel)
    {
        $mapel = MataPelajaran::findOrFail($kdMapel);

        $validated = $request->validate([
            'NamaMapel' => 'required|string|max:30',
            'NamaBuku' => 'nullable|string|max:50',
            'KKM' => 'required|numeric|min:0|max:100',
        ]);

        $mapel->update($validated);

        return redirect()->route('mapel.index')->with('success', 'Mata pelajaran berhasil diubah.');
    }

    public function destroy($kdMapel)
    {
        $mapel = MataPelajaran::findOrFail($kdMapel);
        $mapel->delete();

        return redirect()->route('mapel.index')->with('success', 'Mata pelajaran berhasil dihapus.');
    }
}
