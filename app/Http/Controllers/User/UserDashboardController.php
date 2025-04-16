<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Forum;

class UserDashboardController extends Controller
{
    public function index()
    {
        // Load semua course beserta user pembuatnya
        $courses = Course::with('user')->latest()->get();
        
        // Load semua forum + anggota + request agar bisa digunakan di Blade
        $forums = Forum::with(['members', 'requests'])->latest()->get();
    
        // Ambil forum pertama yang sudah user join (untuk bagian chat)
        $joinedForum = Forum::whereHas('members', function ($q) {
            $q->where('user_id', auth()->id());
        })->first();
    
        // Ambil pesan dari forum yang sudah user join, jika ada
        $messages = $joinedForum 
            ? $joinedForum->messages()->with('user')->latest()->take(20)->get()->reverse() 
            : collect();
    
        return view('user.dashboard', compact('courses', 'forums', 'joinedForum', 'messages'));
    }
}
