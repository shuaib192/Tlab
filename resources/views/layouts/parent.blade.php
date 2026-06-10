@extends('layouts.app')

@section('content')
<div x-data="{ sidebarOpen: false }" class="min-h-screen bg-gray-50">
    
    {{-- Mobile top bar --}}
    <div class="sticky top-0 z-30 flex items-center justify-between h-14 px-4 bg-white border-b border-gray-100 lg:hidden">
        <button @@click="sidebarOpen = true" class="p-2 rounded-lg hover:bg-gray-100 text-ink">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>
        <a href="{{ route('parent.dashboard') }}" class="flex items-center gap-2" data-no-transition>
            <img src="/images/tlab-logo-color.png" alt="TLab" class="h-6 w-auto">
            <span class="font-bold text-sm text-ink">TLab Parent</span>
        </a>
        <a href="{{ route('parent.children.create') }}" class="p-2 rounded-lg hover:bg-gray-100 text-primary">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        </a>
    </div>

    {{-- Sidebar --}}
    @include('partials.parent-sidebar')

    {{-- Main content --}}
    <div class="lg:pl-64">
        <main class="min-h-screen">
            @yield('parent-content')
        </main>
    </div>
</div>

<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.1/dist/cdn.min.js"></script>
@endsection
