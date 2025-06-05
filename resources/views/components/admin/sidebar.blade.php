<div class="w-64 bg-white shadow-lg h-screen fixed">
    <div class="p-4 border-b">
        <h2 class="text-xl font-bold text-gray-800">Admin Panel</h2>
    </div>
    
    <nav class="mt-4">
        <div class="px-4 py-2 text-sm font-medium text-gray-500 uppercase tracking-wider">
            Menu Utama
        </div>
        
        <a href="{{ route('admin.dashboard') }}" 
           class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 transition {{ request()->routeIs('admin.dashboard') ? 'bg-gray-100 border-r-4 border-indigo-500' : '' }}">
            <span class="mr-3">📊</span>
            Dashboard
        </a>
        
        <a href="{{ route('admin.courses.index') }}" 
           class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 transition {{ request()->routeIs('admin.courses.*') ? 'bg-gray-100 border-r-4 border-indigo-500' : '' }}">
            <span class="mr-3">📚</span>
            Kelola Course
        </a>
        
        <a href="{{ route('admin.sub-courses.index') }}" 
           class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 transition {{ request()->routeIs('admin.sub-courses.*') ? 'bg-gray-100 border-r-4 border-indigo-500' : '' }}">
            <span class="mr-3">🧩</span>
            Kelola SubCourse
        </a>
        
        <div class="px-4 py-2 mt-4 text-sm font-medium text-gray-500 uppercase tracking-wider">
            Forum Management
        </div>
        
        <a href="{{ route('admin.forums.index') }}" 
           class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 transition {{ request()->routeIs('admin.forums.index') ? 'bg-gray-100 border-r-4 border-indigo-500' : '' }}">
            <span class="mr-3">💬</span>
            Kelola Forum
        </a>
        <a href="{{ route('admin.forums.requests') }}" 
           class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 transition {{ request()->routeIs('admin.forum.requests') ? 'bg-gray-100 border-r-4 border-indigo-500' : '' }}">
            <span class="mr-3">📥</span>
            Permintaan Join
            @if(isset($jumlahRequestPending) && $jumlahRequestPending > 0)
                <span class="ml-auto bg-red-500 text-white text-xs px-2 py-1 rounded-full">
                    {{ $jumlahRequestPending }}
                </span>
            @endif
        </a>
    </nav>
</div>

