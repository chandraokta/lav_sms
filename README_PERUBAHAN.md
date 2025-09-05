# Aplikasi Pribadi Guru SMP: Absensi & Nilai

## Struktur Folder yang Telah Diubah

Sesuai dengan spesifikasi dalam `app_summary.md`, struktur folder telah diubah menjadi:

```
resources/views/
├── absensi/
│   ├── create.blade.php     # Input absensi
│   └── rekap.blade.php      # Rekap absensi
├── nilai/
│   ├── create.blade.php     # Input nilai
│   └── rekap.blade.php      # Rekap nilai
├── laporan/
│   └── rapor.blade.php      # Cetak rapor
└── layouts/
    └── app.blade.php        # Layout utama
```

## Perubahan yang Telah Dilakukan

1. **Penyederhanaan Menu** - Hanya menampilkan fitur yang diperlukan untuk guru pribadi
2. **Perubahan Struktur Folder** - Menyesuaikan dengan spesifikasi `app_summary.md`
3. **Penamaan Route** - Mengubah nama route menjadi lebih sesuai dengan fungsi:
   - `absensi.rekap` untuk rekap absensi
   - `absensi.create` untuk input absensi
   - `nilai.create` untuk input nilai
   - `nilai.rekap` untuk rekap nilai
   - `laporan.rekap` untuk rekap laporan
   - `laporan.print` untuk cetak rapor

## Cara Mengakses Aplikasi

1. Jalankan server web (XAMPP/Laragon)
2. Akses melalui browser: `http://localhost/lav_sms`
3. Login dengan kredensial:
   - Email: `guru@localhost`
   - Password: `12345678`

## Troubleshooting Login

Jika mengalami masalah login:
1. Pastikan database sudah di-migrate dan di-seed dengan benar
2. Bersihkan cache browser
3. Periksa apakah form login menggunakan field "identity" (bukan email)
4. Jika masih bermasalah, coba gunakan username "guru" sebagai ganti email

## Fitur yang Tersedia

- **Absensi**: Input dan rekap kehadiran siswa
- **Nilai**: Input dan rekap nilai akademik
- **Laporan**: Rekap data dan cetak rapor
- **Backup Data**: Backup database lokal
- **Data Dasar**: Kelola kelas, siswa, mata pelajaran, tahun ajaran

Aplikasi ini dirancang khusus untuk kebutuhan pribadi seorang guru, dengan fokus pada efisiensi dan kemudahan penggunaan.