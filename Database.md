# Legal Counsel — Database Setup

> Run these SQL commands in order inside **phpMyAdmin** or any MySQL client.
> All passwords are hashed as `password` using bcrypt.

---

## 1. Create Database

```sql
CREATE DATABASE IF NOT EXISTS legal_counsel CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE legal_counsel;
```

---

## 2. Schema — Core Tables

```sql
-- Users table
CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `user_type` varchar(20) NOT NULL DEFAULT 'customer',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Lawyers table
CREATE TABLE `lawyers` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `bar_license` varchar(255) NOT NULL,
  `specialization` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `address` text DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `experience_years` int(11) NOT NULL DEFAULT 0,
  `consultation_fee` decimal(10,2) NOT NULL DEFAULT 0.00,
  `status` varchar(20) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `lawyers_slug_unique` (`slug`),
  KEY `lawyers_user_id_foreign` (`user_id`),
  CONSTRAINT `lawyers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Availability Slots table
CREATE TABLE `availability_slots` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `lawyer_id` bigint(20) UNSIGNED NOT NULL,
  `available_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `is_booked` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `availability_slots_lawyer_id_foreign` (`lawyer_id`),
  CONSTRAINT `availability_slots_lawyer_id_foreign` FOREIGN KEY (`lawyer_id`) REFERENCES `lawyers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Appointments table
CREATE TABLE `appointments` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `lawyer_id` bigint(20) UNSIGNED NOT NULL,
  `slot_id` bigint(20) UNSIGNED DEFAULT NULL,
  `subject` varchar(255) NOT NULL,
  `meeting_place` varchar(255) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'pending',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `appointments_customer_id_foreign` (`customer_id`),
  KEY `appointments_lawyer_id_foreign` (`lawyer_id`),
  KEY `appointments_slot_id_foreign` (`slot_id`),
  CONSTRAINT `appointments_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `appointments_lawyer_id_foreign` FOREIGN KEY (`lawyer_id`) REFERENCES `lawyers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `appointments_slot_id_foreign` FOREIGN KEY (`slot_id`) REFERENCES `availability_slots` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Homepage Content table
CREATE TABLE `homepage_contents` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `section` varchar(255) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `body` text DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Laravel sessions table
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Password reset tokens
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Personal access tokens (Sanctum)
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

-- Migrations table
CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

---

## 3. Schema — Spatie Permission Tables

```sql
-- Permissions
CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Roles
CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Model Has Permissions
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Model Has Roles
CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Role Has Permissions
CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

---

## 4. Seed — Roles & Permissions

```sql
INSERT INTO `roles` (`name`, `guard_name`, `created_at`, `updated_at`) VALUES
('admin', 'web', NOW(), NOW()),
('lawyer', 'web', NOW(), NOW()),
('customer', 'web', NOW(), NOW());
```

---

## 5. Seed — Users (password = "password" for all)

```sql
-- Admin
INSERT INTO `users` (`id`, `name`, `email`, `password`, `phone`, `city`, `address`, `user_type`, `email_verified_at`, `created_at`, `updated_at`) VALUES
(1, 'Admin User', 'admin@legalcounsel.com', '$2y$12$sZchPXjBGjjBuQ0aalU7/.YGnM15SEzBnfmPXk7VRAiw7eZAkVdWW', '03001234567', 'Islamabad', 'Blue Area, Islamabad', 'admin', NOW(), NOW(), NOW());

