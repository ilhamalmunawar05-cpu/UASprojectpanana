# SIPERPUS Development Quick Start Guide

## ⚡ Quick Setup (5 minutes)

### Prerequisites
- PHP 7.4 or higher
- Composer
- Node.js & npm (optional, for Vite)
- MySQL/MariaDB
- Git

### Setup Steps

```bash
# 1. Clone or navigate to project
cd c:/laragon/www/UASprojectpanana

# 2. Install composer dependencies
composer install

# 3. Copy environment file
cp .env.example .env

# 4. Generate app key
php artisan key:generate

# 5. Configure database in .env file
# Set DB_DATABASE, DB_USERNAME, DB_PASSWORD

# 6. Run migrations
php artisan migrate

# 7. Seed database (optional)
php artisan db:seed

# 8. Start development server
php artisan serve
# Access at http://localhost:8000
```

## Project Overview

### Technology Stack
- **Backend**: Laravel 8+
- **Frontend**: Bootstrap 4, jQuery
- **Template**: Book Master (Integrated)
- **Database**: MySQL/MariaDB
- **Asset Build**: Vite (configured)

### Key Directories
```
UASprojectpanana/
├── app/              # Application code
│   ├── Http/         # Controllers, Requests, Middleware
│   ├── Models/       # Database models
│   └── Providers/    # Service providers
├── routes/           # Route definitions
│   ├── web.php       # Web routes
│   ├── api.php       # API routes
│   └── auth.php      # Authentication routes
├── resources/        # Frontend assets
│   ├── views/        # Blade templates
│   ├── css/          # Stylesheets
│   ├── js/           # JavaScript
│   └── sass/         # SASS
├── public/           # Public assets
│   └── bookmaster/   # Integrated template assets
├── database/         # Migrations & seeders
├── config/           # Configuration files
└── storage/          # Logs, cache, files
```

## Development Commands

### Starting Development
```bash
# Start PHP development server
php artisan serve

# Start Vite (if using Vue/JS bundling)
npm run dev

# Start both in separate terminals
# Terminal 1:
php artisan serve

# Terminal 2:
npm run dev
```

### Database Management
```bash
# Create tables
php artisan migrate

# Rollback migrations
php artisan migrate:rollback

# Fresh database (warning: destructive!)
php artisan migrate:fresh

# Seed data
php artisan db:seed

# Specific seeder
php artisan db:seed --class=UserSeeder
```

### Working with Models
```bash
# Create model with migration
php artisan make:model Book -m

# Create model with migration and controller
php artisan make:model Book -mc

# Create full resource (model, controller, migration)
php artisan make:model Book -mcr
```

### Working with Controllers
```bash
# Create controller
php artisan make:controller BookController

# Create resource controller (CRUD)
php artisan make:controller BookController --resource

# Create controller with model
php artisan make:controller BookController --model=Book
```

### Create Request Classes
```bash
# Create form request
php artisan make:request StoreBookRequest
```

### Artisan Helpers
```bash
# Clear all caches
php artisan optimize:clear

# List all routes
php artisan route:list

# Check environment
php artisan tinker
```

## Frontend Development

### Template Files
```
resources/views/
├── layouts/
│   └── bookmaster.blade.php     # Main layout
├── bookmaster/
│   ├── index.blade.php          # Home
│   ├── generic.blade.php        # Info
│   └── elements.blade.php       # UI components
├── admin/                       # Admin views
├── auth/                        # Auth views
└── ...
```

### Adding New Page
```php
// 1. Create controller method
// app/Http/Controllers/PageController.php
public function show($page) {
    return view("bookmaster.$page");
}

// 2. Create blade view
// resources/views/bookmaster/newpage.blade.php
@extends('layouts.bookmaster')
@section('title', 'New Page')
@section('content')
    <!-- content -->
@endsection

// 3. Add route
// routes/web.php
Route::get('/page/{page}', [PageController::class, 'show']);
```

### Using Blade Syntax
```blade
{{-- Comments --}}

{{-- Variables --}}
{{ $variable }}
{{ $user->name ?? 'Guest' }}

{{-- Control Structures --}}
@if ($condition)
    // content
@else
    // alternative
@endif

@foreach ($items as $item)
    {{ $item }}
@endforeach

@for ($i = 0; $i < 10; $i++)
    {{ $i }}
@endfor

{{-- Components --}}
<x-alert />
@component('components.alert') @endcomponent

{{-- Include --}}
@include('path.to.view')

{{-- Extend Layout --}}
@extends('layouts.bookmaster')

{{-- Define Section --}}
@section('content')
@endsection

{{-- Inheritance --}}
@yield('content')
```

### Asset Helper
```blade
{{-- CSS --}}
<link href="{{ asset('bookmaster/css/main.css') }}" rel="stylesheet">

{{-- JavaScript --}}
<script src="{{ asset('bookmaster/js/main.js') }}"></script>

{{-- Images --}}
<img src="{{ asset('bookmaster/img/logo.png') }}" alt="">

{{-- URL Generation --}}
<a href="{{ route('home') }}">Home</a>
<a href="{{ url('/page') }}">Page</a>
```

