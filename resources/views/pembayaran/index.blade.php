@extends('layouts.app')

@section('title', 'Pembayaran SPP')
@section('page_title', 'Pembayaran SPP')

@section('content')
<div class="space-y-6">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Card 1: Total Terkumpul -->
        <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden">
            <div class="absolute right-0 top-0 h-24 w-24 -mt-4 -mr-4 bg-emerald-50 rounded-full flex items-center justify-center text-emerald-200">
                <i class="fa-solid fa-money-bill-wave text-5xl"></i>
            </div>
            <div class="relative">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total SPP Terkumpul</p>
                <h3 class="text-2xl font-extrabold text-slate-800 mt-2">Rp {{ number_format($totalTerkumpul, 0, ',', '.') }}</h3>
                <p class="text-xs text-emerald-600 font-semibold mt-2 flex items-center gap-1">
                    <i class="fa-solid fa-circle-check"></i>
                    Bulan Aktif: Juli 2026
                </p>
            </div>
        </div>

        <!-- Card 2: Siswa Belum Bayar -->
        <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden">
            <div class="absolute right-0 top-0 h-24 w-24 -mt-4 -mr-4 bg-rose-50 rounded-full flex items-center justify-center text-rose-200">
                <i class="fa-solid fa-circle-exclamation text-5xl"></i>
            </div>
            <div class="relative">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Tunggakan Bulan Ini</p>
                <h3 class="text-2xl font-extrabold text-slate-800 mt-2">{{ $belumBayarCount }} Siswa</h3>
                <p class="text-xs text-rose-600 font-semibold mt-2 flex items-center gap-1">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    Menunggu konfirmasi/pembayaran
                </p>
            </div>
        </div>

        <!-- Card 3: Tarif SPP Bulanan -->
        <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden">
            <div class="absolute right-0 top-0 h-24 w-24 -mt-4 -mr-4 bg-blue-50 rounded-full flex items-center justify-center text-blue-200">
                <i class="fa-solid fa-wallet text-5xl"></i>
            </div>
            <div class="relative">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Tarif SPP Standar</p>
                <h3 class="text-2xl font-extrabold text-slate-800 mt-2">Rp 150.000</h3>
                <p class="text-xs text-blue-600 font-semibold mt-2 flex items-center gap-1">
                    <i class="fa-solid fa-circle-info"></i>
                    Berlaku untuk semua program keahlian
                </p>
            </div>
        </div>
    </div>

    <!-- Filter & Search Section -->
    <div class="bg-white rounded-xl border border-slate-200 p-4 shadow-sm">
        <form action="{{ route('pembayaran.index') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-center justify-between">
            <div class="relative w-full md:max-w-md">
                <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input name="search" value="{{ request('search') }}" class="w-full pl-10 pr-4 py-2 bg-white border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Cari nama siswa atau NISN..." type="text"/>
            </div>
            <div class="flex flex-col sm:flex-row gap-4 w-full md:w-auto items-center">
                <select name="status" onchange="this.form.submit()" class="w-full sm:w-48 px-4 py-2 bg-white border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="Semua Status" {{ request('status') == 'Semua Status' ? 'selected' : '' }}>Semua Status</option>
                    <option value="Lunas" {{ request('status') == 'Lunas' ? 'selected' : '' }}>Lunas (Telah Bayar)</option>
                    <option value="Belum Lunas" {{ request('status') == 'Belum Lunas' ? 'selected' : '' }}>Belum Lunas</option>
                </select>
                <button type="button" class="w-full sm:w-auto px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-semibold flex items-center justify-center gap-2 transition-colors shadow" id="openModalBtn">
                    <i class="fa-solid fa-plus"></i> Catat Pembayaran
                </button>
            </div>
        </form>
    </div>

    <!-- Table Container -->
    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200">
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-wider">Kode</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-wider">Siswa</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-wider">Kelas</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-wider">Bulan SPP</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-wider">Jumlah Bayar</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-wider">Metode</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-wider">Tgl Bayar</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse($pembayaran as $p)
                        @php
                            $isPaid = !is_null($p->TglBayar) && $p->MetodePembayaran !== 'BelumBayar';
                        @endphp
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-3 font-semibold text-slate-600">{{ $p->KdPembayaran }}</td>
                            <td class="px-6 py-3">
                                <div>
                                    <p class="font-semibold text-slate-800">{{ $p->siswa->Nama ?? 'Tidak Ditemukan' }}</p>
                                    <p class="text-xs text-slate-400">NISN: {{ $p->NISN }}</p>
                                </div>
                            </td>
                            <td class="px-6 py-3">
                                <span class="px-2 py-0.5 bg-slate-100 text-slate-600 rounded text-[10px] font-bold border border-slate-200">
                                    {{ $p->siswa->kelas->NamaKelas ?? ($p->siswa->KdKelas ?? '-') }}
                                </span>
                            </td>
                            <td class="px-6 py-3 text-slate-600 font-medium">{{ $p->BulanBayar }}</td>
                            <td class="px-6 py-3 font-bold text-slate-700">Rp {{ number_format($p->JumlahBayar, 0, ',', '.') }}</td>
                            <td class="px-6 py-3">
                                @if($p->MetodePembayaran == 'Tunai')
                                    <span class="px-2 py-0.5 bg-emerald-50 text-emerald-600 rounded-full text-[10px] font-bold border border-emerald-100">
                                        <i class="fa-solid fa-money-bill mr-1"></i> Tunai
                                    </span>
                                @elseif($p->MetodePembayaran == 'Transfer')
                                    <span class="px-2 py-0.5 bg-blue-50 text-blue-600 rounded-full text-[10px] font-bold border border-blue-100">
                                        <i class="fa-solid fa-credit-card mr-1"></i> Transfer
                                    </span>
                                @else
                                    <span class="text-slate-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-3 text-slate-500">
                                {{ $p->TglBayar ? date('d M Y', strtotime($p->TglBayar)) : '-' }}
                            </td>
                            <td class="px-6 py-3">
                                @if($isPaid)
                                    <span class="px-2.5 py-0.5 bg-emerald-50 text-emerald-700 rounded-full text-[10px] font-bold border border-emerald-200 flex items-center gap-1 w-max">
                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span> Lunas
                                    </span>
                                @else
                                    <span class="px-2.5 py-0.5 bg-amber-50 text-amber-700 rounded-full text-[10px] font-bold border border-amber-200 flex items-center gap-1 w-max">
                                        <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span> Belum Lunas
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-3">
                                <form action="{{ route('pembayaran.destroy', $p->KdPembayaran) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus transaksi pembayaran ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 text-slate-400 hover:text-red-500 transition-colors" title="Hapus Transaksi">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-8 text-slate-400 text-xs">Belum ada catatan transaksi pembayaran.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- AddPaymentModal -->
