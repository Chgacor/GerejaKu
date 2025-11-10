<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>

    {{-- CSRF Token untuk request AJAX --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @vite('resources/css/app.css')

    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
</head>
@php
    $isAdminRoute = request()->routeIs('admin.*');
    $bodyClass = $isAdminRoute ? 'bg-gray-100' : 'bg-gray-50';

    // Ambil data kontak dan ayat mingguan sekali saja di layout
    if (!$isAdminRoute) {
        try {
            $contactKeys = ['contact_phone', 'contact_instagram', 'contact_facebook', 'contact_youtube'];
            $contactSettings = \App\Models\Setting::whereIn('key', $contactKeys)->pluck('value', 'key')->all();
            $weeklyVerse = \App\Models\Setting::where('key', 'weekly_verse')->first();
        } catch (\Exception $e) {
            // Database mungkin belum siap/migrated, set default
            $contactSettings = [];
            $weeklyVerse = null;
        }
    }
@endphp
<body class="{{ $bodyClass }}">

@if ($isAdminRoute)
    {{-- ===================================== --}}
    {{-- NAVIGASI PANEL ADMIN                  --}}
    {{-- ===================================== --}}
    <nav class="bg-gray-800 text-white shadow-md">
        <div class="container mx-auto px-6 py-3">
            <div class="flex justify-between items-center">
                <a href="{{ route('admin.dashboard') }}" class="text-xl font-bold">{{ config('app.name') }} - Admin Panel</a>

                {{-- Menu Desktop Admin --}}
                <div class="hidden md:flex items-center space-x-6">
                    @php
                        function admin_nav_link($routeName, $label) {
                            if (!Route::has($routeName)) return '';
                            $isActive = request()->routeIs($routeName . '*');
                            $classes = $isActive ? 'text-white font-semibold' : 'text-gray-400 hover:text-white';
                            $underlineClasses = $isActive ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100';
                            $url = route($routeName);

                            return <<<HTML
                                <div class="relative group">
                                    <a href="{$url}" class="{$classes} transition-colors duration-300 py-2">
                                        {$label}
                                    </a>
                                    <span class="absolute -bottom-1 left-0 w-full h-0.5 bg-blue-400 transform {$underlineClasses} transition-transform duration-300 ease-out origin-left"></span>
                                </div>
                            HTML;
                        }
                        $adminRoutes = [
                            'admin.jemaat.index' => 'Jemaat',
                            'admin.devotionals.index' => 'Devosi',
                            'admin.slides.index' => 'Slideshow',
                            'admin.services.index' => 'Ibadah',
                            'admin.pastors.index' => 'Hamba Tuhan',
                            'admin.commissions.index' => 'Komisi',
                            'admin.articles.index' => 'Artikel',
                            'admin.events.index' => 'Acara',
                            'admin.qna.index' => 'QnA',
                            'admin.settings.index' => 'Pengaturan',
                        ];
                    @endphp

                    @foreach($adminRoutes as $route => $label)
                        {!! admin_nav_link($route, $label) !!}
                    @endforeach

                    <a href="{{ route('home') }}" target="_blank" class="px-4 py-2 text-sm bg-blue-500 rounded hover:bg-blue-600 transition-colors">Lihat Situs</a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="px-4 py-2 text-sm bg-red-500 rounded hover:bg-red-600 transition-colors">Logout</button>
                    </form>
                </div>

                {{-- Tombol Burger Admin --}}
                <div class="md:hidden">
                    <button data-toggle-button data-toggle-target="#admin-mobile-menu" class="text-white focus:outline-none">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" /></svg>
                    </button>
                </div>
            </div>

            {{-- Menu Mobile Admin --}}
            <div id="admin-mobile-menu" class="hidden md:hidden mt-3 space-y-1" data-toggle-menu>
                @foreach($adminRoutes as $route => $label)
                    @if(Route::has($route))
                        <a href="{{ route($route) }}" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-700">{{ $label }}</a>
                    @endif
                @endforeach
                <a href="{{ route('home') }}" target="_blank" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-700">Lihat Situs Publik</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-700">Logout</button>
                </form>
            </div>
        </div>
    </nav>
@else
    {{-- ===================================== --}}
    {{-- NAVIGASI SITUS PUBLIK                 --}}
    {{-- ===================================== --}}
    <nav class="bg-white shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            {{-- Logo --}}
            <div>
                <a href="/" class="text-xl font-bold text-gray-800">{{ config('app.name', 'GKKB Serdam') }}</a>
            </div>

            {{-- Menu Desktop Publik --}}
            <div class="hidden md:flex items-center space-x-8">
                @php
                    function public_nav_link($routeName, $label, $wildcard = false) {
                        if (!Route::has($routeName)) return '';
                        $checkRoute = $wildcard ? $routeName . '*' : $routeName;
                        $isActive = request()->routeIs($checkRoute);
                        $classes = $isActive ? 'text-blue-600 font-bold' : 'text-gray-600';
                        $underlineClasses = $isActive ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100';
                        $url = route($routeName);

                        return <<<HTML
                            <div class="relative group">
                                <a href="{$url}" class="{$classes} hover:text-blue-600 transition-colors duration-300 py-2">
                                    {$label}
                                </a>
                                <span class="absolute -bottom-1 left-0 w-full h-0.5 bg-blue-500 transform {$underlineClasses} transition-transform duration-300 ease-out origin-left"></span>
                            </div>
                        HTML;
                    }
                    $publicRoutes = [
                        'home' => ['label' => 'Home'],
                        'articles.index' => ['label' => 'Berita', 'wildcard' => true],
                        'events.index' => ['label' => 'Jadwal', 'wildcard' => true],
                        'devotionals.index' => ['label' => 'Devosi', 'wildcard' => true],
                        'about' => ['label' => 'Sejarah Gereja'],
                        'pastors.index' => ['label' => 'Profil GKKB'],
                    ];
                @endphp

                @foreach($publicRoutes as $route => $details)
                    @if(Route::has($route))
                        {!! public_nav_link($route, $details['label'], $details['wildcard'] ?? false) !!}
                    @endif
                @endforeach
            </div>

            {{-- Bagian Kanan Navigasi Publik --}}
            <div class="hidden md:flex items-center">
                @guest
                    <div class="space-x-3">
                        <a href="{{ route('login') }}" class="px-4 py-2 text-sm text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-100">Login</a>
                        <a href="{{ route('register') }}" class="px-4 py-2 text-sm text-white bg-blue-500 rounded-lg hover:bg-blue-600">Register</a>
                    </div>
                @endguest
                @auth
                    <div class="flex items-center">
                        <div class="relative" id="notification-bell-container">
                            <button id="notification-bell-button" data-toggle-button data-toggle-target="#notification-dropdown" class="text-gray-600 hover:text-blue-600 focus:outline-none mr-5">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                                <span id="notification-count" class="absolute end-4 -top-1 bg-red-500 text-white text-xs rounded-full h-4 w-4 flex items-center justify-center hidden"></span>
                            </button>
                            <div id="notification-dropdown" class="hidden absolute right-0 mt-2 w-80 bg-white rounded-md shadow-lg z-50 overflow-hidden" data-toggle-menu>
                                <div class="p-4 font-bold border-b flex justify-between items-center">
                                    <span>Notifikasi</span>
                                    <button id="mark-all-read" class="text-xs text-blue-500 hover:underline focus:outline-none">Tandai semua dibaca</button>
                                </div>
                                <div id="notification-list" class="max-h-96 overflow-y-auto">
                                    <p class="text-center text-gray-400 p-4 text-sm">Memuat...</p>
                                </div>
                            </div>
                        </div>

                        {{-- Tombol Profil Pengguna --}}
                        <div class="relative">
                            <button data-toggle-button data-toggle-target="#profile-menu" class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                @if (Auth::user()->foto_profil)
                                    <img class="h-8 w-8 rounded-full object-cover" src="{{ asset('storage/' . Auth::user()->foto_profil) }}" alt="{{ Auth::user()->nama_lengkap }}">
                                @else
                                    <div class="h-8 w-8 rounded-full bg-blue-500 text-white flex items-center justify-center font-bold">
                                        {{ Str::substr(Auth::user()->nama_lengkap, 0, 1) }}
                                    </div>
                                @endif
                            </button>
                            <div id="profile-menu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50" data-toggle-menu>
                                @if (Auth::user()->role === 'admin')
                                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 font-bold bg-yellow-100">Admin Panel</a>
                                @endif
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profil Saya</a>
                                <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit" class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</button></form>
                            </div>
                        </div>
                    </div>
                @endauth
            </div>

            {{-- Tombol Burger Publik --}}
            <div class="md:hidden flex items-center">
                @auth {{-- Tampilkan lonceng di mobile jika login --}}
                <div class="relative mr-4" id="notification-bell-container-mobile">
                    <button id="notification-bell-button-mobile" data-toggle-button data-toggle-target="#notification-dropdown-mobile" class="text-gray-600 hover:text-blue-600 focus:outline-none mr-5 relative">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                        <span id="notification-count-mobile" class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-4 w-4 flex items-center justify-center hidden"></span>
                    </button>
                    <div id="notification-dropdown-mobile" class="hidden absolute right-0 mt-2 w-80 bg-white rounded-md shadow-lg z-50 overflow-hidden relative" data-toggle-menu>
                        <div class="p-4 font-bold border-b flex justify-between items-center"><span>Notifikasi</span><button id="mark-all-read-mobile" class="text-xs text-blue-500 hover:underline focus:outline-none">Tandai semua dibaca</button></div>
                        <div id="notification-list-mobile" class="max-h-96 overflow-y-auto"><p class="text-center text-gray-400 p-4 text-sm">Memuat...</p></div>
                    </div>
                </div>
                @endauth
                <button data-toggle-button data-toggle-target="#public-mobile-menu" class="text-gray-600 focus:outline-none"><svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" /></svg></button>
            </div>
        </div>

        {{-- Menu Mobile Publik --}}
        <div id="public-mobile-menu" class="hidden md:hidden px-6 pt-2 pb-4 space-y-1" data-toggle-menu>
            @foreach($publicRoutes as $route => $details)
                @if(Route::has($route))
                    <a href="{{ route($route) }}" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-100">{{ $details['label'] }}</a>
                @endif
            @endforeach
            <hr class="my-2 border-gray-200">
            @guest
                <a href="{{ route('login') }}" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-100">Login</a>
                <a href="{{ route('register') }}" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-100">Register</a>
            @endguest
            @auth
                @if (Auth::user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-100">Admin Panel</a>
                @endif
                <a href="{{ route('profile.edit') }}" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-100">Profil Saya</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-100">Logout</button>
                </form>
            @endauth
        </div>
    </nav>
@endif

<main>
    @if ($isAdminRoute)
        <div class="container mx-auto p-6">@yield('content')</div>
    @else
        @yield('content')
    @endif
</main>

@if (!$isAdminRoute)
    <footer class="bg-gray-800 text-white py-10 mt-10">
        <div class="container mx-auto text-center px-4">
            @isset($weeklyVerse)
                <div class="mb-6 max-w-2xl mx-auto"><p class="text-lg italic text-gray-300">"{{ $weeklyVerse->value }}"</p></div>
            @endisset
            @isset($contactSettings)
                <div class="mb-4">
                    @if(!empty($contactSettings['contact_phone']))<a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $contactSettings['contact_phone']) }}" class="text-gray-400 hover:text-white mx-2 inline-block">Telepon: {{ $contactSettings['contact_phone'] }}</a>@endif
                    @if(!empty($contactSettings['contact_instagram']))<a href="{{ $contactSettings['contact_instagram'] }}" target="_blank" class="text-gray-400 hover:text-white mx-2 inline-block">Instagram</a>@endif
                    @if(!empty($contactSettings['contact_facebook']))<a href="{{ $contactSettings['contact_facebook'] }}" target="_blank" class="text-gray-400 hover:text-white mx-2 inline-block">Facebook</a>@endif
                    @if(!empty($contactSettings['contact_youtube']))<a href="{{ $contactSettings['contact_youtube'] }}" target="_blank" class="text-gray-400 hover:text-white mx-2 inline-block">YouTube</a>@endif
                </div>
            @endisset
            <p class="text-sm text-gray-500">&copy; {{ date('Y') }} {{ config('app.name', 'GKKB Serdam') }}. All Rights Reserved.</p>
        </div>
    </footer>

