# Gereja Ku - Church Community Portal

## Project Description
This is a comprehensive web application designed to serve as a community portal and management system for the GKKD Serdam church. It features a public-facing website for members and visitors, along with a secure admin panel for content and member management. The application is built using the **Laravel framework** and styled with **Tailwind CSS**.

---

## 🌟 Fitur Utama (Core Functionality)
Aplikasi ini berfungsi sebagai **portal informasi gereja** yang komprehensif. Fitur utamanya adalah menyediakan:
* **Informasi dan Berita Gereja**: Menampilkan berita terkini, pengumuman resmi, dan laporan kegiatan dari berbagai komisi.
* **Jadwal Kegiatan**: Menyediakan jadwal ibadah (Minggu), komisi, dan acara khusus lainnya.
* **Materi Spiritual**: Menyajikan materi Devosi, renungan harian/mingguan, ayat Alkitab, dan refleksinya.
* **Informasi Institusi**: Memberikan informasi mendalam mengenai sejarah, visi, misi, dan struktur organisasi GKKD Serdam.
* **Portal Komunitas**: Menyediakan fitur otentikasi, manajemen profil, dan notifikasi untuk anggota gereja (**Jemaat**).

---

## Features

### Public Website
Halaman-halaman yang dapat diakses oleh semua pengunjung (anggota dan non-anggota).

* **Homepage** (Halaman Utama): Dynamic hero slideshow dan carousel untuk layanan/ibadah mendatang. Berisi sambutan dan *highlight* terbaru mengenai gereja atau kegiatan.
* **User Authentication**: Members can register and log in to their accounts.
* **Profile Completion**: New users are prompted to complete their profiles after registration.
* **Berita**: Halaman untuk menampilkan informasi mengenai kegiatan gereja, pengumuman resmi, atau laporan kegiatan dari komisi-komisi.
* **Jadwal**: Halaman yang digunakan untuk menampilkan dan mengelola jadwal ibadah Minggu, komisi, atau jadwal kegiatan khusus.
* **Devotionals**: A section for daily or weekly devotionals with images and text. Menampilkan berbagai renungan harian atau mingguan, ayat Alkitab dan refleksinya.
* **About Us** (Multi-page section):
    * **Church History, Vision, and Mission** (Sejarah Gereja): Menampilkan penjelasan mengenai asal mula GKKD Serdam, tahun berdiri, serta visi dan misi gereja.
    * **Pastor Profiles** (Profil GKKD): Menampilkan struktur organisasi gereja, pendeta, penatua, dan majelis.
* **Service Information**: Detailed view for upcoming church services.
* **Weekly Bible Verse**: Displayed in the footer.
* **Notifikasi (Ikon Lonceng)**: Ikon notifikasi digunakan untuk memberi tahu update berita baru, informasi terkait akun pengguna, dan pengumuman penting.
* **Akun/Profil Pengguna**: Menunjukkan pengguna yang sedang *login*. Berisi menu *profil* (untuk melihat dan mengubah data), pengaturan akun, dan *logout*.

### Admin Panel (Panel Administrator)

Panel administrasi yang aman, hanya dapat diakses oleh pengguna dengan peran (`role`) `admin`.

#### Manajemen Pengguna (Jemaat)
* **Jemaat (Member) Management**: Fungsionalitas **CRUD** (Create, Read, Update, Delete) lengkap untuk data anggota gereja, dilengkapi dengan fitur pencarian dan penyaringan (*filtering*).

#### Manajemen Konten Dinamis
Admins dapat mengelola semua konten dinamis yang ditampilkan di website publik:

* **Homepage Slideshow**: CRUD, pengaturan urutan (*ordering*), dan *toggle* status tayang.
* **Devotionals (Renungan)**: CRUD, termasuk fitur unggah gambar (*image uploads*).
* **Upcoming Services (Jadwal Acara)**: CRUD, termasuk unggah gambar dan formulir interaktif terkait layanan.
* **Pastor Profiles (Profil Pendeta)**: CRUD, termasuk unggah foto.
* **Berita (News)**: CRUD untuk informasi dan pengumuman gereja.
* **Jadwal**: CRUD untuk mengatur jadwal ibadah mingguan, komisi, dan kegiatan khusus.

#### ⚙️ Pengaturan Website (Global Settings)
* **Website Settings**: Halaman terpusat untuk memperbarui konten statis seperti halaman *About Us* (Sejarah, Visi, Misi) dan Ayat Alkitab Mingguan (*Weekly Bible Verse*).

---

### Installation

1. **Clone the repository:**

    ```bash
    git clone [URL_REPOSITORY_ANDA]
    cd [NAMA_FOLDER_PROYEK]
    ```

2. **Install PHP dependencies:**

    ```bash
    composer install
    ```

3. **Install Node.js dependencies:**

    ```bash
    npm install
    ```

4. **Copy the environment file:**

    ```bash
    cp .env.example .env
    ```

5. **Generate application key:**

    ```bash
    php artisan key:generate
    ```

6. **Configure your database:**

    Open the `.env` file and update the database connection details:
    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=db_gereja
    DB_USERNAME=root
    DB_PASSWORD=
    ```

7. **Run database migrations and seeders:**

    ```bash
    php artisan migrate:fresh --seed
    ```

8. **Compile frontend assets:**

    ```bash
    npm run dev
    ```

9. **Start the development server:**

    ```bash
    php artisan serve
    ```

    The application will be available at `http://127.0.0.1:8000`.


# Technology Stack

- **Backend**: Laravel 12  
- **Frontend**: Laravel Blade, Tailwind CSS, Alpine.js, Swiper.js  
- **Database**: MySQL  
- **Development Environment**: Herd  

## Contributing

Contributions are welcome! Please fork the repository and submit pull requests.
