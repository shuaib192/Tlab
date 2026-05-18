@extends('layouts.app')
@section('title', 'Parent Dashboard')

@section('content')

{{-- ── TOP NAV ── --}}
<nav class="sticky top-0 z-50 bg-white border-b-2 border-gray-100 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-18 py-4">
            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex-shrink-0" data-no-transition>
                <img src="/images/tlab-logo-color.png" alt="TLab" class="h-9 w-auto">
            </a>

            {{-- Center label --}}
            <span class="hidden md:block text-xs font-black uppercase tracking-widest text-muted bg-surface px-4 py-2 rounded-full border border-gray-200">
                Parent Portal
            </span>

            {{-- Actions --}}
            <div class="flex items-center gap-3">
                <span class="hidden sm:block text-sm font-semibold text-muted">
                    Hello, <strong class="text-ink">{{ $user->name }}</strong>
                </span>
                <a href="{{ route('parent.children.create') }}"
                   class="inline-flex items-center gap-2 btn-cta text-sm !py-2.5 !px-5 !rounded-xl">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                    Add Child
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="text-sm font-bold text-muted hover:text-ink border-2 border-gray-200 hover:border-gray-300 px-4 py-2.5 rounded-xl transition-all">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>

<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

    {{-- Flash --}}
    @if(session('success')) <div class="flash flash-success">{{ session('success') }}</div> @endif
    @if(session('error'))   <div class="flash flash-error">{{ session('error') }}</div> @endif

    {{-- Header --}}
    <div class="mb-10">
        <h1 class="font-black text-3xl sm:text-4xl text-ink mb-2">Family Dashboard</h1>
        <p class="text-muted font-semibold">Manage your children's STEM learning journeys from one place.</p>
    </div>

    {{-- ── STAT OVERVIEW ── --}}
    @php $totalXp = $children->sum('xp'); $totalCourses = $children->sum('enrollments_count'); @endphp
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-12">
        @foreach([
            [$children->count(), 'Children', '#16A34A', '#F0FDF4'],
            [number_format($totalXp), 'Total XP', '#2563EB', '#EFF6FF'],
            [$totalCourses, 'Enrollments', '#7C3AED', '#F5F3FF'],
            [4, 'Clubs Available', '#EA580C', '#FFF7ED'],
        ] as [$val, $label, $color, $bg])
        <div class="tcard p-5 sm:p-6 reveal">
            <div class="font-black text-3xl sm:text-4xl mb-1" style="color:{{ $color }}">{{ $val }}</div>
            <div class="text-muted font-semibold text-sm">{{ $label }}</div>
        </div>
        @endforeach
    </div>

    {{-- ── NO CHILDREN STATE ── --}}
    @if($children->isEmpty())
    <div class="tcard p-16 text-center reveal">
        <div class="w-24 h-24 rounded-3xl bg-primary/10 flex items-center justify-center mx-auto mb-6 border-4 border-dashed border-primary/30">
            <svg class="w-10 h-10 text-primary/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
        </div>
        <h2 class="font-black text-2xl text-ink mb-3">No children added yet</h2>
        <p class="text-muted font-semibold text-sm max-w-sm mx-auto mb-8 leading-relaxed">
            Add your first child's profile to start their TLab STEM journey. Takes less than 2 minutes.
        </p>
        <a href="{{ route('parent.children.create') }}" class="btn-hero inline-flex !px-10">
            Add Your First Child
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
        </a>
    </div>

    @else

    {{-- ── CHILDREN GRID ── --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 mb-12">
        @foreach($children as $child)
        @php
            $rankData = [
                'Explorer'        => ['color'=>'#16A34A','bg'=>'#F0FDF4','label'=>'Explorer'],
                'Innovator'       => ['color'=>'#2563EB','bg'=>'#EFF6FF','label'=>'Innovator'],
                'Builder'         => ['color'=>'#EA580C','bg'=>'#FFF7ED','label'=>'Builder'],
                'Creator'         => ['color'=>'#7C3AED','bg'=>'#F5F3FF','label'=>'Creator'],
                'Master Inventor' => ['color'=>'#D97706','bg'=>'#FFFBEB','label'=>'Master Inventor'],
            ];
            $rd = $rankData[$child->rank] ?? $rankData['Explorer'];
            $progress = $child->rank_progress;
        @endphp

        <div class="tcard tcard-hover p-7 flex flex-col reveal" style="border-top:4px solid {{ $rd['color'] }}">

            {{-- Child info --}}
            <div class="flex items-center gap-4 mb-6">
                <div class="w-14 h-14 rounded-2xl font-black text-xl flex items-center justify-center flex-shrink-0 shadow-sm"
                     style="background:{{ $rd['bg'] }};color:{{ $rd['color'] }}">
                    {{ strtoupper(substr($child->name, 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <div class="font-black text-lg text-ink truncate">{{ $child->name }}</div>
                    <div class="text-muted text-xs font-semibold mt-0.5">
                        Age {{ $child->age ?? 'N/A' }} &bull; {{ ucfirst($child->skill_level) }}
                    </div>
                    <span class="inline-block mt-1.5 text-xs font-black px-3 py-0.5 rounded-full"
                          style="background:{{ $rd['bg'] }};color:{{ $rd['color'] }}">
                        {{ $rd['label'] }}
                    </span>
                </div>
            </div>

            {{-- XP bar --}}
            <div class="mb-6">
                <div class="flex justify-between text-xs font-bold mb-2">
                    <span class="text-ink">{{ number_format($child->xp) }} XP</span>
                    <span class="text-muted">{{ $progress }}% to next rank</span>
                </div>
                <div class="xp-track">
                    <div class="xp-fill" style="width:{{ $progress }}%"></div>
                </div>
            </div>

            {{-- Mini stats --}}
            <div class="grid grid-cols-2 gap-3 mb-6">
                <div class="bg-surface rounded-xl p-3 text-center border border-gray-100">
                    <div class="font-black text-xl" style="color:{{ $rd['color'] }}">{{ $child->enrollments_count }}</div>
                    <div class="text-muted text-xs font-semibold">Courses</div>
                </div>
                <div class="bg-surface rounded-xl p-3 text-center border border-gray-100">
                    <div class="font-black text-xl text-accent">{{ number_format($child->xp) }}</div>
                    <div class="text-muted text-xs font-semibold">XP Points</div>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex gap-2 mt-auto">
                <a href="{{ route('parent.children.switch', $child) }}"
                   class="flex-1 py-3 rounded-xl font-black text-white text-center text-sm transition-all hover:-translate-y-0.5 shadow-sm"
                   style="background:{{ $rd['color'] }}">
                    View Dashboard
                </a>
                <a href="{{ route('parent.children.show', $child) }}"
                   class="px-4 py-3 rounded-xl border-2 border-gray-200 text-muted text-sm font-bold hover:border-gray-300 hover:text-ink transition-all">
                    Details
                </a>
            </div>
        </div>
        @endforeach

        {{-- Add Another --}}
        <a href="{{ route('parent.children.create') }}"
           class="tcard flex flex-col items-center justify-center p-8 border-2 border-dashed border-gray-200 hover:border-primary/40 transition-all group min-h-[300px] reveal">
            <div class="w-16 h-16 rounded-3xl bg-primary/10 flex items-center justify-center mb-4 group-hover:bg-primary/20 group-hover:scale-110 transition-all border-2 border-dashed border-primary/30 group-hover:border-primary/50">
                <svg class="w-7 h-7 text-primary/50 group-hover:text-primary transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            </div>
            <div class="font-black text-sm text-muted group-hover:text-primary transition-colors">Add Another Child</div>
        </a>
    </div>
    @endif

</main>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.xp-fill').forEach(fill => {
        const w = fill.style.width;
        fill.style.width = '0%';
        setTimeout(() => { fill.style.width = w; }, 100);
    });
});
</script>
@endpush

@endsection
