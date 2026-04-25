<!-- Teacher Sidebar -->
<div class="fixed inset-y-0 left-0 w-64 bg-white shadow-lg z-40 transform transition-transform duration-300 lg:translate-x-0 -translate-x-full">
    <div class="flex flex-col h-full">
        <!-- Logo -->
        <div class="p-6 border-b">
            <h1 class="text-2xl font-bold text-gray-800">CASP Portal</h1>
        </div>

        <!-- Navigation Menu - Simple flat list -->
        <nav class="flex-1 py-6">
            <div class="px-4 space-y-2">
                <!-- Dashboard -->
                <a href="{{ route('teacher.dashboard') }}" 
                   class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-gray-100 {{ request()->routeIs('teacher.dashboard') ? 'bg-blue-50 text-blue-600' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Dashboard
                </a>

                <!-- My Assignments -->
                <a href="{{ route('assignments.index') }}" 
                   class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-gray-100 {{ request()->routeIs('assignments.index') ? 'bg-blue-50 text-blue-600' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    My Assignments
                </a>

                <!-- New Assignment Button -->
                <a href="{{ route('assignments.create') }}" 
                   class="flex items-center px-4 py-3 text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    + New Assignment
                </a>

                <!-- All Submissions -->
                <a href="{{ route('teacher.submissions.history') }}" 
                   class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-gray-100 {{ request()->routeIs('teacher.submissions.history') ? 'bg-blue-50 text-blue-600' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                    All Submissions
                </a>
            </div>
        </nav>

        <!-- User Info -->
        <div class="p-4 border-t">
            <div class="flex items-center px-4 py-2">
                <div class="w-10 h-10 rounded-full bg-blue-500 flex items-center justify-center">
                    <span class="text-white font-medium">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-semibold text-gray-800">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-500 capitalize">{{ Auth::user()->role }}</p>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="ml-auto">
                    @csrf
                    <button type="submit" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Mobile Menu Toggle Button -->
<button id="mobileMenuToggle" class="lg:hidden fixed top-4 left-4 z-50 p-2 bg-white rounded-lg shadow-md">
    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
    </svg>
</button>

<script>
    const sidebar = document.querySelector('.fixed.inset-y-0');
    const toggleBtn = document.getElementById('mobileMenuToggle');
    
    if (toggleBtn) {
        toggleBtn.addEventListener('click', function() {
            sidebar.classList.toggle('-translate-x-full');
        });
    }
    
    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', function(event) {
        if (window.innerWidth < 1024) {
            if (sidebar && !sidebar.contains(event.target) && !toggleBtn.contains(event.target)) {
                sidebar.classList.add('-translate-x-full');
            }
        }
    });
</script>