## API Endpoints

### Public Endpoints (No Auth Required)
```
GET /artwork               # List all artworks
GET /artwork/{id}          # Get artwork details
GET /exhibitions           # List exhibitions
GET /artists               # List artists
GET /articles              # List articles
GET /museum                # Museum collections
```

### Authenticated Endpoints
```
POST /auctions/{auction}/bid   # Place bid
GET /profile                   # User profile
```

### Admin Endpoints
```
GET /admin/dashboard           # Admin dashboard
POST /admin/artworks           # Create artwork
PUT /admin/artworks/{id}       # Update artwork
DELETE /admin/artworks/{id}    # Delete artwork
# ...and more CRUD operations
```

## Testing

### Run Tests
```bash
# Run all tests
php artisan test

# Run specific test file
php artisan test tests/Feature/BookTest.php

# Run specific test method
php artisan test tests/Feature/BookTest.php --filter testCreateBook

# Run with coverage
php artisan test --coverage
```

### Create Test
```bash
php artisan make:test BookTest
php artisan make:test Feature/BookTest
php artisan make:test Unit/BookTest
```

## Debugging

### Using dd() (dump and die)
```php
dd($variable);        // Dump and stop execution
dump($variable);      // Just dump, continue
var_dump($variable);  // Native PHP dump
```

### Using Laravel Debugbar
```bash
# Install
composer require barryvdh/laravel-debugbar --dev

# Enable in .env
APP_DEBUG=true
```

### Check Logs
```bash
# View logs
tail -f storage/logs/laravel.log

# Clear logs
php artisan log:clear
```

### Database Debugging
```php
// Enable query logging
DB::enableQueryLog();
// ... your code ...
dd(DB::getQueryLog());
```

## Deployment Checklist

### Before Deploying
- [ ] All tests passing
- [ ] No console errors
- [ ] Database migrations ready
- [ ] Environment variables set
- [ ] Assets compiled
- [ ] Cache cleared

### Deployment Steps
```bash
# 1. Pull latest code
git pull origin main

# 2. Install dependencies
composer install --no-dev

# 3. Clear cache
php artisan optimize:clear

# 4. Run migrations
php artisan migrate --force

# 5. Compile assets
npm run build

# 6. Cache config/routes
php artisan config:cache
php artisan route:cache
```

## Useful Resources

### Internal Documentation
- [FRONTEND_INTEGRATION_GUIDE.md](FRONTEND_INTEGRATION_GUIDE.md) - Frontend setup
- [GIT_WORKFLOW.md](GIT_WORKFLOW.md) - Git branching strategy
- [SRS_SIPERPUS_LENGKAP.md](SRS_SIPERPUS_LENGKAP.md) - System requirements
- [STRUKTUR_DATABASE.md](STRUKTUR_DATABASE.md) - Database schema

### External Documentation
- [Laravel Documentation](https://laravel.com/docs)
- [Bootstrap Documentation](https://getbootstrap.com/docs/4.0/)
- [jQuery Documentation](https://jquery.com/)
- [MySQL Documentation](https://dev.mysql.com/doc/)

## Troubleshooting

### Common Issues

**Issue**: "Class not found" error
```bash
# Solution: Clear composer autoload cache
composer dump-autoload
```

**Issue**: Migration fails
```bash
# Solution: Check .env database settings
php artisan tinker
DB::connection()->getPdo();
```

**Issue**: Assets not loading
```bash
# Solution: Clear cache and verify paths
php artisan optimize:clear
php artisan storage:link
```

**Issue**: Permission denied on storage
```bash
# Solution: Fix permissions
chmod -R 755 storage bootstrap/cache
```

**Issue**: Port 8000 already in use
```bash
# Solution: Use different port
php artisan serve --port=8001
```

## Quick Commands Reference

| Command | Purpose |
|---------|---------|
| `php artisan serve` | Start dev server |
| `composer install` | Install dependencies |
| `php artisan migrate` | Run migrations |
| `php artisan tinker` | Interactive shell |
| `php artisan route:list` | List all routes |
| `php artisan cache:clear` | Clear cache |
| `php artisan optimize:clear` | Clear all caches |
| `npm run dev` | Vite dev mode |
| `npm run build` | Vite production build |
| `php artisan test` | Run tests |

## Getting Help

### Ask in Team
1. Check documentation first
2. Search in chat history
3. Ask in team channel

### Create Issues
- Use GitHub issues for bugs
- Use PR for features
- Assign to relevant person

### Check Logs
- `storage/logs/laravel.log` - Application logs
- Browser console - Frontend errors
- `php artisan log:tail` - Stream logs

---

**Last Updated**: 2026-06-11
**Project**: SIPERPUS
**Status**: Ready for Development
