# CBTP-Project-G-8

Resident certificate & ID management system (final project snapshot).

## Overview

This repository contains a PHP web application that provides three main dashboards:

- Admin Dashboard — manage residents, applications, generate reports and certificates.
- Staff Dashboard — review/verify applications and assist processing.
- User Dashboard — submit applications, check status, download approved documents.

This README documents how to install, configure, and run the project locally and lists the default test credentials included with the sample data.

---

## Contents (important files & folders)

- `Database.sql` — SQL dump to create and populate the database schema used by the project.
- `db_connection.php` — database connection helper (update with your DB credentials).
- `ID generator/` — main PHP application (public entry points like `index.php`, `signin.php`, etc.).
- `ID generator/Admin dashboard/` — admin pages and utilities (settings, dashboard, manage requests).
- `ID generator/Staff_Dashboard/` — staff area files.
- `ID generator/UserProfile/` — user dashboard (profile, application checker, iframe-based content).
- `Death_certificate/` — certificate-related code and PDF generation samples.
- `ID generator/Tests/selenium-test.php` — simple Selenium WebDriver test example (requires composer dependencies and ChromeDriver).
- `uploads/` — user uploads (avatars, etc.) — ensure this folder is writable by the web server.

---

## Requirements

- PHP 7.4+ (or compatible; test with your environment)
- MySQL or MariaDB
- Composer (for vendor packages used in `ID generator/vendor`)
- A web server (Apache, Nginx) or PHP built-in server for quick testing
- If you want to use Selenium tests: ChromeDriver and `php-webdriver` (already present in `ID generator/vendor`)

---

## Installation / Quick Start

1. Place the project in your web server document root, for example `C:\xampp\htdocs\CBTP-Project-G-8` or serve the folder using PHP built-in server from project root.

2. Create a database and import `Database.sql` using your preferred tool (phpMyAdmin, MySQL CLI, or MySQL Workbench):

```powershell
# Example (PowerShell) assuming mysql is on PATH
mysql -u root -p < "C:\path\to\CBTP-Project-G-8\Database.sql"
```

3. Update the database connection settings in `ID generator/db_connection.php` (or top-level `db_connection.php` depending on which pages you use) with your DB host, username, password, and database name.

4. Ensure the `uploads/` directory is writable by the web server user.

5. (Optional) Install composer dependencies (if you plan to run Selenium tests or rebuild vendor):

```powershell
cd "ID generator"
composer install
```

6. Open the app in your browser. If using PHP built-in server for quick testing from the project root:

```powershell
php -S localhost:8000
# then open http://localhost:8000/ID%20generator/signin.php
```

---

## Default/Test Credentials (sample accounts included in the dump)

Use the following phone/password combos to log in to the appropriate dashboard — these are provided for convenience when testing the local copy of the database included in `Database.sql`:

- Admin:
  - Phone: `0909090909`
  - Password: `111111`

- Staff:
  - Phone: `0911111111`
  - Password: `111111`

- Public/User:
  - Phone: `0936739627`
  - Password: `111111`

Important: Change these default passwords when deploying or distributing the project.

---

## How the System Works (Summary)

1. Residents submit application requests for a Certificate (birth/marriage/death) or Residence ID.
2. Admin/Staff receive notifications in the dashboard and review each application.
3. Admin/Staff verify the applicant exists in the residents list (check house number) and accept or reject the request.
4. Applicants see status updates in "Application Checker" in their User Dashboard. Accepted users can generate and download the certificate/ID as a PDF.

---

## Notes about code & known behaviors

- Many user-facing pages (User Dashboard) load content inside an iframe named `contentFrame` — links in the left sidebar use `target="contentFrame"`.
- `ID generator/signin.php` performs server-side validation for phone & password and also includes client-side JavaScript validation in `ID generator/JS/signin-script.js`.
- `ID generator/Admin dashboard/settings.php` is used to update profile and password. The project includes logic to allow an admin to edit other users via `?id=` (this requires admin role in session).
- File upload handling writes to `uploads/`. Validate/clean uploaded files if you enable the site publicly.
- There is an included WebDriver test (`ID generator/Tests/selenium-test.php`) that expects a local ChromeDriver and composer dependencies. It uses `vendor/autoload.php`.

---

## Running Selenium test (optional)

1. Start ChromeDriver on a free port (example):

```powershell
# start chromedriver in the background (example, adjust path)
Start-Process -NoNewWindow -FilePath "C:\path\to\chromedriver.exe" -ArgumentList "--port=9515"
```

2. From the `ID generator` folder, make sure vendor/autoload.php exists (run `composer install` if needed), then run the test script with PHP:

```powershell
php "ID generator\Tests\selenium-test.php"
```

Note: Update the host/port variable inside that script to match your running ChromeDriver URL.

---

## Security & Hardening Recommendations

- Replace default passwords and remove or change demo accounts from production databases.
- Use prepared statements (the codebase already includes prepared statements in places; avoid direct interpolation of user input into SQL).
- Validate uploaded files (limit file types and sizes) and keep the `uploads/` directory outside of web root or block execution there.
- Add CSRF protection for forms (tokens) and rate-limiting on authentication endpoints.
- Use HTTPS in production and secure session cookie settings.

---

## Development Notes

- The project is structured with multiple folders for dashboards and certificate generation.
- To add new pages, follow the pattern used in `UserProfile` (sidebar + `contentFrame` iframe) or replace the UI with a SPA approach if you prefer.
- Consider centralizing authentication checks into a single included file (e.g., `auth.php`) to enforce login/role checks consistently.

---

## Contributing

This is a student project snapshot. If you want to improve it:

- Open issues or submit a PR with small, focused changes (fixes to SQL, improved validation, UI improvements).
- If you add dependencies, update `composer.json` and run `composer install` in the `ID generator` folder.

---

## Contact

If you need help understanding the code or running the project, open an issue or contact the project owner.

- Telegram: [@Ssimelo](https://t.me/Ssimelo)

---
