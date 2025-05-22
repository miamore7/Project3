<?php

// database/factories/CourseFactory.php

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
            'nama_course' => $this->faker->unique()->words(3, true),
            'description' => $this->faker->sentence(),
            'idUser' => User::factory(), // ⬅️ Tambahkan ini
        ];
    }
}
