<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ForumUserRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Course;
use App\Models\SubCourse;
use App\Models\Forum;
use App\Models\ForumRequest;

class DashboardController extends Controller
{
    public function index()
    {
        // User statistics
        $jumlahUserAktif = User::where('status', 'aktif')->count();
        $jumlahUserBaru = User::where('created_at', '>=', now()->subDays(7))->count();
        $userGrowthPercentage = $this->calculateGrowthPercentage(
            User::where('created_at', '>=', now()->subDays(14))
                ->where('created_at', '<', now()->subDays(7))
                ->count(),
            $jumlahUserBaru
        );

        // Course statistics
        $jumlahCourse = Course::count();
        $jumlahCourseBaru = Course::where('created_at', '>=', now()->subDays(7))->count();
        $courseGrowthPercentage = $this->calculateGrowthPercentage(
            Course::where('created_at', '>=', now()->subDays(14))
                ->where('created_at', '<', now()->subDays(7))
                ->count(),
            $jumlahCourseBaru
        );

        // Sub-course statistics
        $jumlahSubCourse = SubCourse::count();
        $subCourseGrowthPercentage = $this->calculateGrowthPercentage(
            SubCourse::where('created_at', '>=', now()->subDays(14))
                ->where('created_at', '<', now()->subDays(7))
                ->count(),
            SubCourse::where('created_at', '>=', now()->subDays(7))->count()
        );

        // Forum statistics
        $jumlahForum = Forum::count();
        $jumlahRequestPending = ForumUserRequest::where('status', 'pending')->count();
        $jumlahRequestDiterima = ForumUserRequest::where('status', 'approved')->count();

        // Latest activities
        $latestCourses = Course::with('user')->latest()->take(5)->get();
        $latestSubCourses = SubCourse::with('user', 'course')->latest()->take(5)->get();
        $latestForumRequests = ForumUserRequest::with('user', 'forum')
            ->where('status', 'pending')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', [
            'jumlahUserAktif' => $jumlahUserAktif,
            'jumlahUserBaru' => $jumlahUserBaru,
            'userGrowthPercentage' => $userGrowthPercentage,
            'jumlahCourse' => $jumlahCourse,
            'jumlahCourseBaru' => $jumlahCourseBaru,
            'courseGrowthPercentage' => $courseGrowthPercentage,
            'jumlahSubCourse' => $jumlahSubCourse,
            'subCourseGrowthPercentage' => $subCourseGrowthPercentage,
            'jumlahForum' => $jumlahForum,
            'jumlahRequestPending' => $jumlahRequestPending,
            'jumlahRequestDiterima' => $jumlahRequestDiterima,
            'latestCourses' => $latestCourses,
            'latestSubCourses' => $latestSubCourses,
            'latestForumRequests' => $latestForumRequests,
            'showChart' => !config('app.offline_mode', false)
        ]);
    }

    /**
     * Calculate growth percentage between two periods
     */
    private function calculateGrowthPercentage($previousCount, $currentCount)
    {
        if ($previousCount == 0) {
            return $currentCount > 0 ? 100 : 0;
        }

        return round((($currentCount - $previousCount) / $previousCount) * 100, 2);
    }

    /**
     * Get weekly registration statistics for chart
     */
    public function getRegistrationStats()
    {
        $data = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $data['labels'][] = now()->subDays($i)->format('D');
            $data['users'][] = User::whereDate('created_at', $date)->count();
            $data['courses'][] = Course::whereDate('created_at', $date)->count();
        }

        return response()->json($data);
    }
}