<div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm hidden" id="addPaymentModal">
    <div class="bg-white rounded-2xl w-full max-w-lg overflow-hidden shadow-2xl transition-all scale-95" id="modalContent">
        <!-- Modal Header -->
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <h3 class="text-base font-bold text-slate-800">Catat Pembayaran Baru</h3>
            <button class="p-1 text-slate-400 hover:text-slate-600 transition-colors" id="closeModalBtn">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>
        <!-- Modal Body -->
        <form action="{{ route('pembayaran.store') }}" method="POST" class="p-6 space-y-4">
            @csrf
            
            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-1">
                    <label class="text-[10px] font-bold text-slate-500 uppercase">Kode Transaksi</label>
                    <input name="KdPembayaran" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm bg-slate-50 text-slate-600 font-semibold" value="{{ $nextCode }}" readonly required type="text"/>
                </div>
                <div class="space-y-1">
                    <label class="text-[10px] font-bold text-slate-500 uppercase">Bulan SPP</label>
                    <select name="BulanBayar" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="Juli 2026">Juli 2026</option>
                        <option value="Agustus 2026">Agustus 2026</option>
                        <option value="September 2026">September 2026</option>
                        <option value="Oktober 2026">Oktober 2026</option>
                        <option value="November 2026">November 2026</option>
                        <option value="Desember 2026">Desember 2026</option>
                        <option value="Januari 2027">Januari 2027</option>
                        <option value="Februari 2027">Februari 2027</option>
                        <option value="Maret 2027">Maret 2027</option>
                        <option value="April 2027">April 2027</option>
                        <option value="Mei 2027">Mei 2027</option>
                        <option value="Juni 2027">Juni 2027</option>
                    </select>
                </div>
            </div>

            <div class="space-y-1">
                <label class="text-[10px] font-bold text-slate-500 uppercase">Pilih Siswa</label>
                <select name="NISN" required class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="" disabled selected>-- Pilih Siswa --</option>
                    @foreach($siswa as $s)
                        <option value="{{ $s->NISN }}">{{ $s->NISN }} - {{ $s->Nama }} ({{ $s->kelas->NamaKelas ?? $s->KdKelas }})</option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-1">
                    <label class="text-[10px] font-bold text-slate-500 uppercase">Jumlah Bayar (Rp)</label>
                    <input name="JumlahBayar" value="150000" min="0" required class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent font-bold text-slate-800" type="number"/>
                </div>
                <div class="space-y-1">
                    <label class="text-[10px] font-bold text-slate-500 uppercase">Metode Pembayaran</label>
                    <select name="MetodePembayaran" required class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="Tunai">Tunai</option>
                        <option value="Transfer">Transfer</option>
                        <option value="BelumBayar">Belum Lunas (Tunda)</option>
                    </select>
                </div>
            </div>

            <!-- Footer Buttons -->
            <div class="pt-4 flex items-center justify-end gap-3 border-t mt-6">
                <button class="px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100 rounded-lg transition-colors" id="cancelModalBtn" type="button">Batal</button>
                <button class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-semibold transition-colors shadow-lg shadow-blue-500/20" type="submit">Catat Transaksi</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const modal = document.getElementById('addPaymentModal');
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
</script>
@endsection
