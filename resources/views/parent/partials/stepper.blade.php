@php
    $steps = [
        ['label' => 'Find Course', 'route' => 'parent.courses.index'],
        ['label' => 'Course Details', 'route' => isset($club) ? 'parent.courses.show' : null],
        ['label' => 'Enrolment', 'route' => null],
        ['label' => 'Payment', 'route' => null],
        ['label' => 'Confirmation', 'route' => null],
    ];
@endphp

<div class="flow-rail" role="navigation" aria-label="Enrolment steps">
    @foreach($steps as $i => $step)
        @php $num = $i + 1; @endphp

        @if($i > 0)
            <div class="flow-connector {{ $num <= $step ? 'done' : '' }}"></div>
        @endif

        <div class="flow-station">
            <span class="flow-dot {{ $num < $step ? 'done' : '' }} {{ $num === $step ? 'current' : '' }}">
                @if($num < $step)
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                @else
                    {{ $num }}
                @endif
            </span>
            @if($step['route'] && $num < $step)
                <a href="{{ route($step['route'], isset($club) ? [$club] : []) }}" class="flow-label">{{ $step['label'] }}</a>
            @else
                <span class="flow-label {{ $num === $step ? '' : 'muted' }}">{{ $step['label'] }}</span>
            @endif
        </div>
    @endforeach
</div>