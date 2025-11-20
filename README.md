# 📖 Jurnal PKL Digital - Sistem Manajemen Praktek Kerja Lapangan

## 🌟 Deskripsi Proyek

**Jurnal PKL Digital** adalah sebuah sistem informasi berbasis *web* yang dikembangkan menggunakan *framework* **Laravel**. Tujuan utama proyek ini adalah untuk mendigitalisasi dan menyederhanakan proses administrasi dan monitoring kegiatan Praktek Kerja Lapangan (PKL) bagi siswa.

Aplikasi ini memfasilitasi tiga peran pengguna utama: **Admin**, **Pembimbing**, dan **Siswa** , memastikan alur kerja yang efisien mulai dari pengelolaan data master hingga pelaporan kegiatan dan absensi harian.

---

## 🛠️ Fitur Utama

Aplikasi ini dirancang dengan fitur *multi-role* yang spesifik untuk setiap pengguna:

### 👑 Admin (Administrator)
Admin memiliki kontrol penuh atas data master dan pelaporan sistem.
* **Pengelolaan Data Master (CRUD)**: Users, biodata siswa, kelas, jurusan, dan DUDI.
* **Dashboard Admin** : Ringkasan data master dan statistik penting.
* **Laporan & Monitoring**: Melihat laporan absensi dan kegiatan seluruh siswa.

### 🧑‍🏫 Pembimbing (Guru Pembimbing)
Pembimbing berfokus pada validasi dan pengawasan kegiatan siswa.
* **Dashboard Pembimbing**: Ikhtisar kegiatan dan absensi siswa bimbingan.
* **Validasi**: Mengkonfirmasi (validasi) kegiatan dan absensi siswa.
* **Komentar/Catatan**: Mengomentari kegiatan siswa (mengisi `Catatan_pembimbing`).

### 🧑‍💻 Siswa
Siswa bertanggung jawab untuk mencatat kegiatan PKL harian mereka.
* **Dashboard Siswa**: Melihat ringkasan progres PKL.
* **Pengisian Data**: Mengisi biodata, laporan kegiatan, dan absensi harian.
* **Melihat Catatan**: Melihat catatan atau komentar yang diberikan oleh Guru Pembimbing.

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
| **`User`** | Menyimpan informasi login dan peran. | `id` (INT, AI) | `role` (`ENUM(‘admin’, ‘pembimbing’, ‘siswa’)`) |
| **`Kelas`** | Data master kelas. | `id` (INT, AI) | `kelas` (`VARCHAR`) |
| **`Jurusan`** | Data master jurusan. | `id` (INT, AI) | `jurusan` (`VARCHAR`) |
| **`Dudi`** | Data master Dunia Usaha/Industri. | `id` (INT, AI) | `nama_dudi` (`VARCHAR`) |
| **`Siswa`** | Biodata lengkap siswa PKL. | `id` (INT, AI) | `Id_siswa` (FK ke `User`), `Id_pembimbing` (FK ke `User`), `Id_dudi` (FK ke `Dudi`) |
| **`Kegiatan`** | Catatan kegiatan harian siswa. | `id` (INT, AI) | `Id_siswa` (FK ke `User`), `Keterangan_kegiatan` (`TEXT`), `Catatan_pembimbing` (`TEXT`) |
| **`Absensi`** | Catatan kehadiran/absensi siswa. | `id` (INT, AI) | `Id_siswa` (FK), `Jam_mulai`/`Jam_akhir` (`Timestamp`), `status` (`ENUM`) |

### Relasi Kunci (Foreign Keys)

* **`Siswa`**: Berelasi dengan `User` (untuk role Siswa dan Pembimbing), `Kelas`, `Jurusan`, dan `Dudi`.
* **`Kegiatan`**: Berelasi dengan `User` sebagai Siswa yang melakukan kegiatan.
* **`Absensi`**: Berelasi dengan `Siswa`.

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