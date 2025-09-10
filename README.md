# GKKD Serdam - Church Community Portal

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
Clone the repository:
```bash
git clone [URL_REPOSITORY_ANDA]
cd [NAMA_FOLDER_PROYEK]
