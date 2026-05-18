# PT Ghina Tour Travel — Company Profile & Booking System

Sistem Company Profile dan Pemesanan Paket Tour milik **PT Ghina Tour Travel** yang dibuat menggunakan framework **Laravel**. Proyek ini dirancang agar responsif, interaktif, dan mudah dikelola oleh admin.

---

## 🚀 Fitur Unggulan Terbaru

1. **Overhaul Struktur Database (Migrasi Tempat ke Destinasi)**:
   * Mengubah istilah dan tabel `tempats` secara total menjadi `destinasis` agar lebih presisi.
   * Menambahkan kolom `image` pada tabel `fasilitas` untuk visualisasi ikon fasilitas (transportasi, akomodasi, konsumsi).
   
2. **Katalog Paket Tour Rill (`PaketSeeder.php`)**:
   * Database kini diisi dengan **10 paket wisata rill** yang diambil langsung dari dokumen katalog `GHINA TOUR.pdf` (misalnya Jogja One Day, Dieng, Malang, Karimunjawa, Bali, dll.).
   * Seeder dilengkapi fungsi **PHP GD Library** untuk melahirkan file gambar dummy secara dinamis ke direktori lokal tanpa mengotori Git.

3. **Manajemen Media & Galeri Pintar (Admin Panel)**:
   * **Filter Tab Kategori**: Admin bisa memfilter seluruh media galeri berdasarkan tab **Semua**, **Destinasi**, **Fasilitas**, dan **Dokumentasi**.
   * **Drag & Drop Upload + Tombol Batal Individual (X)**: Di halaman upload media, admin dapat menyeret file dan membatalkan/menghapus file tertentu secara individual melalui tombol X merah saat hover sebelum data dikirim ke server.

4. **Lightbox Multi-Halaman Global (Customer Frontend)**:
   * Seluruh gambar/video di area publik customer (halaman Beranda, Galeri, gambar Destinasi di Detail Paket, serta gambar ikon kecil di Fasilitas) dapat diklik untuk diperbesar secara penuh menggunakan pop-up **Lightbox Global** yang interaktif.
   * Mendukung video `.mp4`, auto-pause saat ditutup, penutupan via tombol ×, klik luar area, atau tombol **Escape**.

5. **Isolasi Galeri Publik**:
   * Galeri publik pelanggan disetel khusus hanya menampilkan dokumentasi perjalanan murni saja (yang relasinya `null` / tidak dihubungkan ke paket/destinasi/fasilitas) agar foto bawaan katalog tidak mengotori feed dokumentasi tour.

---

## 🛠️ Panduan Instalasi / Panduan bagi Kolaborator Baru

Jika Anda baru saja melakukan **`git pull`** dari repositori ini, ikuti langkah-langkah wajib berikut untuk menyelaraskan aset fisik dan database lokal Anda:

### 1. Buat File Environment & Kunci Aplikasi
Jika Anda belum memilikinya, salin file `.env` dari `.env.example`:
```bash
cp .env.example .env
php artisan key:generate
```
*Jangan lupa atur konfigurasi `DB_DATABASE`, `DB_USERNAME`, dan `DB_PASSWORD` sesuai MySQL lokal Anda.*

### 2. Hubungkan Storage Link (Wajib)
Laravel menyimpan file publik di `storage/app/public`. Hubungkan jembatan symlink ke folder `public/storage` dengan menjalankan:
```bash
php artisan storage:link
```
*(Perintah ini akan melahirkan folder shortcut `public/storage` lokal).*

### 3. Segarkan Database & Jalankan Seeder Dinamis (Wajib)
Jalankan perintah ini untuk membangun tabel-tabel baru dan memicu fungsi PHP GD melahirkan file gambar bawaan secara dinamis ke folder storage lokal Anda:
```bash
php artisan migrate:fresh --seed
```

### 4. Jalankan Server Lokal
Jalankan dev server Laravel dan NPM (jika menggunakan aset build Vite):
```bash
# Terminal 1 - Server PHP
php artisan serve

# Terminal 2 - Server Aset Vite
npm run dev
```

---

## 📂 Struktur Folder Aset Media Lokal (Penting)
* File fisik unggahan disimpan secara lokal di: `storage/app/public/galleries/`
* URL akses web publik dipetakan lewat: `public/storage/galleries/`
* Folder `storage/app/public/` dimasukkan ke dalam `.gitignore` agar tidak membengkaki ukuran repository Git.

---

## 📝 Lisensi
Proyek ini dibuat untuk pemenuhan tugas mata kuliah dan dikembangkan secara internal oleh tim PT Ghina Tour Travel. Ditulis menggunakan basis framework Laravel open-source berlisensi [MIT license](https://opensource.org/licenses/MIT).

