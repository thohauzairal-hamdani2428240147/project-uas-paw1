@extends('layouts.app')

@section('title', 'Jadwal Pelajaran')
@section('page_title', 'Jadwal Pelajaran')

@section('content')
<div class="space-y-4">
    <!-- Controls -->
    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mb-6">
        <form action="{{ route('jadwal.index') }}" method="GET" class="w-full sm:max-w-md">
            <select name="kelas_id" onchange="this.form.submit()" class="w-full border-slate-200 rounded-lg text-sm text-slate-600 focus:ring-blue-500 focus:border-blue-500 bg-white">
                <option value="Semua Kelas">Semua Kelas</option>
                @foreach($kelas as $k)
                    <option value="{{ $k->KdKelas }}" {{ request('kelas_id') == $k->KdKelas ? 'selected' : '' }}>{{ $k->NamaKelas }}</option>
                @endforeach
            </select>
        </form>
        <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium flex items-center gap-2 transition-colors shadow w-full sm:w-auto justify-center" id="openModalBtn">
            <i class="w-4 h-4 fa-solid fa-plus"></i> Tambah Jadwal
        </button>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Hari</th>
                        <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Jam</th>
                        <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Kelas</th>
                        <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Mata Pelajaran</th>
                        <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Guru</th>
                        <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse($jadwal as $j)
                        <tr>
                            <td class="px-6 py-4">
                                @php
                                    $dayClass = 'bg-status-senin text-blue-700';
                                    if ($j->Hari == 'Selasa') $dayClass = 'bg-status-selasa text-purple-700';
                                    elseif ($j->Hari == 'Rabu') $dayClass = 'bg-status-rabu text-green-700';
                                    elseif ($j->Hari == 'Kamis') $dayClass = 'bg-status-kamis text-orange-700';
                                    elseif ($j->Hari == 'Jumat') $dayClass = 'bg-status-jumat text-red-700';
                                @endphp
                                <span class="{{ $dayClass }} text-[10px] font-bold px-3 py-1 rounded-full">{{ $j->Hari }}</span>
                            </td>
                            <td class="px-6 py-4 text-slate-600 font-medium">{{ substr($j->JamMulai, 0, 5) }} - {{ substr($j->JamSelesai, 0, 5) }}</td>
                            <td class="px-6 py-4 text-slate-600">{{ $j->kelas->NamaKelas ?? $j->KdKelas }}</td>
                            <td class="px-6 py-4 font-bold text-slate-800">{{ $j->mataPelajaran->NamaMapel ?? $j->KdMapel }}</td>
                            <td class="px-6 py-4 text-slate-500">{{ $j->staff->Nama ?? $j->KdStaff }}</td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex justify-center gap-2">
                                    <button class="p-2 text-slate-400 hover:text-blue-600 transition-colors" onclick="openEditModal({{ json_encode($j) }})">
                                        <i class="fa-solid fa-pen"></i>
                                    </button>
                                    <form action="{{ route('jadwal.destroy', $j->KdJadwal) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-slate-400 hover:text-red-600 transition-colors">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-8 text-slate-400 text-xs">Belum ada jadwal pelajaran.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 bg-slate-50 text-[11px] text-slate-400 border-t">
            {{ count($jadwal) }} jadwal pelajaran
        </div>
    </div>
</div>

