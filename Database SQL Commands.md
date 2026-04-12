# Database SQL Commands

---

## ✅ Session Fix Log — April 2026 (Site Now Working)

This section documents every fix applied to get the site running on a fresh environment.

---

### Fix 1: PHP 8.1 MySQL Driver Not Enabled

**Error:** `could not find driver` — Laravel could not connect to MySQL at all.

**Root Cause:** The PHP 8.1 installation at `C:\Users\Ashan PC\AppData\Local\Programs\PHP\current\` had `pdo_mysql` and `mysqli` commented out in `php.ini`.

**Fix:** Uncomment both extensions in:
```
C:\Users\Ashan PC\AppData\Local\Programs\PHP\current\php.ini
```

Find these lines and **remove the leading semicolon** (`;`):
```ini
; Before (broken):
;extension=pdo_mysql
;extension=mysqli

; After (fixed):
extension=pdo_mysql
extension=mysqli
```

**Verify** extensions loaded:
```powershell
& "C:\Users\Ashan PC\AppData\Local\Programs\PHP\current\php.exe" -m | Select-String "pdo_mysql|mysqli"
# Should output: mysqli  pdo_mysql
```

---

### Fix 2: Always Start Server with PHP 8.1 (Not WAMP's PHP 8.0)

The project requires PHP >= 8.1. WAMP installs PHP 8.0 as the system default. Always use:

```powershell
& "C:\Users\Ashan PC\AppData\Local\Programs\PHP\current\php.exe" artisan serve
```

> ⚠️ Never use `php artisan serve` directly — that picks up WAMP's PHP 8.0 which fails with a Composer platform check error.

---

### Fix 3: Verify lawyers Table & Status Column (phpMyAdmin)

**Error:** `select * from 'lawyers' where 'status' = approved order by 'created_at' desc limit 6`

**Diagnosis:** Run in phpMyAdmin SQL tab to check the table and column:

```sql
USE `lawyers_db`;

-- Check the status column definition
SHOW COLUMNS FROM `lawyers` LIKE 'status';
-- Expected Type: enum('pending','approved','rejected')

-- Test the exact query manually
SELECT * FROM `lawyers` WHERE `status` = 'approved' ORDER BY `created_at` DESC LIMIT 6;
```

**If `status` column is wrong type**, fix it:
```sql
ALTER TABLE `lawyers`
  MODIFY COLUMN `status` ENUM('pending', 'approved', 'rejected') NOT NULL DEFAULT 'pending';
```

---

### Fix 4: Create Missing Tables (if lawyers table doesn't exist)

Run in phpMyAdmin if the `lawyers` table is missing:

```sql
USE `lawyers_db`;

CREATE TABLE IF NOT EXISTS `lawyers` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `bar_license` varchar(255) NOT NULL,
  `specialization` enum('Criminal','Divorce','Affidavit','Civil') NOT NULL,
  `city` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `phone` varchar(255) NOT NULL,
  `bio` text DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `experience_years` smallint(5) UNSIGNED DEFAULT 0,
  `consultation_fee` decimal(8,2) DEFAULT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `lawyers_bar_license_unique` (`bar_license`),
  KEY `lawyers_user_id_foreign` (`user_id`),
  KEY `lawyers_status_index` (`status`),
  CONSTRAINT `lawyers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `availability_slots` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `lawyer_id` bigint(20) UNSIGNED NOT NULL,
  `available_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `is_booked` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `availability_slots_lawyer_id_foreign` (`lawyer_id`),
  KEY `availability_slots_available_date_index` (`available_date`),
  CONSTRAINT `availability_slots_lawyer_id_foreign` FOREIGN KEY (`lawyer_id`) REFERENCES `lawyers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `appointments` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `lawyer_id` bigint(20) UNSIGNED NOT NULL,
  `slot_id` bigint(20) UNSIGNED NOT NULL,
  `subject` varchar(255) NOT NULL,
  `meeting_place` text DEFAULT NULL,
  `status` enum('pending','confirmed','cancelled','completed') DEFAULT 'pending',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `appointments_customer_id_foreign` (`customer_id`),
  KEY `appointments_lawyer_id_foreign` (`lawyer_id`),
  KEY `appointments_slot_id_foreign` (`slot_id`),
  KEY `appointments_status_index` (`status`),
  CONSTRAINT `appointments_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `appointments_lawyer_id_foreign` FOREIGN KEY (`lawyer_id`) REFERENCES `lawyers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `appointments_slot_id_foreign` FOREIGN KEY (`slot_id`) REFERENCES `availability_slots` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Verify all tables exist
SHOW TABLES;
```

