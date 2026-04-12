<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

DB::statement("INSERT IGNORE INTO `users` (`id`, `name`, `email`, `password`, `user_type`, `phone`, `city`, `created_at`, `updated_at`) VALUES
(1, 'Admin Console', 'admin@legalcounsel.com', '\$2y\$10\$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', '555-0000', 'New York', NOW(), NOW()),
(2, 'Eleanor Vance', 'vance@legalcounsel.com', '\$2y\$10\$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'lawyer', '555-1111', 'Los Angeles', NOW(), NOW()),
(3, 'James Sterling', 'sterling@legalcounsel.com', '\$2y\$10\$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'lawyer', '555-2222', 'Chicago', NOW(), NOW()),
(4, 'Olivia Chen', 'chen@legalcounsel.com', '\$2y\$10\$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'lawyer', '555-3333', 'New York', NOW(), NOW()),
(5, 'Marcus Wayne', 'marcus@example.com', '\$2y\$10\$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'customer', '555-4444', 'New York', NOW(), NOW());");

DB::statement("INSERT IGNORE INTO `lawyers` (`id`, `user_id`, `full_name`, `bar_license`, `specialization`, `city`, `address`, `phone`, `bio`, `experience_years`, `consultation_fee`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, 'Eleanor Vance', 'TX-72314-BL', 'Divorce', 'Los Angeles', '100 Wilshire Blvd, Suite 400', '555-1111', 'Senior partner specializing in high-net-worth divorce and asset protection.', 18, 550.00, 'approved', NOW(), NOW()),
(2, 3, 'James Sterling', 'IL-88452-BL', 'Criminal', 'Chicago', '45 W Monroe St, Floor 22', '555-2222', 'Relentless criminal defense litigator with an unmatched portfolio.', 14, 400.00, 'approved', NOW(), NOW()),
(3, 4, 'Olivia Chen', 'NY-99012-BL', 'Civil', 'New York', '1 World Trade Center, Suite 85', '555-3333', 'Highly sought-after civil litigation expert focusing on corporate disputes.', 10, 480.00, 'approved', NOW(), NOW());");

DB::statement("INSERT IGNORE INTO `availability_slots` (`id`, `lawyer_id`, `available_date`, `start_time`, `end_time`, `is_booked`, `created_at`, `updated_at`) VALUES
(1, 1, DATE_ADD(CURDATE(), INTERVAL 1 DAY), '09:00:00', '10:00:00', 0, NOW(), NOW()),
(2, 1, DATE_ADD(CURDATE(), INTERVAL 1 DAY), '10:30:00', '11:30:00', 0, NOW(), NOW()),
(3, 1, DATE_ADD(CURDATE(), INTERVAL 1 DAY), '14:00:00', '15:00:00', 0, NOW(), NOW()),
(4, 2, DATE_ADD(CURDATE(), INTERVAL 1 DAY), '10:00:00', '11:00:00', 0, NOW(), NOW()),
(5, 2, DATE_ADD(CURDATE(), INTERVAL 2 DAY), '15:00:00', '16:00:00', 0, NOW(), NOW()),
(6, 3, DATE_ADD(CURDATE(), INTERVAL 2 DAY), '08:30:00', '09:30:00', 0, NOW(), NOW()),
(7, 3, DATE_ADD(CURDATE(), INTERVAL 3 DAY), '11:00:00', '12:00:00', 0, NOW(), NOW());");

DB::statement("INSERT IGNORE INTO `appointments` (`id`, `customer_id`, `lawyer_id`, `slot_id`, `subject`, `meeting_place`, `status`, `created_at`, `updated_at`) VALUES
(1, 5, 1, 1, 'Prenuptial Agreement', 'Video Conference', 'pending', NOW(), NOW()),
(2, 5, 2, 4, 'Civil Traffic', 'Office', 'confirmed', NOW(), NOW());");

DB::statement("UPDATE `availability_slots` SET `is_booked` = 1 WHERE `id` IN (1, 4);");

echo "Seeded successfully.\n";