<!-- Modal Tambah Jadwal -->
<div class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/40 backdrop-blur-sm hidden" id="addModal">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-md overflow-hidden animate-in fade-in zoom-in duration-200" id="addModalContent">
        <div class="px-6 py-4 border-b flex items-center justify-between">
            <h3 class="text-sm font-bold text-slate-800">Tambah Jadwal</h3>
            <button class="text-slate-400 hover:text-slate-600 transition-colors" id="closeModalBtn">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>
        <form action="{{ route('jadwal.store') }}" method="POST" class="p-6 space-y-4">
            @csrf
            <div>
                <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1">Kode Jadwal</label>
                <input name="KdJadwal" class="w-full border-slate-200 rounded-lg text-sm text-slate-600 focus:ring-blue-500 focus:border-blue-500" required placeholder="JD0011" type="text" maxlength="6"/>
            </div>
            <div>
                <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1">Hari</label>
                <select name="Hari" class="w-full border-slate-200 rounded-lg text-sm text-slate-600 focus:ring-blue-500 focus:border-blue-500">
                    <option value="Senin">Senin</option>
                    <option value="Selasa">Selasa</option>
                    <option value="Rabu">Rabu</option>
                    <option value="Kamis">Kamis</option>
                    <option value="Jumat">Jumat</option>
                </select>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1">Jam Mulai</label>
                    <input name="JamMulai" class="w-full border-slate-200 rounded-lg text-sm text-slate-600 focus:ring-blue-500 focus:border-blue-500" placeholder="07:30" required type="text"/>
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1">Jam Selesai</label>
                    <input name="JamSelesai" class="w-full border-slate-200 rounded-lg text-sm text-slate-600 focus:ring-blue-500 focus:border-blue-500" placeholder="09:45" required type="text"/>
                </div>
            </div>
            <div>
                <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1">Kelas</label>
                <select name="KdKelas" class="w-full border-slate-200 rounded-lg text-sm text-slate-600 focus:ring-blue-500 focus:border-blue-500">
                    @foreach($kelas as $k)
                        <option value="{{ $k->KdKelas }}">{{ $k->NamaKelas }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1">Mata Pelajaran</label>
                <select name="KdMapel" class="w-full border-slate-200 rounded-lg text-sm text-slate-600 focus:ring-blue-500 focus:border-blue-500">
                    @foreach($mapel as $m)
                        <option value="{{ $m->KdMapel }}">{{ $m->NamaMapel }} ({{ $m->KdMapel }})</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1">Guru</label>
                <select name="KdStaff" class="w-full border-slate-200 rounded-lg text-sm text-slate-600 focus:ring-blue-500 focus:border-blue-500">
                    @foreach($guru as $g)
                        <option value="{{ $g->NIY }}">{{ $g->Nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex justify-end gap-3 pt-4 border-t">
                <button class="px-4 py-2 text-sm font-medium text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-lg transition-colors" id="cancelBtn" type="button">Batal</button>
                <button class="px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-colors shadow" type="submit">Tambah</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Jadwal -->
<div class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/40 backdrop-blur-sm hidden" id="editModal">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-md overflow-hidden animate-in fade-in zoom-in duration-200" id="editModalContent">
        <div class="px-6 py-4 border-b flex items-center justify-between">
            <h3 class="text-sm font-bold text-slate-800">Edit Jadwal</h3>
            <button class="text-slate-400 hover:text-slate-600 transition-colors" onclick="closeEditModal()">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>
        <form id="editForm" method="POST" class="p-6 space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1">Hari</label>
                <select name="Hari" id="editHari" class="w-full border-slate-200 rounded-lg text-sm text-slate-600 focus:ring-blue-500 focus:border-blue-500">
                    <option value="Senin">Senin</option>
                    <option value="Selasa">Selasa</option>
                    <option value="Rabu">Rabu</option>
                    <option value="Kamis">Kamis</option>
                    <option value="Jumat">Jumat</option>
                </select>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1">Jam Mulai</label>
                    <input name="JamMulai" id="editJamMulai" class="w-full border-slate-200 rounded-lg text-sm text-slate-600 focus:ring-blue-500 focus:border-blue-500" required type="text"/>
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1">Jam Selesai</label>
                    <input name="JamSelesai" id="editJamSelesai" class="w-full border-slate-200 rounded-lg text-sm text-slate-600 focus:ring-blue-500 focus:border-blue-500" required type="text"/>
                </div>
            </div>
            <div>
                <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1">Kelas</label>
                <select name="KdKelas" id="editKdKelas" class="w-full border-slate-200 rounded-lg text-sm text-slate-600 focus:ring-blue-500 focus:border-blue-500">
                    @foreach($kelas as $k)
                        <option value="{{ $k->KdKelas }}">{{ $k->NamaKelas }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1">Mata Pelajaran</label>
                <select name="KdMapel" id="editKdMapel" class="w-full border-slate-200 rounded-lg text-sm text-slate-600 focus:ring-blue-500 focus:border-blue-500">
                    @foreach($mapel as $m)
                        <option value="{{ $m->KdMapel }}">{{ $m->NamaMapel }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1">Guru</label>
                <select name="KdStaff" id="editKdStaff" class="w-full border-slate-200 rounded-lg text-sm text-slate-600 focus:ring-blue-500 focus:border-blue-500">
                    @foreach($guru as $g)
                        <option value="{{ $g->NIY }}">{{ $g->Nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex justify-end gap-3 pt-4 border-t">
                <button class="px-4 py-2 text-sm font-medium text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-lg transition-colors" onclick="closeEditModal()" type="button">Batal</button>
                <button class="px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-colors shadow" type="submit">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const addModal = document.getElementById('addModal');
    const addModalContent = document.getElementById('addModalContent');
    const openModalBtn = document.getElementById('openModalBtn');
    const closeModalBtn = document.getElementById('closeModalBtn');
    const cancelBtn = document.getElementById('cancelBtn');

    const toggleAddModal = (show) => {
        if (show) {
            addModal.classList.remove('hidden');
            setTimeout(() => addModalContent.classList.remove('scale-95'), 10);
        } else {
            addModalContent.classList.add('scale-95');
            setTimeout(() => addModal.classList.add('hidden'), 150);
        }
    };

    openModalBtn.addEventListener('click', () => toggleAddModal(true));
    closeModalBtn.addEventListener('click', () => toggleAddModal(false));
    cancelBtn.addEventListener('click', () => toggleAddModal(false));

    addModal.addEventListener('click', (e) => {
        if (e.target === addModal) toggleAddModal(false);
    });

    // Edit Modal Logic
    const editModal = document.getElementById('editModal');
    const editModalContent = document.getElementById('editModalContent');
    const editForm = document.getElementById('editForm');

    function openEditModal(j) {
        editForm.action = `/jadwal/${j.KdJadwal}`;
        document.getElementById('editHari').value = j.Hari;
        document.getElementById('editJamMulai').value = j.JamMulai.substr(0, 5);
        document.getElementById('editJamSelesai').value = j.JamSelesai.substr(0, 5);
        document.getElementById('editKdKelas').value = j.KdKelas;
        document.getElementById('editKdMapel').value = j.KdMapel;
        document.getElementById('editKdStaff').value = j.KdStaff;

        editModal.classList.remove('hidden');
        setTimeout(() => editModalContent.classList.remove('scale-95'), 10);
    }

    function closeEditModal() {
        editModalContent.classList.add('scale-95');
        setTimeout(() => editModal.classList.add('hidden'), 150);
    }
</script>
@endsection
