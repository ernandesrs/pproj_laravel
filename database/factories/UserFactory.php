<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $g = ['male', 'female'][rand(0, 1)];
        $first = $this->faker->firstName($g);
        $last = $this->faker->lastName();
        $gender = ['male' => 'm', 'female' => 'f'][$g];
        return [
            'first_name' => $first,
            'last_name' => $last,
            'name' => $first . " " . $last,
            'level' => User::LEVEL_1,
            'username' => $first . "_" . uniqid(),
            'gender' => $gender,
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => [now(), null][rand(0, 1)],
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
