<?php

namespace Database\Factories;

use App\Models\SubCourse;
use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubCourseFactory extends Factory
{
    protected $model = SubCourse::class;

    public function definition()
    {
        return [
            'nama_course' => $this->faker->unique()->words(2, true),
            'link_video' => $this->faker->optional()->url(),
            'description' => $this->faker->sentence(),
            'course_id' => Course::factory(),   // auto buat Course
            'idUser' => User::factory(),        // auto buat User
        ];
    }
}
