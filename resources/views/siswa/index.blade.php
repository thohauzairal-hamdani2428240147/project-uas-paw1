@extends('layouts.app')

@section('title', 'Data Siswa')
@section('page_title', 'Data Siswa')

@section('content')
<div class="space-y-4">
    <!-- FilterSection -->
    <div class="space-y-4 mb-6">
        <form action="{{ route('siswa.index') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-center justify-between">
            <div class="relative w-full md:max-w-md">
                <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input name="search" value="{{ request('search') }}" class="w-full pl-10 pr-4 py-2 bg-white border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Cari nama atau NISN..." type="text"/>
            </div>
            <div class="flex flex-col sm:flex-row gap-4 w-full md:w-auto items-center">
                <select name="kelas_id" onchange="this.form.submit()" class="w-full sm:w-48 px-4 py-2 bg-white border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="Semua Kelas">Semua Kelas</option>
                    @foreach($kelas as $k)
                        <option value="{{ $k->KdKelas }}" {{ request('kelas_id') == $k->KdKelas ? 'selected' : '' }}>{{ $k->NamaKelas }}</option>
                    @endforeach
                </select>
                <button type="button" class="w-full sm:w-auto px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-semibold flex items-center justify-center gap-2 transition-colors shadow" id="openModalBtn">
                    <i class="fa-solid fa-plus"></i> Tambah Siswa
                </button>
            </div>
        </form>
    </div>
    
    <!-- TableContainer -->
    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200">
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-wider">NISN</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-wider">Nama Lengkap</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-wider">Kelas</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-wider">J/K</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-wider">Asal Sekolah</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-wider">Ibu Kandung</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse($siswa as $s)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-3 font-medium text-slate-600">{{ $s->NISN }}</td>
                            <td class="px-6 py-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 text-[10px] font-bold">
                                        {{ strtoupper(substr($s->Nama, 0, 1)) }}
                                    </div>
                                    <span class="font-semibold text-slate-800">{{ $s->Nama }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-3">
                                <span class="px-2.5 py-0.5 bg-blue-50 text-blue-600 rounded-full text-[10px] font-bold border border-blue-100">{{ $s->kelas->NamaKelas ?? $s->KdKelas }}</span>
                            </td>
                            <td class="px-6 py-3 text-slate-600">{{ $s->JenisKelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                            <td class="px-6 py-3 text-slate-600">{{ $s->AsalSekolahSMP }}</td>
                            <td class="px-6 py-3 text-slate-600">{{ $s->orangTua->NamaIbu ?? '-' }}</td>
                            <td class="px-6 py-3">
                                <div class="flex items-center gap-2">
                                    <!-- Edit Trigger Form (Simulated for visual match) -->
                                    <button class="p-1.5 text-slate-400 hover:text-blue-600 transition-colors" onclick="openEditModal({{ json_encode($s) }})">
                                        <i class="fa-solid fa-pen"></i>
                                    </button>
                                    <form action="{{ route('siswa.destroy', $s->NISN) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus siswa ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 text-slate-400 hover:text-red-500 transition-colors">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-8 text-slate-400 text-xs">Belum ada data siswa.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- AddStudentModal -->
<div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm hidden" id="addStudentModal">
    <div class="bg-white rounded-2xl w-full max-w-2xl overflow-hidden shadow-2xl transition-all scale-95 max-h-[90vh] flex flex-col" id="modalContent">
        <!-- Modal Header -->
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <h3 class="text-base font-bold text-slate-800">Daftarkan Siswa Baru</h3>
            <button class="p-1 text-slate-400 hover:text-slate-600 transition-colors" id="closeModalBtn">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>
        <!-- Modal Body -->
        <form action="{{ route('siswa.store') }}" method="POST" class="overflow-y-auto p-6 space-y-6">
            @csrf
            
            <!-- SECTION 1: Personal Info -->
            <div>
                <h4 class="text-xs font-bold text-blue-600 uppercase border-b border-slate-100 pb-2 mb-4">I. DATA PRIBADI SISWA</h4>
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-slate-500 uppercase">NISN</label>
                        <input name="NISN" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="0102806210" required type="text" maxlength="10"/>
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-slate-500 uppercase">Nama Lengkap</label>
                        <input name="Nama" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Nama lengkap siswa" required type="text"/>
                    </div>
                </div>
                
                <div class="grid grid-cols-3 gap-4 mt-3">
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-slate-500 uppercase">Jenis Kelamin</label>
                        <select name="JenisKelamin" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-slate-500 uppercase">Tempat Lahir</label>
                        <input name="TempatLahir" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent" required type="text"/>
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-slate-500 uppercase">Tanggal Lahir</label>
                        <input name="TanggalLahir" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent" required type="date"/>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 mt-3">
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-slate-500 uppercase">Agama</label>
                        <input name="Agama" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent" value="Islam" required type="text"/>
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-slate-500 uppercase">Kewarganegaraan</label>
                        <input name="Kewarganegaraan" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent" value="Indonesia" required type="text"/>
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-4 mt-3">
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-slate-500 uppercase">Anak Ke</label>
                        <input name="AnakKeBRP" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent" required type="number"/>
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-slate-500 uppercase">Saudara Kandung</label>
                        <input name="JumlahSaudaraKandung" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent" required type="number"/>
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-slate-500 uppercase">Saudara Tiri</label>
                        <input name="JumlahSaudaraTiri" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent" value="0" type="number"/>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 mt-3">
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-slate-500 uppercase">Baju Batik</label>
                        <select name="UkuranBajuBatik" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="M">M</option>
                            <option value="L" selected>L</option>
                            <option value="XL">XL</option>
                        </select>
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-slate-500 uppercase">Baju Olahraga</label>
                        <select name="UkuranBajuOlahraga" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="M">M</option>
                            <option value="L" selected>L</option>
                            <option value="XL">XL</option>
                        </select>
                    </div>
                </div>

                <div class="space-y-1 mt-3">
                    <label class="text-[10px] font-bold text-slate-500 uppercase">Penerima Bantuan (Opsional)</label>
                    <input name="PenerimaBantuan" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Contoh: PIP - Anggun Lestari" type="text"/>
                </div>

                <div class="grid grid-cols-2 gap-4 mt-3">
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-slate-500 uppercase">No. Handphone</label>
                        <input name="NoHP" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="08..." required type="text"/>
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-slate-500 uppercase">Tinggal Bersama</label>
                        <input name="TinggalBersama" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent" value="Orang Tua" required type="text"/>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 mt-3">
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-slate-500 uppercase">Asal Sekolah (SMP)</label>
                        <input name="AsalSekolahSMP" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Contoh: MTsS Assalam" required type="text"/>
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-slate-500 uppercase">Tahun Lulus SMP</label>
                        <input name="TahunLulusSMP" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="2026" required type="text" maxlength="4"/>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 mt-3">
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-slate-500 uppercase">Kelas Penempatan</label>
                        <select name="KdKelas" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @foreach($kelas as $k)
                                <option value="{{ $k->KdKelas }}">{{ $k->NamaKelas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-slate-500 uppercase">Alamat Siswa</label>
                        <input name="Alamat" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Alamat lengkap" required type="text"/>
                    </div>
                </div>
            </div>

            <!-- SECTION 2: Parents Info -->
            <div>
                <h4 class="text-xs font-bold text-emerald-600 uppercase border-b border-slate-100 pb-2 mb-4">II. DATA ORANG TUA / WALI</h4>
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-slate-500 uppercase">Kode Orang Tua</label>
                        <input name="KdOrangTua" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-slate-50" value="{{ $nextOtCode }}" readonly required type="text"/>
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-slate-500 uppercase">Nama Ibu Kandung</label>
                        <input name="NamaIbu" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent" required type="text"/>
                    </div>
                </div>
                
                <div class="grid grid-cols-3 gap-4 mt-3">
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-slate-500 uppercase">Tempat Lahir Ibu</label>
                        <input name="TempatLahirIbu" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent" required type="text"/>
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-slate-500 uppercase">Tgl Lahir Ibu</label>
                        <input name="TanggalLahirIbu" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent" required type="date"/>
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-slate-500 uppercase">Agama Ibu</label>
                        <input name="AgamaIbu" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent" value="Islam" required type="text"/>
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-4 mt-3">
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-slate-500 uppercase">Kwn Ibu</label>
                        <input name="KewarganegaraanIbu" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent" value="Indonesia" required type="text"/>
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-slate-500 uppercase">Pekerjaan Ibu</label>
                        <input name="PekerjaanIbu" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Ibu Rumah Tangga" required type="text"/>
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-slate-500 uppercase">Alamat Ibu</label>
                        <input name="AlamatIbu" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Alamat Ibu" required type="text"/>
                    </div>
                </div>

                <div class="border-t border-slate-100 my-4 pt-4">
                    <h5 class="text-[10px] font-bold text-slate-400 uppercase mb-3">Informasi Ayah (Opsional)</h5>
                    <div class="grid grid-cols-3 gap-4">
                        <div class="space-y-1">
                            <label class="text-[10px] font-bold text-slate-500 uppercase">Nama Ayah</label>
                            <input name="NamaAyah" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent" type="text"/>
                        </div>
                        <div class="space-y-1">
                            <label class="text-[10px] font-bold text-slate-500 uppercase">Pekerjaan Ayah</label>
                            <input name="PekerjaanAyah" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent" type="text"/>
                        </div>
                        <div class="space-y-1">
                            <label class="text-[10px] font-bold text-slate-500 uppercase">Alamat Ayah</label>
                            <input name="AlamatAyah" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent" type="text"/>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Buttons -->
            <div class="pt-4 flex items-center justify-end gap-3 border-t">
                <button class="px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100 rounded-lg transition-colors" id="cancelModalBtn" type="button">Batal</button>
                <button class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-semibold transition-colors shadow-lg shadow-blue-500/20" type="submit">Daftarkan Siswa</button>
            </div>
        </form>
    </div>
</div>

<!-- EditStudentModal -->
<div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm hidden" id="editStudentModal">
    <div class="bg-white rounded-2xl w-full max-w-lg overflow-hidden shadow-2xl transition-all scale-95" id="editModalContent">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <h3 class="text-base font-bold text-slate-800">Edit Data Siswa</h3>
            <button class="p-1 text-slate-400 hover:text-slate-600 transition-colors" onclick="closeEditModal()">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>
        <form id="editForm" method="POST" class="p-6 space-y-4">
            @csrf
            @method('PUT')
            <div class="space-y-1">
                <label class="text-[10px] font-bold text-slate-500 uppercase">Nama Lengkap</label>
                <input name="Nama" id="editNama" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent" required type="text"/>
            </div>
            
            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-1">
                    <label class="text-[10px] font-bold text-slate-500 uppercase">Jenis Kelamin</label>
                    <select name="JenisKelamin" id="editJenisKelamin" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                </div>
                <div class="space-y-1">
                    <label class="text-[10px] font-bold text-slate-500 uppercase">Kelas</label>
                    <select name="KdKelas" id="editKdKelas" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        @foreach($kelas as $k)
                            <option value="{{ $k->KdKelas }}">{{ $k->NamaKelas }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-1">
                    <label class="text-[10px] font-bold text-slate-500 uppercase">Tempat Lahir</label>
                    <input name="TempatLahir" id="editTempatLahir" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent" required type="text"/>
                </div>
                <div class="space-y-1">
                    <label class="text-[10px] font-bold text-slate-500 uppercase">Tanggal Lahir</label>
                    <input name="TanggalLahir" id="editTanggalLahir" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent" required type="date"/>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-1">
                    <label class="text-[10px] font-bold text-slate-500 uppercase">Agama</label>
                    <input name="Agama" id="editAgama" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent" required type="text"/>
                </div>
                <div class="space-y-1">
                    <label class="text-[10px] font-bold text-slate-500 uppercase">Kewarganegaraan</label>
                    <input name="Kewarganegaraan" id="editKewarganegaraan" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent" required type="text"/>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-1">
                    <label class="text-[10px] font-bold text-slate-500 uppercase">No. Handphone</label>
                    <input name="NoHP" id="editNoHP" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent" required type="text"/>
                </div>
                <div class="space-y-1">
                    <label class="text-[10px] font-bold text-slate-500 uppercase">Asal SMP</label>
                    <input name="AsalSekolahSMP" id="editAsalSekolahSMP" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent" required type="text"/>
                </div>
            </div>

            <div class="space-y-1">
                <label class="text-[10px] font-bold text-slate-500 uppercase">Alamat Lengkap</label>
                <textarea name="Alamat" id="editAlamat" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none" rows="2" required></textarea>
            </div>

            <div class="pt-4 flex items-center justify-end gap-3 border-t">
                <button class="px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100 rounded-lg transition-colors" onclick="closeEditModal()" type="button">Batal</button>
                <button class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-semibold transition-colors shadow-lg shadow-blue-500/20" type="submit">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const modal = document.getElementById('addStudentModal');
    const modalContent = document.getElementById('modalContent');
    const openBtn = document.getElementById('openModalBtn');
    const closeBtn = document.getElementById('closeModalBtn');
    const cancelBtn = document.getElementById('cancelModalBtn');

    function toggleModal(show) {
        if (show) {
            modal.classList.remove('hidden');
            setTimeout(() => modalContent.classList.remove('scale-95'), 10);
        } else {
            modalContent.classList.add('scale-95');
            setTimeout(() => modal.classList.add('hidden'), 150);
        }
    }

    openBtn.addEventListener('click', () => toggleModal(true));
    closeBtn.addEventListener('click', () => toggleModal(false));
    cancelBtn.addEventListener('click', () => toggleModal(false));

    modal.addEventListener('click', (e) => {
        if (e.target === modal) toggleModal(false);
    });

    // Edit Modal Functions
    const editModal = document.getElementById('editStudentModal');
    const editModalContent = document.getElementById('editModalContent');
    const editForm = document.getElementById('editForm');

    function openEditModal(siswa) {
        editForm.action = `/siswa/${siswa.NISN}`;
        document.getElementById('editNama').value = siswa.Nama;
        document.getElementById('editJenisKelamin').value = siswa.JenisKelamin;
        document.getElementById('editKdKelas').value = siswa.KdKelas;
        document.getElementById('editTempatLahir').value = siswa.TempatLahir;
        document.getElementById('editTanggalLahir').value = siswa.TanggalLahir;
        document.getElementById('editAgama').value = siswa.Agama;
        document.getElementById('editKewarganegaraan').value = siswa.Kewarganegaraan;
        document.getElementById('editNoHP').value = siswa.NoHP;
        document.getElementById('editAsalSekolahSMP').value = siswa.AsalSekolahSMP;
        document.getElementById('editAlamat').value = siswa.Alamat;

        editModal.classList.remove('hidden');
        setTimeout(() => editModalContent.classList.remove('scale-95'), 10);
    }

    function closeEditModal() {
        editModalContent.classList.add('scale-95');
        setTimeout(() => editModal.classList.add('hidden'), 150);
    }
</script>
@endsection