---

### Quick-Start Checklist (New Machine / Fresh Clone)

1. ✅ Use PHP 8.1: `& "C:\Users\Ashan PC\AppData\Local\Programs\PHP\current\php.exe"`
2. ✅ Enable `pdo_mysql` + `mysqli` in PHP 8.1's `php.ini`
3. ✅ Create database `lawyers_db` in phpMyAdmin
4. ✅ Run the full table setup SQL (Option 1 or Option 2 below)
5. ✅ Copy `.env.example` to `.env`, set `DB_DATABASE=lawyers_db`, `DB_USERNAME`, `DB_PASSWORD`
6. ✅ Start server: `& "C:\...\php.exe" artisan serve`

---

# Database SQL Commands

## Option 1: Complete Fresh Setup (Recommended)

Use these commands if the database is in an inconsistent state. This will drop and recreate everything:

```sql
-- Step 1: Drop the database if it exists (WARNING: deletes all data)
DROP DATABASE IF EXISTS `lawyers_db`;

-- Step 2: Create the database
CREATE DATABASE `lawyers_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `lawyers_db`;

-- Step 3: Create all tables (copy and paste everything below this line)
-- =====================================================
-- Laravel Core Tables
-- =====================================================

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `user_type` enum('admin','lawyer','customer') DEFAULT 'customer',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `lawyers` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `bar_license` varchar(255) NOT NULL,
  `specialization` enum('Criminal','Divorce','Affidavit','Civil') NOT NULL,
  `city` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `phone` varchar(255) NOT NULL,
  `bio` text DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `experience_years` smallint(5) UNSIGNED DEFAULT 0,
  `consultation_fee` decimal(8,2) DEFAULT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `lawyers_bar_license_unique` (`bar_license`),
  KEY `lawyers_user_id_foreign` (`user_id`),
  KEY `lawyers_status_index` (`status`),
  CONSTRAINT `lawyers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `availability_slots` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `lawyer_id` bigint(20) UNSIGNED NOT NULL,
  `available_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `is_booked` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `availability_slots_lawyer_id_foreign` (`lawyer_id`),
  KEY `availability_slots_available_date_index` (`available_date`),
  CONSTRAINT `availability_slots_lawyer_id_foreign` FOREIGN KEY (`lawyer_id`) REFERENCES `lawyers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `appointments` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `lawyer_id` bigint(20) UNSIGNED NOT NULL,
  `slot_id` bigint(20) UNSIGNED NOT NULL,
  `subject` varchar(255) NOT NULL,
  `meeting_place` text DEFAULT NULL,
  `status` enum('pending','confirmed','cancelled','completed') DEFAULT 'pending',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `appointments_customer_id_foreign` (`customer_id`),
  KEY `appointments_lawyer_id_foreign` (`lawyer_id`),
  KEY `appointments_slot_id_foreign` (`slot_id`),
  KEY `appointments_status_index` (`status`),
  CONSTRAINT `appointments_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `appointments_lawyer_id_foreign` FOREIGN KEY (`lawyer_id`) REFERENCES `lawyers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `appointments_slot_id_foreign` FOREIGN KEY (`slot_id`) REFERENCES `availability_slots` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `homepage_contents` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `section` varchar(255) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `body` text DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `homepage_contents_section_unique` (`section`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `roles` (`name`, `guard_name`, `created_at`, `updated_at`) VALUES
('admin', 'web', NOW(), NOW()),
('lawyer', 'web', NOW(), NOW()),
('customer', 'web', NOW(), NOW());
```

