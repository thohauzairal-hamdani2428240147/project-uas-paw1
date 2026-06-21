@extends('layouts.app')

@section('title', 'Data Guru')
@section('page_title', 'Data Guru')

@section('content')
<div class="space-y-4">
    <!-- Search and Actions -->
    <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-6">
        <form action="{{ route('guru.index') }}" method="GET" class="relative w-full md:max-w-lg">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                <i class="w-5 h-5 fa-solid fa-magnifying-glass"></i>
            </span>
            <input name="search" value="{{ request('search') }}" class="block w-full pl-10 pr-3 py-2 border border-slate-200 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all text-sm" placeholder="Cari nama atau NIY..." type="text"/>
        </form>
        <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg flex items-center gap-2 font-medium transition-all shadow-sm text-sm w-full md:w-auto justify-center" id="openModalBtn">
            <i class="w-4 h-4 fa-solid fa-plus"></i> Tambah Guru
        </button>
    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200">
                        <th class="px-6 py-4 font-semibold text-slate-500 uppercase tracking-wider text-[11px]">NIY</th>
                        <th class="px-6 py-4 font-semibold text-slate-500 uppercase tracking-wider text-[11px]">Nama Guru</th>
                        <th class="px-6 py-4 font-semibold text-slate-500 uppercase tracking-wider text-[11px]">J/K</th>
                        <th class="px-6 py-4 font-semibold text-slate-500 uppercase tracking-wider text-[11px]">Jabatan</th>
                        <th class="px-6 py-4 font-semibold text-slate-500 uppercase tracking-wider text-[11px]">Pendidikan</th>
                        <th class="px-6 py-4 font-semibold text-slate-500 uppercase tracking-wider text-[11px]">Telepon</th>
                        <th class="px-6 py-4 font-semibold text-slate-500 uppercase tracking-wider text-[11px] text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse($guru as $g)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 text-slate-600 font-medium">{{ $g->NIY }}</td>
                            <td class="px-6 py-4 flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-xs font-bold">
                                    {{ strtoupper(substr($g->Nama, 0, 1)) }}
                                </div>
                                <span class="font-medium text-slate-800">{{ $g->Nama }}</span>
                            </td>
                            <td class="px-6 py-4 text-slate-500">{{ $g->JenisKelamin }}</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full bg-purple-50 text-purple-600 text-xs font-medium">{{ $g->Jabatan }}</span>
                            </td>
                            <td class="px-6 py-4 text-slate-500">{{ $g->PendidikanTerakhir }}</td>
                            <td class="px-6 py-4 text-slate-500">{{ $g->NoHP }}</td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex justify-center gap-2">
                                    <button class="p-1.5 text-slate-400 hover:text-blue-600 transition-colors" onclick="openEditModal({{ json_encode($g) }})">
                                        <i class="fa-solid fa-pen"></i>
                                    </button>
                                    <form action="{{ route('guru.destroy', $g->NIY) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus guru ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 text-slate-400 hover:text-red-600 transition-colors">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-8 text-slate-400 text-xs">Belum ada data guru.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- AddTeacherModal -->
<div class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center hidden" id="addTeacherModal">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-xl overflow-hidden animate-in fade-in zoom-in duration-200" id="modalContent">
        <!-- Modal Header -->
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
            <h3 class="text-base font-bold text-slate-800">Tambah Guru Baru</h3>
            <button class="p-1 text-slate-400 hover:text-slate-600 transition-colors" id="closeModalBtn">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>
        <!-- Modal Body -->
        <form action="{{ route('guru.store') }}" method="POST" class="p-6 space-y-4">
            @csrf
            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-1">
                    <label class="text-[11px] font-bold text-slate-500 uppercase">NIY</label>
                    <input name="NIY" class="w-full border-slate-200 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500" required type="text" placeholder="G000000011"/>
                </div>
                <div class="space-y-1">
                    <label class="text-[11px] font-bold text-slate-500 uppercase">Jenis Kelamin</label>
                    <select name="JenisKelamin" class="w-full border-slate-200 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                </div>
            </div>
            
            <div class="space-y-1">
                <label class="text-[11px] font-bold text-slate-500 uppercase">Nama Lengkap</label>
                <input name="Nama" class="w-full border-slate-200 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Nama dan gelar" required type="text"/>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-1">
                    <label class="text-[11px] font-bold text-slate-500 uppercase">Tempat Lahir</label>
                    <input name="TempatLahir" class="w-full border-slate-200 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500" required type="text"/>
                </div>
                <div class="space-y-1">
                    <label class="text-[11px] font-bold text-slate-500 uppercase">Tanggal Lahir</label>
                    <input name="TanggalLahir" class="w-full border-slate-200 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500" required type="date"/>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-4">
                <div class="space-y-1">
                    <label class="text-[11px] font-bold text-slate-500 uppercase">Pendidikan Terakhir</label>
                    <input name="PendidikanTerakhir" class="w-full border-slate-200 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500" value="S1" required type="text"/>
                </div>
                <div class="space-y-1">
                    <label class="text-[11px] font-bold text-slate-500 uppercase">Jabatan</label>
                    <input name="Jabatan" class="w-full border-slate-200 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Guru ..." required type="text"/>
                </div>
                <div class="space-y-1">
                    <label class="text-[11px] font-bold text-slate-500 uppercase">No. Telepon</label>
                    <input name="NoHP" class="w-full border-slate-200 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500" placeholder="08..." required type="text"/>
                </div>
            </div>

            <div class="space-y-1">
                <label class="text-[11px] font-bold text-slate-500 uppercase">Alamat Lengkap</label>
                <textarea name="Alamat" class="w-full border-slate-200 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500 resize-none" rows="2" required></textarea>
            </div>

            <!-- Modal Footer -->
            <div class="pt-4 flex justify-end gap-3 border-t">
                <button class="px-5 py-2 text-sm font-medium text-slate-600 bg-white border border-slate-200 rounded-lg hover:bg-slate-100 transition-colors" id="cancelModalBtn" type="button">Batal</button>
                <button class="px-5 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors shadow" type="submit">Tambah Guru</button>
            </div>
        </form>
    </div>
