<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubCoursesTable extends Migration
{
    public function up(): void
    {
        Schema::create('sub_courses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('course_id');
            $table->string('nama_course', 255);
            $table->string('link_video', 255)->nullable();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('idUser');
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
            $table->foreign('idUser')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sub_courses');
    }
}