@endif

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
@stack('scripts')

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const allToggleMenus = document.querySelectorAll('[data-toggle-menu]');
        const allToggleButtons = document.querySelectorAll('[data-toggle-button]');

        allToggleButtons.forEach(button => {
            button.addEventListener('click', (event) => {
                event.stopPropagation();
                const targetSelector = button.dataset.toggleTarget;
                const targetMenu = document.querySelector(targetSelector);
                if (targetMenu) {
                    allToggleMenus.forEach(menu => { if (menu !== targetMenu) menu.classList.add('hidden'); });
                    targetMenu.classList.toggle('hidden');
                }
            });
        });
        window.addEventListener('click', (event) => {
            let clickedInside = false;
            allToggleButtons.forEach(button => { if (button.contains(event.target)) clickedInside = true; });
            allToggleMenus.forEach(menu => { if (menu.contains(event.target)) clickedInside = true; });
            if (!clickedInside) {
                allToggleMenus.forEach(menu => menu.classList.add('hidden'));
            }
        });
    });
</script>

@auth
    @if (!$isAdminRoute)
        @vite('resources/js/app.js')


        <script type="module">

            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');


            function updateUI(notifications, listId, countId) {
                const countBadge = document.getElementById(countId);
                const notificationList = document.getElementById(listId);
                const unreadCount = notifications.length;

                if (countBadge) {
                    countBadge.textContent = unreadCount > 9 ? '9+' : unreadCount;
                    unreadCount > 0 ? countBadge.classList.remove('hidden') : countBadge.classList.add('hidden');
                }

                if (notificationList) {
                    notificationList.innerHTML = unreadCount === 0
                        ? '<p class="text-center text-gray-500 p-4 text-sm">Tidak ada notifikasi baru.</p>'
                        : notifications.map(notif => `
                            <a href="${notif.data.url}" data-id="${notif.id}" class="block p-4 hover:bg-gray-100 border-b notification-item">
                                <p class="font-semibold text-sm text-gray-800">${notif.data.title}</p>
                                <p class="text-xs text-gray-600 mt-1">${notif.data.body}</p>
                            </a>
                        `).join('');
                }
            }


            function fetchAllNotifications() {
                fetch('{{ route("notifications.index") }}', {
                    headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
                })
                    .then(res => res.ok ? res.json() : Promise.reject('Failed to fetch'))
                    .then(notifications => {

                        updateUI(notifications, 'notification-list', 'notification-count');
                        updateUI(notifications, 'notification-list-mobile', 'notification-count-mobile');
                    })
                    .catch(error => {
                        console.error("Error fetching notifications:", error);
                        const listDesktop = document.getElementById('notification-list');
                        const listMobile = document.getElementById('notification-list-mobile');
                        if (listDesktop) listDesktop.innerHTML = '<p class="text-center text-red-500 p-4 text-xs">Gagal memuat notifikasi.</p>';
                        if (listMobile) listMobile.innerHTML = '<p class="text-center text-red-500 p-4 text-xs">Gagal memuat notifikasi.</p>';
                    });
            }

            function markAllNotificationsRead(event) {
                event.stopPropagation();
                fetch('{{ route("notifications.read") }}', {
                    method: 'POST',
                    headers: {'X-CSRF-TOKEN': csrfToken, 'Content-Type': 'application/json', 'Accept': 'application/json'},
                    body: JSON.stringify({ id: null })
                }).then(response => {
                    if (response.ok) fetchAllNotifications(); // Refresh list
                }).catch(error => console.error('Error marking read:', error));
            }

            document.addEventListener('DOMContentLoaded', function () {

                function setupBell(containerId, markAllReadId) {
                    const container = document.getElementById(containerId);
                    if (!container) return;

                    const markAllReadBtn = document.getElementById(markAllReadId);
                    if (markAllReadBtn) {
                        markAllReadBtn.addEventListener('click', markAllNotificationsRead);
                    }
                }


                setupBell('notification-bell-container', 'mark-all-read');

                setupBell('notification-bell-container-mobile', 'mark-all-read-mobile');

                fetchAllNotifications();

                setInterval(fetchAllNotifications, 60000);


                if (window.Echo) {

                    const userId = {{ Auth::user()->id }};

                    window.Echo.private(`App.Models.User.${userId}`)
                        .notification((notification) => {
                            console.log('NOTIFIKASI BARU DITERIMA:', notification);

                            fetchAllNotifications();
                        });

                    console.log(`Echo listening on private channel: App.Models.User.${userId}`);
                } else {
                    console.warn('Laravel Echo is not defined. Real-time notifications will not work.');
                }
            });
        </script>
    @endif
@endauth

</body>
</html>

