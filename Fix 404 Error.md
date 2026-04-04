# Fix 404 Error on /lawyer/register

## Root Cause: PHP Version Mismatch

Your system has PHP 8.0.30, but this project requires PHP 8.1 or higher.

**Check your PHP version:**
```bash
php -v
```

If it shows 8.0.x, you need to upgrade or use a different PHP installation.

## Solution 1: Use PHP 8.1+ (Recommended)

If you have PHP 8.1+ installed elsewhere (as you mentioned), you need to:

### Option A: Update System PATH (Windows)

1. Find where PHP 8.1+ is installed (common locations):
   - `C:\xampp\php\` (if XAMPP)
   - `C:\wamp64\bin\php\php8.1.x\`
   - `C:\php\` or `C:\php81\`

2. Update your system PATH:
   - Right-click "This PC" → Properties → Advanced system settings → Environment Variables
   - Under "System variables", find "Path", click Edit
   - Move the PHP 8.1+ path **above** any PHP 8.0 paths
   - Remove or reorder PHP 8.0 path if needed

3. Open a **new** terminal and verify:
```bash
php -v
```
Should show: PHP 8.1.x or higher

4. Start the server:
```bash
php artisan serve
```

### Option B: Use a Specific PHP Path Temporarily

If you don't want to change PATH, specify the full PHP path:
```bash
# Find your PHP 8.1 executable first
# Example: C:\xampp\php\php.exe

"C:\path\to\php8.1\php.exe" artisan serve
```

Or create a new batch file `start_server.bat`:
```batch
@echo off
"C:\xampp\php\php.exe" artisan serve
pause
```

## Solution 2: Downgrade Laravel Requirements (Not Recommended)

If you cannot upgrade PHP, you could modify `composer.json` to allow PHP 8.0, but this may cause other compatibility issues.

Change:
```json
"php": "^8.1",
```
to:
```json
"php": "^8.0",
```

Then run:
```bash
composer update
```

**Warning:** This may break functionality that requires PHP 8.1+ features.

## Solution 3: Use Docker (Alternative)

If you have Docker, create a `docker-compose.yml`:

```yaml
version: '3.8'
services:
  laravel:
    image: php:8.1-apache
    ports:
      - "8000:80"
    volumes:
      - ./:/var/www/html
    environment:
      - APACHE_DOCUMENT_ROOT=/var/www/html/public
```

Then:
```bash
docker-compose up -d
```

## After Fixing PHP Version

Once you're running PHP 8.1+:

1. Clear Laravel caches:
```bash
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

2. Verify `/lawyer/register` route exists:
```bash
php artisan route:list | grep lawyer
```

You should see:
```
GET|HEAD  lawyer/register  lawyer.register  App\Http\Controllers\Auth\LawyerRegistrationController@showRegistrationForm  guest
```

3. Start the server:
```bash
php artisan serve
```

4. Visit: http://localhost:8000/lawyer/register

## Testing the Route

If you still get 404 after fixing PHP version:

1. Make sure you're **not logged in** - the route uses `guest` middleware
2. Try in incognito/private browsing mode
3. Check that the `auth.php` routes file is being loaded (line 78 in `web.php` has `require __DIR__.'/auth.php';`)
4. Verify the view file exists: `resources/views/auth/lawyer/register.blade.php`

## Summary

The two issues you're experiencing are:
1. ✅ **GSAP text showing** - Fixed! (moved code inside `<script>` tags in `home.blade.php`)
2. ❌ **404 on /lawyer/register** - Caused by PHP 8.0.30 < 8.1 requirement

**Fix PHP version first, then test the route again.**
