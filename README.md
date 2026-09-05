# 📊 Sales Visit Report

<p align="center">
  <strong>Internal Sales Visit Management System</strong><br>
  Laravel 12 • PHP 8.2 • MySQL • Blade • Apache/XAMPP
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12-FF2D20?style=for-the-badge&logo=laravel&logoColor=white">
  <img src="https://img.shields.io/badge/PHP-8.2-777BB4?style=for-the-badge&logo=php&logoColor=white">
  <img src="https://img.shields.io/badge/MySQL-8+-4479A1?style=for-the-badge&logo=mysql&logoColor=white">
  <img src="https://img.shields.io/badge/Apache-XAMPP-D22128?style=for-the-badge&logo=apache&logoColor=white">
</p>

---

## 📌 Overview

**Sales Visit Report** is a web-based internal application for recording, managing, monitoring, and reporting Sales visit activities.

The system was designed for deployment on a **local office LAN**, using a Windows PC as the application server with Apache/XAMPP, Laravel, PHP, and MySQL.

The project uses a layered OOP-oriented architecture:

```text
HTTP Request
     ↓
Controller
     ↓
Service
     ↓
Repository
     ↓
Eloquent Model
     ↓
MySQL
```

## 🎯 Objectives

- Digitalize Sales visit reporting.
- Centralize Sales activity data.
- Help Admin monitor Sales activity.
- Separate Admin and Sales permissions.
- Protect records using backend authorization and ownership validation.
- Provide dashboard and reporting for management.
- Support Excel/PDF export.
- Deploy the application locally through the office LAN.

## ✨ Features

### 🔐 Authentication & Authorization
- Login / Logout
- Remember login
- Active / inactive accounts
- Password hashing
- Admin and Sales roles
- Role-based middleware
- Backend authorization

### 📊 Executive Dashboard
- Total visits
- Today's visits
- Monthly visit information
- Total Sales
- Total institutions
- 7-day visit activity
- Sales ranking
- Visit result distribution
- Recent activities
- Quick actions

### 📋 Sales Visit Management
- Create visit reports
- View details
- Edit reports
- Delete reports according to authorization
- Search
- Date filtering
- Sales filtering
- Institution filtering
- Visit type filtering
- Visit result filtering
- Pagination
- Excel export
- PDF export

### 🏢 Institution Management
- Create
- View
- Edit
- Delete according to authorization
- Global institutions
- Sales-owned institutions
- Ownership validation

### 👥 User Management
Admin can:
- Create users
- Edit users
- Reset passwords
- Activate/deactivate users
- Manage Admin/Sales roles

## 👤 Roles & Permissions

| Capability | Admin | Sales |
|---|:---:|:---:|
| Dashboard | All data | Own data |
| View visits | All | Own |
| Create visit | ✅ | ✅ |
| Edit visit | All | Own |
| Delete visit | All | Own |
| View institutions | All | Global + Own |
| Manage institutions | All | Own |
| User management | ✅ | ❌ |
| Export reports | ✅ | ✅ According to access |

## 🏗️ Architecture

```text
                    ┌─────────────────┐
                    │     Browser     │
                    └────────┬────────┘
                             ↓
                    ┌─────────────────┐
                    │  Laravel Route  │
                    └────────┬────────┘
                             ↓
                    ┌─────────────────┐
                    │   Controller    │
                    │ Request / Auth  │
                    └────────┬────────┘
                             ↓
                    ┌─────────────────┐
                    │     Service     │
                    │ Business Logic  │
                    └────────┬────────┘
                             ↓
                    ┌─────────────────┐
                    │   Repository    │
                    │   Data Access   │
                    └────────┬────────┘
                             ↓
                    ┌─────────────────┐
                    │ Eloquent Model  │
                    └────────┬────────┘
                             ↓
                    ┌─────────────────┐
                    │      MySQL      │
                    └─────────────────┘
```

### Layer Responsibilities

