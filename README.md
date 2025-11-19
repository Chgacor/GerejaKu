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

### Admin Panel
* **Role-Based Access**: Secure admin area accessible only to users with an `admin` role.
* **Jemaat (Member) Management**: Full CRUD functionality for church member data, complete with search and filtering.
* **Content Management**: Admins can manage all dynamic content, including:
  * Homepage Slideshow (CRUD, ordering, and status toggle).
  * Devotionals (CRUD with image uploads).
  * Upcoming Services (CRUD with image uploads and interactive forms).
  * Pastor Profiles (CRUD with photo uploads).
  * Berita (CRUD)
  * Jadwal (CRUD)
* **Website Settings**: A central page to update static content like the About Us page and the weekly bible verse.

---

## Setup Instructions

### Prerequisites
Make sure you have the following installed:
- PHP >= 8.2  
- Composer  
- Node.js & NPM  
- A local server environment (e.g., Herd, Laragon, XAMPP)  
- MySQL or another compatible database  

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
