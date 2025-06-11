<?php

namespace Database\Factories;

use App\Models\ForumUserRequest; // Make sure to import your model
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
            'forum_id' => \App\Models\Forum::factory(), // Assuming you have a Forum model and factory
            'user_id' => \App\Models\User::factory(),   // Assuming you have a User model and factory
            'status' => $this->faker->randomElement(['pending', 'approved', 'rejected']),
            // Add other attributes required for your ForumUserRequest model
        ];
    }
}