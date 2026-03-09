FAKE DANA GENERATOR
===================
Version: 1.0.0
Author: Original Developer
Website: https://fakedanageneratorditzx-production.up.railway.app/

STRUKTUR FOLDER:
----------------
/fakedana-generator/
├── index.html              # Halaman utama
├── api/
│   └── generate.php        # Backend API (opsional)
├── assets/
│   ├── css/
│   │   └── style.css       # Semua styling
│   ├── js/
│   │   └── script.js       # Semua JavaScript
│   └── images/
│       └── favicon.ico      # Icon website
└── README.txt               # File ini

FITUR LENGKAP:
--------------
✓ Tampilan 100% mirip website asli
✓ Responsive (HP, Tablet, Desktop)
✓ Format Rupiah otomatis (contoh: 1000000 => 1.000.000)
✓ Validasi input
✓ Loading animation
✓ Download hasil sebagai PNG
✓ Reset button
✓ Error handling
✓ Enter key support
✓ Clean UI tanpa elemen berlebihan

CARA INSTALL:
-------------
1. Upload semua file ke hosting Anda
2. Pastikan struktur folder tetap seperti di atas
3. Jika menggunakan backend asli, sesuaikan URL di script.js
4. Untuk testing lokal, gunakan XAMPP/Laragon atau live server

KONFIGURASI API:
----------------
Secara default, kode akan memanggil endpoint:
POST /api/generate

Jika endpoint berbeda, ubah di file assets/js/script.js 
pada bagian fetch('/api/generate', ...)

TESTING TANPA BACKEND:
----------------------
Untuk testing tampilan tanpa backend:
1. Buka file assets/js/script.js
2. Cari function handleGenerate()
3. Ganti dengan versi simulasi (ada di komentar)

PERBEDAAN DENGAN WEBSITE ASLI:
------------------------------
- Kode ini menggunakan struktur folder yang rapi (CSS/JS terpisah)
- 100% fungsionalitas sama persis dengan aslinya
- Tampilan identik, warna, font, spacing sama persis
- Sudah responsive untuk semua device

TROUBLESHOOTING:
----------------
1. Error "Gagal generate" 
   → Pastikan backend API aktif dan URL-nya benar

2. Gambar tidak muncul
   → Cek console browser (F12) untuk melihat error

3. Format rupiah tidak berfungsi
   → Hapus cache browser atau coba di private window

4. Download tidak bekerja
   → Pastikan browser mendukung fitur Blob

KREDIT:
-------
- Font: -apple-system, BlinkMacSystemFont (system default)
- Icons: Menggunakan karakter Unicode
- Framework: Vanilla HTML, CSS, JavaScript (no dependencies)

NOTE:
-----
Tools ini untuk tujuan edukasi. Tidak terafiliasi dengan DANA.