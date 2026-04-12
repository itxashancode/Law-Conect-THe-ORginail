# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

Law-Conect is a premium legal services platform built with Laravel 10, designed to connect clients with elite legal professionals. The application features a sophisticated multi-role architecture with distinct interfaces for administrators, lawyers, and customers.

**Core Features:**
- Public lawyer search and booking system
- Role-based access control (admin, lawyer, customer)
- Appointment management with scheduling
- Premium UI with advanced animations and gradients
- Multi-tenant design with role-specific dashboards

## Architecture

### Technology Stack
- **Backend:** Laravel 10, PHP 8.1+
- **Frontend:** Vite, Alpine.js, Tailwind CSS, GSAP
- **Database:** MySQL (configured via .env)
- **Authentication:** Laravel Sanctum + Spatie Permission
- **Testing:** PHPUnit

### Directory Structure
- `app/Models/` - Eloquent models (User, Lawyer, Appointment, etc.)
- `app/Http/Controllers/` - Role-specific controllers
- `resources/views/` - Blade templates with three layouts (public, admin, lawyer/customer)
- `resources/js/` - Frontend components (Grainient, BounceCards, CustomMenu)
- `routes/` - Web routes organized by role

### Key Models
- **User:** Base authentication model with role traits
- **Lawyer:** Profile data linked to User
- **Appointment:** Booking system with customer/lawyer/slot relationships
- **AvailabilitySlot:** Time slot management for lawyers

## Development Commands

### Setup & Installation
```bash
# Install dependencies
composer install
npm install

# Generate app key
php artisan key:generate

# Run database migrations
php artisan migrate

# Seed database with sample data
php artisan db:seed

# Compile frontend assets
npm run dev
```

### Running the Application
```bash
# Start development server
php artisan serve

# Run with hot module replacement
npm run dev

# Build for production
npm run build
```

### Testing
```bash
# Run all tests
php artisan test

# Run specific test file
php artisan test tests/Feature/Auth/RegistrationTest.php

# Run with coverage
php artisan test --coverage
```

### Database Operations
```bash
# Create migration
php artisan make:migration create_table_name

# Run migrations
php artisan migrate

# Rollback last migration
php artisan migrate:rollback

# Seed database
php artisan db:seed

# Create model with migration
php artisan make:model Lawyer --migration
```

### Frontend Development
```bash
# Watch for changes
npm run dev

# Build for production
npm run build

# Clear Vite cache
npm run build -- --force
```

## Code Patterns & Conventions

### Models
- Use Eloquent relationships for data access
- Mass assignment protection via `$fillable`
- Role-based middleware in controllers

### Controllers
- Role-specific prefixes in routes
- Consistent naming: `AdminLawyerController`, `LawyerDashboardController`
- Middleware: `role.admin`, `role.lawyer`, `role.customer`

### Views
- Three main layouts: `public.blade.php`, `admin.blade.php`, `app.blade.php`
- Component-based design with reusable Blade components
- Tailwind CSS with custom color scheme (onyx/gold/linen)

### Frontend Components
- **Grainient:** WebGL-based animated gradient backgrounds
- **BounceCards:** GSAP-animated attorney cards
- **CustomMenu:** Fullscreen staggered navigation

## Testing Strategy

### Test Types
- **Feature Tests:** Authentication flows, role-based access
- **Unit Tests:** Model relationships, business logic
- **Database Tests:** Migration testing with `RefreshDatabase` trait

### Test Examples
```php
// Authentication tests
$response = $this->post('/login', [
    'email' => $user->email,
    'password' => 'password',
]);

// Role-based access tests
$response = $this->actingAs($user)->get('/admin/dashboard');
$response->assertForbidden();
```

## Deployment Notes

### Environment Configuration
- Configure `.env` with database credentials
- Set `APP_ENV=production` for live deployments
- Configure mail settings for notifications

### Asset Compilation
- Frontend assets compiled via Vite
- Tailwind CSS with custom color configuration
- Alpine.js for interactive components

## Security Considerations

### Authentication
- Role-based middleware for access control
- Laravel Sanctum for API authentication
- Password hashing with Bcrypt

### Data Protection
- Mass assignment protection in models
- Input validation in form requests
- SQL injection prevention via Eloquent

## Common Development Tasks

### Adding New Features
1. Create migration for database changes
2. Update models with relationships
3. Create controller with appropriate middleware
4. Add routes with role prefixes
5. Create/update views with consistent styling

### Modifying Existing Features
1. Check existing tests for coverage
2. Update related models/controllers
3. Test role-based access changes
4. Update frontend components if needed

### Debugging
- Check Laravel logs in `storage/logs/laravel.log`
- Use browser DevTools for frontend issues
- Verify role permissions in database

## Performance Considerations

### Frontend
- Optimize images and animations
- Use lazy loading for large components
- Cache compiled assets

### Backend
- Use eager loading for relationships
- Implement query optimization
- Cache frequently accessed data

## Maintenance

### Regular Tasks
- Update dependencies with `composer update`
- Run tests after updates
- Monitor application logs
- Backup database regularly

### Database Maintenance
- Run `php artisan optimize` for performance
- Clear caches when needed: `php artisan cache:clear`
- Check migration status: `php artisan migrate:status`

## Troubleshooting

### Common Issues
- **Asset compilation:** Check Vite configuration and dependencies
- **Authentication:** Verify role assignments in database
- **Database:** Check migration status and connection settings
- **Frontend:** Verify Alpine.js and GSAP initialization

### Debug Commands
```bash
# Check Laravel version
php artisan --version

# Check PHP version
php --version

# Check database connection
php artisan tinker --execute="DB::connection()->getPdo()"

# Clear all caches
php artisan optimize:clear
```

## Notes for Future Development

- The application uses a sophisticated color scheme with custom Tailwind configuration
- Advanced animations require careful testing across browsers
- Role-based access control is central to the application architecture
- Frontend components are modular and reusable
- Database relationships are well-defined with Eloquent models