</div>

<!-- EditTeacherModal -->
<div class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center hidden" id="editTeacherModal">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-xl overflow-hidden animate-in fade-in zoom-in duration-200" id="editModalContent">
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
            <h3 class="text-base font-bold text-slate-800">Edit Data Guru</h3>
            <button class="p-1 text-slate-400 hover:text-slate-600 transition-colors" onclick="closeEditModal()">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>
        <form id="editForm" method="POST" class="p-6 space-y-4">
            @csrf
            @method('PUT')
            <div class="space-y-1">
                <label class="text-[11px] font-bold text-slate-500 uppercase">Nama Lengkap</label>
                <input name="Nama" id="editNama" class="w-full border-slate-200 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500" required type="text"/>
            </div>

            <div class="grid grid-cols-3 gap-4">
                <div class="space-y-1">
                    <label class="text-[11px] font-bold text-slate-500 uppercase">Pendidikan Terakhir</label>
                    <input name="PendidikanTerakhir" id="editPendidikan" class="w-full border-slate-200 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500" required type="text"/>
                </div>
                <div class="space-y-1">
                    <label class="text-[11px] font-bold text-slate-500 uppercase">Jabatan</label>
                    <input name="Jabatan" id="editJabatan" class="w-full border-slate-200 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500" required type="text"/>
                </div>
                <div class="space-y-1">
                    <label class="text-[11px] font-bold text-slate-500 uppercase">No. Telepon</label>
                    <input name="NoHP" id="editNoHP" class="w-full border-slate-200 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500" required type="text"/>
                </div>
            </div>

            <div class="space-y-1">
                <label class="text-[11px] font-bold text-slate-500 uppercase">Alamat Lengkap</label>
                <textarea name="Alamat" id="editAlamat" class="w-full border-slate-200 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500 resize-none" rows="2" required></textarea>
            </div>

            <div class="pt-4 flex justify-end gap-3 border-t">
                <button class="px-5 py-2 text-sm font-medium text-slate-600 bg-white border border-slate-200 rounded-lg hover:bg-slate-100 transition-colors" onclick="closeEditModal()" type="button">Batal</button>
                <button class="px-5 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors shadow" type="submit">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const modal = document.getElementById('addTeacherModal');
    const modalContent = document.getElementById('modalContent');
    const openBtn = document.getElementById('openModalBtn');
    const closeBtn = document.getElementById('closeModalBtn');
    const cancelBtn = document.getElementById('cancelModalBtn');

    const toggleModal = (show) => {
        if (show) {
            modal.classList.remove('hidden');
            setTimeout(() => modalContent.classList.remove('scale-95'), 10);
        } else {
            modalContent.classList.add('scale-95');
            setTimeout(() => modal.classList.add('hidden'), 150);
        }
    };

    openBtn.addEventListener('click', () => toggleModal(true));
    closeBtn.addEventListener('click', () => toggleModal(false));
    cancelBtn.addEventListener('click', () => toggleModal(false));

    modal.addEventListener('click', (e) => {
        if (e.target === modal) toggleModal(false);
    });

    // Edit Modal logic
    const editModal = document.getElementById('editTeacherModal');
    const editModalContent = document.getElementById('editModalContent');
    const editForm = document.getElementById('editForm');

    function openEditModal(guru) {
        editForm.action = `/guru/${guru.NIY}`;
        document.getElementById('editNama').value = guru.Nama;
        document.getElementById('editPendidikan').value = guru.PendidikanTerakhir;
        document.getElementById('editJabatan').value = guru.Jabatan;
        document.getElementById('editNoHP').value = guru.NoHP;
        document.getElementById('editAlamat').value = guru.Alamat;

        editModal.classList.remove('hidden');
        setTimeout(() => editModalContent.classList.remove('scale-95'), 10);
    }

    function closeEditModal() {
        editModalContent.classList.add('scale-95');
        setTimeout(() => editModal.classList.add('hidden'), 150);
    }
</script>
@endsection
