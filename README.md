# 📖 Jurnal PKL Digital - Sistem Manajemen Praktek Kerja Lapangan

## 🌟 Deskripsi Proyek

**Jurnal PKL Digital** adalah sebuah sistem informasi berbasis *web* yang dikembangkan menggunakan *framework* **Laravel**. [cite_start]Tujuan utama proyek ini adalah untuk mendigitalisasi dan menyederhanakan proses administrasi dan monitoring kegiatan Praktek Kerja Lapangan (PKL) bagi siswa[cite: 12, 14, 24].

[cite_start]Aplikasi ini memfasilitasi tiga peran pengguna utama: **Admin**, **Pembimbing**, dan **Siswa** [cite: 2, 15, 19, 23][cite_start], memastikan alur kerja yang efisien mulai dari pengelolaan data master hingga pelaporan kegiatan dan absensi harian[cite: 16, 18, 20, 24].

---

## 🛠️ Fitur Utama

[cite_start]Aplikasi ini dirancang dengan fitur *multi-role* yang spesifik untuk setiap pengguna[cite: 2]:

### [cite_start]👑 Admin (Administrator) [cite: 15]
Admin memiliki kontrol penuh atas data master dan pelaporan sistem.
* [cite_start]**Pengelolaan Data Master (CRUD)**: Users, biodata siswa, kelas, jurusan, dan DUDI[cite: 16].
* [cite_start]**Dashboard Admin**[cite: 17]: Ringkasan data master dan statistik penting.
* [cite_start]**Laporan & Monitoring**: Melihat laporan absensi dan kegiatan seluruh siswa[cite: 18].

### [cite_start]🧑‍🏫 Pembimbing (Guru Pembimbing) [cite: 19]
Pembimbing berfokus pada validasi dan pengawasan kegiatan siswa.
* [cite_start]**Dashboard Pembimbing**[cite: 21]: Ikhtisar kegiatan dan absensi siswa bimbingan.
* [cite_start]**Validasi**: Mengkonfirmasi (validasi) kegiatan dan absensi siswa[cite: 20].
* [cite_start]**Komentar/Catatan**: Mengomentari kegiatan siswa (mengisi `Catatan_pembimbing`)[cite: 12, 22].

### [cite_start]🧑‍💻 Siswa [cite: 23]
Siswa bertanggung jawab untuk mencatat kegiatan PKL harian mereka.
* [cite_start]**Dashboard Siswa**[cite: 25]: Melihat ringkasan progres PKL.
* [cite_start]**Pengisian Data**: Mengisi biodata, laporan kegiatan, dan absensi harian[cite: 24].
* [cite_start]**Melihat Catatan**: Melihat catatan atau komentar yang diberikan oleh Guru Pembimbing[cite: 26].

---

## 💻 Instalasi dan Setup Proyek

Ikuti langkah-langkah di bawah ini untuk menjalankan proyek secara lokal:

### Prasyarat
Pastikan sistem Anda sudah terinstal:
* PHP (v8.0 atau lebih tinggi disarankan)
* Composer
* MySQL/MariaDB (atau database pilihan Anda)
* Web Server (Apache/Nginx/XAMPP/Laragon)

### Langkah-langkah Instalasi

1.  **Clone Repository:**
    ```bash
    git clone [URL_REPOSITORY_ANDA]
    cd nama-folder-proyek
    ```

2.  **Install Dependencies:**
    Gunakan Composer untuk menginstal semua paket PHP yang dibutuhkan.
    ```bash
    composer install
    ```

3.  **Konfigurasi Environment:**
    * Buat file `.env` dari contoh yang ada:
        ```bash
        cp .env.example .env
        ```
    * Buka file `.env` dan atur konfigurasi database Anda:
        ```dotenv
        APP_NAME="Jurnal PKL Digital"
        APP_ENV=local
        APP_KEY= # Akan diisi pada langkah berikutnya

        DB_CONNECTION=mysql
        DB_HOST=127.0.0.1
        DB_PORT=3306
        DB_DATABASE=[NAMA_DB_ANDA]
        DB_USERNAME=[USER_DB_ANDA]
        DB_PASSWORD=[PASS_DB_ANDA]
        ```

