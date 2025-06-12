<?php

namespace Database\Factories;

use App\Models\ForumUserRequest; // Pastikan ini mengarah ke model Anda
use Illuminate\Database\Eloquent\Factories\Factory;

class ForumUserRequestFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ForumUserRequest::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => \App\Models\User::factory(), // Atau User::factory()->create()->id
            'forum_id' => \App\Models\Forum::factory(), // Atau Forum::factory()->create()->id
            'status' => $this->faker->randomElement(['pending', 'approved', 'rejected']),
            // Tambahkan field lain yang dibutuhkan model ForumUserRequest Anda
        ];
    }
}