<!-- resources/views/layouts/partials/admin_sidebar.blade.php -->
<nav class="mt-4 flex-grow ">
    <div class="px-4 py-2 text-sm font-medium text-gray-500 uppercase tracking-wider">
        Menu Utama
    </div>

    <a href="{{ route('admin.dashboard') }}" 
       class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 transition {{ request()->routeIs('admin.dashboard') ? 'bg-gray-100 border-r-4 border-indigo-500' : '' }} no-underline">
        <span class="mr-3">📊</span>
        Dashboard
    </a>

    <a href="{{ route('admin.courses.index') }}" 
       class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 transition {{ request()->routeIs('admin.courses.*') ? 'bg-gray-100 border-r-4 border-indigo-500' : '' }} no-underline">
        <span class="mr-3">📚</span>
        Kelola Course
    </a>

     {{-- kelola reset password --}}
    <a href="{{ route('admin.users.index') }}" 
       class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 transition {{ request()->routeIs('admin.users.*') ? 'bg-gray-100 border-r-4 border-indigo-500' : '' }} no-underline">
        <span class="mr-3">👥</span>
        Kelola Pengguna
    </a>

    <a href="{{ route('admin.sub-courses.index') }}" 
       class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 transition {{ request()->routeIs('admin.sub-courses.*') ? 'bg-gray-100 border-r-4 border-indigo-500' : '' }} no-underline">
        <span class="mr-3">🧩</span>
        Kelola SubCourse
    </a>


    <a href="{{ route('admin.forums.index') }}" 
       class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 transition {{ request()->routeIs('admin.forums.index') ? 'bg-gray-100 border-r-4 border-indigo-500' : '' }} no-underline">
        <span class="mr-3">💬</span>
        Kelola Forum
    </a>

    <a href="{{ route('admin.forum.requests') }}" 
       class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 transition {{ request()->routeIs('admin.forum.requests') ? 'bg-gray-100 border-r-4 border-indigo-500' : '' }} no-underline">
        <span class="mr-3">📥</span>
        Permintaan Join
        @if(isset($jumlahRequestPending) && $jumlahRequestPending > 0)
            <span class="ml-auto bg-red-500 text-white text-xs px-2 py-1 rounded-full">
                {{ $jumlahRequestPending }}
            </span>
        @endif
    </a>
</nav>
