<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' =>$name= fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'is_active' => fake()->boolean(60),
            'email_verified_at' => now(),
            "phone_number" => fake()->e164PhoneNumber(),
            // 'avatar' => fake()->image('public/storage/users/avatars/', 500, 500, $name, false),
            // "birth_date" => fake()->date($format='d-m-Y'),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'phone_number' => fake()->unique()->e164PhoneNumber(),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
