<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class CourseFactory extends Factory
{
    public function definition()
    {
        return [
            'nama_course' => $this->faker->sentence(3),
            'link_video' => $this->faker->url(),
            'description' => $this->faker->paragraph(),
            'idUser' => User::factory(),
        ];
    }
}