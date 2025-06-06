<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseFactory extends Factory
{
    protected $model = Course::class;

    public function definition()
    {
        return [
            'nama_course' => $this->faker->unique()->sentence(3),
            'link_video' => $this->faker->optional()->url,
            'description' => $this->faker->paragraph,
            'idUser' => User::factory(), // otomatis bikin user baru juga
        ];
    }
}
