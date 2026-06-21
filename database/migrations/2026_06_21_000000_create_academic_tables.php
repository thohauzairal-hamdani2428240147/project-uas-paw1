<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Drop tables if they exist to prevent migration conflicts
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('Nilai');
        Schema::dropIfExists('Pembayaran');
        Schema::dropIfExists('JadwalPelajaran');
        Schema::dropIfExists('MataPelajaran');
        Schema::dropIfExists('Staff');
        Schema::dropIfExists('Siswa');
        Schema::dropIfExists('OrangTua');
        Schema::dropIfExists('Kelas');
        Schema::dropIfExists('Jurusan');
        Schema::enableForeignKeyConstraints();

        // 1. Tabel Jurusan
        Schema::create('Jurusan', function (Blueprint $table) {
            $table->char('KdJurusan', 4)->primary();
            $table->string('NamaJurusan', 40);
            $table->timestamps();
        });

        // 2. Tabel Kelas
        Schema::create('Kelas', function (Blueprint $table) {
            $table->char('KdKelas', 6)->primary();
            $table->string('NamaKelas', 40);
            $table->char('KdJurusan', 4);
            $table->foreign('KdJurusan')->references('KdJurusan')->on('Jurusan')->onUpdate('cascade')->onDelete('restrict');
            $table->timestamps();
        });

        // 3. Tabel OrangTua
        Schema::create('OrangTua', function (Blueprint $table) {
            $table->char('KdOrangTua', 6)->primary();
            $table->string('NamaAyah', 60)->nullable();
            $table->string('TempatLahirAyah', 30)->nullable();
            $table->date('TanggalLahirAyah')->nullable();
            $table->string('AgamaAyah', 25)->nullable();
            $table->string('KewarganegaraanAyah', 20)->nullable();
            $table->string('PendidikanTerakhirAyah', 20)->nullable();
            $table->string('PekerjaanAyah', 30)->nullable();
            $table->decimal('PenghasilanAyah', 12, 2)->nullable();
            $table->string('AlamatAyah', 255)->nullable();
            
            $table->string('NamaIbu', 60);
            $table->string('TempatLahirIbu', 30);
            $table->date('TanggalLahirIbu');
            $table->string('AgamaIbu', 25);
            $table->string('KewarganegaraanIbu', 20);
            $table->string('PendidikanTerakhirIbu', 20)->nullable();
            $table->string('PekerjaanIbu', 30);
            $table->decimal('PenghasilanIbu', 12, 2)->nullable();
            $table->string('AlamatIbu', 255);
            $table->timestamps();
        });

        // 4. Tabel Siswa
        Schema::create('Siswa', function (Blueprint $table) {
            $table->string('Nama', 60);
            $table->char('NISN', 10)->primary();
            $table->char('JenisKelamin', 2);
            $table->string('TempatLahir', 25);
            $table->date('TanggalLahir');
            $table->string('Agama', 25);
            $table->string('Kewarganegaraan', 20);
            $table->integer('AnakKeBRP');
            $table->integer('JumlahSaudaraKandung');
            $table->integer('JumlahSaudaraTiri')->default(0);
            $table->string('AnakYatimPiatu', 20)->nullable();
            $table->string('JurusanPilihan', 30)->nullable();
            $table->char('UkuranBajuBatik', 2);
            $table->char('UkuranBajuOlahraga', 2);
            $table->string('PenerimaBantuan', 50)->nullable();
            $table->string('Alamat', 255);
            $table->string('NoHP', 13);
            $table->string('TinggalBersama', 30);
            $table->string('AsalSekolahSMP', 50);
            $table->char('TahunLulusSMP', 4);
            $table->char('KdKelas', 6);
            $table->char('KdOrangTua', 6);
            
            $table->foreign('KdKelas')->references('KdKelas')->on('Kelas')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('KdOrangTua')->references('KdOrangTua')->on('OrangTua')->onUpdate('cascade')->onDelete('restrict');
            $table->timestamps();
        });

        // 5. Tabel Staff
        Schema::create('Staff', function (Blueprint $table) {
            $table->char('NIY', 10)->primary();
            $table->string('Nama', 60);
            $table->string('TempatLahir', 30);
            $table->date('TanggalLahir');
            $table->char('JenisKelamin', 2);
            $table->string('PendidikanTerakhir', 10);
            $table->string('Jabatan', 30);
            $table->char('NoHP', 13);
            $table->string('Alamat', 255);
            $table->timestamps();
        });

        // 6. Tabel MataPelajaran
        Schema::create('MataPelajaran', function (Blueprint $table) {
            $table->char('KdMapel', 10)->primary();
            $table->string('NamaMapel', 30);
            $table->string('NamaBuku', 50)->nullable();
            $table->decimal('KKM', 5, 2);
            $table->timestamps();
        });

        // 7. Tabel JadwalPelajaran
        Schema::create('JadwalPelajaran', function (Blueprint $table) {
            $table->char('KdJadwal', 6)->primary();
            $table->string('Hari', 10);
            $table->time('JamMulai');
            $table->time('JamSelesai');
            $table->char('KdStaff', 10);
            $table->char('KdMapel', 10);
            $table->char('KdKelas', 6);
            
            $table->foreign('KdStaff')->references('NIY')->on('Staff')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('KdMapel')->references('KdMapel')->on('MataPelajaran')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('KdKelas')->references('KdKelas')->on('Kelas')->onUpdate('cascade')->onDelete('restrict');
            $table->timestamps();
        });

        // 8. Tabel Pembayaran
        Schema::create('Pembayaran', function (Blueprint $table) {
            $table->char('KdPembayaran', 6)->primary();
            $table->string('BulanBayar', 15);
            $table->date('TglBayar')->nullable();
            $table->decimal('JumlahBayar', 10, 2);
            $table->string('MetodePembayaran', 15);
            $table->char('NISN', 10);
            
            $table->foreign('NISN')->references('NISN')->on('Siswa')->onUpdate('cascade')->onDelete('restrict');
            $table->timestamps();
        });

        // 9. Tabel Nilai
        Schema::create('Nilai', function (Blueprint $table) {
            $table->char('NISN', 10);
            $table->char('KdMapel', 10);
            $table->string('Semester', 10);
            $table->decimal('nilaiUTS', 5, 2);
            $table->decimal('nilaiUAS', 5, 2);
            $table->decimal('nilaiTugas', 5, 2);
            $table->decimal('nilaiAkhir', 5, 2);
            $table->string('Keterangan', 10);
            
            $table->primary(['NISN', 'KdMapel', 'Semester']);
            $table->foreign('NISN')->references('NISN')->on('Siswa')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('KdMapel')->references('KdMapel')->on('MataPelajaran')->onUpdate('cascade')->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Nilai');
        Schema::dropIfExists('Pembayaran');
        Schema::dropIfExists('JadwalPelajaran');
        Schema::dropIfExists('MataPelajaran');
        Schema::dropIfExists('Staff');
        Schema::dropIfExists('Siswa');
        Schema::dropIfExists('OrangTua');
        Schema::dropIfExists('Kelas');
        Schema::dropIfExists('Jurusan');
    }
};
