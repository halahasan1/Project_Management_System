
# Project Management System 

A project management platform built with Laravel that supports teams, tasks, projects, file attachments, comments, and role-based permissions.

---

## Requirements

- PHP >= 8.1
- Composer
- Laravel 10+
- MySQL 

---

## Installation

1. **Clone the Repository**

```bash
git clone https://github.com/halahasan1/Project_Management_System.git
cd project-management-system
````

2. **Install Dependencies**

```bash
composer install
npm install && npm run dev
```

3. **Environment Setup**

```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env` with your DB and mail configuration.

4. **Run Migrations and Seeders**

```bash
php artisan migrate --seed
```

This includes all required tables for:

* Users
* Teams
* Projects
* Tasks
* Comments
* Attachments
* Notifications
* Permissions

5. **Storage Linking**

```bash
php artisan storage:link
```

6. **Queue (Optional)**

If you’re using queues and events:

```bash
php artisan queue:work
```

---

## Features

* Team and Project management
* Task assignments and statuses
* Comments with attachments (morphable)
* User authentication and authorization
* Notification system
* RESTful API endpoints
* Event & Listener handling
* Queueable jobs
* Eloquent Observers
* File uploads

---

## Testing

1. **Run Unit and Feature Tests**

```bash
php artisan test
```

2. **Common Areas Covered**

* CRUD for Teams, Projects, Tasks, Comments
* User Permissions & Roles
* Event and Queue fakes
* Observer behavior
* File upload logic

---

## Factories and Seeders

The project includes:

* Model Factories for Users, Teams, Projects, Tasks, Comments
* Related Seeders with real relationships for testing

You may regenerate seed data with:

```bash
php artisan migrate:fresh --seed
```

---

## Folder Structure 

* `app/Models/` — Eloquent models
* `app/Services/` — Business logic layer (TeamService, TaskService, etc.)
* `app/Http/Controllers/` — API controllers
* `app/Http/Requests/` — Form requests for validation
* `app/Observers/` — Model observers
* `app/Events/`, `app/Listeners/` — Event-driven architecture
* `database/seeders/`, `database/factories/` — Seeder and test data

---

## API Usage

👉 **[Postman Collection Link](https://www.postman.com/research-geoscientist-78470583/workspace/my-workspace/collection/39063412-e89237fb-9fca-4f8b-b3b9-3ef99ebfb6da?action=share&creator=39063412)**

This system exposes standard RESTful API routes for:

* Teams
* Projects
* Tasks
* Comments
* Attachments

Authentication is handled via Sanctum 

