# Laravel & Flutter Task Manager

A cross-platform task management application combining Laravel 12 for the web backend and Flutter for the mobile frontend with shared database integration and full CRUD operations.

## Table of Contents
- [Features](#features)  
- [Prerequisites](#prerequisites)  
- [Installation](#installation)  
  - [1. Clone Repository](#1-clone-repository)  
  - [2. Backend Setup (Laravel)](#2-backend-setup-laravel)  
  - [3. Frontend Setup (Flutter)](#3-frontend-setup-flutter)  
- [Usage](#usage)  
- [API Endpoints](#api-endpoints)  
- [Testing](#testing)  
- [Contributing](#contributing)  
- [License](#license)  

## Features
- User authentication with Laravel Sanctum and Flutter login screen.  
- Full CRUD operations for tasks and categories on both web and mobile platforms.  
- Task filtering by status (All, Pending, In Progress, Completed) on the web interface.  
- Offline capability and local data caching in Flutter for intermittent connectivity.  
- Push notifications for task deadlines via Flutter’s notification APIs.  

## Prerequisites
- **XAMPP** (Apache, MySQL) for local PHP and database services.  
- **PHP 8.2+** and **Composer 2.x** for Laravel development.  
- **Node.js** (v16+) and **npm** for frontend asset compilation.  
- **Flutter SDK** (v3.10+) and **Android Studio** for mobile development.  
- **MySQL 8.x** database configured via XAMPP.  

## Installation

### 1. Clone Repository
```
git clone https://github.com/yourusername/task-manager.git
cd task-manager
```

### 2. Backend Setup (Laravel)
1. Install PHP dependencies:  
   ```
   composer install
   ```
2. Copy environment file and generate app key:  
   ```
   cp .env.example .env
   php artisan key:generate
   ```
3. Configure `.env` for MySQL (XAMPP defaults):  
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=task_manager_db
   DB_USERNAME=root
   DB_PASSWORD=
   ```
4. Run migrations and seeders:  
   ```
   php artisan migrate --seed
   ```
5. Install Node.js dependencies and build assets:  
   ```
   npm install
   npm run build
   ```
6. Serve the application:  
   ```
   php artisan serve --host=0.0.0.0 --port=8000
   ```

### 3. Frontend Setup (Flutter)
1. Navigate to the mobile project:  
   ```
   cd mobile
   ```
2. Install Flutter dependencies:  
   ```
   flutter pub get
   ```
3. Launch an emulator or connect a device in Android Studio.  
4. Run the app:  
   ```
   flutter run
   ```

## Usage
- **Web:** Visit `http://localhost:8000` to register, login, and manage tasks/categories.  
- **Mobile:** Use the Flutter app to login, view, add, edit, and delete tasks on the go.  

## API Endpoints
| Method | Endpoint                     | Description                   |
|--------|------------------------------|-------------------------------|
| POST   | `/api/auth/mobile-login`     | Authenticate mobile user      |
| POST   | `/api/auth/logout`           | Logout and revoke token       |
| GET    | `/api/tasks`                 | List user tasks               |
| POST   | `/api/tasks`                 | Create a new task             |
| GET    | `/api/tasks/{id}`            | Retrieve a specific task      |
| PUT    | `/api/tasks/{id}`            | Update a specific task        |
| DELETE | `/api/tasks/{id}`            | Delete a specific task        |
| GET    | `/api/categories`            | List user categories          |
| POST   | `/api/categories`            | Create a new category         |
| GET    | `/api/categories/{id}`       | Retrieve a specific category  |
| PUT    | `/api/categories/{id}`       | Update a specific category    |
| DELETE | `/api/categories/{id}`       | Delete a specific category    |

## Testing
- **Backend:**  
  ```
  php artisan test
  ```
- **Mobile:**  
  ```
  flutter test
  ```

## Contributing
1. Fork the repository and create a feature branch.  
2. Commit changes with descriptive messages.  
3. Submit a pull request adhering to PSR-12 and Dart style guidelines.  

## License
This project is licensed under the [MIT License](LICENSE).  
