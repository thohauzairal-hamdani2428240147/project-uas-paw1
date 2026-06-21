@extends('layouts.app')

@section('title', 'Nilai Siswa')
@section('page_title', 'Nilai Siswa')

@section('content')
@php
    $totalRecords = $nilai->count();
    $avgNilai = $totalRecords > 0 ? $nilai->avg('nilaiAkhir') : 0;
    $tuntasCount = $nilai->where('Keterangan', 'Tuntas')->count();
    $remedialCount = $nilai->where('Keterangan', 'Remedial')->count();
    $passRate = $totalRecords > 0 ? ($tuntasCount / $totalRecords) * 100 : 0;
@endphp

<div class="space-y-6">
    <!-- Academic Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Average Score Card -->
        <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden">
            <div class="absolute right-0 top-0 h-24 w-24 -mt-4 -mr-4 bg-blue-50 rounded-full flex items-center justify-center text-blue-200">
                <i class="fa-solid fa-graduation-cap text-5xl"></i>
            </div>
            <div class="relative">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Rata-Rata Nilai Akhir</p>
                <h3 class="text-2xl font-extrabold text-slate-800 mt-2">{{ number_format($avgNilai, 2) }}</h3>
                <p class="text-xs text-blue-600 font-semibold mt-2 flex items-center gap-1">
                    <i class="fa-solid fa-calculator"></i>
                    Dari {{ $totalRecords }} entri nilai
                </p>
            </div>
        </div>

        <!-- Passing Rate Card -->
        <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden">
            <div class="absolute right-0 top-0 h-24 w-24 -mt-4 -mr-4 bg-emerald-50 rounded-full flex items-center justify-center text-emerald-200">
                <i class="fa-solid fa-circle-check text-5xl"></i>
            </div>
            <div class="relative">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Persentase Kelulusan (KKM)</p>
                <h3 class="text-2xl font-extrabold text-slate-800 mt-2">{{ number_format($passRate, 1) }}%</h3>
                <p class="text-xs text-emerald-600 font-semibold mt-2 flex items-center gap-1">
                    <i class="fa-solid fa-thumbs-up"></i>
                    {{ $tuntasCount }} siswa dinyatakan tuntas
                </p>
            </div>
        </div>

        <!-- Remedial Card -->
        <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden">
            <div class="absolute right-0 top-0 h-24 w-24 -mt-4 -mr-4 bg-rose-50 rounded-full flex items-center justify-center text-rose-200">
                <i class="fa-solid fa-user-pen text-5xl"></i>
            </div>
            <div class="relative">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Siswa Remedial</p>
                <h3 class="text-2xl font-extrabold text-slate-800 mt-2">{{ $remedialCount }} Siswa</h3>
                <p class="text-xs text-rose-600 font-semibold mt-2 flex items-center gap-1">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                    Perlu perbaikan nilai akademik
                </p>
            </div>
        </div>
    </div>

    <!-- Search & Filters -->
    <div class="bg-white rounded-xl border border-slate-200 p-4 shadow-sm">
        <form action="{{ route('nilai.index') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-center justify-between">
            <div class="relative w-full md:max-w-md">
                <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input name="search" value="{{ request('search') }}" class="w-full pl-10 pr-4 py-2 bg-white border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Cari nama siswa atau NISN..." type="text"/>
            </div>
            <div class="flex flex-col sm:flex-row gap-4 w-full md:w-auto items-center">
                <select name="semester" onchange="this.form.submit()" class="w-full sm:w-48 px-4 py-2 bg-white border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="Semua Semester" {{ request('semester') == 'Semua Semester' ? 'selected' : '' }}>Semua Semester</option>
                    <option value="Ganjil" {{ request('semester') == 'Ganjil' ? 'selected' : '' }}>Semester Ganjil</option>
                    <option value="Genap" {{ request('semester') == 'Genap' ? 'selected' : '' }}>Semester Genap</option>
                </select>
                <button type="button" class="w-full sm:w-auto px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-semibold flex items-center justify-center gap-2 transition-colors shadow" id="openModalBtn">
                    <i class="fa-solid fa-plus"></i> Input / Edit Nilai
                </button>
            </div>
        </form>
    </div>

    <!-- Table Grades -->
    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200">
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-wider">Siswa</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-wider">Kelas</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-wider">Mata Pelajaran</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-wider">Sem.</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-wider text-center">Tugas (30%)</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-wider text-center">UTS (30%)</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-wider text-center">UAS (40%)</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-wider text-center">Nilai Akhir</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-wider">Keterangan</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse($nilai as $n)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-3">
                                <div>
                                    <p class="font-semibold text-slate-800">{{ $n->siswa->Nama ?? 'Tidak Ditemukan' }}</p>
                                    <p class="text-[10px] text-slate-400">NISN: {{ $n->NISN }}</p>
                                </div>
                            </td>
                            <td class="px-6 py-3">
                                <span class="px-2 py-0.5 bg-slate-100 text-slate-600 rounded text-[10px] font-bold border border-slate-200">
                                    {{ $n->siswa->kelas->NamaKelas ?? ($n->siswa->KdKelas ?? '-') }}
                                </span>
                            </td>
                            <td class="px-6 py-3">
                                <div>
                                    <p class="font-semibold text-slate-700">{{ $n->mataPelajaran->NamaMapel ?? 'Tidak Ditemukan' }}</p>
                                    <p class="text-[10px] text-slate-400">KKM: {{ $n->mataPelajaran->KKM ?? '-' }}</p>
                                </div>
                            </td>
                            <td class="px-6 py-3 text-slate-600 font-medium">{{ $n->Semester }}</td>
                            <td class="px-6 py-3 text-center font-medium text-slate-600">{{ number_format($n->nilaiTugas, 1) }}</td>
                            <td class="px-6 py-3 text-center font-medium text-slate-600">{{ number_format($n->nilaiUTS, 1) }}</td>
                            <td class="px-6 py-3 text-center font-medium text-slate-600">{{ number_format($n->nilaiUAS, 1) }}</td>
                            <td class="px-6 py-3 text-center font-bold text-base {{ $n->Keterangan == 'Tuntas' ? 'text-emerald-600' : 'text-rose-600' }}">
                                {{ number_format($n->nilaiAkhir, 2) }}
                            </td>
                            <td class="px-6 py-3">
                                @if($n->Keterangan == 'Tuntas')
                                    <span class="px-2 py-0.5 bg-emerald-50 text-emerald-700 rounded-full text-[10px] font-bold border border-emerald-200 inline-flex items-center gap-1">
                                        <i class="fa-solid fa-circle-check"></i> Tuntas
                                    </span>
                                @else
                                    <span class="px-2 py-0.5 bg-rose-50 text-rose-700 rounded-full text-[10px] font-bold border border-rose-200 inline-flex items-center gap-1 animate-pulse">
                                        <i class="fa-solid fa-clock-rotate-left"></i> Remedial
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-3">
                                <div class="flex items-center gap-2">
                                    <button class="p-1.5 text-slate-400 hover:text-blue-600 transition-colors" onclick="openEditModal({{ json_encode($n) }})" title="Ubah Nilai">
                                        <i class="fa-solid fa-pen"></i>
                                    </button>
                                    <form action="{{ route('nilai.destroy') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data nilai ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="nisn" value="{{ $n->NISN }}">
                                        <input type="hidden" name="kd_mapel" value="{{ $n->KdMapel }}">
                                        <input type="hidden" name="semester" value="{{ $n->Semester }}">
                                        <button type="submit" class="p-1.5 text-slate-400 hover:text-red-500 transition-colors" title="Hapus Nilai">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center py-8 text-slate-400 text-xs">Belum ada data nilai siswa yang dicatat.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add/Edit Nilai Modal -->