| Layer | Responsibility |
|---|---|
| Route | Maps HTTP requests |
| Controller | Request, validation, authorization and response |
| Service | Business logic and transactions |
| Repository | Database queries and data retrieval |
| Model | Entities and relationships |
| Blade | User interface |

## 🗄️ Database

Database:

```text
sales_visit_report
```

Main tables:

```text
users
institutions
visit_types
visit_results
visits
```

Relationship:

```text
users
  │
  │ 1:N
  ↓
visits
  ├──────────────→ institutions
  ├──────────────→ visit_types
  └──────────────→ visit_results
```

### Visits

```text
visits
├── id
├── user_id
├── institution_id
├── visit_type_id
├── visit_result_id
├── visit_date
├── visit_time
├── notes
├── created_at
└── updated_at
```

### Institution Ownership

```text
user_id = NULL
    → Global institution

user_id = Sales ID
    → Sales-owned institution
```

## 🔒 Security

The application enforces authorization on the backend.

- Sales cannot access another Sales user's visit by changing a URL ID.
- Sales cannot modify another Sales user's institution.
- Sales can use global institutions and their own institutions.
- Admin can access all authorized records.
- Inactive users cannot log in.
- `.env` is excluded from Git.
- Production should use `APP_DEBUG=false`.
- MySQL does not need to be exposed directly to LAN clients.

Recommended network flow:

```text
Client PC
    │
    │ HTTP :80
    ↓
Apache
    │
    │ Local connection
    ↓
MySQL
```

## 🖥️ LAN Deployment

Example deployment:

```text
             OFFICE LAN
                 │
       ┌─────────┴─────────┐
       │                   │
    Admin PC            Sales PC
       │                   │
       └─────────┬─────────┘
                 │
                 │ HTTP :80
                 ↓
       ┌──────────────────────┐
       │      PC IT SERVER    │
       │      10.130.53.87    │
       │                      │
       │ Apache / XAMPP       │
       │ Laravel 12           │
       │ PHP 8.2              │
       │ MySQL                │
       └──────────────────────┘
```

Primary LAN URL:

```text
http://10.130.53.87
```

Optional local hostname:

```text
http://sales-visit.local
```

## 🛠️ Tech Stack

| Technology | Usage |
|---|---|
| Laravel 12 | Backend framework |
| PHP 8.2 | Application language |
| MySQL | Database |
| Blade | Server-side UI |
| HTML5 | Page structure |
| CSS3 | Styling |
| Apache | Web server |
| XAMPP | Windows local server |
| Laravel Excel | Excel export |
| DomPDF | PDF export |

## 📁 Project Structure

```text
sales-visit-report/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   └── Middleware/
│   ├── Models/
│   ├── Repositories/
│   └── Services/
├── bootstrap/
├── config/
├── database/
│   ├── migrations/
│   └── seeders/
├── public/
├── resources/
│   └── views/
│       ├── auth/
│       ├── dashboard/
│       ├── institutions/
│       ├── layouts/
│       ├── users/
│       └── visits/
├── routes/
├── storage/
├── tests/
├── .env.example
├── .gitignore
├── artisan
├── composer.json
├── composer.lock
├── package.json
└── vite.config.js
```

## 📸 Screenshots

Add sanitized screenshots under:

```text
docs/screenshots/
├── login.png
├── dashboard.png
├── visits.png
├── institutions.png
└── users.png
```

Example:

```markdown
### Login
![Login](docs/screenshots/login.png)

### Executive Dashboard
![Dashboard](docs/screenshots/dashboard.png)

### Visit Reports
![Visit Reports](docs/screenshots/visits.png)

### Institution Management
![Institutions](docs/screenshots/institutions.png)

### User Management
![Users](docs/screenshots/users.png)
```

> Do not upload real customer/company data, passwords, or other confidential information.

## 🚀 Installation

### Requirements

- PHP 8.2+
- Composer
- MySQL
- Apache or another Laravel-compatible web server
- Node.js/NPM if frontend assets require it

### 1. Clone

```bash
git clone https://github.com/rahmanbayupradana/sales-visit-report.git
cd sales-visit-report
```

