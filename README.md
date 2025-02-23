# Laravel Invoice Management System

This is a Laravel-based Invoice Management System that provides functionalities to create, read, update, and delete (CRUD) sales invoices. The application also includes features for listing and filtering invoices based on criteria such as date range and payment status. Additionally, it supports file uploads for each invoice, with files stored in Cloudinary.

## Features

### CRUD Operations
- Create, Read, Update, and Delete invoices.

### Filtering
- Filter invoices by payment status and date range.

### File Upload
- Upload and manage related files (e.g., images, documents) for each invoice using Cloudinary.

### User Interface
- Built with Laravel Blade, HTML, CSS, and JavaScript for a clean and responsive design.

## Prerequisites

Before you begin, ensure you have the following installed:

- PHP (>= 8.0)
- Composer (for dependency management)
- Node.js (for frontend assets, if needed)
- MySQL (or any other supported database)
- Cloudinary Account (for file uploads)

## Setup Instructions

### 1. Clone the Repository

```bash
git clone https://github.com/latestbob/laravel_invoice.git
cd laravel_invoice
```

### 2. Install Dependencies

Run the following command to install PHP dependencies:

```bash
composer install
```

If you have frontend assets (e.g., JavaScript, CSS), install Node.js dependencies:

```bash
npm install
```

### 3. Configure Environment Variables

Create a `.env` file by copying the `.env.example` file:

```bash
cp .env.example .env
```

Open the `.env` file and update the following configurations:

#### Database Configuration

For a local MySQL database, update the following:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=invoice
DB_USERNAME=root
DB_PASSWORD=
```

Replace the values with your local database credentials.

#### Cloudinary Configuration

To enable file uploads, configure your Cloudinary URL. You can find your Cloudinary credentials in the Cloudinary Console.

The `CLOUDINARY_URL` format is:

```env
CLOUDINARY_URL=cloudinary://<API_KEY>:<API_SECRET>@<CLOUD_NAME>
```

Example (with dummy data):

```env
CLOUDINARY_URL=cloudinary://123456789012345:abcdeFGHIJKLMNOPQRSTUVWXYZ@my_cloud_name
```

- **API_KEY**: Your Cloudinary API Key.
- **API_SECRET**: Your Cloudinary API Secret.
- **CLOUD_NAME**: Your Cloudinary Cloud Name.

### 4. Generate Application Key

Generate a unique application key:

```bash
php artisan key:generate
```

### 5. Run Migrations

Run the database migrations to create the necessary tables:

```bash
php artisan migrate
```

### 6. Serve the Application

Start the Laravel development server:

```bash
php artisan serve
```

Visit [http://localhost:8000](http://localhost:8000) in your browser to access the application.
