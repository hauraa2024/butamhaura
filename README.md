# Buku Tamu Digital

Aplikasi Laravel 12 untuk mengelola buku tamu: login hanya admin, form publik dengan captcha, admin approve/reject, dan ekspor CSV.

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
![faccae9f-e0fb-44dd-9392-06c9ba4f2c1f](https://github.com/user-attachments/assets/81f4bdfc-7486-47d5-a44e-340ae02dec7d)
