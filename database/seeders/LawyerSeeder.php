<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Lawyer;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LawyerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create sample users that will become lawyers
        $lawyerUsers = [
            [
                'name' => 'Sarah Mitchell',
                'email' => 'sarah@example.com',
                'password' => 'password',
                'phone' => '+1-555-1001',
                'city' => 'New York',
                'address' => '350 Fifth Avenue, Empire State Building',
                'user_type' => 'lawyer'
            ],
            [
                'name' => 'James Harrison',
                'email' => 'james@example.com',
                'password' => 'password',
                'phone' => '+1-555-1002',
                'city' => 'Los Angeles',
                'address' => '633 West 5th Street',
                'user_type' => 'lawyer'
            ],
            [
                'name' => 'Elena Rodriguez',
                'email' => 'elena@example.com',
                'password' => 'password',
                'phone' => '+1-555-1003',
                'city' => 'Chicago',
                'address' => '233 S. Wacker Drive',
                'user_type' => 'lawyer'
            ]
        ];

        foreach ($lawyerUsers as $userData) {
            $user = User::firstOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'password' => Hash::make($userData['password']),
                    'phone' => $userData['phone'],
                    'city' => $userData['city'],
                    'address' => $userData['address'],
                    'user_type' => $userData['user_type']
                ]
            );

            $user->assignRole('lawyer');

            // Create lawyer profile
            $lawyer = Lawyer::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'full_name' => $user->name,
                    'specialization' => $this->getRandomSpecialization(),
                    'bar_license' => 'BAR-' . rand(10000, 99999),
                    'experience_years' => rand(5, 25),
                    'consultation_fee' => rand(150, 500),
                    'status' => 'approved',
                    'bio' => $this->generateBio($user->name, $this->getRandomSpecialization())
                ]
            );
        }
    }

    private function getRandomSpecialization(): string
    {
        $specializations = ['Criminal', 'Divorce', 'Affidavit', 'Civil', 'Corporate', 'Family', 'Immigration'];
        return $specializations[array_rand($specializations)];
    }

    private function generateBio(string $name, string $specialization): string
    {
        return "{$name} is a highly experienced {$specialization} law practitioner with a proven track record of successful cases. Dedicated to providing exceptional legal services with integrity and professionalism.";
    }
}