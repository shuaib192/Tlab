<?php
namespace Database\Factories;
use App\Models\ChildProfile;
use Illuminate\Database\Eloquent\Factories\Factory;
class ChildProfileFactory extends Factory
{
    protected $model = ChildProfile::class;
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'username' => fake()->unique()->userName(),
            'xp' => fake()->numberBetween(0, 1000),
            'rank' => fake()->randomElement(['Explorer', 'Innovator', 'Builder']),
            'user_id' => \App\Models\User::factory(),
        ];
    }
}
