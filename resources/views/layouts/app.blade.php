<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>@yield('title', 'Sistem Informasi Akademik') - SMK Gajah Mada 3</title>
    <!-- Tailwind CSS v3 CDN with plugins -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'sidebar-bg': '#0f172a',
                        'sidebar-active': '#2563eb',
                        'table-header': '#f8fafc',
                        'status-senin': '#dbeafe',
                        'status-selasa': '#f3e8ff',
                        'status-rabu': '#dcfce7',
                        'status-kamis': '#ffedd5',
                        'status-jumat': '#fee2e2',
                        primary: '#2563eb',
                        statusLunas: '#ecfdf5',
                        textLunas: '#059669',
                        statusMetode: '#eff6ff',
                        textMetode: '#3b82f6',
                    }
                }
            }
        }
    </script>
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"/>
    <!-- Google Fonts Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
    @yield('styles')
</head>
<body class="bg-slate-50 font-sans text-slate-700 h-screen overflow-hidden">
    <div class="flex h-full">
        <!-- Sidebar -->
        <aside class="w-64 bg-sidebar-bg text-slate-400 flex flex-col flex-shrink-0">
            <!-- Sidebar Header -->
            <div class="p-6 border-b border-slate-800">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-blue-600 rounded flex items-center justify-center text-white font-bold">G</div>
                    <div>
                        <h1 class="text-white text-sm font-bold leading-tight">SMK Gajah Mada 3</h1>
                        <p class="text-[10px] text-slate-500">Palembang</p>
                    </div>
                </div>
            </div>
            
            <!-- Navigation Links -->
            <nav class="flex-1 px-4 py-4 space-y-1 overflow-y-auto">
                <a class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('dashboard') ? 'bg-sidebar-active text-white font-semibold' : 'hover:text-white hover:bg-white/5' }}" href="{{ route('dashboard') }}">
                    <i class="w-5 h-5 fa-solid fa-gauge-high text-center"></i>
                    <span class="text-sm">Dashboard</span>
                </a>
                <a class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('siswa.*') ? 'bg-sidebar-active text-white font-semibold' : 'hover:text-white hover:bg-white/5' }}" href="{{ route('siswa.index') }}">
                    <i class="w-5 h-5 fa-solid fa-user-group text-center"></i>
                    <span class="text-sm">Data Siswa</span>
                </a>
                <a class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('guru.*') ? 'bg-sidebar-active text-white font-semibold' : 'hover:text-white hover:bg-white/5' }}" href="{{ route('guru.index') }}">
                    <i class="w-5 h-5 fa-solid fa-chalkboard-user text-center"></i>
                    <span class="text-sm">Data Guru</span>
                </a>
                <a class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('kelas.*') ? 'bg-sidebar-active text-white font-semibold' : 'hover:text-white hover:bg-white/5' }}" href="{{ route('kelas.index') }}">
                    <i class="w-5 h-5 fa-solid fa-school text-center"></i>
                    <span class="text-sm">Kelas</span>
                </a>
                <a class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('jadwal.*') ? 'bg-sidebar-active text-white font-semibold' : 'hover:text-white hover:bg-white/5' }}" href="{{ route('jadwal.index') }}">
                    <i class="w-5 h-5 fa-solid fa-calendar-days text-center"></i>
                    <span class="text-sm">Jadwal</span>
                </a>
                <a class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('pembayaran.*') ? 'bg-sidebar-active text-white font-semibold' : 'hover:text-white hover:bg-white/5' }}" href="{{ route('pembayaran.index') }}">
                    <i class="w-5 h-5 fa-solid fa-file-invoice-dollar text-center"></i>
                    <span class="text-sm">Pembayaran SPP</span>
                </a>
                <a class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('nilai.*') ? 'bg-sidebar-active text-white font-semibold' : 'hover:text-white hover:bg-white/5' }}" href="{{ route('nilai.index') }}">
                    <i class="w-5 h-5 fa-solid fa-chart-line text-center"></i>
                    <span class="text-sm">Nilai Siswa</span>
                </a>
                <a class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('mapel.*') ? 'bg-sidebar-active text-white font-semibold' : 'hover:text-white hover:bg-white/5' }}" href="{{ route('mapel.index') }}">
                    <i class="w-5 h-5 fa-solid fa-book text-center"></i>
                    <span class="text-sm">Mata Pelajaran</span>
                </a>
            </nav>
            
            <!-- Sidebar Footer User Profile -->
            <div class="p-4 border-t border-slate-800 mt-auto">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold text-sm">
                        {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                    </div>
                    <div class="overflow-hidden">
                        <p class="text-white text-xs font-semibold truncate">{{ Auth::user()->name ?? 'User' }}</p>
                        <p class="text-[10px] text-slate-500 uppercase tracking-wider">{{ Auth::user()->role ?? 'Admin' }}</p>
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="flex items-center gap-2 text-xs hover:text-white text-slate-400 transition-colors w-full text-left">
                        <i class="w-4 h-4 fa-solid fa-arrow-right-from-bracket"></i>
                        Keluar
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content Area -->
        <main class="flex-1 flex flex-col min-w-0 overflow-hidden">
            <!-- Header -->
            <header class="bg-white h-16 border-b border-slate-200 flex items-center justify-between px-8 flex-shrink-0">
                <div>
                    <h2 class="text-base font-bold text-slate-800">@yield('page_title', 'Sistem Akademik')</h2>
                    <p class="text-xs text-slate-400">Tahun Ajaran 2026/2027</p>
                </div>
                <div class="flex items-center space-x-6">
                    <div class="relative">
                        <button class="text-slate-400 hover:text-slate-600">
                            <i class="w-6 h-6 fa-regular fa-bell"></i>
                        </button>
                        <span class="absolute top-0 right-0 block h-2 w-2 rounded-full bg-red-500 ring-2 ring-white"></span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="text-right">
                            <p class="text-xs font-bold text-slate-700 leading-none">{{ Auth::user()->name ?? 'User' }}</p>
                            <p class="text-[10px] text-slate-400 leading-none mt-1 uppercase">{{ Auth::user()->role ?? 'Admin' }}</p>
                        </div>
                        <div class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold text-xs">
                            {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                        </div>
                    </div>
                </div>
            </header>
            
            <!-- Alert Messages -->
            @if(session('success'))
                <div class="bg-emerald-50 border-b border-emerald-200 text-emerald-800 text-xs px-8 py-3 flex justify-between items-center transition-all" id="successAlert">
                    <span><i class="fa-solid fa-circle-check mr-2"></i> {{ session('success') }}</span>
                    <button class="text-emerald-500 hover:text-emerald-700 font-bold" onclick="document.getElementById('successAlert').remove()">✕</button>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-rose-50 border-b border-rose-200 text-rose-800 text-xs px-8 py-3 flex justify-between items-center transition-all" id="errorAlert">
                    <span><i class="fa-solid fa-triangle-exclamation mr-2"></i> {{ session('error') }}</span>
                    <button class="text-rose-500 hover:text-rose-700 font-bold" onclick="document.getElementById('errorAlert').remove()">✕</button>
                </div>
            @endif

            @if($errors->any())
                <div class="bg-rose-50 border-b border-rose-200 text-rose-800 text-xs px-8 py-3 flex justify-between items-center transition-all" id="validationAlert">
                    <div>
                        <p class="font-bold mb-1"><i class="fa-solid fa-triangle-exclamation mr-2"></i> Harap perbaiki kesalahan berikut:</p>
                        <ul class="list-disc list-inside pl-2 space-y-0.5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <button class="text-rose-500 hover:text-rose-700 font-bold self-start" onclick="document.getElementById('validationAlert').remove()">✕</button>
                </div>
            @endif

            <!-- Content Area -->
            <section class="flex-1 overflow-y-auto p-8">
                @yield('content')
            </section>
        </main>
    </div>

    <!-- Initialize Lucide Icons -->
    <script>
        lucide.createIcons();
    </script>
    @yield('scripts')
</body>
</html>
