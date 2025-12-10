# Screening Demo (Laravel 12)

A small Laravel 12 application that demonstrates clean architecture, validation, and testing around a simple **clinical trial screening** flow.

The app lets you:

- Create a **screening** for a participant
- Determine **eligibility** based on age
- Assign the subject to **Cohort A or B** based on migraine frequency
- View **all screenings** and individual **result pages**

It uses:

- PHP 8.2+ / Laravel 12
- Laravel Sail (Docker, PHP 8.4 runtime)
- SQLite (default) or MySQL (via Sail)
- Blade templates
- Enums & service layer for business logic
- PHPUnit tests

---

## 1. Requirements

You may run the project using:

### **Option A — Laravel Sail (recommended)**
Requires:
- Docker
- Docker Compose

### **Option B — Native installation**
Requires:
- PHP 8.2+
- Composer
- Node.js + npm
- SQLite or MySQL

---

## 2. Getting Started

### 2.1 Clone the repository

```bash
git clone <your-repo-url> screening
cd screening
```

### 2.2 Install PHP dependencies

Without Sail:

```bash
composer install
```

With Sail:

```bash
./vendor/bin/sail composer install
```

---

## 3. Environment Configuration

### 3.1 Create `.env`

```bash
cp .env.example .env
```

### 3.2 Generate app key

Without Sail:

```bash
php artisan key:generate
```

With Sail:

```bash
./vendor/bin/sail artisan key:generate
```

### 3.3 Database Setup

Default is **SQLite**:

```env
DB_CONNECTION=sqlite
```

Make sure the SQLite file exists:

```bash
mkdir -p database
touch database/database.sqlite
```

---

## 4. Using Laravel Sail (Docker)

This project includes services:

- `laravel.test` (PHP 8.4 + Nginx)
- `mysql` (MySQL 8)
- `redis`

### 4.1 Start Sail

```bash
./vendor/bin/sail up -d
```

### 4.2 Stop Sail

```bash
./vendor/bin/sail down
```

### 4.3 Run commands via Sail

Examples:

```bash
./vendor/bin/sail artisan migrate
./vendor/bin/sail artisan test
./vendor/bin/sail composer install
```

---

## 5. Database Migrations

Run:

```bash
php artisan migrate
```

Or with Sail:

```bash
./vendor/bin/sail artisan migrate
```

(Optional seeders):

```bash
php artisan db:seed
```

---

## 6. Frontend (Vite + npm)

Install JS deps:

```bash
npm install
```

Run dev server:

```bash
npm run dev
```

Build production assets:

```bash
npm run build
```

---

## 7. Running the Application

### Without Sail:

```bash
php artisan serve
```

Visit:

```
http://localhost:8000
```

### With Sail:

The container exposes port **80**:

```
http://localhost
```

---

## 8. Testing

This project uses **PHPUnit**.

Run tests:

```bash
php artisan test
```

Or with Sail:

```bash
./vendor/bin/sail artisan test
```

---

## 9. Project Structure Overview

Key components:

```
app/
  Services/
    ScreeningService.php   
  Http/
    Controllers/
      ScreeningController.php
    Requests/
      ScreeningRequest.php    
    Resources/
      ScreeningResource.php
  Models/
    Screening.php
  Enums/
    HeadacheFrequency.php
    CohortEnum.php
    DailyFrequencyEnum.php
resources/
  views/
    screenings/
      create.blade.php
      index.blade.php
      show.blade.php
tests/
  Feature/
  Unit/
```

---

## 10. Notes

- Clean separation of concerns (controller → service → model)
- Validations handled via Form Request
- Enum-driven frequency values
- Blade‑based UI with TailwindCSS

---

## 11. License

MIT (or adjust if needed)
