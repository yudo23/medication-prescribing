# Medication Prescribing Web Application

Aplikasi web untuk manajemen pemeriksaan pasien dan peresepan obat, dengan role **Admin**, **Dokter**, dan **Apoteker**.

---

## Tech Stack
- PHP >= 8.3
- Laravel v13.4.0
- MySQL

---

## Repository
```bash
git clone https://github.com/yudo23/medication-prescribing
cd medication-prescribing
```

---

---

## Dokumentasi
https://docs.google.com/document/d/1Y7FyjJvZn_p_WneuR8-reMHvckFrc1XwofMshhh_JTU/edit?usp=sharing

---

## Instalasi

### 1. Install Dependency
```bash
composer install
```

### 2. Setup Environment
```bash
cp .env.example .env
php artisan key:generate
```

### 3. Konfigurasi Database (Pastikan database sudah dibuat sebelumnya)
Edit file `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=medication-prescribing
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Migrasi dan Seeder
```bash
php artisan migrate
php artisan db:seed
```

### 5. Storage Link
```bash
php artisan storage:link
```

### 6. Jalankan Aplikasi
```bash
php artisan serve
```

Buka di browser:
```
http://localhost:8000
```

---

## Akun Default

### Admin
- Email: admin@gmail.com  
- Username: admin  
- Password: 123456789  

### Dokter
- Email: andi@gmail.com  
- Username: andi  
- Password: 123456789  

### Apoteker
- Email: dewi@gmail.com  
- Username: dewi  
- Password: 123456789  

---

## Fitur Utama
- Manajemen Pemeriksaan Pasien (Tagihan)  
- Manajemen Pembayaran
- Pengguna (Admin, Dokter, Apoteker)
- Log Pengguna
- Dashboard statistik  

---

## Troubleshooting

### Clear Cache
```bash
php artisan optimize:clear
```
---

## Catatan
- Gunakan PHP versi >= 8.3  
- Pastikan MySQL berjalan  
- Gunakan browser modern (Chrome / Edge)  