<div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm hidden" id="addGradeModal">
    <div class="bg-white rounded-2xl w-full max-w-lg overflow-hidden shadow-2xl transition-all scale-95" id="modalContent">
        <!-- Modal Header -->
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <h3 class="text-base font-bold text-slate-800" id="modalTitle">Input Nilai Siswa</h3>
            <button class="p-1 text-slate-400 hover:text-slate-600 transition-colors" id="closeModalBtn">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>
        <!-- Modal Body -->
        <form action="{{ route('nilai.store') }}" method="POST" class="p-6 space-y-4" id="gradeForm">
            @csrf
            
            <div class="space-y-1">
                <label class="text-[10px] font-bold text-slate-500 uppercase">Pilih Siswa</label>
                <select name="NISN" id="fieldNISN" required class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="" disabled selected>-- Pilih Siswa --</option>
                    @foreach($siswa as $s)
                        <option value="{{ $s->NISN }}">{{ $s->NISN }} - {{ $s->Nama }} ({{ $s->kelas->NamaKelas ?? $s->KdKelas }})</option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-1">
                    <label class="text-[10px] font-bold text-slate-500 uppercase">Mata Pelajaran</label>
                    <select name="KdMapel" id="fieldKdMapel" required class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="" disabled selected>-- Pilih Mapel --</option>
                        @foreach($mapel as $m)
                            <option value="{{ $m->KdMapel }}">{{ $m->NamaMapel }} (KKM: {{ $m->KKM }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="space-y-1">
                    <label class="text-[10px] font-bold text-slate-500 uppercase">Semester</label>
                    <select name="Semester" id="fieldSemester" required class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="Ganjil">Ganjil</option>
                        <option value="Genap">Genap</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-4">
                <div class="space-y-1">
                    <label class="text-[10px] font-bold text-slate-500 uppercase">Nilai Tugas (30%)</label>
                    <input name="nilaiTugas" id="fieldTugas" min="0" max="100" step="0.01" required placeholder="0.00" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent" type="number"/>
                </div>
                <div class="space-y-1">
                    <label class="text-[10px] font-bold text-slate-500 uppercase">Nilai UTS (30%)</label>
                    <input name="nilaiUTS" id="fieldUTS" min="0" max="100" step="0.01" required placeholder="0.00" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent" type="number"/>
                </div>
                <div class="space-y-1">
                    <label class="text-[10px] font-bold text-slate-500 uppercase">Nilai UAS (40%)</label>
                    <input name="nilaiUAS" id="fieldUAS" min="0" max="100" step="0.01" required placeholder="0.00" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent" type="number"/>
                </div>
            </div>

            <!-- Footer Buttons -->
            <div class="pt-4 flex items-center justify-end gap-3 border-t mt-6">
                <button class="px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100 rounded-lg transition-colors" id="cancelModalBtn" type="button">Batal</button>
                <button class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-semibold transition-colors shadow-lg shadow-blue-500/20" type="submit">Simpan Nilai</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const modal = document.getElementById('addGradeModal');
    const modalContent = document.getElementById('modalContent');
    const openBtn = document.getElementById('openModalBtn');
    const closeBtn = document.getElementById('closeModalBtn');
    const cancelBtn = document.getElementById('cancelModalBtn');
    
    const modalTitle = document.getElementById('modalTitle');
    const fieldNISN = document.getElementById('fieldNISN');
    const fieldKdMapel = document.getElementById('fieldKdMapel');
    const fieldSemester = document.getElementById('fieldSemester');
    const fieldTugas = document.getElementById('fieldTugas');
    const fieldUTS = document.getElementById('fieldUTS');
    const fieldUAS = document.getElementById('fieldUAS');

    function toggleModal(show) {
        if (show) {
            modal.classList.remove('hidden');
            setTimeout(() => modalContent.classList.remove('scale-95'), 10);
        } else {
            modalContent.classList.add('scale-95');
            setTimeout(() => modal.classList.add('hidden'), 150);
        }
    }

    openBtn.addEventListener('click', () => {
        // Reset form for clean insert
        modalTitle.textContent = "Input Nilai Siswa";
        fieldNISN.value = "";
        fieldNISN.disabled = false;
        fieldKdMapel.value = "";
        fieldKdMapel.disabled = false;
        fieldSemester.value = "Ganjil";
        fieldSemester.disabled = false;
        fieldTugas.value = "";
        fieldUTS.value = "";
        fieldUAS.value = "";
        toggleModal(true);
    });

    closeBtn.addEventListener('click', () => toggleModal(false));
    cancelBtn.addEventListener('click', () => toggleModal(false));

    modal.addEventListener('click', (e) => {
        if (e.target === modal) toggleModal(false);
    });

    function openEditModal(nilaiObj) {
        modalTitle.textContent = "Edit Nilai Siswa";
        
        fieldNISN.value = nilaiObj.NISN;
        // Since we want these fields to submit, but we might want them disabled to prevent changing composite primary keys, 
        // we can submit them as hidden fields or just keep them editable. The backend handle handles both update/create.
        // Let's keep them editable but matching the existing key so it replaces.
        fieldNISN.value = nilaiObj.NISN;
        fieldKdMapel.value = nilaiObj.KdMapel;
        fieldSemester.value = nilaiObj.Semester;
        
        fieldTugas.value = nilaiObj.nilaiTugas;
        fieldUTS.value = nilaiObj.nilaiUTS;
        fieldUAS.value = nilaiObj.nilaiUAS;

        toggleModal(true);
    }
</script>
@endsection
