<header class="bg-emerald-800 text-white p-4 shadow">
    <div class="container mx-auto flex justify-between items-center">
        <!-- لوگو -->
        <div class="text-2xl font-bold">
            <a href="{{ route('home') }}">گیاه‌یار</a>
        </div>

        <!-- منوی دسکتاپ -->
        <nav class="hidden md:flex space-x-8 space-x-reverse">
            <a href="{{ route('home') }}" class="hover:text-emerald-200 {{ request()->routeIs('home') ? 'font-bold' : '' }}">خانه</a>
            <a href="{{ route('experts') }}" class="hover:text-emerald-200 {{ request()->routeIs('experts') ? 'font-bold' : '' }}">متخصصان</a>
            <a href="{{ route('about') }}" class="hover:text-emerald-200 {{ request()->routeIs('about') ? 'font-bold' : '' }}">درباره ما</a>
            
            @auth
                <a href="{{ route('dashboard') }}" class="bg-emerald-600 px-4 py-2 rounded hover:bg-emerald-700">
                    داشبورد
                </a>
            @else
                <a href="{{ route('login') }}" class="bg-emerald-600 px-4 py-2 rounded hover:bg-emerald-700">
                    ورود/ثبت‌نام
                </a>
            @endauth
        </nav>

        <!-- منوی موبایل -->
        <button class="md:hidden mobile-menu-button">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
    </div>

    <!-- منوی موبایل (م