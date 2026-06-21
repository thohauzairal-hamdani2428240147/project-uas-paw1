@extends('layouts.app')

@section('title', 'Mata Pelajaran')
@section('page_title', 'Mata Pelajaran')

@section('content')
<div class="space-y-6">
    <!-- Header Controls -->
    <div class="flex flex-col sm:flex-row justify-between items-center gap-4 bg-white p-4 rounded-xl border border-slate-200 shadow-sm">
        <div>
            <h3 class="text-sm font-bold text-slate-800">Daftar Mata Pelajaran Kejuruan & Umum</h3>
            <p class="text-xs text-slate-400">Total: {{ $mapel->count() }} Mata Pelajaran terdaftar</p>
        </div>
        <button type="button" class="w-full sm:w-auto px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-semibold flex items-center justify-center gap-2 transition-colors shadow" id="openModalBtn">
            <i class="fa-solid fa-plus"></i> Tambah Mapel
        </button>
    </div>

    <!-- Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($mapel as $m)
            <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm hover:shadow-md hover:border-blue-300 transition-all flex flex-col justify-between relative overflow-hidden group">
                <!-- Decorative background patch -->
                <div class="absolute right-0 top-0 h-16 w-16 -mt-3 -mr-3 bg-blue-50/50 rounded-full group-hover:bg-blue-100/50 transition-colors flex items-center justify-center text-blue-300">
                    <i class="fa-solid fa-book-bookmark text-xl"></i>
                </div>
                
                <div>
                    <!-- Code & KKM Pill -->
                    <div class="flex items-center gap-2 mb-3">
                        <span class="px-2 py-0.5 bg-blue-50 text-blue-600 border border-blue-100 rounded text-[10px] font-bold">
                            {{ $m->KdMapel }}
                        </span>
                        <span class="px-2 py-0.5 bg-amber-50 text-amber-600 border border-amber-100 rounded text-[10px] font-bold">
                            KKM: {{ number_format($m->KKM, 0) }}
                        </span>
                    </div>

                    <!-- Title -->
                    <h4 class="text-base font-bold text-slate-800 mb-1 group-hover:text-blue-600 transition-colors">
                        {{ $m->NamaMapel }}
                    </h4>

                    <!-- Book info -->
                    <p class="text-xs text-slate-500 mb-4 flex items-start gap-2">
                        <i class="fa-solid fa-book-open mt-0.5 text-slate-400"></i>
                        <span>
                            <strong class="text-slate-600">Buku:</strong> 
                            {{ $m->NamaBuku ?: 'Tidak ada referensi buku' }}
                        </span>
                    </p>
                </div>

                <!-- Progress Bar for KKM -->
                <div class="mb-4">
                    <div class="flex justify-between text-[10px] font-bold text-slate-400 uppercase mb-1">
                        <span>Standar Kelulusan</span>
                        <span>{{ number_format($m->KKM, 0) }}%</span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-1.5 overflow-hidden">
                        <div class="bg-blue-500 h-1.5 rounded-full" style="width: {{ $m->KKM }}%"></div>
                    </div>
                </div>

                <!-- Actions Footer -->
                <div class="border-t border-slate-100 pt-4 flex items-center justify-between">
                    <button class="text-xs font-semibold text-slate-500 hover:text-blue-600 transition-colors flex items-center gap-1" onclick="openEditModal({{ json_encode($m) }})">
                        <i class="fa-solid fa-pen"></i> Ubah Detail
                    </button>
                    
                    <form action="{{ route('mapel.destroy', $m->KdMapel) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus mata pelajaran {{ $m->NamaMapel }}? Tindakan ini akan menghapus jadwal dan nilai terkait.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-xs font-semibold text-slate-400 hover:text-red-500 transition-colors flex items-center gap-1">
                            <i class="fa-solid fa-trash-can"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white rounded-xl border border-slate-200 p-8 text-center text-slate-400 text-xs shadow-sm">
                Belum ada data mata pelajaran. Klik tombol "Tambah Mapel" untuk memasukkan data baru.
            </div>
        @endforelse
    </div>
</div>

