## Step-by-Step Migration to Spatie

composer require spatie/laravel-permission


# 1. Teachers first
php artisan migrate --path=database/migrations/your_teachers_migration.php

# 2. School classes second  
php artisan migrate --path=database/migrations/your_school_classes_migration.php

# 3. Then the pivot tables
php artisan migrate --path=database/migrations/your_teacher_class_migration.php
php artisan migrate --path=database/migrations/your_teacher_subject_migration.php

## Installing Auth Sanctum

composer require laravel/sanctum

## Clear ALL caches

php artisan route:clear
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan optimize:clear
composer dump-autoload

