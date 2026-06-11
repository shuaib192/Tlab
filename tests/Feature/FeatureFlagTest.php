<?php

namespace Tests\Feature;

use App\Models\FeatureFlag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FeatureFlagTest extends TestCase
{
    use RefreshDatabase;

    public function test_feature_flag_enabled_for_all()
    {
        FeatureFlag::create(['key' => 'test_feature', 'name' => 'Test Feature', 'is_active' => true, 'staging_only' => false]);
        $this->assertTrue(FeatureFlag::isEnabled('test_feature'));
    }

    public function test_feature_flag_staging_only_blocks_in_production()
    {
        app()->detectEnvironment(fn () => 'production');
        FeatureFlag::create(['key' => 'beta_feature', 'name' => 'Beta Feature', 'is_active' => true, 'staging_only' => true]);
        $this->assertFalse(FeatureFlag::isEnabled('beta_feature'));
    }

    public function test_feature_flag_staging_only_allows_specific_user()
    {
        app()->detectEnvironment(fn () => 'production');
        $user = User::factory()->create(['role' => 'parent']);
        FeatureFlag::create([
            'key' => 'beta_feature',
            'name' => 'Beta Feature',
            'is_active' => true,
            'staging_only' => true,
            'enabled_for_users' => [$user->id],
        ]);
        $this->assertTrue(FeatureFlag::isEnabled('beta_feature', $user));
    }

    public function test_inactive_feature_flag_returns_false()
    {
        FeatureFlag::create(['key' => 'disabled_feature', 'name' => 'Disabled Feature', 'is_active' => false]);
        $this->assertFalse(FeatureFlag::isEnabled('disabled_feature'));
    }
}
