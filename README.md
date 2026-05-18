# PT Ghina Tour Travel — Company Profile & Booking System

Aplikasi berbasis web **Company Profile dan Sistem Katalog/Pemesanan Paket Tour** milik **PT Ghina Tour Travel** yang dibangun menggunakan framework **Laravel**. 

Sistem ini ditujukan untuk mempermudah calon pelanggan menjelajahi paket perjalanan wisata, melihat dokumentasi foto/video galeri tour, dan melakukan pemesanan via WhatsApp, serta menyediakan panel kontrol admin yang lengkap untuk pengelolaan paket, destinasi, fasilitas, pemesanan, dan aset galeri media secara dinamis.

---

## 🛠️ Panduan Instalasi & Pengaturan Project

Gunakan panduan berikut untuk memasang project di komputer lokal Anda, baik untuk pemasangan pertama kali (**Clone**) maupun saat memperbarui pembaruan dari repository (**Pull**).

### A. Persiapan Awal (Bagi yang baru pertama kali Clone)

1. **Clone Repository**:
   ```bash
   git clone https://github.com/H4N1P/Ghina-Tour-Travel.git
   cd Ghina-Tour-Travel
   ```

2. **Install Dependensi PHP & Node.js**:
   ```bash
   composer install
   npm install
   ```

3. **Salin File Environment & Generate App Key**:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   *Buka file `.env` di text editor Anda, lalu sesuaikan konfigurasi database (`DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`) dengan database MySQL di PC Anda.*

---

### B. Sinkronisasi (Bagi yang baru saja melakukan Git Pull)

Setiap kali Anda melakukan **`git pull`** untuk mengambil update kode terbaru, pastikan untuk selalu menjalankan perintah berikut agar database dan aset lokal Anda tersinkronisasi sempurna:

1. **Hubungkan Symlink Folder Storage (Wajib sekali saja)**:
   Perintah ini akan membuat tautan (shortcut) dari folder `storage/app/public` ke folder publik web `public/storage`:
   ```bash
   php artisan storage:link
   ```

2. **Segarkan Database & Jalankan Seeder Dinamis (Wajib)**:
   Perintah ini akan memperbarui skema tabel database dan secara otomatis memicu fungsi PHP GD untuk melahirkan file gambar dummy secara lokal di laptop Anda agar halaman web tidak kosong:
   ```bash
   php artisan migrate:fresh --seed
   ```

---

### C. Menjalankan Aplikasi

Jalankan server lokal PHP dan builder aset Vite secara bersamaan:

* **Terminal 1** (Untuk Server Backend Laravel):
  ```bash
  php artisan serve
  ```

* **Terminal 2** (Untuk Compiler Aset Frontend Vite):
  ```bash
  npm run dev
  ```

Buka browser Anda dan akses aplikasi di alamat: [http://localhost:8000](http://localhost:8000).

---

## 📂 Manajemen File & Aset Media
* Seluruh file gambar/video fisik hasil unggahan manual melalui Admin Panel akan tersimpan secara lokal di folder `storage/app/public/galleries/`.
* Folder media lokal tersebut sudah diabaikan di `.gitignore` agar tidak membengkaki ukuran Git. Kolaborator baru cukup menjalankan `php artisan db:seed` untuk menghasilkan file media dummy lokal secara otomatis saat testing.

---

## 📝 Lisensi
Proyek ini dibuat untuk pemenuhan tugas kuliah dan dikembangkan secara internal oleh tim pengembang PT Ghina Tour Travel. Ditulis menggunakan basis framework Laravel open-source berlisensi [MIT license](https://opensource.org/licenses/MIT).