<!-- Add Subject Modal -->
<div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm hidden" id="addSubjectModal">
    <div class="bg-white rounded-2xl w-full max-w-lg overflow-hidden shadow-2xl transition-all scale-95" id="modalContent">
        <!-- Modal Header -->
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <h3 class="text-base font-bold text-slate-800">Tambah Mata Pelajaran</h3>
            <button class="p-1 text-slate-400 hover:text-slate-600 transition-colors" id="closeModalBtn">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>
        <!-- Modal Body -->
        <form action="{{ route('mapel.store') }}" method="POST" class="p-6 space-y-4">
            @csrf
            
            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-1">
                    <label class="text-[10px] font-bold text-slate-500 uppercase">Kode Mapel</label>
                    <input name="KdMapel" required placeholder="Contoh: M011" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent font-semibold uppercase" type="text" maxlength="10"/>
                </div>
                <div class="space-y-1">
                    <label class="text-[10px] font-bold text-slate-500 uppercase">KKM Kelulusan</label>
                    <input name="KKM" required min="0" max="100" placeholder="75" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent font-bold text-slate-850" type="number"/>
                </div>
            </div>

            <div class="space-y-1">
                <label class="text-[10px] font-bold text-slate-500 uppercase">Nama Mata Pelajaran</label>
                <input name="NamaMapel" required placeholder="Contoh: Pemrograman Mobile" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent" type="text"/>
            </div>

            <div class="space-y-1">
                <label class="text-[10px] font-bold text-slate-500 uppercase">Judul Buku Panduan / Pegangan (Opsional)</label>
                <input name="NamaBuku" placeholder="Contoh: Buku Pemrograman Flutter Kejuruan" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent" type="text"/>
            </div>

            <!-- Footer Buttons -->
            <div class="pt-4 flex items-center justify-end gap-3 border-t mt-6">
                <button class="px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100 rounded-lg transition-colors" id="cancelModalBtn" type="button">Batal</button>
                <button class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-semibold transition-colors shadow-lg shadow-blue-500/20" type="submit">Tambah Mapel</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Subject Modal -->
<div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm hidden" id="editSubjectModal">
    <div class="bg-white rounded-2xl w-full max-w-lg overflow-hidden shadow-2xl transition-all scale-95" id="editModalContent">
        <!-- Modal Header -->
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <h3 class="text-base font-bold text-slate-800">Ubah Mata Pelajaran</h3>
            <button class="p-1 text-slate-400 hover:text-slate-600 transition-colors" onclick="closeEditModal()">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>
        <!-- Modal Body -->
        <form id="editForm" method="POST" class="p-6 space-y-4">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-1">
                    <label class="text-[10px] font-bold text-slate-500 uppercase">Kode Mapel (Tetap)</label>
                    <input id="editKdMapel" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm bg-slate-50 text-slate-450 font-semibold" readonly type="text"/>
                </div>
                <div class="space-y-1">
                    <label class="text-[10px] font-bold text-slate-500 uppercase">KKM Kelulusan</label>
                    <input name="KKM" id="editKKM" required min="0" max="100" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent font-bold text-slate-850" type="number"/>
                </div>
            </div>

            <div class="space-y-1">
                <label class="text-[10px] font-bold text-slate-500 uppercase">Nama Mata Pelajaran</label>
                <input name="NamaMapel" id="editNamaMapel" required class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent" type="text"/>
            </div>

            <div class="space-y-1">
                <label class="text-[10px] font-bold text-slate-500 uppercase">Judul Buku Panduan / Pegangan</label>
                <input name="NamaBuku" id="editNamaBuku" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent" type="text"/>
            </div>

            <!-- Footer Buttons -->
            <div class="pt-4 flex items-center justify-end gap-3 border-t mt-6">
                <button class="px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100 rounded-lg transition-colors" onclick="closeEditModal()" type="button">Batal</button>
                <button class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-semibold transition-colors shadow-lg shadow-blue-500/20" type="submit">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const modal = document.getElementById('addSubjectModal');
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

    // Edit modal
    const editModal = document.getElementById('editSubjectModal');
    const editModalContent = document.getElementById('editModalContent');
    const editForm = document.getElementById('editForm');
    
    function openEditModal(mapel) {
        editForm.action = `/mapel/${mapel.KdMapel}`;
        document.getElementById('editKdMapel').value = mapel.KdMapel;
        document.getElementById('editNamaMapel').value = mapel.NamaMapel;
        document.getElementById('editNamaBuku').value = mapel.NamaBuku || '';
        document.getElementById('editKKM').value = mapel.KKM;

        editModal.classList.remove('hidden');
        setTimeout(() => editModalContent.classList.remove('scale-95'), 10);
    }

    function closeEditModal() {
        editModalContent.classList.add('scale-95');
        setTimeout(() => editModal.classList.add('hidden'), 150);
    }
</script>
@endsection
