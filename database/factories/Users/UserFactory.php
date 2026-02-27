<?php

namespace Database\Factories\Users;

use App\Enums\UserRoles;
use App\Enums\UserStatus;
use App\Users\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Users\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = User::class;

    /**
     * Cache da senha para otimizar a velocidade de criação em massa.
     */
    protected static ?string $password;
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => static::$password ??= Hash::make('password'),
            'role' => fake()->randomElement([
                UserRoles::USER->value,
                UserRoles::ADMIN->value
            ]),
            'status' => fake()->randomElement([
                UserStatus::ACTIVE->value,
                UserStatus::INACTIVE->value
            ]),
          'email_verified_at' => now(),
        ];
    }
}
