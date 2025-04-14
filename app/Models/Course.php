<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_course',
        'link_video',
        'description',
        'idUser'
    ];
    

    public function subCourses()
    {
        return $this->hasMany(SubCourse::class, 'course_id');
    }

    public function user()
{
    return $this->belongsTo(User::class, 'idUser');
}
public function likedByUsers() {
    return $this->belongsToMany(User::class, 'likes');
}

}
