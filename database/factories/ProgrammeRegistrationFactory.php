<?php

namespace Database\Factories;

use App\Models\ProgrammeRegistration;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProgrammeRegistrationFactory extends Factory
{
    protected $model = ProgrammeRegistration::class;

    public function definition(): array
    {
        return [
            'parent_name' => $this->faker->name,
            'phone' => $this->faker->phoneNumber,
            'email' => $this->faker->safeEmail,
            'child_name' => $this->faker->name,
            'child_age' => $this->faker->numberBetween(5, 17),
            'programme' => 'Scratch Programming',
            'device' => $this->faker->randomElement(['laptop', 'tablet', 'smartphone']),
            'payment_option' => $this->faker->randomElement(['monthly', 'full']),
            'amount' => 10000,
            'status' => 'pending',
            'reference' => 'TLAB-PRG-'.strtoupper($this->faker->unique()->bothify('????#????')),
        ];
    }
}
