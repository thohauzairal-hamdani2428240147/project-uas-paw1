<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Login - SMK Gajah Mada 3 Palembang</title>
    <!-- Tailwind CSS v3 CDN with plugins -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'brand-dark': '#0a192f',
                        'brand-blue': '#1a73e8',
                        'brand-blue-hover': '#1557b0',
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-brand-dark min-h-screen flex flex-col items-center justify-center p-4">
    <!-- HeaderSection -->
    <header class="text-center mb-8">
        <div class="flex justify-center mb-4">
            <div class="w-16 h-16 bg-brand-blue rounded-xl flex items-center justify-center shadow-lg">
                <svg class="h-10 w-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                </svg>
            </div>
        </div>
        <h1 class="text-white text-2xl font-bold tracking-wide">SMK Gajah Mada 3 Palembang</h1>
        <p class="text-gray-400 text-sm mt-1">Sistem Informasi Akademik</p>
    </header>
    
    <!-- LoginForm -->
    <main class="w-full max-w-md">
        <div class="bg-white rounded-2xl shadow-2xl p-8 md:p-10">
            <h2 class="text-[#1e293b] text-xl font-bold mb-8">Masuk ke Akun Anda</h2>
            
            <form action="{{ route('login') }}" class="space-y-6" method="POST">
                @csrf
                <!-- Email Field -->
                <div>
                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2" for="email">EMAIL</label>
                    <input class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-brand-blue focus:border-brand-blue outline-none transition-all text-gray-700 placeholder-gray-400" id="email" name="email" placeholder="admin@sekolah.sch.id" type="email" value="{{ old('email') }}" required autofocus/>
                    @error('email')
                        <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                    @enderror
                </div>
                <!-- Password Field -->
                <div>
                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2" for="password">KATA SANDI</label>
                    <div class="relative">
                        <input class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-brand-blue focus:border-brand-blue outline-none transition-all text-gray-700" id="password" name="password" type="password" required/>
                        <button class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600" type="button" id="togglePassword">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                                <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                <!-- Login Button -->
                <button class="w-full bg-[#1d63ed] hover:bg-brand-blue-hover text-white font-semibold py-3 rounded-lg shadow-md transition-colors duration-200 mt-4" type="submit">
                    Masuk
                </button>
            </form>
            
            <!-- DemoAccounts -->
            <div class="mt-10 pt-8 border-t border-gray-100">
                <p class="text-xs font-semibold text-gray-400 mb-4">Akun Demo:</p>
                <div class="grid grid-cols-2 gap-4">
                    <!-- Admin Demo -->
                    <div class="bg-gray-50 p-3 rounded-lg">
                        <p class="text-[11px] font-bold text-gray-700 mb-1">Admin</p>
                        <p class="text-[10px] text-gray-500 break-all">admin@sekolah.sch.id</p>
                        <p class="text-[10px] text-gray-500">password</p>
                    </div>
                    <!-- Teacher Demo -->
                    <div class="bg-gray-50 p-3 rounded-lg">
                        <p class="text-[11px] font-bold text-gray-700 mb-1">Guru</p>
                        <p class="text-[10px] text-gray-500 break-all">guru@sekolah.sch.id</p>
                        <p class="text-[10px] text-gray-500">password</p>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script>
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            passwordInput.type = passwordInput.type === 'password' ? 'text' : 'password';
        });
    </script>
</body>
</html>
