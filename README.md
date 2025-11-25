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