### 2. Install PHP dependencies

```bash
composer install
```

If frontend dependencies are required:

```bash
npm install
npm run build
```

### 3. Environment

Windows:

```cmd
copy .env.example .env
```

Linux/macOS:

```bash
cp .env.example .env
```

Generate application key:

```bash
php artisan key:generate
```

### 4. Configure MySQL

Create:

```text
sales_visit_report
```

Configure `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sales_visit_report
DB_USERNAME=root
DB_PASSWORD=
```

Use the correct credentials for your environment.

### 5. Run migrations

```bash
php artisan migrate
```

If seeders are available:

```bash
php artisan migrate --seed
```

### 6. Run locally

```bash
php artisan serve
```

Open:

```text
http://127.0.0.1:8000
```

For LAN testing:

```bash
php artisan serve --host=0.0.0.0 --port=8000
```

## ⚙️ Apache / XAMPP

Example Apache configuration:

```apache
DocumentRoot "C:/Users/User/sales-visit-report/public"

<Directory "C:/Users/User/sales-visit-report/public">
    AllowOverride All
    Require all granted
</Directory>
```

Test Apache configuration:

```cmd
httpd.exe -t
```

Expected:

```text
Syntax OK
```

## 🔧 Useful Commands

```bash
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan route:list
```

## 🐛 Troubleshooting

### Duplicate login route

If Laravel reports:

```text
Another route has already been assigned name [login]
```

use different route names:

```php
Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.authenticate');
```

### LAN cannot access application

Check:

1. Server IP.
2. Apache status.
3. Windows Firewall TCP port 80.
4. Client-to-server connectivity.
5. Apache configuration.
6. Laravel `.env`.

PowerShell:

```powershell
Test-NetConnection 10.130.53.87 -Port 80
```

### Clear Laravel cache

```bash
php artisan optimize:clear
```

### Database issue

Check:

- MySQL service
- Database name
- `.env`
- MySQL port
- Laravel logs

## 💾 Backup

Database backup is intentionally handled outside the application through phpMyAdmin or another backup process.

Typical flow:

```text
phpMyAdmin
    ↓
sales_visit_report
    ↓
Export
    ↓
SQL backup
```

Database dumps should **not** be committed to this public repository.

## 🧪 Final Acceptance Checklist

```text
[ ] Admin login
[ ] Sales login
[ ] Logout
[ ] Executive Dashboard
[ ] Visit CRUD
[ ] Institution CRUD
[ ] User Management
[ ] Search
[ ] Filters
[ ] Pagination
[ ] Excel export
[ ] PDF export
[ ] Role authorization
[ ] Sales ownership authorization
[ ] LAN access
[ ] Apache
[ ] MySQL
[ ] APP_DEBUG=false
[ ] Database backup
```

## 📈 Future Improvements

Potential Version 2 features:

- Sales target and achievement
- Target vs actual dashboard
- Audit log
- Visit photo/proof upload
- Admin approval workflow
- Excel import for institutions
- Automated monthly reports
- Notification system
- Advanced management analytics

## 💼 Portfolio Highlights

This project demonstrates practical experience with:

- Laravel application development
- PHP OOP
- MVC architecture
- Service Layer
- Repository Pattern
- Eloquent ORM
- MySQL database design
- Authentication
- Role-Based Access Control (RBAC)
- Backend authorization
- Data ownership validation
- Dashboard development
- Excel/PDF reporting
- Apache/XAMPP deployment
- Windows LAN deployment
- Application troubleshooting
- Git/GitHub workflow

## 👨‍💻 Developer

**Rahman Bayu Pradana**

GitHub:  
https://github.com/rahmanbayupradana

## 📄 License

This project is maintained primarily as a portfolio and demonstration project.

If you intend to distribute or reuse it as open-source software, add an appropriate license and review the project's dependencies and business requirements.

---

<p align="center">
  <strong>Sales Visit Report</strong><br>
  Built with Laravel 12 ❤️
</p>