## Option 2: Add Missing Tables Only

If you only need to add the missing `appointments` table (and related tables), use these commands:

```sql
-- Use your database
USE `lawyers_db`;

-- Create lawyers table if missing
CREATE TABLE IF NOT EXISTS `lawyers` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `bar_license` varchar(255) NOT NULL,
  `specialization` enum('Criminal','Divorce','Affidavit','Civil') NOT NULL,
  `city` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `phone` varchar(255) NOT NULL,
  `bio` text DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `experience_years` smallint(5) UNSIGNED DEFAULT 0,
  `consultation_fee` decimal(8,2) DEFAULT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `lawyers_bar_license_unique` (`bar_license`),
  KEY `lawyers_user_id_foreign` (`user_id`),
  KEY `lawyers_status_index` (`status`),
  CONSTRAINT `lawyers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create availability_slots table if missing
CREATE TABLE IF NOT EXISTS `availability_slots` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `lawyer_id` bigint(20) UNSIGNED NOT NULL,
  `available_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `is_booked` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `availability_slots_lawyer_id_foreign` (`lawyer_id`),
  KEY `availability_slots_available_date_index` (`available_date`),
  CONSTRAINT `availability_slots_lawyer_id_foreign` FOREIGN KEY (`lawyer_id`) REFERENCES `lawyers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create appointments table if missing
CREATE TABLE IF NOT EXISTS `appointments` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `lawyer_id` bigint(20) UNSIGNED NOT NULL,
  `slot_id` bigint(20) UNSIGNED NOT NULL,
  `subject` varchar(255) NOT NULL,
  `meeting_place` text DEFAULT NULL,
  `status` enum('pending','confirmed','cancelled','completed') DEFAULT 'pending',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `appointments_customer_id_foreign` (`customer_id`),
  KEY `appointments_lawyer_id_foreign` (`lawyer_id`),
  KEY `appointments_slot_id_foreign` (`slot_id`),
  KEY `appointments_status_index` (`status`),
  CONSTRAINT `appointments_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `appointments_lawyer_id_foreign` FOREIGN KEY (`lawyer_id`) REFERENCES `lawyers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `appointments_slot_id_foreign` FOREIGN KEY (`slot_id`) REFERENCES `availability_slots` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create homepage_contents table if missing
