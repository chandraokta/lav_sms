# 📄 Aplikasi Pribadi Guru SMP: Absensi & Nilai
*Versi: 1.0 (Pribadi - Localhost)*  
*Author: [Nama Kamu]*  
*Platform: Laravel 8*  
*Hanya untuk Penggunaan Pribadi*

---

## 🎯 Deskripsi
Aplikasi ini adalah **alat bantu pribadi** bagi seorang guru SMP untuk mencatat **kehadiran siswa** dan **nilai akademik** secara cepat dan teratur.  
Dirancang khusus untuk **satu pengguna (guru)**, tanpa akun siswa, orang tua, atau petugas lain.

Dijalankan sepenuhnya di **localhost**, cocok untuk:
- Portofolio Laravel
- Alat bantu mengajar
- Presentasi
- Simpanan data offline

---

## 🛠️ Teknologi
- **Framework**: Laravel 8
- **Template**: Blade + Bootstrap (offline)
- **Database**: MySQL (XAMPP)
- **Autentikasi**: Laravel UI (login guru)
- **Export**: `barryvdh/laravel-dompdf` (PDF)
- **Library tambahan**: 
  - `hashids/hashids` (enkripsi ID)
  - `fakerphp/faker` (data dummy)

---

## ✅ Fitur Inti (Minimalis & Efisien)

### 1. **Login Pribadi**
- Hanya 1 akun guru
- Login dengan email & password
- Ganti password di halaman profil

### 2. **Manajemen Data Dasar**
- **Kelas**: Manajemen kelas
- **Siswa**: NIS, nama, jenis kelamin, kelas
- **Mata Pelajaran**: Matematika, IPA, Bahasa Indonesia, dll
- **Tahun Ajaran**: Pengaturan tahun ajaran

> 💡 Tidak ada relasi kompleks. Guru bisa akses semua kelas & mapel.

### 3. **Input Absensi Harian**
- Pilih kelas & tanggal
- Tampilkan daftar siswa
- Pilih status: Hadir (H), Sakit (S), Izin (I), Alpa (A)
- Simpan semua dengan satu klik
- Bisa input ulang jika salah

### 4. **Input Nilai Massal**
- Pilih: kelas, mapel, jenis nilai (Tugas, UH, UTS, UAS)
- Tabel input: semua siswa dalam satu halaman
- Validasi: nilai 0–100
- Simpan sekaligus

### 5. **Rekap & Laporan**
- Rekap absensi per kelas
- Rata-rata nilai per siswa
- Cetak rapor sederhana

### 6. **Backup Data Lokal**
- Tombol "Backup Sekarang" → simpan `.sql` di `storage/app/backups/`
- Restore manual dari file SQL

---

## 🚫 Fitur yang DIHAPUS (Karena Tidak Perlu)
- ❌ Akun siswa / orang tua / librarian
- ❌ Verifikasi email
- ❌ Notifikasi email/SMS
- ❌ Multi-guru atau role kompleks
- ❌ API eksternal
- ❌ Wali kelas atau jadwal otomatis
- ❌ Ekstrakurikuler, sikap, deskripsi

> ✅ Fokus: **absensi + nilai + cetak**

---

## 🖥️ Lingkungan Lokal (Offline)
- Tidak butuh internet
- Semua data disimpan di database lokal
- Aman dan privat

---

## 📁 Struktur Folder
```
lav_sms/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       └── SupportTeam/     # Controller utama (Absensi, Nilai, Laporan)
│   ├── Models/                  # Model data (Student, Mark, Attendance, dll)
│   └── User.php                 # Model user
├── database/
│   ├── migrations/              # Skema database
│   └── seeders/                 # Data awal
├── resources/
│   ├── views/
│   │   ├── absensi/             # View absensi (create, rekap)
│   │   ├── nilai/               # View nilai (create, rekap)
│   │   ├── laporan/             # View laporan (rapor)
│   │   └── layouts/             # Template layout
│   └── lang/                    # Bahasa (Indonesia/Inggris)
├── routes/
│   └── web.php                  # Semua rute aplikasi
├── storage/
│   └── app/                     # File upload dan backup
├── .env                         # Konfigurasi lokal
└── app_summary.md               # Dokumentasi ini
```

---

## ⚙️ Cara Instalasi

1. **Buka terminal di folder project**
   ```bash
   composer install
   ```

2. **Buat file .env**
   ```bash
   cp .env.example .env
   ```

3. **Edit .env**
   ```env
   DB_DATABASE=lav_sms
   DB_USERNAME=root
   DB_PASSWORD=
   ```

4. **Generate key & migrate**
   ```bash
   php artisan key:generate
   php artisan migrate --seed
   php artisan storage:link
   ```

5. **Jalankan server**
   ```bash
   php artisan serve
   ```

6. **Buka di browser**
   ```
   http://localhost:8000
   ```

7. **Login**
   - Email: `guru@localhost`
   - Password: `12345678`

---

## 🧪 Data Awal (Seeder)
- 1 akun guru
- Kelas dan tingkat
- Mata pelajaran
- Data siswa dummy
- Tahun ajaran

---

## 📎 Catatan
- Aplikasi ini **hanya untuk satu guru**.
- Tidak ada fitur yang terbuang atau berlebihan.
- Cepat, ringan, dan mudah digunakan.
- Cocok untuk portofolio Laravel atau alat bantu pribadi.

---

> 💡 **Tips**:  
> - Ganti nama guru di seeder jika perlu.  
> - Tambahkan logo sekolah di layout (opsional).  
> - Backup rutin jika data penting.

---

✅ **Dokumen ini adalah bagian resmi dari project. Simpan selalu di folder root.**  
📄 File: `app_summary.md`