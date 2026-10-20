# Portal Admin Perizinan 

Aplikasi web admin berbasis Laravel untuk mendukung pengelolaan informasi dan permohonan pada portal perizinan. Dokumen ini menjelaskan gambaran proyek, kebutuhan lingkungan, serta instalasi lokal.

---

## ✨ Fitur utama

- **Login Admin**  
  Login melalui layanan autentikasi eksternal.

- **CMS Berita**  
  Daftar dan pencarian berita, kategori, detail, unggah thumbnail/file, pengaturan publikasi, serta pengelolaan konten.

- **FAQ**  
  Pengelolaan menu FAQ dan item FAQ bertipe menu atau PDF.

- **Permintaan akses / API Management**  
  Pencatatan permohonan akses, pengelolaan dokumen pendukung, status permohonan, dan informasi API.

- **Activity Log**  
  Pencatatan aktivitas admin untuk kebutuhan audit.
  
- **Tracking Permohonan** 
  Pencarian informasi permohonan perizinan dan tampilan tahapan proses.

---

## 🛠️ Tech Stack

- PHP 8.3 
- Laravel 11
- MySQL
- Blade
- Template admin Sash dan aset frontend proyek
- Quill editor
- Integrasi layanan autentikasi eksternal

---

## ⚙️ Installation

Ikuti langkah berikut untuk menjalankan project secara lokal:

1. Clone repository
```bash
git clone https://github.com/yonathanfrans/Dashboard-Admin.git
cd dashboard-admin
```
2. Pasang dependency PHP
```bash
composer install
```
3. Siapkan file environment:
Linux/macOS:
```bash
cp .env.example .env
```
Windows:
```bash
copy .env.example .env
```
4. Atur APP_URL, koneksi database, session, logging, dan timezone di .env. Buat database MySQL terlebih dahulu.
5. Generate application key
```bash
php artisan key:generate
```
6. Migrasi database
```bash
php artisan migrate
```

7. Siapkan storage publik untuk file
```bash
php artisan storage:link
```
8. Install dan build aset front end
```bash
npm install
npm run build
```
9. Jalankan server pengembangan
```bash
php artisan serve
```



---