CREATE TABLE IF NOT EXISTS `homepage_contents` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `section` varchar(255) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `body` text DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `homepage_contents_section_unique` (`section`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create Spatie permission tables if missing
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert default roles if not exist
INSERT IGNORE INTO `roles` (`name`, `guard_name`, `created_at`, `updated_at`) VALUES
('admin', 'web', NOW(), NOW()),
('lawyer', 'web', NOW(), NOW()),
('customer', 'web', NOW(), NOW());
```

## How to Execute These Commands

### Using MySQL Command Line:

```bash
mysql -u root -p lawyers_db < "full_path_to_these_commands.sql"
```

Or manually:
```bash
mysql -u root -p
```
Then paste the commands and press Enter.

### Using phpMyAdmin:

1. Open phpMyAdmin
2. Select the `lawyers_db` database
3. Click on "SQL" tab
4. Paste the commands
5. Click "Go"

### Using MySQL Workbench:

1. Open a new query tab
2. Paste the commands
3. Click "Execute"

## Verify Tables Were Created

After running the commands, verify with:

```sql
SHOW TABLES;
```

Expected output should include:
- users
- lawyers
- availability_slots
- appointments
- homepage_contents
- roles
- permissions
- model_has_roles
- model_has_permissions
- role_has_permissions
- migrations
- password_reset_tokens
- personal_access_tokens

## Quick One-Line Command

If you have the `database.sql` file ready, just run:

```bash
mysql -u root -p lawyers_db < database.sql
```

Or to recreate everything fresh:
```bash
mysql -u root -p -e "DROP DATABASE IF EXISTS lawyers_db; CREATE DATABASE lawyers_db;"
mysql -u root -p lawyers_db < database.sql
```
## Option 3: Bulk Test Data (Crowd the Site)

Run these commands to populate the database with realistic test data for all roles. This will add lawyers, availability slots, and sample customers.

```sql
USE `lawyers_db`;

-- 1. Create Sample Customers
INSERT INTO `users` (`name`, `email`, `password`, `user_type`, `created_at`, `updated_at`) VALUES
('Alexander Wright', 'customer1@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'customer', NOW(), NOW()),
('Sophia Montgomery', 'customer2@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'customer', NOW(), NOW()),
('Julian Thorne', 'customer3@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'customer', NOW(), NOW()),
('Elena Vance', 'customer4@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'customer', NOW(), NOW());

-- 2. Create Lawyer Users
INSERT INTO `users` (`name`, `email`, `password`, `user_type`, `created_at`, `updated_at`) VALUES
('Dr. Alistair Sterling', 'lawyer1@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'lawyer', NOW(), NOW()),
('Beatrix Von Bloom', 'lawyer2@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'lawyer', NOW(), NOW()),
('Cillian O''Sullivan', 'lawyer3@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'lawyer', NOW(), NOW()),
('Daphne Ashford', 'lawyer4@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'lawyer', NOW(), NOW()),
('Evander Blackwood', 'lawyer5@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'lawyer', NOW(), NOW()),
('Flora Nightingale', 'lawyer6@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'lawyer', NOW(), NOW()),
('Gideon Thorne', 'lawyer7@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'lawyer', NOW(), NOW()),
('Helena Troy', 'lawyer8@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'lawyer', NOW(), NOW()),
('Ignatius Fray', 'lawyer9@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'lawyer', NOW(), NOW()),
('Jasper Crane', 'lawyer10@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'lawyer', NOW(), NOW());

-- 3. Populate Lawyer Profiles
-- Note: Replace LAST_INSERT_ID() logic with specific IDs if running piecewise, 
-- but this script assumes fresh sequential IDs from 5 (since 1-4 are customers).
INSERT INTO `lawyers` (`user_id`, `full_name`, `bar_license`, `specialization`, `city`, `address`, `phone`, `bio`, `experience_years`, `consultation_fee`, `status`, `created_at`, `updated_at`) VALUES
(5, 'Dr. Alistair Sterling', 'BAR-2024-001', 'Criminal', 'New York', '45 Wall Street, Executive Plaza', '+1 212-555-0198', 'Specializing in high-stakes white-collar criminal defense with over two decades of trial experience.', 22, 550.00, 'approved', NOW(), NOW()),
(6, 'Beatrix Von Bloom', 'BAR-2024-002', 'Divorce', 'Los Angeles', '888 Wilshire Blvd, Suite 12', '+1 310-555-0122', 'A leading expert in high-net-worth matrimonial litigation and family mediation.', 15, 450.00, 'approved', NOW(), NOW()),
(7, 'Cillian O''Sullivan', 'BAR-2024-003', 'Civil', 'Chicago', '122 Michigan Ave, Office 9', '+1 312-555-0144', 'Aggressive civil litigation focused on corporate disputes and contract integrity.', 12, 375.00, 'approved', NOW(), NOW()),
(8, 'Daphne Ashford', 'BAR-2024-004', 'Affidavit', 'Houston', '202 Main St, Heritage Tower', '+1 713-555-0166', 'Precision legal documentation and affidavit verification for international corporate compliance.', 8, 250.00, 'approved', NOW(), NOW()),
(9, 'Evander Blackwood', 'BAR-2024-005', 'Criminal', 'London', '10 Park Lane, Mayfair', '+44 20-7555-0188', 'Defending the elite with absolute discretion and strategic brilliance.', 20, 600.00, 'approved', NOW(), NOW()),
(10, 'Flora Nightingale', 'BAR-2024-006', 'Divorce', 'Paris', '42 Avenue Montaigne', '+33 1-555-0199', 'Elegant solutions for complex family transitions across international borders.', 10, 420.00, 'approved', NOW(), NOW()),
(11, 'Gideon Thorne', 'BAR-2024-007', 'Civil', 'Toronto', '100 King St West, Suite 500', '+1 416-555-0177', 'Master of mediation and relentless advocate in civil property disputes.', 14, 390.00, 'approved', NOW(), NOW()),
(12, 'Helena Troy', 'BAR-2024-008', 'Criminal', 'Rome', 'Via Condotti 15', '+39 06-555-0155', 'Expertise in international criminal law and diplomatic immunity cases.', 18, 520.00, 'approved', NOW(), NOW()),
(13, 'Ignatius Fray', 'BAR-2024-009', 'Affidavit', 'Dubai', 'Burj Daman, DIFC', '+971 4-555-0133', 'Premium notary services and affidavit drafting for regional investment portfolios.', 7, 300.00, 'approved', NOW(), NOW()),
(14, 'Jasper Crane', 'BAR-2024-010', 'Civil', 'Singapore', '1 Marina Boulevard', '+65 6555-0111', 'Leading light in maritime law and cross-border commercial litigation.', 25, 650.00, 'approved', NOW(), NOW());

-- 4. Create Availability Slots (3 per lawyer)
-- Alistair (ID:1)
INSERT INTO `availability_slots` (`lawyer_id`, `available_date`, `start_time`, `end_time`, `is_booked`, `created_at`, `updated_at`) VALUES
(1, CURDATE() + INTERVAL 1 DAY, '09:00:00', '10:00:00', 0, NOW(), NOW()),
(1, CURDATE() + INTERVAL 1 DAY, '11:00:00', '12:00:00', 0, NOW(), NOW()),
(1, CURDATE() + INTERVAL 2 DAY, '14:00:00', '15:00:00', 0, NOW(), NOW());

-- Beatrix (ID:2)
INSERT INTO `availability_slots` (`lawyer_id`, `available_date`, `start_time`, `end_time`, `is_booked`, `created_at`, `updated_at`) VALUES
(2, CURDATE() + INTERVAL 1 DAY, '10:00:00', '11:00:00', 0, NOW(), NOW()),
(2, CURDATE() + INTERVAL 2 DAY, '13:00:00', '14:00:00', 0, NOW(), NOW()),
(2, CURDATE() + INTERVAL 3 DAY, '09:30:00', '10:30:00', 0, NOW(), NOW());

-- Cillian (ID:3)
INSERT INTO `availability_slots` (`lawyer_id`, `available_date`, `start_time`, `end_time`, `is_booked`, `created_at`, `updated_at`) VALUES
(3, CURDATE() + INTERVAL 1 DAY, '15:00:00', '16:00:00', 0, NOW(), NOW()),
(3, CURDATE() + INTERVAL 1 DAY, '16:00:00', '17:00:00', 0, NOW(), NOW());

-- Evander (ID:5)
INSERT INTO `availability_slots` (`lawyer_id`, `available_date`, `start_time`, `end_time`, `is_booked`, `created_at`, `updated_at`) VALUES
(5, CURDATE() + INTERVAL 1 DAY, '08:00:00', '09:00:00', 0, NOW(), NOW()),
(5, CURDATE() + INTERVAL 5 DAY, '10:00:00', '11:00:00', 0, NOW(), NOW());

-- 5. Link Roles (Spatie model_has_roles)
-- Assuming roles ID are: 1 (admin), 2 (lawyer), 3 (customer)
INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(3, 'App\\Models\\User', 1), (3, 'App\\Models\\User', 2), (3, 'App\\Models\\User', 3), (3, 'App\\Models\\User', 4),
(2, 'App\\Models\\User', 5), (2, 'App\\Models\\User', 6), (2, 'App\\Models\\User', 7), (2, 'App\\Models\\User', 8),
(2, 'App\\Models\\User', 9), (2, 'App\\Models\\User', 10), (2, 'App\\Models\\User', 11), (2, 'App\\Models\\User', 12),
(2, 'App\\Models\\User', 13), (2, 'App\\Models\\User', 14);
```
