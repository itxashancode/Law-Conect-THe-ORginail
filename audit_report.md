# 🛡️ Law-Conect System Failure Audit

This audit identifies critical points that may cause the application to crash or malfunction. Use this report with Claude Code (step-3.5-flash) to systematically harden the application.

---

## 1. Critical "Hard Crash" Vectors (PHP/Laravel)

### 🔴 Problem A: Role-Based Redirects
**File:** `routes/web.php` (L21-25)
**Risk:** If the Spatie `roles` table is empty or the user lacks a role, `auth()->user()->hasRole('admin')` might behave unexpectedly or lead to a redirect loop if the default route is not handled correctly.
**Action for Claude Code:** 
- Verify `spatie/laravel-permission` is fully installed (run `php artisan vendor:publish`).
- Check if roles ('admin', 'lawyer', 'customer') are seeded in `Database\Seeders\RolesAndPermissionsSeeder.php`.
- Add a fallback redirect to a 'profile setup' page if no role is found.

### 🔴 Problem B: Number Formatting on Nulls
**File:** `resources/views/public/lawyer-profile.blade.php`
**Risk:** `number_format($lawyer->consultation_fee, 0)` will throw a TypeError if `consultation_fee` is null.
**Action for Claude Code:** 
- Use the null-safe operator or a default value: `number_format($lawyer->consultation_fee ?? 0, 0)`.
- Ensure all numeric fields in Blade are wrapped in null-coalescing logic.

### 🔴 Problem C: Missing `HomepageContent` Data
**File:** `app/Http/Controllers/PublicController.php` (L17)
**Risk:** The controller fetches `HomepageContent::all()`, but if the table is empty, the variable is an empty collection. While not a crash, it defeats the purpose of the CMS.
**Action for Claude Code:** 
- Add a check in the controller to provide "default" content if the DB is empty.
- Generate a seeder for `HomepageContent`.

---

## 2. Infrastructure & Environment Readiness

### 🟠 Problem D: Unlinked Storage
**Risk:** Lawyer photos are stored in `storage/app/public`. If `php artisan storage:link` hasn't been run, `asset('storage/...')` will return 404s.
**Action for Claude Code:** 
- Run `php artisan storage:link`.
- Verify the `FILESYSTEM_DISK` is set to `public` in `.env`.

### 🟠 Problem E: Vite Manifest Exceptions
**Risk:** If `public/build/manifest.json` is missing (happens if Vite isn't compiled), Laravel throws an exception.
**Action for Claude Code:** 
- Run `npm install && npm run build` to ensure assets are present for production.

---

## 3. Database Integrity

### 🟡 Problem F: Base Table Missing
**Risk:** The `Lawyer` model and others are accessed before migrations are run.
**Action for Claude Code:** 
- Run `php artisan migrate`.
- Check `database/migrations` for consistency between `Lawyer`, `AvailabilitySlot`, and `Appointment`.

---

## 📋 Summary of Next Steps for Claude Code

1. **Phase 1: Hardening**
   - [ ] Audit all Blade files for `number_format` and `Carbon::parse` on nullable fields.
   - [ ] Add `->default(0)` or `->nullable()` to migrations for fee and experience fields.
2. **Phase 2: Seeding**
   - [ ] Create `RolesAndPermissionsSeeder`.
   - [ ] Create `LawyerSeeder` with realistic data and existing photo paths.
3. **Phase 3: Integration**
   - [ ] Ensure `PublicController` correctly passes fallback data for the homepage.
