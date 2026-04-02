<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HomepageContent;

class HomepageContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sections = [
            [
                'section' => 'hero',
                'title' => 'Connect with Elite Legal Minds',
                'body' => 'Access a curated network of top-tier attorneys ready to serve your needs with discretion and excellence.',
                'order' => 1
            ],
            [
                'section' => 'featured_lawyers',
                'title' => 'Featured Legal Experts',
                'body' => 'Browse our selection of highly qualified lawyers specializing in various practice areas.',
                'order' => 2
            ],
            [
                'section' => 'call_to_action',
                'title' => 'Ready to Get Started?',
                'body' => 'Join thousands of clients who have found the perfect legal representation through our platform.',
                'order' => 3
            ],
            [
                'section' => 'footer_about',
                'title' => 'About Law-Conect',
                'body' => 'We bridge the gap between clients and exceptional legal professionals, ensuring quality legal services are accessible to all.',
                'order' => 4
            ]
        ];

        foreach ($sections as $sectionData) {
            HomepageContent::updateOrCreate(
                ['section' => $sectionData['section']],
                [
                    'title' => $sectionData['title'],
                    'body' => $sectionData['body'],
                    'order' => $sectionData['order'],
                    'is_active' => true
                ]
            );
        }
    }
}