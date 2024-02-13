<?php

namespace Database\Factories;

use App\Enums\MemberTypeEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Member>
 */
class MemberFactory extends Factory
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
            'id_number' => fake()->randomNumber(5),
            'phone' => fake()->phoneNumber(),
            'company_id' => 1,
            'department_id' => 1,
            'camp_id' => 1,
            'room_id' => 1
        ];
    }
}
