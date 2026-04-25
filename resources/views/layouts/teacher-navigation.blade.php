<!-- Teacher Sidebar -->
<div class="fixed inset-y-0 left-0 w-64 shadow-lg z-40 transform transition-transform duration-300 lg:translate-x-0 -translate-x-full" style="background-color: #042C53;">
    <div class="flex flex-col h-full">
        <!-- Logo -->
        <div class="p-6" style="border-bottom: 1px solid #0C447C;">
            <h1 class="text-2xl font-bold text-white">CASP Portal</h1>
            <p class="text-xs mt-1" style="color: #85B7EB;">School Management System</p>
        </div>

        <!-- Navigation Menu -->
        <nav class="flex-1 py-6">
            <div class="px-4 space-y-2">
                <!-- Dashboard -->
                <a href="{{ route('teacher.dashboard') }}" 
                   class="flex items-center px-4 py-3 rounded-lg transition-colors duration-150
                   {{ request()->routeIs('teacher.dashboard') 
                      ? 'text-white' 
                      : 'hover:text-white' }}"
                   style="{{ request()->routeIs('teacher.dashboard') 
                      ? 'background-color: #185FA5; color: white;' 
                      : 'color: #B5D4F4;' }}"
                   onmouseover="{{ !request()->routeIs('teacher.dashboard') ? 'this.style.backgroundColor=\"#0C447C\"' : '' }}"
                   onmouseout="{{ !request()->routeIs('teacher.dashboard') ? 'this.style.backgroundColor=\"transparent\"' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Dashboard
                </a>

                <!-- My Assignments -->
                <a href="{{ route('assignments.index') }}" 
                   class="flex items-center px-4 py-3 rounded-lg transition-colors duration-150"
                   style="{{ request()->routeIs('assignments.index') 
                      ? 'background-color: #185FA5; color: white;' 
                      : 'color: #B5D4F4;' }}"
                   onmouseover="{{ !request()->routeIs('assignments.index') ? 'this.style.backgroundColor=\"#0C447C\"' : '' }}"
                   onmouseout="{{ !request()->routeIs('assignments.index') ? 'this.style.backgroundColor=\"transparent\"' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    My Assignments
                </a>

                <!-- New Assignment Button -->
                <a href="{{ route('assignments.create') }}" 
                   class="flex items-center px-4 py-3 text-white rounded-lg transition-colors duration-150"
                   style="background-color: #378ADD;"
                   onmouseover="this.style.backgroundColor='#185FA5'"
                   onmouseout="this.style.backgroundColor='#378ADD'">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                     New Assignment
                </a>

                <!-- All Submissions -->
                <a href="{{ route('teacher.submissions.history') }}" 
                   class="flex items-center px-4 py-3 rounded-lg transition-colors duration-150"
                   style="{{ request()->routeIs('teacher.submissions.history') 
                      ? 'background-color: #185FA5; color: white;' 
                      : 'color: #B5D4F4;' }}"
                   onmouseover="{{ !request()->routeIs('teacher.submissions.history') ? 'this.style.backgroundColor=\"#0C447C\"' : '' }}"
                   onmouseout="{{ !request()->routeIs('teacher.submissions.history') ? 'this.style.backgroundColor=\"transparent\"' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                    All Submissions
                </a>
            </div>
        </nav>

        <!-- User Info -->
        <div class="p-4" style="border-top: 1px solid #0C447C;">
            <div class="flex items-center px-4 py-2">
                <div class="w-10 h-10 rounded-full flex items-center justify-center" style="background-color: #378ADD;">
                    <span class="text-white font-medium">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-semibold text-white">{{ Auth::user()->name }}</p>
                    <p class="text-xs capitalize" style="color: #85B7EB;">{{ Auth::user()->role }}</p>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="ml-auto">
                    @csrf
                    <button type="submit" style="color: #85B7EB;" onmouseover="this.style.color='white'" onmouseout="this.style.color='#85B7EB'">
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
<button id="mobileMenuToggle" class="lg:hidden fixed top-4 left-4 z-50 p-2 rounded-lg shadow-md" style="background-color: #042C53;">
    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
    document.addEventListener('click', function(event) {
        if (window.innerWidth < 1024) {
            if (sidebar && !sidebar.contains(event.target) && !toggleBtn.contains(event.target)) {
                sidebar.classList.add('-translate-x-full');
            }
        }
    });
</script>