-- Lawyers (user accounts)
INSERT INTO `users` (`id`, `name`, `email`, `password`, `phone`, `city`, `address`, `user_type`, `email_verified_at`, `created_at`, `updated_at`) VALUES
(2, 'Ali Raza Khan', 'ali.raza@legalcounsel.com', '$2y$12$sZchPXjBGjjBuQ0aalU7/.YGnM15SEzBnfmPXk7VRAiw7eZAkVdWW', '03211234567', 'Lahore', 'Gulberg III, Lahore', 'lawyer', NOW(), NOW(), NOW()),
(3, 'Fatima Noor Malik', 'fatima.noor@legalcounsel.com', '$2y$12$sZchPXjBGjjBuQ0aalU7/.YGnM15SEzBnfmPXk7VRAiw7eZAkVdWW', '03331234567', 'Karachi', 'Clifton Block 5, Karachi', 'lawyer', NOW(), NOW(), NOW()),
(4, 'Usman Tariq Shah', 'usman.tariq@legalcounsel.com', '$2y$12$sZchPXjBGjjBuQ0aalU7/.YGnM15SEzBnfmPXk7VRAiw7eZAkVdWW', '03451234567', 'Islamabad', 'F-8 Markaz, Islamabad', 'lawyer', NOW(), NOW(), NOW()),
(5, 'Ayesha Siddiqui', 'ayesha.s@legalcounsel.com', '$2y$12$sZchPXjBGjjBuQ0aalU7/.YGnM15SEzBnfmPXk7VRAiw7eZAkVdWW', '03121234567', 'Rawalpindi', 'Commercial Market, Rawalpindi', 'lawyer', NOW(), NOW(), NOW()),
(6, 'Hassan Javed Qureshi', 'hassan.j@legalcounsel.com', '$2y$12$sZchPXjBGjjBuQ0aalU7/.YGnM15SEzBnfmPXk7VRAiw7eZAkVdWW', '03001234599', 'Faisalabad', 'D Ground, Faisalabad', 'lawyer', NOW(), NOW(), NOW()),
(7, 'Zara Ahmed Butt', 'zara.ahmed@legalcounsel.com', '$2y$12$sZchPXjBGjjBuQ0aalU7/.YGnM15SEzBnfmPXk7VRAiw7eZAkVdWW', '03561234567', 'Multan', 'Gulgasht Colony, Multan', 'lawyer', NOW(), NOW(), NOW());

-- Customers
INSERT INTO `users` (`id`, `name`, `email`, `password`, `phone`, `city`, `address`, `user_type`, `email_verified_at`, `created_at`, `updated_at`) VALUES
(8, 'Ahmed Bilal', 'ahmed.bilal@gmail.com', '$2y$12$sZchPXjBGjjBuQ0aalU7/.YGnM15SEzBnfmPXk7VRAiw7eZAkVdWW', '03009876543', 'Lahore', 'Johar Town, Lahore', 'customer', NOW(), NOW(), NOW()),
(9, 'Sara Iqbal', 'sara.iqbal@gmail.com', '$2y$12$sZchPXjBGjjBuQ0aalU7/.YGnM15SEzBnfmPXk7VRAiw7eZAkVdWW', '03339876543', 'Karachi', 'DHA Phase 6, Karachi', 'customer', NOW(), NOW(), NOW()),
(10, 'Kamran Yousaf', 'kamran.y@gmail.com', '$2y$12$sZchPXjBGjjBuQ0aalU7/.YGnM15SEzBnfmPXk7VRAiw7eZAkVdWW', '03459876543', 'Islamabad', 'G-11 Markaz, Islamabad', 'customer', NOW(), NOW(), NOW()),
(11, 'Mehreen Akram', 'mehreen.a@gmail.com', '$2y$12$sZchPXjBGjjBuQ0aalU7/.YGnM15SEzBnfmPXk7VRAiw7eZAkVdWW', '03129876543', 'Rawalpindi', 'Bahria Town, Rawalpindi', 'customer', NOW(), NOW(), NOW()),
(12, 'Imran Saleem', 'imran.s@gmail.com', '$2y$12$sZchPXjBGjjBuQ0aalU7/.YGnM15SEzBnfmPXk7VRAiw7eZAkVdWW', '03219876543', 'Lahore', 'DHA Phase 5, Lahore', 'customer', NOW(), NOW(), NOW());
```

---

## 6. Seed — Role Assignments

```sql
-- Admin role
INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1);

-- Lawyer roles
INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(2, 'App\\Models\\User', 2),
(2, 'App\\Models\\User', 3),
(2, 'App\\Models\\User', 4),
(2, 'App\\Models\\User', 5),
(2, 'App\\Models\\User', 6),
(2, 'App\\Models\\User', 7);

