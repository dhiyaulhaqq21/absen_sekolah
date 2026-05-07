````md
# 📘 Website Absensi Siswa QR Code

Sistem absensi siswa berbasis web menggunakan **PHP Native**, **MySQL**, **Bootstrap 5**, dan **QR Code**.

Website ini dibuat untuk mempermudah proses absensi siswa secara digital dengan fitur:
- login multi user,
- absensi berbasis waktu,
- QR Code absensi,
- rekap kehadiran,
- export laporan,
- serta status hadir, telat, dan alfa.

---

# ✨ Fitur Utama

## 🔐 Authentication
- Login Admin
- Login Siswa
- Session Login

---

## 👨‍💼 Admin
- Dashboard statistik
- CRUD Data Siswa
- CRUD Data Staf
- Membuat sesi absensi
- Generate token absensi
- Generate QR Code absensi
- Rekap kehadiran
- Filter berdasarkan tanggal
- Export Excel

---

## 👨‍🎓 Siswa
- Dashboard siswa
- Absensi menggunakan token
- Scan QR Code
- Riwayat absensi

---

## ⏰ Sistem Kehadiran
- Hadir
- Telat (toleransi 15 menit)
- Alfa otomatis

---

# 🛠️ Teknologi

- PHP Native
- MySQL / MariaDB
- Bootstrap 5
- Chart.js
- PHP QR Code Library

---

# 📂 Struktur Folder

```bash
absensi/
│
├── admin/
├── siswa/
├── auth/
├── config/
├── assets/
│   └── qr/
├── lib/
│   └── phpqrcode/
├── index.php
└── README.md
````

---

# ⚙️ Cara Menjalankan

## 1. Clone Repository

```bash
git clone https://github.com/username/absensi.git
```

---

## 2. Pindahkan ke htdocs

Contoh:

```bash
C:/xampp/htdocs/absensi
```

---

## 3. Import Database

Import file database `.sql` ke phpMyAdmin.

---

## 4. Jalankan XAMPP

Aktifkan:

* Apache
* MySQL

---

## 5. Akses Website

```bash
http://localhost/absensi
```

---

# 🔑 Default Login

## Admin

| Username | Password |
| -------- | -------- |
| admin    | admin123 |

---

## Siswa

| Username | Password |
| -------- | -------- |
| siswa    | siswa123 |

---

# 📸 Screenshot

## Login

Tambahkan screenshot login di sini

## Dashboard Admin

Tambahkan screenshot dashboard admin di sini

## Dashboard Siswa

Tambahkan screenshot dashboard siswa di sini

## Rekap Absensi

Tambahkan screenshot rekap di sini

---

# 🎥 Video Demo

Link YouTube:

[https://youtu.be/5OrXHnv6ruU?si=evsXj35RC6Q1JWz1](https://youtu.be/5OrXHnv6ruU?si=evsXj35RC6Q1JWz1)

---

# 📌 Catatan

Project ini masih menggunakan:

* PHP Native
* query manual mysqli

Sehingga masih cocok untuk:

* tugas kampus,
* pembelajaran CRUD,
* latihan sistem informasi berbasis web.

---

# 👨‍💻 Author

Dhiyaul Haqq

```
```
