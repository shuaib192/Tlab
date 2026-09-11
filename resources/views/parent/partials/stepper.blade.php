@php
    $steps = [
        ['label' => 'Find Course', 'route' => 'parent.courses.index'],
        ['label' => 'Course Details', 'route' => isset($club) ? 'parent.courses.show' : null],
        ['label' => 'Enrolment', 'route' => null],
        ['label' => 'Payment', 'route' => null],
        ['label' => 'Confirmation', 'route' => null],
    ];
@endphp

<nav class="flex items-center justify-center gap-2 sm:gap-3 mb-8 text-xs sm:text-sm">
    @foreach($steps as $i => $step)
        @php $num = $i + 1; @endphp
        <div class="flex items-center gap-2 sm:gap-3 {{ $num < $step ? 'opacity-40' : '' }}">
            <span class="flex items-center justify-center w-7 h-7 rounded-full font-bold shrink-0
                         {{ $num === $step ? 'bg-primary text-white shadow-md' : ($num < $step ? 'bg-primary/10 text-primary' : 'bg-gray-100 text-muted') }}">
                @if($num < $step)
                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                @else
                    {{ $num }}
                @endif
            </span>
            @if($step['route'] && $num < $step)
                <a href="{{ route($step['route'], isset($club) ? [$club] : []) }}" class="font-bold {{ $num === $step ? 'text-ink' : 'text-muted hover:text-primary hidden sm:inline' }}">{{ $step['label'] }}</a>
            @else
                <span class="font-bold {{ $num === $step ? 'text-ink' : 'text-muted hidden sm:inline' }}">{{ $step['label'] }}</span>
            @endif
            @if($num < 5)
                <div class="w-6 sm:w-10 h-px bg-gray-200 {{ $num < $step ? 'bg-primary/30' : '' }}"></div>
            @endif
        </div>
    @endforeach
</nav>
