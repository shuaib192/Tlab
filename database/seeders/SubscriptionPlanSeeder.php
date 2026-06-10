<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubscriptionPlanSeeder extends Seeder
{
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Explorer',
                'slug' => 'explorer',
                'description' => '1 club of your choice. Perfect for trying TLab.',
                'price' => 30000,
                'interval' => 'monthly',
                'max_children' => 1,
                'max_clubs' => 1,
                'features' => json_encode(['1 club', '4 Saturday sessions/month', 'Monthly progress report', 'Welcome kit', 'Student portal']),
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Builder',
                'slug' => 'builder',
                'description' => '2 clubs. Our most popular plan.',
                'price' => 54000,
                'interval' => 'monthly',
                'max_children' => 2,
                'max_clubs' => 2,
                'features' => json_encode(['2 clubs', 'Priority scheduling', 'Bi-monthly parent meeting', '30% off Holiday Camps', 'Student Spotlight']),
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'All-Access',
                'slug' => 'all-access',
                'description' => 'All 4 clubs. The complete TLab experience.',
                'price' => 100000,
                'interval' => 'monthly',
                'max_children' => 4,
                'max_clubs' => 4,
                'features' => json_encode(['All 4 clubs', 'Guaranteed seat every session', 'VIP event seating', '50% off Holiday Camps', '1-on-1 coaching per term']),
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Explorer Termly',
                'slug' => 'explorer-termly',
                'description' => '1 club paid termly. Save ~8%.',
                'price' => 82800,
                'interval' => 'termly',
                'max_children' => 1,
                'max_clubs' => 1,
                'features' => json_encode(['Same as Explorer', 'Termly billing', '8% savings']),
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Builder Termly',
                'slug' => 'builder-termly',
                'description' => '2 clubs paid termly.',
                'price' => 149000,
                'interval' => 'termly',
                'max_children' => 2,
                'max_clubs' => 2,
                'features' => json_encode(['Same as Builder', 'Termly billing', '~8% savings']),
                'is_active' => true,
                'sort_order' => 5,
            ],
            [
                'name' => 'Explorer Annual',
                'slug' => 'explorer-annual',
                'description' => '1 club paid annually. Save ~13%.',
                'price' => 316800,
                'interval' => 'annual',
                'max_children' => 1,
                'max_clubs' => 1,
                'features' => json_encode(['Same as Explorer', 'Annual billing', '13% savings']),
                'is_active' => true,
                'sort_order' => 6,
            ],
        ];

        foreach ($plans as $plan) {
            DB::table('subscription_plans')->updateOrInsert(
                ['slug' => $plan['slug']],
                $plan
            );
        }
    }
}
