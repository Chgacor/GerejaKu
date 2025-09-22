# Gereja Ku - Church Community Portal

## Project Description
This is a comprehensive web application designed to serve as a community portal and management system for the GKKD Serdam church. It features a public-facing website for members and visitors, along with a secure admin panel for content and member management. The application is built using the **Laravel framework** and styled with **Tailwind CSS**.

---

## Features

### Public Website
- **Homepage**: Dynamic hero slideshow and a carousel for upcoming services.
- **User Authentication**: Members can register and log in to their accounts.
- **Profile Completion**: New users are prompted to complete their profiles after registration.
- **Devotionals**: A section for daily or weekly devotionals with images and text.
- **About Us**: A multi-page section including:
  - Church History, Vision, and Mission.
  - Pastor Profiles.
- **Service Information**: Detailed view for upcoming church services.
- **Weekly Bible Verse**: Displayed in the footer.

### Admin Panel
- **Role-Based Access**: Secure admin area accessible only to users with an `admin` role.
- **Jemaat (Member) Management**: Full CRUD functionality for church member data, complete with search and filtering.
- **Content Management**: Admins can manage all dynamic content, including:
  - Homepage Slideshow (CRUD, ordering, and status toggle).
  - Devotionals (CRUD with image uploads).
  - Upcoming Services (CRUD with image uploads and interactive forms).
  - Pastor Profiles (CRUD with photo uploads).
- **Website Settings**: A central page to update static content like the About Us page and the weekly bible verse.

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

8. **Create the storage link:**

    ```bash
    php artisan storage:link
    ```

9. **Compile frontend assets:**

    ```bash
    npm run dev
    ```

10. **Start the development server:**

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
