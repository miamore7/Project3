<?php

namespace Database\Factories;

use App\Models\Forum;
use App\Models\User; // Assuming User model exists and is linked
use Illuminate\Database\Eloquent\Factories\Factory;

class ForumFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Forum::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->sentence(3),
            'description' => $this->faker->paragraph(),
            'created_by' => User::factory(), // Automatically creates a user and assigns its ID
        ];
    }
}

