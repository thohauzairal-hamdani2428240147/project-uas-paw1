@extends('layouts.app')

@section('title', 'Manajemen Kelas')
@section('page_title', 'Manajemen Kelas')

@section('content')
<div class="space-y-4">
    <!-- Header Actions -->
    <div class="flex justify-end mb-8">
        <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center gap-2 text-sm font-semibold shadow transition-all" id="btnTambahKelas">
            <i class="w-4 h-4 fa-solid fa-plus"></i> Tambah Kelas
        </button>
    </div>

    <!-- Class Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($kelas as $k)
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden hover:shadow-md transition-shadow">
                <div class="p-5">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="text-lg font-bold text-slate-800">{{ $k->NamaKelas }}</h3>
                            <p class="text-xs text-slate-400">Kode: {{ $k->KdKelas }}</p>
                        </div>
                        <span class="bg-blue-50 text-blue-600 text-[10px] font-bold px-2 py-1 rounded">Jurusan: {{ $k->KdJurusan }}</span>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <div class="flex justify-between text-[11px] mb-1">
                                <span class="text-slate-400">Siswa Terdaftar</span>
                                <span class="text-slate-800 font-semibold">{{ $k->siswa_count }} / 32</span>
                            </div>
                            <div class="w-full bg-slate-100 rounded-full h-1.5">
                                <div class="bg-blue-500 h-1.5 rounded-full" style="width: {{ ($k->siswa_count / 32) * 100 }}%"></div>
                            </div>
                        </div>
                        <div class="flex justify-between items-center text-xs">
                            <span class="text-slate-400">Wali Kelas</span>
                            <span class="text-slate-800 font-semibold truncate max-w-[150px]">{{ $k->wali_kelas }}</span>
                        </div>
                    </div>
                </div>
                <div class="flex border-t border-slate-100 bg-slate-50">
                    <button class="flex-1 py-3 text-xs font-semibold text-slate-500 hover:bg-slate-100 flex items-center justify-center gap-2 border-r border-slate-100 transition-colors" onclick="openEditModal({{ json_encode($k) }})">
                        <i class="w-3.5 h-3.5 fa-solid fa-pen"></i> Edit
                    </button>
                    <form action="{{ route('kelas.destroy', $k->KdKelas) }}" method="POST" class="flex-shrink-0" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kelas ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-12 py-3 h-full text-red-500 hover:bg-red-50 flex items-center justify-center transition-colors">
                            <i class="w-3.5 h-3.5 fa-solid fa-trash-can"></i>
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <p class="text-slate-400 text-xs py-8 text-center col-span-3">Belum ada kelas terdaftar.</p>
        @endforelse
    </div>
</div>

<!-- Modal Tambah Kelas -->
<div class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-sm hidden" id="modalTambah">
    <!-- Modal Content -->
    <div class="relative bg-white w-full max-w-md rounded-xl shadow-2xl overflow-hidden animate-in fade-in zoom-in duration-200" id="addModalContent">
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
            <h3 class="text-sm font-bold text-slate-800">Tambah Kelas Baru</h3>
            <button class="text-slate-400 hover:text-slate-600 transition-colors" id="btnCloseModal">
                <i class="w-4 h-4 fa-solid fa-xmark text-xl"></i>
            </button>
        </div>
        <form action="{{ route('kelas.store') }}" method="POST" class="p-6">
            @csrf
            <div class="space-y-4 mb-6">
                <div>
                    <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1.5">Kode Kelas</label>
                    <input name="KdKelas" class="w-full text-sm border-slate-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition-all" placeholder="Contoh: 10AK" required type="text" maxlength="6"/>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1.5">Nama Kelas</label>
                    <input name="NamaKelas" class="w-full text-sm border-slate-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition-all" placeholder="Contoh: X Akuntansi 1" required type="text"/>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1.5">Jurusan</label>
                    <select name="KdJurusan" class="w-full text-sm border-slate-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition-all">
                        @foreach($jurusan as $j)
                            <option value="{{ $j->KdJurusan }}">{{ $j->NamaJurusan }} ({{ $j->KdJurusan }})</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="flex justify-end gap-2 pt-2 border-t">
                <button class="px-4 py-2 text-xs font-semibold text-slate-500 hover:bg-slate-50 rounded-lg transition-colors border border-slate-200" id="btnBatal" type="button">
                    Batal
                </button>
                <button class="px-4 py-2 text-xs font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-all shadow-lg shadow-blue-600/20" type="submit">
                    Buat Kelas
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Kelas -->
<div class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-sm hidden" id="modalEdit">
    <div class="relative bg-white w-full max-w-md rounded-xl shadow-2xl overflow-hidden animate-in fade-in zoom-in duration-200" id="editModalContent">
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
            <h3 class="text-sm font-bold text-slate-800">Edit Kelas</h3>
            <button class="text-slate-400 hover:text-slate-600 transition-colors" onclick="closeEditModal()">
                <i class="w-4 h-4 fa-solid fa-xmark text-xl"></i>
            </button>
        </div>
        <form id="editForm" method="POST" class="p-6">
            @csrf
            @method('PUT')
            <div class="space-y-4 mb-6">
                <div>
                    <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1.5">Nama Kelas</label>
                    <input name="NamaKelas" id="editNamaKelas" class="w-full text-sm border-slate-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition-all" required type="text"/>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1.5">Jurusan</label>
                    <select name="KdJurusan" id="editKdJurusan" class="w-full text-sm border-slate-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition-all">
                        @foreach($jurusan as $j)
                            <option value="{{ $j->KdJurusan }}">{{ $j->NamaJurusan }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="flex justify-end gap-2 pt-2 border-t">
                <button class="px-4 py-2 text-xs font-semibold text-slate-500 hover:bg-slate-50 rounded-lg transition-colors border border-slate-200" onclick="closeEditModal()" type="button">
                    Batal
                </button>
                <button class="px-4 py-2 text-xs font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-all shadow-lg shadow-blue-600/20" type="submit">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const modalTambah = document.getElementById('modalTambah');
    const addModalContent = document.getElementById('addModalContent');
    const btnTambah = document.getElementById('btnTambahKelas');
    const btnClose = document.getElementById('btnCloseModal');
    const btnBatal = document.getElementById('btnBatal');

    const toggleAddModal = (show) => {
        if (show) {
            modalTambah.classList.remove('hidden');
            setTimeout(() => addModalContent.classList.remove('scale-95'), 10);
        } else {
            addModalContent.classList.add('scale-95');
            setTimeout(() => modalTambah.classList.add('hidden'), 150);
        }
    };

    btnTambah.addEventListener('click', () => toggleAddModal(true));
    btnClose.addEventListener('click', () => toggleAddModal(false));
    btnBatal.addEventListener('click', () => toggleAddModal(false));

    modalTambah.addEventListener('click', (e) => {
        if (e.target === modalTambah) toggleAddModal(false);
    });

    // Edit Modal Logic
    const modalEdit = document.getElementById('modalEdit');
    const editModalContent = document.getElementById('editModalContent');
    const editForm = document.getElementById('editForm');

    function openEditModal(kelas) {
        editForm.action = `/kelas/${kelas.KdKelas}`;
        document.getElementById('editNamaKelas').value = kelas.NamaKelas;
        document.getElementById('editKdJurusan').value = kelas.KdJurusan;

        modalEdit.classList.remove('hidden');
        setTimeout(() => editModalContent.classList.remove('scale-95'), 10);
    }

    function closeEditModal() {
        editModalContent.classList.add('scale-95');
        setTimeout(() => modalEdit.classList.add('hidden'), 150);
    }
</script>
@endsection
