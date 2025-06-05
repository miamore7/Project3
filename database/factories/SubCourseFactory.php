<?php

namespace Database\Factories;

use App\Models\SubCourse;
use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubCourseFactory extends Factory
{
    protected $model = SubCourse::class;

    public function definition()
    {
        return [
            'nama_course' => $this->faker->unique()->sentence(3),
            'link_video' => $this->faker->url,
            'description' => $this->faker->paragraph,
            'course_id' => Course::factory(), // otomatis bikin course baru
            'idUser' => 1, // sesuaikan jika perlu atau buat user factory juga
        ];
    }
}
