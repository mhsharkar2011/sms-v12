## Step-by-Step Migration to Spatie

composer require spatie/laravel-permission


# 1. Teachers first
php artisan migrate --path=database/migrations/your_teachers_migration.php

# 2. School classes second  
php artisan migrate --path=database/migrations/your_school_classes_migration.php

# 3. Then the pivot tables
php artisan migrate --path=database/migrations/your_teacher_class_migration.php
php artisan migrate --path=database/migrations/your_teacher_subject_migration.php



## Enrollment 

resources/views/admin/enrollments/
├── index.blade.php      # List all enrollments
├── create.blade.php     # Create new enrollment
├── show.blade.php       # View single enrollment
├── edit.blade.php       # Edit enrollment
├── class.blade.php      # Enrollments for a specific class
└── student.blade.php    # Enrollments for a specific student


## Final Work

-- Student Create done
-- Student Delete Pending
-- 
## How to install project

-- composer global require laravel/installer

-- laravel new project-name

## For authentication system with blade

-- composer require laravel/breeze --dev

-- php artisan breeze:install

## Run for frontend

-- npm install
-- npm run dev
-- php artisan migrate


## Component

Component	Purpose
app/Models/User.php	The main user model.
app/Http/Controllers/Auth/	Controllers for Login, Register, Password Reset, etc.
routes/auth.php	Routes for authentication endpoints (linked by RouteServiceProvider).
database/migrations/	Contains the create_users_table migration.
