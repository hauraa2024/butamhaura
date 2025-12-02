## 📚 Dokumentasi Proyek Buku tamu
Buku tamu adalah aplikasi web inovatif yang dirancang sebagai sistem Manajemen Janji Temu Digital bagi pengunjung atau pihak eksternal yang ingin bertemu dengan staf di kantor, instansi, atau perusahaan.

Situs ini bertujuan untuk mentransformasi proses penjadwalan pertemuan dari metode konvensional menjadi sepenuhnya online.

## Tujuan Utama: 
Menyediakan platform yang efisien, transparan, dan terstruktur untuk memfasilitasi pembuatan janji temu.

## Memudahkan Proses:
Mempercepat dan menyederhanakan proses pembuatan perjanjian pertemuan atau registrasi kunjungan tanpa memerlukan kehadiran fisik di lokasi kantor.

Melalui Buku tamu, instansi dapat mengelola arus tamu dengan lebih teratur, sementara pengunjung dapat membuat janji temu dengan mudah dan menerima konfirmasi secara instan, sehingga meningkatkan efisiensi operasional dan pengalaman pengguna secara keseluruhan.

Aplikasi Laravel 12 untuk mengelola buku tamu: login hanya admin, form publik dengan captcha, admin approve/reject, dan ekspor CSV.

## Halaman publik (Non-Login)
• Home 
• Input data tamu

## Authentication
• Login

## Admin
• mengelola data tamu
• melihat data tamu

## 🔓 Akun Default
• admin:
   - Email : admin@example.com
   - password : admin123

## ERD
![WhatsApp Image 2025-12-02 at 7 57 51 PM](https://github.com/user-attachments/assets/ebf1f2d9-c20b-4b46-9a9f-ec6f5bf42036)


## UML
![WhatsApp Image 2025-12-02 at 7 53 39 PM](https://github.com/user-attachments/assets/29749876-b798-41d1-83b7-dcae934e2b68)

## Teknologi yang Digunakan
• laravel 12

## Tools yang Digunakan 
• Xampp
• Apache2
• MySQL
• VSCode
• Node.js
• Npm
• Composer
• PHP
• Laravel

## Persyaratan untuk Instalasi
• PHP 8.4.15
• Web Server
• Database (MySQL)
• Web Browser

## Kebutuhan
- PHP 8.2+ (proyek ini 8.4.14)
- Composer
- Node.js + npm
- SQLite/MySQL/PostgreSQL (atur di `.env`)

## Clone & Instalasi
```bash
git clone <repo-url> laravel_bukutamu
cd laravel_bukutamu
cp .env.example .env
composer install
npm install
php artisan key:generate
php artisan migrate
php artisan storage:link
npm run dev   # atau npm run build untuk produksi
php artisan serve
```

## Lingkungan
- Atur database di `.env` (mis. `DB_CONNECTION=mysql` atau SQLite).
- Seeder admin (jalankan `php artisan db:seed`):  
  - Email: `admin@example.com`  
  - Password: `password`
- Autentikasi hanya admin; registrasi dinonaktifkan.

## Menjalankan
- Server aplikasi: `php artisan serve`
- Vite dev server: `npm run dev`
- Build produksi: `npm run build`

## Fitur
- Landing publik menampilkan statistik real-time dan sparkline 7 hari.
- Form buku tamu publik + captcha → status pending.
- Panel admin (role `admin`):
  - Review pending, approve/reject dengan catatan.
  - Lihat daftar approved/rejected, hapus entri.
  - Ekspor CSV untuk approved/rejected.
  - Sortir daftar tamu (tanggal dibuat, tanggal kunjungan, nama; asc/desc).
  - Dashboard dengan ringkasan dan aktivitas terbaru.

## Alur Admin
1. Login di `/login` (hanya kredensial admin).
2. Dashboard menampilkan statistik dan entri terbaru.
3. Ke menu Kunjungan untuk review:
   - Approve atau reject permintaan pending.
   - Hapus entri jika perlu.
   - Ekspor approved/rejected ke CSV.
   - Ubah sorting via dropdown.

## Alur Publik
- Landing: `/` (statistik dari data live).
- Form buku tamu: `/guest/create` (captcha wajib); entri masuk antrian pending untuk admin.

## Database (Ringkas ERD)
- `users`: akun admin (kolom `role`).
- `guest_entries`: data tamu publik dengan status (`pending`, `approved`, `rejected`), visit_date, catatan, reviewer, timestamps.
- `password_reset_tokens`, `sessions`: tabel auth/sesi.

## Testing
- Tersedia test untuk login admin dan alur guest entry. Jalankan bila perlu:
```bash
php artisan test --filter=AdminLoginTest
php artisan test --filter=GuestEntryFlowTest
```

