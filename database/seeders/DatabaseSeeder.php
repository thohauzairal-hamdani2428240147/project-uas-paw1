<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 0. Seed Users for Auth
        User::updateOrCreate(
            ['email' => 'admin@sekolah.sch.id'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'guru@sekolah.sch.id'],
            [
                'name' => 'Staff Guru',
                'password' => Hash::make('password'),
                'role' => 'guru',
            ]
        );

        // Disable Foreign Key checks for seeding
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Clear existing tables
        DB::table('Nilai')->truncate();
        DB::table('Pembayaran')->truncate();
        DB::table('JadwalPelajaran')->truncate();
        DB::table('MataPelajaran')->truncate();
        DB::table('Staff')->truncate();
        DB::table('Siswa')->truncate();
        DB::table('OrangTua')->truncate();
        DB::table('Kelas')->truncate();
        DB::table('Jurusan')->truncate();

        // 1. Data Jurusan
        DB::table('Jurusan')->insert([
            ['KdJurusan' => 'AK', 'NamaJurusan' => 'Akuntansi', 'created_at' => now(), 'updated_at' => now()],
            ['KdJurusan' => 'MP', 'NamaJurusan' => 'Manajemen Perkantoran', 'created_at' => now(), 'updated_at' => now()],
            ['KdJurusan' => 'TKR', 'NamaJurusan' => 'Teknik Kendaraan Ringan', 'created_at' => now(), 'updated_at' => now()],
            ['KdJurusan' => 'TKJ', 'NamaJurusan' => 'Teknik Komputer Jaringan', 'created_at' => now(), 'updated_at' => now()],
            ['KdJurusan' => 'MM', 'NamaJurusan' => 'Multimedia', 'created_at' => now(), 'updated_at' => now()],
            ['KdJurusan' => 'PH', 'NamaJurusan' => 'Perhotelan', 'created_at' => now(), 'updated_at' => now()],
            ['KdJurusan' => 'TB', 'NamaJurusan' => 'Tata Boga', 'created_at' => now(), 'updated_at' => now()],
            ['KdJurusan' => 'BD', 'NamaJurusan' => 'Bisnis Digital', 'created_at' => now(), 'updated_at' => now()],
            ['KdJurusan' => 'DPIB', 'NamaJurusan' => 'Desain Pemodelan dan Informasi Bangunan', 'created_at' => now(), 'updated_at' => now()],
            ['KdJurusan' => 'TITL', 'NamaJurusan' => 'Teknik Instalasi Tenaga Listrik', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // 2. Data Kelas
        DB::table('Kelas')->insert([
            ['KdKelas' => '10AK', 'NamaKelas' => 'X Akuntansi 1', 'KdJurusan' => 'AK', 'created_at' => now(), 'updated_at' => now()],
            ['KdKelas' => '10MP', 'NamaKelas' => 'X Manajemen Perkantoran', 'KdJurusan' => 'MP', 'created_at' => now(), 'updated_at' => now()],
            ['KdKelas' => '11AK', 'NamaKelas' => 'XI Akuntansi 1', 'KdJurusan' => 'AK', 'created_at' => now(), 'updated_at' => now()],
            ['KdKelas' => '11TKR', 'NamaKelas' => 'XI Teknik Kendaraan Ringan', 'KdJurusan' => 'TKR', 'created_at' => now(), 'updated_at' => now()],
            ['KdKelas' => '12AK', 'NamaKelas' => 'XII Akuntansi 1', 'KdJurusan' => 'AK', 'created_at' => now(), 'updated_at' => now()],
            ['KdKelas' => '12TKJ', 'NamaKelas' => 'XII Teknik Komputer Jaringan', 'KdJurusan' => 'TKJ', 'created_at' => now(), 'updated_at' => now()],
            ['KdKelas' => '12TKR', 'NamaKelas' => 'XII Teknik Kendaraan Ringan', 'KdJurusan' => 'TKR', 'created_at' => now(), 'updated_at' => now()],
            ['KdKelas' => '10TKR', 'NamaKelas' => 'X Teknik Kendaraan Ringan', 'KdJurusan' => 'TKR', 'created_at' => now(), 'updated_at' => now()],
            ['KdKelas' => '10TKJ', 'NamaKelas' => 'X Teknik Komputer Jaringan', 'KdJurusan' => 'TKJ', 'created_at' => now(), 'updated_at' => now()],
            ['KdKelas' => '11TKJ', 'NamaKelas' => 'XI Teknik Komputer Jaringan', 'KdJurusan' => 'TKJ', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // 3. Data OrangTua
        DB::table('OrangTua')->insert([
            [
                'KdOrangTua' => 'OT0001',
                'NamaAyah' => null, 'TempatLahirAyah' => null, 'TanggalLahirAyah' => null, 'AgamaAyah' => null, 'KewarganegaraanAyah' => null, 'PendidikanTerakhirAyah' => null, 'PekerjaanAyah' => null, 'PenghasilanAyah' => null, 'AlamatAyah' => null,
                'NamaIbu' => 'Apriyanti', 'TempatLahirIbu' => 'Palembang', 'TanggalLahirIbu' => '1988-11-11', 'AgamaIbu' => 'Islam', 'KewarganegaraanIbu' => 'Indonesia', 'PendidikanTerakhirIbu' => 'SMP', 'PekerjaanIbu' => 'Buruh', 'PenghasilanIbu' => 1500000.00, 'AlamatIbu' => 'Lr. Sei goren Rt 023/04 1 Ulu laut',
                'created_at' => now(), 'updated_at' => now()
            ],
            [
                'KdOrangTua' => 'OT0002',
                'NamaAyah' => 'M. Yusuf', 'TempatLahirAyah' => 'Palembang', 'TanggalLahirAyah' => '1975-05-10', 'AgamaAyah' => 'Islam', 'KewarganegaraanAyah' => 'Indonesia', 'PendidikanTerakhirAyah' => 'SMA', 'PekerjaanAyah' => 'Wiraswasta', 'PenghasilanAyah' => 4500000.00, 'AlamatAyah' => 'Jl. Sukabangun II No. 45 Palembang',
                'NamaIbu' => 'Siti Aminah', 'TempatLahirIbu' => 'Palembang', 'TanggalLahirIbu' => '1978-08-15', 'AgamaIbu' => 'Islam', 'KewarganegaraanIbu' => 'Indonesia', 'PendidikanTerakhirIbu' => 'SMA', 'PekerjaanIbu' => 'Ibu Rumah Tangga', 'PenghasilanIbu' => 0.00, 'AlamatIbu' => 'Jl. Sukabangun II No. 45 Palembang',
                'created_at' => now(), 'updated_at' => now()
            ],
            [
                'KdOrangTua' => 'OT0003',
                'NamaAyah' => 'J. Silalahi', 'TempatLahirAyah' => 'Medan', 'TanggalLahirAyah' => '1970-12-05', 'AgamaAyah' => 'Kristen', 'KewarganegaraanAyah' => 'Indonesia', 'PendidikanTerakhirAyah' => 'S1', 'PekerjaanAyah' => 'PNS', 'PenghasilanAyah' => 6000000.00, 'AlamatAyah' => 'Jl. Kolonel Atmo No. 12 Palembang',
                'NamaIbu' => 'M. Simanjuntak', 'TempatLahirIbu' => 'Medan', 'TanggalLahirIbu' => '1973-03-22', 'AgamaIbu' => 'Kristen', 'KewarganegaraanIbu' => 'Indonesia', 'PendidikanTerakhirIbu' => 'S1', 'PekerjaanIbu' => 'Guru', 'PenghasilanIbu' => 4000000.00, 'AlamatIbu' => 'Jl. Kolonel Atmo No. 12 Palembang',
                'created_at' => now(), 'updated_at' => now()
            ],
            [
                'KdOrangTua' => 'OT0004',
                'NamaAyah' => 'H. Suherman', 'TempatLahirAyah' => 'Palembang', 'TanggalLahirAyah' => '1972-02-15', 'AgamaAyah' => 'Islam', 'KewarganegaraanAyah' => 'Indonesia', 'PendidikanTerakhirAyah' => 'S1', 'PekerjaanAyah' => 'Karyawan Swasta', 'PenghasilanAyah' => 5000000.00, 'AlamatAyah' => 'Jl. Veteran No. 89 Palembang',
                'NamaIbu' => 'Hj. Fatimah', 'TempatLahirIbu' => 'Palembang', 'TanggalLahirIbu' => '1976-06-18', 'AgamaIbu' => 'Islam', 'KewarganegaraanIbu' => 'Indonesia', 'PendidikanTerakhirIbu' => 'D3', 'PekerjaanIbu' => 'Ibu Rumah Tangga', 'PenghasilanIbu' => 0.00, 'AlamatIbu' => 'Jl. Veteran No. 89 Palembang',
                'created_at' => now(), 'updated_at' => now()
            ],
            [
                'KdOrangTua' => 'OT0005',
                'NamaAyah' => 'Ridwan', 'TempatLahirAyah' => 'Palembang', 'TanggalLahirAyah' => '1974-10-12', 'AgamaAyah' => 'Islam', 'KewarganegaraanAyah' => 'Indonesia', 'PendidikanTerakhirAyah' => 'SMA', 'PekerjaanAyah' => 'Wiraswasta', 'PenghasilanAyah' => 3500000.00, 'AlamatAyah' => 'Jl. Basuki Rahmat No. 101 Palembang',
                'NamaIbu' => 'Farida', 'TempatLahirIbu' => 'Palembang', 'TanggalLahirIbu' => '1979-11-20', 'AgamaIbu' => 'Islam', 'KewarganegaraanIbu' => 'Indonesia', 'PendidikanTerakhirIbu' => 'SMA', 'PekerjaanIbu' => 'Ibu Rumah Tangga', 'PenghasilanIbu' => 0.00, 'AlamatIbu' => 'Jl. Basuki Rahmat No. 101 Palembang',
                'created_at' => now(), 'updated_at' => now()
            ],
            [
                'KdOrangTua' => 'OT0006',
                'NamaAyah' => 'Supardi', 'TempatLahirAyah' => 'Palembang', 'TanggalLahirAyah' => '1978-01-05', 'AgamaAyah' => 'Islam', 'KewarganegaraanAyah' => 'Indonesia', 'PendidikanTerakhirAyah' => 'SMA', 'PekerjaanAyah' => 'Buruh', 'PenghasilanAyah' => 2000000.00, 'AlamatAyah' => 'Jl. KH. Wahid Hasyim Rt 012 Palembang',
                'NamaIbu' => 'Sumarni', 'TempatLahirIbu' => 'Palembang', 'TanggalLahirIbu' => '1982-04-14', 'AgamaIbu' => 'Islam', 'KewarganegaraanIbu' => 'Indonesia', 'PendidikanTerakhirIbu' => 'SMP', 'PekerjaanIbu' => 'Buruh', 'PenghasilanIbu' => 1000000.00, 'AlamatIbu' => 'Jl. KH. Wahid Hasyim Rt 012 Palembang',
                'created_at' => now(), 'updated_at' => now()
            ],
            [
                'KdOrangTua' => 'OT0007',
                'NamaAyah' => 'Gunawan', 'TempatLahirAyah' => 'Jakarta', 'TanggalLahirAyah' => '1971-08-25', 'AgamaAyah' => 'Islam', 'KewarganegaraanAyah' => 'Indonesia', 'PendidikanTerakhirAyah' => 'S1', 'PekerjaanAyah' => 'Karyawan Swasta', 'PenghasilanAyah' => 5500000.00, 'AlamatAyah' => 'Jl. Plaju No. 8 Palembang',
                'NamaIbu' => 'Hesti', 'TempatLahirIbu' => 'Palembang', 'TanggalLahirIbu' => '1975-09-30', 'AgamaIbu' => 'Islam', 'KewarganegaraanIbu' => 'Indonesia', 'PendidikanTerakhirIbu' => 'S1', 'PekerjaanIbu' => 'Guru', 'PenghasilanIbu' => 3500000.00, 'AlamatIbu' => 'Jl. Plaju No. 8 Palembang',
                'created_at' => now(), 'updated_at' => now()
            ],
            [
                'KdOrangTua' => 'OT0008',
                'NamaAyah' => 'Hendra Wijaya', 'TempatLahirAyah' => 'Palembang', 'TanggalLahirAyah' => '1973-12-03', 'AgamaAyah' => 'Islam', 'KewarganegaraanAyah' => 'Indonesia', 'PendidikanTerakhirAyah' => 'S1', 'PekerjaanAyah' => 'PNS', 'PenghasilanAyah' => 5000000.00, 'AlamatAyah' => 'Jl. Kamboja No. 54 Palembang',
                'NamaIbu' => 'Kartini', 'TempatLahirIbu' => 'Palembang', 'TanggalLahirIbu' => '1977-03-25', 'AgamaIbu' => 'Islam', 'KewarganegaraanIbu' => 'Indonesia', 'PendidikanTerakhirIbu' => 'S1', 'PekerjaanIbu' => 'PNS', 'PenghasilanIbu' => 4500000.00, 'AlamatIbu' => 'Jl. Kamboja No. 54 Palembang',
                'created_at' => now(), 'updated_at' => now()
            ],
            [
                'KdOrangTua' => 'OT0009',
                'NamaAyah' => 'Bambang Sukarno', 'TempatLahirAyah' => 'Palembang', 'TanggalLahirAyah' => '1974-06-15', 'AgamaAyah' => 'Islam', 'KewarganegaraanAyah' => 'Indonesia', 'PendidikanTerakhirAyah' => 'SMA', 'PekerjaanAyah' => 'Wiraswasta', 'PenghasilanAyah' => 4000000.00, 'AlamatAyah' => 'Jl. Sudirman No. 120 Palembang',
                'NamaIbu' => 'Ratih Purwasih', 'TempatLahirIbu' => 'Palembang', 'TanggalLahirIbu' => '1979-05-18', 'AgamaIbu' => 'Islam', 'KewarganegaraanIbu' => 'Indonesia', 'PendidikanTerakhirIbu' => 'SMA', 'PekerjaanIbu' => 'Ibu Rumah Tangga', 'PenghasilanIbu' => 0.00, 'AlamatIbu' => 'Jl. Sudirman No. 120 Palembang',
                'created_at' => now(), 'updated_at' => now()
            ],
            [
                'KdOrangTua' => 'OT0010',
                'NamaAyah' => 'Slamet Riyadi', 'TempatLahirAyah' => 'Palembang', 'TanggalLahirAyah' => '1976-02-28', 'AgamaAyah' => 'Islam', 'KewarganegaraanAyah' => 'Indonesia', 'PendidikanTerakhirAyah' => 'SMP', 'PekerjaanAyah' => 'Buruh', 'PenghasilanAyah' => 2500000.00, 'AlamatAyah' => 'Jl. Demang Lebar Daun Palembang',
                'NamaIbu' => 'Endang Sulastri', 'TempatLahirIbu' => 'Palembang', 'TanggalLahirIbu' => '1981-09-12', 'AgamaIbu' => 'Islam', 'KewarganegaraanIbu' => 'Indonesia', 'PendidikanTerakhirIbu' => 'SMA', 'PekerjaanIbu' => 'Karyawan Swasta', 'PenghasilanIbu' => 2000000.00, 'AlamatIbu' => 'Jl. Demang Lebar Daun Palembang',
                'created_at' => now(), 'updated_at' => now()
            ]
        ]);

        // 4. Data Siswa
        DB::table('Siswa')->insert([
            [
                'Nama' => 'Anggun Syafitri', 'NISN' => '0102806210', 'JenisKelamin' => 'P', 'TempatLahir' => 'Palembang', 'TanggalLahir' => '2010-06-28',
                'Agama' => 'Islam', 'Kewarganegaraan' => 'Indonesia', 'AnakKeBRP' => 1, 'JumlahSaudaraKandung' => 2, 'JumlahSaudaraTiri' => 0, 'AnakYatimPiatu' => 'Tidak',
                'JurusanPilihan' => 'Akuntansi', 'UkuranBajuBatik' => 'L', 'UkuranBajuOlahraga' => 'L', 'PenerimaBantuan' => 'PIP - Anggun Lestari',
                'Alamat' => 'Lr. Sei goren Rt 023/009 1 Ulu laut', 'NoHP' => '081274628190', 'TinggalBersama' => 'Orang Tua', 'AsalSekolahSMP' => 'MTsS Assalam', 'TahunLulusSMP' => '2026',
                'KdKelas' => '10AK', 'KdOrangTua' => 'OT0001', 'created_at' => now(), 'updated_at' => now()
            ],
            [
                'Nama' => 'Rian Hidayat', 'NISN' => '2428240159', 'JenisKelamin' => 'L', 'TempatLahir' => 'Palembang', 'TanggalLahir' => '2005-04-12',
                'Agama' => 'Islam', 'Kewarganegaraan' => 'Indonesia', 'AnakKeBRP' => 2, 'JumlahSaudaraKandung' => 1, 'JumlahSaudaraTiri' => 0, 'AnakYatimPiatu' => 'Tidak',
                'JurusanPilihan' => 'Teknik Kendaraan Ringan', 'UkuranBajuBatik' => 'L', 'UkuranBajuOlahraga' => 'XL', 'PenerimaBantuan' => null,
                'Alamat' => 'Jl. Sukabangun II No. 45 Palembang', 'NoHP' => '081234567890', 'TinggalBersama' => 'Orang Tua', 'AsalSekolahSMP' => 'SMP Negeri 1 Palembang', 'TahunLulusSMP' => '2021',
                'KdKelas' => '11TKR', 'KdOrangTua' => 'OT0002', 'created_at' => now(), 'updated_at' => now()
            ],
            [
                'Nama' => 'Bambang Pratama', 'NISN' => '2428240123', 'JenisKelamin' => 'L', 'TempatLahir' => 'Palembang', 'TanggalLahir' => '2005-09-21',
                'Agama' => 'Kristen', 'Kewarganegaraan' => 'Indonesia', 'AnakKeBRP' => 1, 'JumlahSaudaraKandung' => 2, 'JumlahSaudaraTiri' => 0, 'AnakYatimPiatu' => 'Tidak',
                'JurusanPilihan' => 'Teknik Kendaraan Ringan', 'UkuranBajuBatik' => 'M', 'UkuranBajuOlahraga' => 'L', 'PenerimaBantuan' => null,
                'Alamat' => 'Jl. Kolonel Atmo No. 12 Palembang', 'NoHP' => '081345678901', 'TinggalBersama' => 'Orang Tua', 'AsalSekolahSMP' => 'SMP Negeri 3 Palembang', 'TahunLulusSMP' => '2021',
                'KdKelas' => '11TKR', 'KdOrangTua' => 'OT0003', 'created_at' => now(), 'updated_at' => now()
            ],
            [
                'Nama' => 'Faris Rahman', 'NISN' => '2428240147', 'JenisKelamin' => 'L', 'TempatLahir' => 'Palembang', 'TanggalLahir' => '2005-01-05',
                'Agama' => 'Islam', 'Kewarganegaraan' => 'Indonesia', 'AnakKeBRP' => 1, 'JumlahSaudaraKandung' => 1, 'JumlahSaudaraTiri' => 0, 'AnakYatimPiatu' => 'Tidak',
                'JurusanPilihan' => 'Teknik Kendaraan Ringan', 'UkuranBajuBatik' => 'L', 'UkuranBajuOlahraga' => 'L', 'PenerimaBantuan' => null,
                'Alamat' => 'Jl. Veteran No. 89 Palembang', 'NoHP' => '081456789012', 'TinggalBersama' => 'Orang Tua', 'AsalSekolahSMP' => 'SMP Swasta Methodist 1', 'TahunLulusSMP' => '2021',
                'KdKelas' => '11TKR', 'KdOrangTua' => 'OT0004', 'created_at' => now(), 'updated_at' => now()
            ],
            [
                'Nama' => 'Bayu Saputra', 'NISN' => '2428240161', 'JenisKelamin' => 'L', 'TempatLahir' => 'Palembang', 'TanggalLahir' => '2005-06-18',
                'Agama' => 'Islam', 'Kewarganegaraan' => 'Indonesia', 'AnakKeBRP' => 3, 'JumlahSaudaraKandung' => 2, 'JumlahSaudaraTiri' => 0, 'AnakYatimPiatu' => 'Tidak',
                'JurusanPilihan' => 'Teknik Kendaraan Ringan', 'UkuranBajuBatik' => 'L', 'UkuranBajuOlahraga' => 'L', 'PenerimaBantuan' => null,
                'Alamat' => 'Jl. Basuki Rahmat No. 101 Palembang', 'NoHP' => '081567890123', 'TinggalBersama' => 'Orang Tua', 'AsalSekolahSMP' => 'SMP Negeri 10 Palembang', 'TahunLulusSMP' => '2021',
                'KdKelas' => '11TKR', 'KdOrangTua' => 'OT0005', 'created_at' => now(), 'updated_at' => now()
            ],
            [
                'Nama' => 'Budi Santoso', 'NISN' => '0102806211', 'JenisKelamin' => 'L', 'TempatLahir' => 'Palembang', 'TanggalLahir' => '2010-11-30',
                'Agama' => 'Islam', 'Kewarganegaraan' => 'Indonesia', 'AnakKeBRP' => 2, 'JumlahSaudaraKandung' => 2, 'JumlahSaudaraTiri' => 0, 'AnakYatimPiatu' => 'Tidak',
                'JurusanPilihan' => 'Manajemen Perkantoran', 'UkuranBajuBatik' => 'M', 'UkuranBajuOlahraga' => 'M', 'PenerimaBantuan' => null,
                'Alamat' => 'Jl. KH. Wahid Hasyim Rt 012 Palembang', 'NoHP' => '081678901234', 'TinggalBersama' => 'Orang Tua', 'AsalSekolahSMP' => 'SMP Negeri 4 Palembang', 'TahunLulusSMP' => '2026',
                'KdKelas' => '10MP', 'KdOrangTua' => 'OT0006', 'created_at' => now(), 'updated_at' => now()
            ],
            [
                'Nama' => 'Citra Lestari', 'NISN' => '0102806212', 'JenisKelamin' => 'P', 'TempatLahir' => 'Jakarta', 'TanggalLahir' => '2009-03-25',
                'Agama' => 'Islam', 'Kewarganegaraan' => 'Indonesia', 'AnakKeBRP' => 1, 'JumlahSaudaraKandung' => 3, 'JumlahSaudaraTiri' => 0, 'AnakYatimPiatu' => 'Tidak',
                'JurusanPilihan' => 'Akuntansi', 'UkuranBajuBatik' => 'M', 'UkuranBajuOlahraga' => 'M', 'PenerimaBantuan' => null,
                'Alamat' => 'Jl. Plaju No. 8 Palembang', 'NoHP' => '081789012345', 'TinggalBersama' => 'Orang Tua', 'AsalSekolahSMP' => 'SMP Xaverius 2 Palembang', 'TahunLulusSMP' => '2025',
                'KdKelas' => '11AK', 'KdOrangTua' => 'OT0007', 'created_at' => now(), 'updated_at' => now()
            ],
            [
                'Nama' => 'Dina Mariana', 'NISN' => '0102806213', 'JenisKelamin' => 'P', 'TempatLahir' => 'Palembang', 'TanggalLahir' => '2008-08-14',
                'Agama' => 'Islam', 'Kewarganegaraan' => 'Indonesia', 'AnakKeBRP' => 2, 'JumlahSaudaraKandung' => 1, 'JumlahSaudaraTiri' => 0, 'AnakYatimPiatu' => 'Tidak',
                'JurusanPilihan' => 'Akuntansi', 'UkuranBajuBatik' => 'L', 'UkuranBajuOlahraga' => 'L', 'PenerimaBantuan' => null,
                'Alamat' => 'Jl. Kamboja No. 54 Palembang', 'NoHP' => '081890123456', 'TinggalBersama' => 'Orang Tua', 'AsalSekolahSMP' => 'SMP Negeri 15 Palembang', 'TahunLulusSMP' => '2024',
                'KdKelas' => '12AK', 'KdOrangTua' => 'OT0008', 'created_at' => now(), 'updated_at' => now()
            ],
            [
                'Nama' => 'Eko Prasetyo', 'NISN' => '0102806214', 'JenisKelamin' => 'L', 'TempatLahir' => 'Palembang', 'TanggalLahir' => '2009-05-10',
                'Agama' => 'Islam', 'Kewarganegaraan' => 'Indonesia', 'AnakKeBRP' => 1, 'JumlahSaudaraKandung' => 2, 'JumlahSaudaraTiri' => 0, 'AnakYatimPiatu' => 'Tidak',
                'JurusanPilihan' => 'Teknik Komputer Jaringan', 'UkuranBajuBatik' => 'L', 'UkuranBajuOlahraga' => 'XL', 'PenerimaBantuan' => null,
                'Alamat' => 'Jl. Sudirman No. 120 Palembang', 'NoHP' => '081901234567', 'TinggalBersama' => 'Orang Tua', 'AsalSekolahSMP' => 'SMP Negeri 2 Palembang', 'TahunLulusSMP' => '2025',
                'KdKelas' => '11TKJ', 'KdOrangTua' => 'OT0009', 'created_at' => now(), 'updated_at' => now()
            ],
            [
                'Nama' => 'Fitri Handayani', 'NISN' => '0102806215', 'JenisKelamin' => 'P', 'TempatLahir' => 'Palembang', 'TanggalLahir' => '2010-02-15',
                'Agama' => 'Islam', 'Kewarganegaraan' => 'Indonesia', 'AnakKeBRP' => 2, 'JumlahSaudaraKandung' => 1, 'JumlahSaudaraTiri' => 0, 'AnakYatimPiatu' => 'Tidak',
                'JurusanPilihan' => 'Teknik Komputer Jaringan', 'UkuranBajuBatik' => 'M', 'UkuranBajuOlahraga' => 'M', 'PenerimaBantuan' => null,
                'Alamat' => 'Jl. Demang Lebar Daun Palembang', 'NoHP' => '082012345678', 'TinggalBersama' => 'Orang Tua', 'AsalSekolahSMP' => 'SMP Negeri 8 Palembang', 'TahunLulusSMP' => '2026',
                'KdKelas' => '10TKJ', 'KdOrangTua' => 'OT0010', 'created_at' => now(), 'updated_at' => now()
            ],
            [
                'Nama' => 'Dewi Lestari', 'NISN' => '0102806216', 'JenisKelamin' => 'P', 'TempatLahir' => 'Palembang', 'TanggalLahir' => '2010-09-09',
                'Agama' => 'Islam', 'Kewarganegaraan' => 'Indonesia', 'AnakKeBRP' => 2, 'JumlahSaudaraKandung' => 2, 'JumlahSaudaraTiri' => 0, 'AnakYatimPiatu' => 'Tidak',
                'JurusanPilihan' => 'Akuntansi', 'UkuranBajuBatik' => 'M', 'UkuranBajuOlahraga' => 'M', 'PenerimaBantuan' => null,
                'Alamat' => 'Lr. Sei goren Rt 023/009 1 Ulu laut', 'NoHP' => '082198765432', 'TinggalBersama' => 'Orang Tua', 'AsalSekolahSMP' => 'MTsS Assalam', 'TahunLulusSMP' => '2026',
                'KdKelas' => '10AK', 'KdOrangTua' => 'OT0001', 'created_at' => now(), 'updated_at' => now()
            ]
        ]);

        // 5. Data Staff
        DB::table('Staff')->insert([
            ['NIY' => 'G000000001', 'Nama' => 'Sri Sari Alam, S.Pd.', 'TempatLahir' => 'Palembang', 'TanggalLahir' => '1975-08-12', 'JenisKelamin' => 'P', 'PendidikanTerakhir' => 'S1', 'Jabatan' => 'Kepala Sekolah', 'NoHP' => '081274628191', 'Alamat' => 'Jl. Mayor Ruslan No. 12 Palembang', 'created_at' => now(), 'updated_at' => now()],
            ['NIY' => 'G000000002', 'Nama' => 'Vira Indriani', 'TempatLahir' => 'Palembang', 'TanggalLahir' => '1985-03-15', 'JenisKelamin' => 'P', 'PendidikanTerakhir' => 'S1', 'Jabatan' => 'Bendahara', 'NoHP' => '081274628192', 'Alamat' => 'Jl. Jenderal Sudirman No. 88 Palembang', 'created_at' => now(), 'updated_at' => now()],
            ['NIY' => 'G000000003', 'Nama' => 'Amaniah, S1', 'TempatLahir' => 'Palembang', 'TanggalLahir' => '2001-07-12', 'JenisKelamin' => 'P', 'PendidikanTerakhir' => 'S1', 'Jabatan' => 'Staff Administrasi', 'NoHP' => '082179572766', 'Alamat' => 'Jln. H. Faqih Usman No. 2062 Kel. 1 Ulu', 'created_at' => now(), 'updated_at' => now()],
            ['NIY' => 'G000000004', 'Nama' => 'Drs. Heri Supriyadi', 'TempatLahir' => 'Palembang', 'TanggalLahir' => '1970-04-20', 'JenisKelamin' => 'L', 'PendidikanTerakhir' => 'S1', 'Jabatan' => 'Guru Matematika', 'NoHP' => '081111111111', 'Alamat' => 'Jl. Sukabangun II No. 12 Palembang', 'created_at' => now(), 'updated_at' => now()],
            ['NIY' => 'G000000005', 'Nama' => 'Diana Putri, S.Si., M.T.', 'TempatLahir' => 'Palembang', 'TanggalLahir' => '1982-11-02', 'JenisKelamin' => 'P', 'PendidikanTerakhir' => 'S2', 'Jabatan' => 'Guru Basis Data', 'NoHP' => '082222222222', 'Alamat' => 'Jl. Mayor Ruslan No. 89 Palembang', 'created_at' => now(), 'updated_at' => now()],
            ['NIY' => 'G000000006', 'Nama' => 'Ir. M. Ridwan, M.T.', 'TempatLahir' => 'Palembang', 'TanggalLahir' => '1978-01-01', 'JenisKelamin' => 'L', 'PendidikanTerakhir' => 'S2', 'Jabatan' => 'Guru TKR', 'NoHP' => '083333333333', 'Alamat' => 'Jl. Kenten Laut No. 44 Palembang', 'created_at' => now(), 'updated_at' => now()],
            ['NIY' => 'G000000007', 'Nama' => 'Rina Astuti, S.Pd.', 'TempatLahir' => 'Palembang', 'TanggalLahir' => '1988-12-25', 'JenisKelamin' => 'P', 'PendidikanTerakhir' => 'S1', 'Jabatan' => 'Guru Bahasa Inggris', 'NoHP' => '084444444444', 'Alamat' => 'Jl. Srijaya Negara No. 10 Palembang', 'created_at' => now(), 'updated_at' => now()],
            ['NIY' => 'G000000008', 'Nama' => 'Andi Wijaya, S.Kom.', 'TempatLahir' => 'Palembang', 'TanggalLahir' => '1992-07-30', 'JenisKelamin' => 'L', 'PendidikanTerakhir' => 'S1', 'Jabatan' => 'Guru Pemrograman Web', 'NoHP' => '087777777777', 'Alamat' => 'Jl. Perumnas Talang Kelapa Palembang', 'created_at' => now(), 'updated_at' => now()],
            ['NIY' => 'G000000009', 'Nama' => 'Eka Susanti, S.Pd.', 'TempatLahir' => 'Palembang', 'TanggalLahir' => '1989-04-18', 'JenisKelamin' => 'P', 'PendidikanTerakhir' => 'S1', 'Jabatan' => 'Guru Jaringan Komputer', 'NoHP' => '089999999999', 'Alamat' => 'Jl. Plaju No. 88 Palembang', 'created_at' => now(), 'updated_at' => now()],
            ['NIY' => 'G000000010', 'Nama' => 'Hendra Wijaya, S.Kom.', 'TempatLahir' => 'Palembang', 'TanggalLahir' => '1991-03-24', 'JenisKelamin' => 'L', 'PendidikanTerakhir' => 'S1', 'Jabatan' => 'Guru Pemrograman Dasar', 'NoHP' => '088888888888', 'Alamat' => 'Jl. Veteran No. 12 Palembang', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // 6. Data Mata Pelajaran
        DB::table('MataPelajaran')->insert([
            ['KdMapel' => 'M001', 'NamaMapel' => 'Basis Data', 'NamaBuku' => 'Basis Data Terapan Versi 2', 'KKM' => 78.00, 'created_at' => now(), 'updated_at' => now()],
            ['KdMapel' => 'M002', 'NamaMapel' => 'Matematika', 'NamaBuku' => 'Matematika SMK Kelompok Bisnis', 'KKM' => 75.00, 'created_at' => now(), 'updated_at' => now()],
            ['KdMapel' => 'M003', 'NamaMapel' => 'Pemrograman Web', 'NamaBuku' => 'Pemrograman Web Dinamis PHP', 'KKM' => 78.00, 'created_at' => now(), 'updated_at' => now()],
            ['KdMapel' => 'M004', 'NamaMapel' => 'Bahasa Inggris', 'NamaBuku' => 'English for Vocational School', 'KKM' => 70.00, 'created_at' => now(), 'updated_at' => now()],
            ['KdMapel' => 'M005', 'NamaMapel' => 'Teknik Kendaraan Ringan', 'NamaBuku' => 'Konsep Dasar Otomotif TKR', 'KKM' => 80.00, 'created_at' => now(), 'updated_at' => now()],
            ['KdMapel' => 'M006', 'NamaMapel' => 'Jaringan Komputer', 'NamaBuku' => 'Jaringan Dasar & Troubleshooting', 'KKM' => 75.00, 'created_at' => now(), 'updated_at' => now()],
            ['KdMapel' => 'M007', 'NamaMapel' => 'Bahasa Indonesia', 'NamaBuku' => 'Bahasa Indonesia Terapan', 'KKM' => 75.00, 'created_at' => now(), 'updated_at' => now()],
            ['KdMapel' => 'M008', 'NamaMapel' => 'Fisika Terapan', 'NamaBuku' => 'Fisika Industri Ringan', 'KKM' => 70.00, 'created_at' => now(), 'updated_at' => now()],
            ['KdMapel' => 'M009', 'NamaMapel' => 'Pendidikan Pancasila', 'NamaBuku' => 'Pendidikan Pancasila SMK', 'KKM' => 75.00, 'created_at' => now(), 'updated_at' => now()],
            ['KdMapel' => 'M010', 'NamaMapel' => 'Kimia Industri', 'NamaBuku' => 'Kimia Dasar Kejuruan', 'KKM' => 70.00, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // 7. Data Jadwal Pelajaran
        DB::table('JadwalPelajaran')->insert([
            ['KdJadwal' => 'JD0001', 'Hari' => 'Senin', 'JamMulai' => '07:30:00', 'JamSelesai' => '09:45:00', 'KdStaff' => 'G000000005', 'KdMapel' => 'M001', 'KdKelas' => '11TKR', 'created_at' => now(), 'updated_at' => now()],
            ['KdJadwal' => 'JD0002', 'Hari' => 'Senin', 'JamMulai' => '10:00:00', 'JamSelesai' => '12:15:00', 'KdStaff' => 'G000000004', 'KdMapel' => 'M002', 'KdKelas' => '11TKR', 'created_at' => now(), 'updated_at' => now()],
            ['KdJadwal' => 'JD0003', 'Hari' => 'Selasa', 'JamMulai' => '08:00:00', 'JamSelesai' => '10:15:00', 'KdStaff' => 'G000000008', 'KdMapel' => 'M003', 'KdKelas' => '11TKR', 'created_at' => now(), 'updated_at' => now()],
            ['KdJadwal' => 'JD0004', 'Hari' => 'Rabu', 'JamMulai' => '07:30:00', 'JamSelesai' => '09:45:00', 'KdStaff' => 'G000000006', 'KdMapel' => 'M005', 'KdKelas' => '12TKR', 'created_at' => now(), 'updated_at' => now()],
            ['KdJadwal' => 'JD0005', 'Hari' => 'Kamis', 'JamMulai' => '08:30:00', 'JamSelesai' => '10:45:00', 'KdStaff' => 'G000000007', 'KdMapel' => 'M004', 'KdKelas' => '11TKR', 'created_at' => now(), 'updated_at' => now()],
            ['KdJadwal' => 'JD0006', 'Hari' => 'Jumat', 'JamMulai' => '08:00:00', 'JamSelesai' => '10:15:00', 'KdStaff' => 'G000000005', 'KdMapel' => 'M001', 'KdKelas' => '10AK', 'created_at' => now(), 'updated_at' => now()],
            ['KdJadwal' => 'JD0007', 'Hari' => 'Selasa', 'JamMulai' => '10:30:00', 'JamSelesai' => '12:45:00', 'KdStaff' => 'G000000004', 'KdMapel' => 'M002', 'KdKelas' => '10AK', 'created_at' => now(), 'updated_at' => now()],
            ['KdJadwal' => 'JD0008', 'Hari' => 'Rabu', 'JamMulai' => '10:00:00', 'JamSelesai' => '12:15:00', 'KdStaff' => 'G000000008', 'KdMapel' => 'M003', 'KdKelas' => '10TKR', 'created_at' => now(), 'updated_at' => now()],
            ['KdJadwal' => 'JD0009', 'Hari' => 'Kamis', 'JamMulai' => '10:30:00', 'JamSelesai' => '12:45:00', 'KdStaff' => 'G000000007', 'KdMapel' => 'M004', 'KdKelas' => '10TKJ', 'created_at' => now(), 'updated_at' => now()],
            ['KdJadwal' => 'JD0010', 'Hari' => 'Jumat', 'JamMulai' => '10:30:00', 'JamSelesai' => '12:45:00', 'KdStaff' => 'G000000009', 'KdMapel' => 'M006', 'KdKelas' => '11TKJ', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // 8. Data Pembayaran
        DB::table('Pembayaran')->insert([
            ['KdPembayaran' => 'P00001', 'BulanBayar' => 'Juli 2026', 'TglBayar' => '2026-07-05', 'JumlahBayar' => 150000.00, 'MetodePembayaran' => 'Tunai', 'NISN' => '0102806210', 'created_at' => now(), 'updated_at' => now()],
            ['KdPembayaran' => 'P00002', 'BulanBayar' => 'Juli 2026', 'TglBayar' => '2026-07-06', 'JumlahBayar' => 150000.00, 'MetodePembayaran' => 'Transfer', 'NISN' => '2428240159', 'created_at' => now(), 'updated_at' => now()],
            ['KdPembayaran' => 'P00003', 'BulanBayar' => 'Juli 2026', 'TglBayar' => '2026-07-08', 'JumlahBayar' => 150000.00, 'MetodePembayaran' => 'Transfer', 'NISN' => '2428240123', 'created_at' => now(), 'updated_at' => now()],
            ['KdPembayaran' => 'P00004', 'BulanBayar' => 'Juli 2026', 'TglBayar' => '2026-07-05', 'JumlahBayar' => 150000.00, 'MetodePembayaran' => 'Tunai', 'NISN' => '2428240147', 'created_at' => now(), 'updated_at' => now()],
            ['KdPembayaran' => 'P00005', 'BulanBayar' => 'Juli 2026', 'TglBayar' => null, 'JumlahBayar' => 150000.00, 'MetodePembayaran' => 'BelumBayar', 'NISN' => '2428240161', 'created_at' => now(), 'updated_at' => now()],
            ['KdPembayaran' => 'P00006', 'BulanBayar' => 'Juli 2026', 'TglBayar' => '2026-07-10', 'JumlahBayar' => 150000.00, 'MetodePembayaran' => 'Tunai', 'NISN' => '0102806211', 'created_at' => now(), 'updated_at' => now()],
            ['KdPembayaran' => 'P00007', 'BulanBayar' => 'Juli 2026', 'TglBayar' => null, 'JumlahBayar' => 150000.00, 'MetodePembayaran' => 'BelumBayar', 'NISN' => '0102806212', 'created_at' => now(), 'updated_at' => now()],
            ['KdPembayaran' => 'P00008', 'BulanBayar' => 'Juli 2026', 'TglBayar' => '2026-07-12', 'JumlahBayar' => 150000.00, 'MetodePembayaran' => 'Transfer', 'NISN' => '0102806213', 'created_at' => now(), 'updated_at' => now()],
            ['KdPembayaran' => 'P00009', 'BulanBayar' => 'Juli 2026', 'TglBayar' => '2026-07-07', 'JumlahBayar' => 150000.00, 'MetodePembayaran' => 'Tunai', 'NISN' => '0102806214', 'created_at' => now(), 'updated_at' => now()],
            ['KdPembayaran' => 'P00010', 'BulanBayar' => 'Juli 2026', 'TglBayar' => null, 'JumlahBayar' => 150000.00, 'MetodePembayaran' => 'BelumBayar', 'NISN' => '0102806215', 'created_at' => now(), 'updated_at' => now()],
            ['KdPembayaran' => 'P00011', 'BulanBayar' => 'Juli 2026', 'TglBayar' => '2026-07-09', 'JumlahBayar' => 150000.00, 'MetodePembayaran' => 'Tunai', 'NISN' => '0102806216', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // 9. Data Nilai
        DB::table('Nilai')->insert([
            ['NISN' => '0102806210', 'KdMapel' => 'M002', 'Semester' => 'Ganjil', 'nilaiUTS' => 80.00, 'nilaiUAS' => 85.00, 'nilaiTugas' => 80.00, 'nilaiAkhir' => 82.00, 'Keterangan' => 'Tuntas', 'created_at' => now(), 'updated_at' => now()],
            ['NISN' => '2428240159', 'KdMapel' => 'M001', 'Semester' => 'Ganjil', 'nilaiUTS' => 90.00, 'nilaiUAS' => 90.00, 'nilaiTugas' => 85.00, 'nilaiAkhir' => 88.50, 'Keterangan' => 'Tuntas', 'created_at' => now(), 'updated_at' => now()],
            ['NISN' => '2428240123', 'KdMapel' => 'M001', 'Semester' => 'Ganjil', 'nilaiUTS' => 70.00, 'nilaiUAS' => 75.00, 'nilaiTugas' => 75.00, 'nilaiAkhir' => 73.50, 'Keterangan' => 'Remedial', 'created_at' => now(), 'updated_at' => now()],
            ['NISN' => '2428240147', 'KdMapel' => 'M001', 'Semester' => 'Ganjil', 'nilaiUTS' => 90.00, 'nilaiUAS' => 90.00, 'nilaiTugas' => 90.00, 'nilaiAkhir' => 90.00, 'Keterangan' => 'Tuntas', 'created_at' => now(), 'updated_at' => now()],
            ['NISN' => '2428240161', 'KdMapel' => 'M001', 'Semester' => 'Ganjil', 'nilaiUTS' => 65.00, 'nilaiUAS' => 68.00, 'nilaiTugas' => 60.00, 'nilaiAkhir' => 64.70, 'Keterangan' => 'Remedial', 'created_at' => now(), 'updated_at' => now()],
            ['NISN' => '0102806211', 'KdMapel' => 'M002', 'Semester' => 'Ganjil', 'nilaiUTS' => 80.00, 'nilaiUAS' => 78.00, 'nilaiTugas' => 75.00, 'nilaiAkhir' => 77.70, 'Keterangan' => 'Tuntas', 'created_at' => now(), 'updated_at' => now()],
            ['NISN' => '0102806212', 'KdMapel' => 'M002', 'Semester' => 'Ganjil', 'nilaiUTS' => 70.00, 'nilaiUAS' => 72.00, 'nilaiTugas' => 75.00, 'nilaiAkhir' => 72.30, 'Keterangan' => 'Remedial', 'created_at' => now(), 'updated_at' => now()],
            ['NISN' => '0102806213', 'KdMapel' => 'M002', 'Semester' => 'Ganjil', 'nilaiUTS' => 85.00, 'nilaiUAS' => 90.00, 'nilaiTugas' => 88.00, 'nilaiAkhir' => 87.90, 'Keterangan' => 'Tuntas', 'created_at' => now(), 'updated_at' => now()],
            ['NISN' => '0102806214', 'KdMapel' => 'M006', 'Semester' => 'Ganjil', 'nilaiUTS' => 92.00, 'nilaiUAS' => 95.00, 'nilaiTugas' => 90.00, 'nilaiAkhir' => 92.60, 'Keterangan' => 'Tuntas', 'created_at' => now(), 'updated_at' => now()],
            ['NISN' => '0102806215', 'KdMapel' => 'M006', 'Semester' => 'Ganjil', 'nilaiUTS' => 75.00, 'nilaiUAS' => 80.00, 'nilaiTugas' => 78.00, 'nilaiAkhir' => 77.90, 'Keterangan' => 'Tuntas', 'created_at' => now(), 'updated_at' => now()],
            ['NISN' => '0102806216', 'KdMapel' => 'M002', 'Semester' => 'Ganjil', 'nilaiUTS' => 60.00, 'nilaiUAS' => 65.00, 'nilaiTugas' => 68.00, 'nilaiAkhir' => 64.40, 'Keterangan' => 'Remedial', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Enable Foreign Key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