-- Customer roles
INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(3, 'App\\Models\\User', 8),
(3, 'App\\Models\\User', 9),
(3, 'App\\Models\\User', 10),
(3, 'App\\Models\\User', 11),
(3, 'App\\Models\\User', 12);
```

---

## 7. Seed — Lawyer Profiles

```sql
INSERT INTO `lawyers` (`id`, `user_id`, `full_name`, `slug`, `bar_license`, `specialization`, `city`, `address`, `phone`, `bio`, `photo`, `experience_years`, `consultation_fee`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, 'Ali Raza Khan', 'ali-raza-khan-criminal-lawyer-lahore', 'BAR-LHR-20145', 'Criminal', 'Lahore', 'Gulberg III, Main Boulevard, Lahore', '03211234567', 'Senior criminal defense attorney with over 12 years of courtroom experience. Specializing in white-collar crime, bail applications, and high-profile defense cases across Punjab.', NULL, 12, 5000.00, 'approved', NOW(), NOW()),
(2, 3, 'Fatima Noor Malik', 'fatima-noor-malik-divorce-lawyer-karachi', 'BAR-KHI-20187', 'Divorce', 'Karachi', 'Clifton Block 5, Karachi', '03331234567', 'Compassionate family law specialist helping clients navigate divorce, custody, and alimony matters with dignity. Recognized for her empathetic yet assertive approach in family courts.', NULL, 8, 4000.00, 'approved', NOW(), NOW()),
(3, 4, 'Usman Tariq Shah', 'usman-tariq-shah-civil-lawyer-islamabad', 'BAR-ISB-20129', 'Civil', 'Islamabad', 'F-8 Markaz, Islamabad', '03451234567', 'Seasoned civil litigation expert handling property disputes, contract enforcement, and constitutional petitions. Former associate at a top-tier Islamabad law firm with Supreme Court practice.', NULL, 15, 7500.00, 'approved', NOW(), NOW()),
(4, 5, 'Ayesha Siddiqui', 'ayesha-siddiqui-affidavit-lawyer-rawalpindi', 'BAR-RWP-20193', 'Affidavit', 'Rawalpindi', 'Commercial Market, Satellite Town, Rawalpindi', '03121234567', 'Trusted notary and affidavit specialist with meticulous attention to documentation. Handles oath commissioner services, affidavits for immigration, and legal declarations across the twin cities.', NULL, 5, 2000.00, 'approved', NOW(), NOW()),
(5, 6, 'Hassan Javed Qureshi', 'hassan-javed-qureshi-criminal-lawyer-faisalabad', 'BAR-FSD-20168', 'Criminal', 'Faisalabad', 'D Ground, Peoples Colony, Faisalabad', '03001234599', 'Dedicated criminal lawyer representing clients in drug-related offenses, murder trials, and cyber-crime cases. Known for thorough investigation and powerful courtroom advocacy.', NULL, 10, 3500.00, 'approved', NOW(), NOW()),
(6, 7, 'Zara Ahmed Butt', 'zara-ahmed-butt-divorce-lawyer-multan', 'BAR-MLT-20201', 'Divorce', 'Multan', 'Gulgasht Colony, Multan', '03561234567', 'Young and dynamic family law practitioner focusing on women rights, khula proceedings, and child custody. Passionate about accessible legal aid for underserved communities in South Punjab.', NULL, 4, 2500.00, 'approved', NOW(), NOW());
```

---

## 8. Seed — Availability Slots

```sql
INSERT INTO `availability_slots` (`id`, `lawyer_id`, `available_date`, `start_time`, `end_time`, `is_booked`, `created_at`, `updated_at`) VALUES
-- Ali Raza Khan (Lawyer 1)
(1, 1, '2026-05-10', '09:00:00', '10:00:00', 1, NOW(), NOW()),
(2, 1, '2026-05-10', '10:00:00', '11:00:00', 0, NOW(), NOW()),
(3, 1, '2026-05-10', '14:00:00', '15:00:00', 0, NOW(), NOW()),
(4, 1, '2026-05-12', '09:00:00', '10:00:00', 1, NOW(), NOW()),
(5, 1, '2026-05-12', '11:00:00', '12:00:00', 0, NOW(), NOW()),
-- Fatima Noor Malik (Lawyer 2)
(6, 2, '2026-05-10', '10:00:00', '11:00:00', 1, NOW(), NOW()),
(7, 2, '2026-05-10', '15:00:00', '16:00:00', 0, NOW(), NOW()),
(8, 2, '2026-05-11', '09:00:00', '10:00:00', 0, NOW(), NOW()),
(9, 2, '2026-05-13', '14:00:00', '15:00:00', 1, NOW(), NOW()),
-- Usman Tariq Shah (Lawyer 3)
(10, 3, '2026-05-10', '11:00:00', '12:00:00', 1, NOW(), NOW()),
(11, 3, '2026-05-11', '09:00:00', '10:00:00', 0, NOW(), NOW()),
(12, 3, '2026-05-11', '14:00:00', '15:00:00', 0, NOW(), NOW()),
(13, 3, '2026-05-14', '10:00:00', '11:00:00', 0, NOW(), NOW()),
-- Ayesha Siddiqui (Lawyer 4)
(14, 4, '2026-05-10', '09:00:00', '10:00:00', 1, NOW(), NOW()),
(15, 4, '2026-05-10', '11:00:00', '12:00:00', 0, NOW(), NOW()),
(16, 4, '2026-05-12', '15:00:00', '16:00:00', 0, NOW(), NOW()),
-- Hassan Javed (Lawyer 5)
(17, 5, '2026-05-10', '09:00:00', '10:00:00', 0, NOW(), NOW()),
(18, 5, '2026-05-11', '10:00:00', '11:00:00', 1, NOW(), NOW()),
(19, 5, '2026-05-13', '14:00:00', '15:00:00', 0, NOW(), NOW()),
-- Zara Ahmed (Lawyer 6)
(20, 6, '2026-05-10', '10:00:00', '11:00:00', 0, NOW(), NOW()),
(21, 6, '2026-05-12', '09:00:00', '10:00:00', 1, NOW(), NOW()),
(22, 6, '2026-05-14', '11:00:00', '12:00:00', 0, NOW(), NOW());
```

---

## 9. Seed — Appointments

```sql
INSERT INTO `appointments` (`id`, `customer_id`, `lawyer_id`, `slot_id`, `subject`, `meeting_place`, `status`, `notes`, `created_at`, `updated_at`) VALUES
(1, 8, 1, 1, 'Bail Application for Theft Case', 'Gulberg III Office, Lahore', 'confirmed', 'Client needs urgent bail. Bring CNIC copies and FIR.', NOW(), NOW()),
(2, 9, 2, 6, 'Khula Proceedings Consultation', 'Clifton Office, Karachi', 'confirmed', 'Initial consultation for khula. Client to bring nikah nama.', NOW(), NOW()),
(3, 10, 3, 10, 'Property Dispute — Land Title', 'F-8 Markaz Office, Islamabad', 'confirmed', 'Dispute over inherited agricultural land in Taxila.', NOW(), NOW()),
(4, 11, 4, 14, 'Immigration Affidavit', 'Satellite Town Office, Rawalpindi', 'completed', 'Affidavit for Canadian visa application. Completed successfully.', NOW(), NOW()),
(5, 12, 5, 18, 'Cyber Crime Defense', 'D Ground Office, Faisalabad', 'confirmed', 'Client accused under PECA. Need to review evidence.', NOW(), NOW()),
(6, 8, 3, 4, 'Contract Review for Business', 'F-8 Markaz Office, Islamabad', 'pending', 'Partnership agreement needs legal review before signing.', NOW(), NOW()),
(7, 9, 6, 21, 'Child Custody Consultation', 'Gulgasht Colony Office, Multan', 'confirmed', 'Mother seeking custody of 2 children after separation.', NOW(), NOW()),
(8, 10, 1, 4, 'White Collar Crime Defense', 'Gulberg III Office, Lahore', 'pending', 'NAB inquiry related. Needs senior counsel advice.', NOW(), NOW()),
(9, 11, 2, 9, 'Divorce Settlement Negotiation', 'Clifton Office, Karachi', 'confirmed', 'Both parties agreed to mediation. Settlement terms to discuss.', NOW(), NOW()),
(10, 12, 4, NULL, 'General Legal Affidavit', 'Satellite Town Office, Rawalpindi', 'cancelled', 'Client cancelled due to personal reasons.', NOW(), NOW());
```

---

## 10. Seed — Homepage Content

```sql
INSERT INTO `homepage_contents` (`section`, `title`, `body`, `image_path`, `created_at`, `updated_at`) VALUES
('hero', 'Excellence|Redefined.', 'Connecting you with trusted legal professionals through a seamless, secure, and private digital experience. Your first consultation is just a click away.', NULL, NOW(), NOW()),
('featured_lawyers', 'Selected|Practice Areas', 'A curated network of specialists across every major legal discipline, ready to serve you with dedication and expertise.', NULL, NOW(), NOW()),
('call_to_action', 'Distinguished Counsel', 'Our Inner Circle', NULL, NOW(), NOW()),
('footer_about', 'Secure your|legacy today.', 'Private consultations starting from PKR 2,000 with distinguished professionals across Pakistan.', NULL, NOW(), NOW());
```

---

## Login Credentials

| Role | Email | Password |
|------|-------|----------|
| **Admin** | `admin@legalcounsel.com` | `password` |
| **Lawyer** | `ali.raza@legalcounsel.com` | `password` |
| **Lawyer** | `fatima.noor@legalcounsel.com` | `password` |
| **Lawyer** | `usman.tariq@legalcounsel.com` | `password` |
| **Customer** | `ahmed.bilal@gmail.com` | `password` |
| **Customer** | `sara.iqbal@gmail.com` | `password` |
| **Customer** | `kamran.y@gmail.com` | `password` |
