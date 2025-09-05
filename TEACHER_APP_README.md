# Aplikasi Pribadi Guru SMP: Absensi & Nilai

## Deskripsi
Aplikasi ini telah disesuaikan untuk digunakan oleh seorang guru SMP sebagai alat bantu pribadi untuk mencatat kehadiran dan nilai siswa secara cepat dan teratur. Aplikasi ini dirancang khusus untuk satu pengguna (guru) tanpa akun siswa, orang tua, atau petugas lain.

## Fitur Utama
1. **Login Pribadi** - Hanya 1 akun guru
2. **Manajemen Data Dasar** - Kelas, Siswa, Mata Pelajaran, Tahun Ajaran
3. **Input Absensi Harian** - Pilih kelas & tanggal, input status kehadiran
4. **Input Nilai Massal** - Input nilai untuk semua siswa dalam satu halaman
5. **Rekap & Laporan** - Rekap absensi dan nilai per kelas
6. **Cetak Rapor Sederhana** - Cetak rapor per siswa atau per kelas
7. **Backup Data Lokal** - Backup data dalam bentuk file SQL

## Perubahan yang Dilakukan
1. **Penyederhanaan Menu** - Menghapus menu yang tidak diperlukan untuk aplikasi pribadi guru
2. **Pembatasan Akses** - Hanya role "teacher" yang dapat mengakses fitur-fitur aplikasi
3. **Penambahan Fitur Absensi** - Membuat model, controller, dan view untuk absensi harian
4. **Penyederhanaan Laporan** - Membuat laporan rekap nilai dan cetak rapor yang sederhana
5. **Backup Data** - Menambahkan fitur backup data lokal
6. **Dashboard Guru** - Membuat dashboard khusus untuk guru dengan akses cepat ke fitur utama

## Struktur Menu
- Dashboard
- Absensi (Input Absensi, Rekap Absensi)
- Nilai (Input Nilai, Rekap Nilai)
- Laporan (Rekap Laporan, Cetak Rapor)
- Backup Data
- Data Dasar (Kelas, Siswa, Mata Pelajaran, Tahun Ajaran)
- Akun Saya

## Catatan
Aplikasi ini hanya untuk penggunaan pribadi seorang guru dan tidak memerlukan fitur yang kompleks seperti sistem informasi sekolah lengkap. Semua data disimpan secara lokal dan tidak memerlukan koneksi internet untuk penggunaan harian.