# 📌 Proyek Akhir – Pemrograman Framework  
## 🎯 Tema: E-Voting Berbasis Subscription

---

## 🎓 Program Studi
**Informatika**

---

## 👥 Anggota Kelompok

| Nama                         | NIM       |
|------------------------------|-----------|
| Muhammad Rizki Kurniawan     | 22670033  |
| Danu Candra Saputra          | 22670008  |

---

## 📖 Deskripsi Proyek

Proyek ini merupakan **Proyek Akhir Mata Kuliah Pemrograman Framework** yang dikembangkan menggunakan **framework Laravel**.  
Aplikasi yang dibangun adalah **sistem e-voting dan manajemen event voting** yang dilengkapi dengan **sistem pembayaran online menggunakan Midtrans** untuk mengelola paket atau layanan berbayar.

Aplikasi ini menerapkan konsep **MVC (Model–View–Controller)**, relasi database, autentikasi pengguna, serta integrasi **payment gateway Midtrans** sebagai simulasi sistem transaksi digital pada aplikasi berbasis web modern.

---

## 🎯 Tujuan Pembuatan

- Menerapkan pemrograman berbasis framework **Laravel**
- Mengimplementasikan konsep **MVC**, routing, dan controller
- Mengelola database menggunakan **migration** dan **relasi**
- Mengintegrasikan **payment gateway Midtrans**
- Mengelola transaksi dan status pembayaran
- Membangun sistem **e-voting yang terstruktur dan aman**
- Melatih kerja sama tim dalam pengembangan aplikasi web

---

## ⚙️ Teknologi yang Digunakan

### Backend
- **Framework** : Laravel  
- **Bahasa Pemrograman** : PHP  
- **Database** : MySQL  

### Frontend
- Blade Template  
- Bootstrap  

### Payment Gateway
- **Midtrans (Sandbox Mode)**

### Tools Pendukung
- Composer  
- Git & GitHub  
- Visual Studio Code  
- XAMPP / Laragon  

---

## ✨ Fitur Utama Aplikasi

- Manajemen Event Voting
- Manajemen Kandidat
- Sistem Token Pemilih (sekali pakai)
- Sistem Voting & Rekapitulasi Suara
- Dashboard Statistik
- Autentikasi & Otorisasi Admin
- Sistem Pembayaran Online (Midtrans)
- Manajemen Paket / Subscription Event
- Monitoring Status Transaksi:
  - Pending
  - Paid
  - Failed

---

## 💳 Integrasi Midtrans

Aplikasi ini menggunakan **Midtrans (Sandbox Mode)** sebagai payment gateway untuk simulasi pembayaran paket atau layanan event voting.

### Alur Pembayaran:
1. User memilih paket atau layanan event
2. Sistem membuat transaksi dan mengirim request ke Midtrans
3. Midtrans mengembalikan **token transaksi**
4. User melakukan pembayaran melalui **popup Midtrans**
5. Midtrans mengirimkan **notifikasi (callback)**
6. Sistem memperbarui status pembayaran secara otomatis

---

## 📌 Konsep Sistem

Aplikasi e-voting ini menggunakan model **subscription-based system**, di mana:
- User harus membeli paket terlebih dahulu
- Setiap paket memiliki batasan (jumlah event, kandidat, pemilih)
- Event hanya dapat dijalankan jika pembayaran berstatus **Paid**

Konsep ini mensimulasikan aplikasi **SaaS (Software as a Service)**.

---

## 📌 Penutup

Proyek ini dikembangkan sebagai bentuk penerapan materi **Pemrograman Framework** dengan studi kasus nyata yang mengombinasikan **sistem e-voting** dan **payment gateway Midtrans**.  
Melalui proyek ini, mahasiswa diharapkan mampu memahami pengembangan aplikasi web modern yang terintegrasi dengan layanan pihak ketiga serta menerapkan praktik pengembangan aplikasi yang terstruktur.

---
