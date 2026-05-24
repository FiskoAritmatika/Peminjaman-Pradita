<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Peminjaman Pradita</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen antialiased">

    @if(session('user'))
        @php
            $user = (object) session('user');
            $menuItems = [];
            if ($user->role === 'Mahasiswa' || $user->role === 'Organisasi') {
                $menuItems = [
                    [
                        'name' => 'Dashboard',
                        'url' => '/mahasiswa/dashboard',
                        'active' => request()->is('mahasiswa/dashboard*'),
                        'icon' => 'home'
                    ],

                    [
                        'name' => 'Pinjam Barang',
                        'url' => '/mahasiswa/barang',
                        'active' => request()->is('mahasiswa/barang') || request()->is('mahasiswa/barang/create*'),
                        'icon' => 'shopping-bag'
                    ],

                ];

                if ($user->role === 'Organisasi') {
                    // Tambahkan menu khusus Organisasi
                    $menuItems[] = [
                        'name' => 'Pinjam Lapangan',
                        'url' => '/mahasiswa/lapangan',
                        'active' => request()->is('mahasiswa/lapangan*'),
                        'icon' => 'calendar'
                    ];
                    $menuItems[] = [
                        'name' => 'Barang Saya',
                        'url' => '/mahasiswa/barang-saya',
                        'active' => request()->is('mahasiswa/barang-saya*'),
                        'icon' => 'box'
                    ];
                    $menuItems[] = [
                        'name' => 'Permintaan Masuk',
                        'url' => '/mahasiswa/permintaan-masuk',
                        'active' => request()->is('mahasiswa/permintaan-masuk*'),
                        'icon' => 'bell'
                    ];
                }
            } else {
                $menuItems = [
                    [
                        'name' => 'Dashboard',
                        'url' => '/admin/dashboard',
                        'active' => request()->is('admin/dashboard*'),
                        'icon' => 'home'
                    ],
                    [
                        'name' => 'Permintaan Lapangan',
                        'url' => '/admin/peminjaman',
                        'active' => request()->is('admin/peminjaman*'),
                        'icon' => 'clipboard-list'
                    ],
                    [
                        'name' => 'Kelola Lapangan',
                        'url' => '/admin/objek',
                        'active' => request()->is('admin/objek*'),
                        'icon' => 'settings'
                    ]
                ];
            }
        @endphp

        <!-- Sidebar Mobile / Drawer Container -->
        <div id="mobile-sidebar-container" class="relative z-50 lg:hidden hidden" role="dialog" aria-modal="true">
            <!-- Backdrop -->
            <div id="mobile-backdrop" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm transition-opacity duration-300 ease-linear opacity-0"></div>

            <!-- Slide-over panel -->
            <div class="fixed inset-0 flex">
                <div id="mobile-sidebar" class="relative mr-16 flex w-full max-w-xs flex-1 transform -translate-x-full transition-transform duration-300 ease-in-out">
                    <!-- Close button in slide-over -->
                    <div class="absolute top-0 right-0 -mr-12 pt-2">
                        <button type="button" id="close-sidebar-btn" class="ml-1 flex h-10 w-10 items-center justify-center rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white text-white hover:text-slate-200">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Mobile Sidebar Content -->
                    
                    <div id="mobile-sidebar-inner" class="flex grow flex-col overflow-y-auto bg-[#0e6333] text-white border-r border-white/10">
                        
                        <div class="p-6 border-b border-white/10">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-graduation-cap w-6 h-6 text-[#0e6333]"><path d="M21.42 10.922a1 1 0 0 0-.019-1.838L12.83 5.18a2 2 0 0 0-1.66 0L2.6 9.08a1 1 0 0 0 0 1.832l8.57 3.908a2 2 0 0 0 1.66 0z"></path><path d="M22 10v6"></path><path d="M6 12.5V16a6 3 0 0 0 12 0v-3.5"></path></svg>
                                </div>
                                <div>
                                    <h2 class="font-semibold text-lg tracking-wide text-white" style="font-family: 'Titillium Web', sans-serif;">Peminjaman Pradita</h2>
                                </div>
                            </div>
                        </div>
                        
                        <nav class="flex-1 py-6 px-3 overflow-y-auto">
                            <ul class="space-y-1">
                                @foreach($menuItems as $item)
                                    <li>
                                        <a href="{{ $item['url'] }}" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200 {{ $item['active'] ? 'bg-white/20 text-white shadow-sm' : 'text-white/80 hover:bg-white/10 hover:text-white' }}" style="font-family: 'Titillium Web', sans-serif;">
                                            <span class="text-white">
                                                @if($item['icon'] === 'home')
                                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" /></svg>
                                                @elseif($item['icon'] === 'calendar')
                                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" /></svg>
                                                @elseif($item['icon'] === 'shopping-bag')
                                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" /></svg>
                                                @elseif($item['icon'] === 'box')
                                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 7.5l-9-5.25L3 7.5m18 0l-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9" /></svg>
                                                @elseif($item['icon'] === 'bell')
                                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0M3.124 7.5A8.969 8.969 0 015.292 3m13.416 0a8.969 8.969 0 012.168 4.5" /></svg>
                                                @elseif($item['icon'] === 'clipboard-list')
                                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.03 0 1.9.693 2.166 1.638m-7.377 0A48.536 48.536 0 0112 3m0 0c2.917 0 5.747.294 8.5.862m-21 10.398c0-.652.209-1.282.597-1.816l2.337-3.213C3.9 8.242 4.626 8 5.378 8H7.5" /></svg>
                                                @elseif($item['icon'] === 'settings')
                                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.43l-1.003.828c-.293.241-.438.613-.43.992a7.723 7.723 0 010 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.43l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.991l-1.004-.827a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072(1076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.28z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                                @endif
                                            </span>
                                            <span class="text-sm font-medium">{{ $item['name'] }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </nav>
                        
                        <div class="p-4 border-t border-white/10">
                            <div class="flex items-center gap-3 px-2 py-3">
                                <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center text-sm font-semibold text-white">
                                    {{ strtoupper(substr($user->nama_user, 0, 2)) }}
                                </div>
                                <div class="flex-1 overflow-hidden">
                                    <p class="text-sm font-semibold text-white truncate" title="{{ $user->nama_user }}" style="font-family: 'Titillium Web', sans-serif;">{{ $user->nama_user }}</p>
                                    <p class="text-xs text-white/70 truncate" style="font-family: 'Titillium Web', sans-serif;">{{ strtolower($user->role) }}</p>
                                </div>
                                <form action="/logout" method="POST" class="inline m-0">
                                    @csrf
                                    <button type="submit" class="p-2 text-white hover:bg-white/10 rounded-lg transition-colors" aria-label="Logout">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-log-out w-5 h-5"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" x2="9" y1="12" y2="12"></line></svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Sidebar Desktop (Permanent) -->
        
        <aside class="hidden lg:flex lg:w-72 lg:flex-col lg:fixed lg:inset-y-0 z-40 bg-[#0e6333] text-white">
            
                        <div class="p-6 border-b border-white/10">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-graduation-cap w-6 h-6 text-[#0e6333]"><path d="M21.42 10.922a1 1 0 0 0-.019-1.838L12.83 5.18a2 2 0 0 0-1.66 0L2.6 9.08a1 1 0 0 0 0 1.832l8.57 3.908a2 2 0 0 0 1.66 0z"></path><path d="M22 10v6"></path><path d="M6 12.5V16a6 3 0 0 0 12 0v-3.5"></path></svg>
                                </div>
                                <div>
                                    <h2 class="font-semibold text-lg tracking-wide text-white" style="font-family: 'Titillium Web', sans-serif;">Peminjaman Pradita</h2>
                                </div>
                            </div>
                        </div>
            
                        <nav class="flex-1 py-6 px-3 overflow-y-auto">
                            <ul class="space-y-1">
                                @foreach($menuItems as $item)
                                    <li>
                                        <a href="{{ $item['url'] }}" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200 {{ $item['active'] ? 'bg-white/20 text-white shadow-sm' : 'text-white/80 hover:bg-white/10 hover:text-white' }}" style="font-family: 'Titillium Web', sans-serif;">
                                            <span class="text-white">
                                                @if($item['icon'] === 'home')
                                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" /></svg>
                                                @elseif($item['icon'] === 'calendar')
                                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" /></svg>
                                                @elseif($item['icon'] === 'shopping-bag')
                                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" /></svg>
                                                @elseif($item['icon'] === 'box')
                                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 7.5l-9-5.25L3 7.5m18 0l-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9" /></svg>
                                                @elseif($item['icon'] === 'bell')
                                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0M3.124 7.5A8.969 8.969 0 015.292 3m13.416 0a8.969 8.969 0 012.168 4.5" /></svg>
                                                @elseif($item['icon'] === 'clipboard-list')
                                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.03 0 1.9.693 2.166 1.638m-7.377 0A48.536 48.536 0 0112 3m0 0c2.917 0 5.747.294 8.5.862m-21 10.398c0-.652.209-1.282.597-1.816l2.337-3.213C3.9 8.242 4.626 8 5.378 8H7.5" /></svg>
                                                @elseif($item['icon'] === 'settings')
                                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.43l-1.003.828c-.293.241-.438.613-.43.992a7.723 7.723 0 010 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.43l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.991l-1.004-.827a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072(1076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.28z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                                @endif
                                            </span>
                                            <span class="text-sm font-medium">{{ $item['name'] }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </nav>
            
                        <div class="p-4 border-t border-white/10">
                            <div class="flex items-center gap-3 px-2 py-3">
                                <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center text-sm font-semibold text-white">
                                    {{ strtoupper(substr($user->nama_user, 0, 2)) }}
                                </div>
                                <div class="flex-1 overflow-hidden">
                                    <p class="text-sm font-semibold text-white truncate" title="{{ $user->nama_user }}" style="font-family: 'Titillium Web', sans-serif;">{{ $user->nama_user }}</p>
                                    <p class="text-xs text-white/70 truncate" style="font-family: 'Titillium Web', sans-serif;">{{ strtolower($user->role) }}</p>
                                </div>
                                <form action="/logout" method="POST" class="inline m-0">
                                    @csrf
                                    <button type="submit" class="p-2 text-white hover:bg-white/10 rounded-lg transition-colors" aria-label="Logout">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-log-out w-5 h-5"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" x2="9" y1="12" y2="12"></line></svg>
                                    </button>
                                </form>
                            </div>
                        </div>
        </aside>

    @endif

    <!-- Main Content Wrapper -->
    <div class="{{ session('user') ? 'lg:pl-64' : '' }} flex flex-col flex-1 min-h-screen">
        
        @if(session('user'))
            <!-- Header Bar -->
            <header class="sticky top-0 z-30 flex h-16 shrink-0 items-center justify-between border-b border-gray-200 bg-white/80 backdrop-blur-md px-4 sm:px-6 lg:px-8 shadow-sm">
                <!-- Hamburger menu button -->
                <button type="button" id="hamburger-btn" class="text-gray-500 hover:text-gray-700 lg:hidden p-2 rounded-lg hover:bg-gray-100 transition-colors">
                    <span class="sr-only">Buka menu</span>
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>

                <!-- Page / Context Title -->
                <div class="flex items-center gap-2">
                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-green-50 text-green-800 border border-green-200 tracking-wide uppercase">{{ $user->role }} Portal</span>
                    <span class="text-gray-300">/</span>
                    <h2 class="text-sm font-medium text-gray-500 truncate">@yield('title', 'Aplikasi Peminjaman')</h2>
                </div>

                <!-- Right-side actions / user status -->
                <div class="flex items-center gap-4">
                    <div class="hidden sm:flex flex-col text-right">
                        <span class="text-sm font-semibold text-gray-700 leading-tight">{{ $user->nama_user }}</span>
                        <span class="text-xs text-gray-400 capitalize leading-none mt-0.5">{{ strtolower($user->role) }}</span>
                    </div>
                    <div class="w-9 h-9 rounded-full bg-green-800 text-white font-bold flex items-center justify-center border border-green-700 text-xs">
                        {{ strtoupper(substr($user->nama_user, 0, 2)) }}
                    </div>
                </div>
            </header>
        @endif

        <!-- Main Content Area -->
        <main class="flex-1 p-4 sm:p-6 lg:p-8 max-w-7xl w-full mx-auto">
            
            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl mb-6 shadow-sm flex items-start gap-3">
                    <svg class="w-5 h-5 text-emerald-500 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div>
                        <span class="font-medium">Berhasil!</span>
                        <p class="text-sm text-emerald-700 mt-0.5">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-rose-50 border border-rose-200 text-rose-800 px-4 py-3 rounded-xl mb-6 shadow-sm flex items-start gap-3">
                    <svg class="w-5 h-5 text-rose-500 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <div>
                        <span class="font-medium">Galat!</span>
                        <p class="text-sm text-rose-700 mt-0.5">{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            @if($errors->any())
                <div class="bg-rose-50 border border-rose-200 text-rose-800 px-4 py-3 rounded-xl mb-6 shadow-sm flex items-start gap-3">
                    <svg class="w-5 h-5 text-rose-500 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <div>
                        <span class="font-medium">Harap periksa kembali isian form Anda:</span>
                        <ul class="list-disc list-inside mt-1.5 space-y-0.5 text-sm text-rose-700">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 md:p-8 min-h-[calc(100vh-12rem)]">
                @yield('content')
            </div>
        </main>
    </div>

    @if(session('user'))
        <!-- Navigation Drawer Toggle JavaScript -->
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const container = document.getElementById('mobile-sidebar-container');
                const backdrop = document.getElementById('mobile-backdrop');
                const sidebar = document.getElementById('mobile-sidebar');
                const openBtn = document.getElementById('hamburger-btn');
                const closeBtn = document.getElementById('close-sidebar-btn');

                const openSidebar = () => {
                    container.classList.remove('hidden');
                    // Force repaint
                    container.offsetHeight;
                    backdrop.classList.remove('opacity-0');
                    backdrop.classList.add('opacity-100');
                    sidebar.classList.remove('-translate-x-full');
                    sidebar.classList.add('translate-x-0');
                    document.body.classList.add('overflow-hidden');
                };

                const closeSidebar = () => {
                    backdrop.classList.remove('opacity-100');
                    backdrop.classList.add('opacity-0');
                    sidebar.classList.remove('translate-x-0');
                    sidebar.classList.add('-translate-x-full');
                    document.body.classList.remove('overflow-hidden');
                    
                    // Wait for animations to finish
                    setTimeout(() => {
                        container.classList.add('hidden');
                    }, 300);
                };

                if (openBtn) openBtn.addEventListener('click', openSidebar);
                if (closeBtn) closeBtn.addEventListener('click', closeSidebar);
                if (backdrop) backdrop.addEventListener('click', closeSidebar);
            });
        </script>
    @endif

</body>
</html>