4.  **Generate Application Key:**
    ```bash
    php artisan key:generate
    ```

5.  **Migrasi Database:**
    Jalankan migrasi untuk membuat semua tabel.
    ```bash
    php artisan migrate
    ```
    **(Opsional: Jika Anda memiliki Seeder untuk data awal seperti akun Admin, jalankan: `php artisan db:seed`)*

6.  **Jalankan Server Lokal:**
    ```bash
    php artisan serve
    ```
    Aplikasi sekarang dapat diakses di `http://127.0.0.1:8000`.

---

## 🏗️ Struktur Database & Relasi

Proyek ini menggunakan 7 tabel utama dengan relasi *Foreign Key* (FK) yang terstruktur.

### 📝 Daftar Tabel & Kolom Kunci

| Nama Tabel | Deskripsi | Kunci Utama (PK) | Kolom Penting |
| :--- | :--- | :--- | :--- |
| [cite_start]**`User`** [cite: 1, 2] | Menyimpan informasi login dan peran. | `id` (INT, AI) | [cite_start]`role` (`ENUM(‘admin’, ‘pembimbing’, ‘siswa’)`) [cite: 2] |
| [cite_start]**`Kelas`** [cite: 3, 4] | Data master kelas. | `id` (INT, AI) | [cite_start]`kelas` (`VARCHAR`) [cite: 4] |
| [cite_start]**`Jurusan`** [cite: 5, 6] | Data master jurusan. | `id` (INT, AI) | [cite_start]`jurusan` (`VARCHAR`) [cite: 6] |
| [cite_start]**`Dudi`** [cite: 7, 8] | Data master Dunia Usaha/Industri. | `id` (INT, AI) | [cite_start]`nama_dudi` (`VARCHAR`) [cite: 8] |
| [cite_start]**`Siswa`** [cite: 9, 10] | Biodata lengkap siswa PKL. | `id` (INT, AI) | [cite_start]`Id_siswa` (FK ke `User`), `Id_pembimbing` (FK ke `User`), `Id_dudi` (FK ke `Dudi`) [cite: 10] |
| [cite_start]**`Kegiatan`** [cite: 11, 12] | Catatan kegiatan harian siswa. | `id` (INT, AI) | [cite_start]`Id_siswa` (FK ke `User`), `Keterangan_kegiatan` (`TEXT`), `Catatan_pembimbing` (`TEXT`) [cite: 12] |
| [cite_start]**`Absensi`** [cite: 13, 14] | Catatan kehadiran/absensi siswa. | `id` (INT, AI) | [cite_start]`Id_siswa` (FK), `Jam_mulai`/`Jam_akhir` (`Timestamp`), `status` (`ENUM`) [cite: 14] |

### Relasi Kunci (Foreign Keys)

* [cite_start]**`Siswa`**: Berelasi dengan `User` (untuk role Siswa dan Pembimbing), `Kelas`, `Jurusan`, dan `Dudi`[cite: 10].
* [cite_start]**`Kegiatan`**: Berelasi dengan `User` sebagai Siswa yang melakukan kegiatan[cite: 12].
* [cite_start]**`Absensi`**: Berelasi dengan `Siswa`[cite: 14].

---

## 🤝 Kontribusi

Jika Anda ingin berkontribusi pada proyek ini, silakan ikuti alur berikut:

1.  *Fork* repositori ini.
2.  Buat *branch* baru untuk fitur Anda (`git checkout -b feature/nama-fitur-baru`).
3.  Lakukan *commit* perubahan Anda (`git commit -m 'feat: menambahkan fitur X'`).
4.  *Push* ke *branch* Anda (`git push origin feature/nama-fitur-baru`).
5.  Buka *Pull Request* (PR).

---


## ✉️ Kontak

Untuk pertanyaan, saran, atau masalah, silakan hubungi:

* **Ghani Rizky**