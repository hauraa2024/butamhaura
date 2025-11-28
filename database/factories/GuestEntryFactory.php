<?php

namespace Database\Factories;

use App\Models\GuestEntry;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GuestEntry>
 */
class GuestEntryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'organization' => fake()->company(),
            'person_to_meet' => fake()->name(),
            'visit_date' => fake()->dateTimeBetween('-1 week', '+1 week'),
            'purpose' => fake()->sentence(8),
            'status' => GuestEntry::STATUS_PENDING,
            'notes' => null,
        ];
    }

    public function approved(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => GuestEntry::STATUS_APPROVED,
            'reviewed_at' => now(),
        ]);
    }

    public function rejected(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => GuestEntry::STATUS_REJECTED,
            'reviewed_at' => now(),
        ]);
    }
}
