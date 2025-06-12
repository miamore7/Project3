<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumUserRequest extends Model
{
    use HasFactory;

    // Tambahkan 'status' ke dalam array $fillable
    protected $fillable = [
        'user_id',
        'forum_id',
        'status', // <<< Pastikan ini ada di sini!
        // tambahkan kolom lain yang Anda izinkan untuk diisi secara massal
    ];

    // Atau, jika Anda menggunakan $guarded, pastikan 'status' tidak ada di dalamnya
    // protected $guarded = []; // Mengizinkan semua kolom diisi secara massal

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function forum()
    {
        return $this->belongsTo(Forum::class);
    }

    public function users()
{
    return $this->belongsToMany(User::class, 'forum_user', 'forum_id', 'user_id');
}
public function members()
{
    return $this->belongsToMany(User::class, 'forum_user', 'forum_id', 'user_id');
}

}