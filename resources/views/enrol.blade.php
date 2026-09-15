@extends('layouts.app')

@section('title', 'Register — Foundational Skills Programme')
@section('description', 'Register your child for the TLab Foundational Skills Programme. Practical skills in coding, Python, digital design, reading, and writing.')

@push('styles')
<style>
    .landing-nav { background: rgba(255,255,255,.92); backdrop-filter: blur(10px); }
    .landing-cta { background:#16A34A; color:#fff; }
    .landing-cta:hover { background:#15803D; }
    .form-input { width:100%; border:1.5px solid #E7E5E4; border-radius:.85rem; padding:.75rem 1rem; font-size:.95rem; font-weight:600; color:#1C1917; background:#fff; }
    .form-input:focus { outline:none; border-color:#16A34A; box-shadow:0 0 0 3px rgba(22,163,74,.12); }
    .form-label { display:block; font-size:.8rem; font-weight:800; color:#57534E; text-transform:uppercase; letter-spacing:.05em; margin-bottom:.4rem; }
    .option-card { border:1.5px solid #E7E5E4; border-radius:.85rem; padding:.9rem 1rem; cursor:pointer; transition:border-color .15s ease, background .15s ease; }
    .option-card:hover { border-color:#A7F3D0; }
    input:checked + .option-card { border-color:#16A34A; background:#F0FDF4; }
    .option-card input { position:absolute; opacity:0; pointer-events:none; }
    .error-text { font-size:.8rem; font-weight:700; color:#DC2626; margin-top:.35rem; }
</style>
@endpush

@section('content')
<div class="min-h-screen bg-white text-ink font-sans">

    <nav class="landing-nav sticky top-0 z-50 border-b border-gray-100">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 py-4 flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <img src="/images/tlab-logo-black.png" alt="TLab" class="h-8 w-auto">
            </a>
            <a href="{{ route('programme.enrol') }}" class="landing-cta rounded-xl px-5 py-2.5 text-sm font-bold">Register Your Child</a>
        </div>
    </nav>

    <section class="bg-green-50/50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 py-16">
            <h1 class="font-black text-3xl sm:text-4xl">Register Your Child</h1>
            <p class="mt-2 text-muted">Complete the form below to secure a place in the Foundational Skills Programme. Registration closes 26 September 2026.</p>
        </div>
    </section>

    <section class="py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6">
            @if(session('error'))
                <div class="mb-6 bg-red-50 border border-red-200 text-red-700 rounded-xl px-5 py-4 text-sm font-bold">{{ session('error') }}</div>
            @endif

            <form method="POST" action="{{ route('programme.enrol.store') }}" class="bg-white border border-gray-200 rounded-3xl p-6 sm:p-10 shadow-sm">
                @csrf

                <h2 class="font-black text-xl mb-2">Parent / Guardian Details</h2>
                <p class="text-sm text-muted mb-6">We will send class and payment confirmation to these details.</p>

                <div class="grid sm:grid-cols-2 gap-5">
                    <div>
                        <label class="form-label" for="parent_name">Full name</label>
                        <input id="parent_name" name="parent_name" type="text" class="form-input" value="{{ old('parent_name') }}" placeholder="e.g. Adaeze Okafor" required>
                        @error('parent_name')<p class="error-text">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="form-label" for="phone">Phone or WhatsApp</label>
                        <input id="phone" name="phone" type="text" class="form-input" value="{{ old('phone') }}" placeholder="e.g. 0801 234 5678" required>
                        @error('phone')<p class="error-text">{{ $message }}</p>@enderror
                    </div>
                    <div class="sm:col-span-2">
                        <label class="form-label" for="email">Email address</label>
                        <input id="email" name="email" type="email" class="form-input" value="{{ old('email') }}" placeholder="you@example.com" required>
                        @error('email')<p class="error-text">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="border-t border-gray-100 my-8"></div>

                <h2 class="font-black text-xl mb-2">Child's Details</h2>
                <p class="text-sm text-muted mb-6">Select your child's age and we will show suitable programmes.</p>

                <div class="grid sm:grid-cols-2 gap-5">
                    <div>
                        <label class="form-label" for="child_name">Child's full name</label>
                        <input id="child_name" name="child_name" type="text" class="form-input" value="{{ old('child_name') }}" placeholder="e.g. Chidera Okafor" required>
                        @error('child_name')<p class="error-text">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="form-label" for="child_age">Child's age</label>
                        <select id="child_age" name="child_age" class="form-input" required>
                            <option value="">Select age</option>
                            @for($age = 5; $age <= 17; $age++)
                                <option value="{{ $age }}" @selected(old('child_age') == $age)>{{ $age }} years</option>
                            @endfor
                        </select>
                        @error('child_age')<p class="error-text">{{ $message }}</p>@enderror
                    </div>
                    <div class="sm:col-span-2">
                        <label class="form-label" for="programme">Choose a programme</label>
                        <select id="programme" name="programme" class="form-input" required disabled>
                            <option value="">Select your child's age first</option>
                        </select>
                        <p id="programme_hint" class="text-xs text-muted mt-1.5 font-semibold"></p>
                        @error('programme')<p class="error-text">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="mt-6">
                    <span class="form-label">Device your child will use</span>
                    <div class="grid grid-cols-3 gap-3 max-w-xl">
                        @foreach(['laptop' => 'Laptop', 'tablet' => 'Tablet', 'smartphone' => 'Smartphone'] as $value => $label)
                        <label class="relative block">
                            <input type="radio" name="device" value="{{ $value }}" @checked(old('device') === $value)>
                            <span class="option-card block text-center text-sm font-bold">{{ $label }}</span>
                        </label>
                        @endforeach
                    </div>
                    @error('device')<p class="error-text">{{ $message }}</p>@enderror
                </div>

                <div class="border-t border-gray-100 my-8"></div>

                <h2 class="font-black text-xl mb-2">Payment</h2>
                <p class="text-sm text-muted mb-6">Pay securely with Paystack. A class recording is available when your child misses a session.</p>

                <div class="grid sm:grid-cols-2 gap-4">
                    <label class="relative block">
                        <input type="radio" name="payment_option" value="monthly" @checked(old('payment_option') === 'monthly')>
                        <span class="option-card block">
                            <span class="block font-black text-lg">₦10,000 <span class="text-sm font-bold text-muted">monthly</span></span>
                            <span class="block text-sm text-muted mt-1">Three monthly payments for three months</span>
                        </span>
                    </label>
                    <label class="relative block">
                        <input type="radio" name="payment_option" value="full" @checked(old('payment_option') === 'full')>
                        <span class="option-card block">
                            <span class="block font-black text-lg">₦30,000 <span class="text-sm font-bold text-muted">full payment</span></span>
                            <span class="block text-sm text-muted mt-1">One-time payment for the whole programme</span>
                        </span>
                    </label>
                </div>
                @error('payment_option')<p class="error-text">{{ $message }}</p>@enderror

                <div class="mt-6 rounded-xl bg-gray-50 border border-gray-100 p-5">
                    <label class="flex gap-3 items-start cursor-pointer">
                        <input id="consent" name="consent" type="checkbox" value="1" class="mt-0.5 w-5 h-5 accent-green-600" @checked(old('consent'))>
                        <span class="text-sm font-semibold text-ink">
                            I agree to the programme terms and give permission for my child to participate.
                        </span>
                    </label>
                    @error('consent')<p class="error-text">{{ $message }}</p>@enderror
                </div>

                <button type="submit" class="landing-cta w-full rounded-xl px-8 py-4 mt-8 text-base font-bold flex items-center justify-center gap-2">
                    Proceed to Payment
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </button>

                <p class="text-xs text-muted text-center mt-4">
                    Need help? Email
                    <a href="mailto:tlabadmin@edfrica.org" class="font-bold text-green-700 hover:underline">tlabadmin@edfrica.org</a>
                </p>
            </form>
        </div>
    </section>

    <footer class="border-t border-gray-100 py-10">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 text-center">
            <p class="text-xs text-muted">TLab by Edfrica · <a href="mailto:tlabadmin@edfrica.org" class="hover:text-ink">tlabadmin@edfrica.org</a></p>
        </div>
    </footer>

</div>
@endsection

@push('scripts')
<script>
(function () {
    var programmes = @json(\App\Http\Controllers\ProgrammeRegistrationController::programmes());

    var ageSelect = document.getElementById('child_age');
    var programmeSelect = document.getElementById('programme');
    var programmeHint = document.getElementById('programme_hint');

    function bandFor(age) {
        if (age >= 5 && age <= 7) return '5–7';
        if (age >= 8 && age <= 11) return '8–11';
        if (age >= 12 && age <= 17) return '12–17';
        return null;
    }

    var selected = programmeSelect.value;

    function refresh() {
        var age = parseInt(ageSelect.value, 10);
        var band = bandFor(age);
        programmeSelect.innerHTML = '';

        if (!band) {
            programmeSelect.disabled = true;
            programmeSelect.appendChild(new Option('Select your child\'s age first', ''));
            programmeHint.textContent = '';
            return;
        }

        var options = programmes.filter(function (p) { return p.band === band; });

        options.forEach(function (p) {
            programmeSelect.appendChild(new Option(p.name + ' (' + p.band + ')', p.key));
        });

        programmeSelect.disabled = false;
        programmeHint.textContent = options.length + ' programme' + (options.length === 1 ? '' : 's') + ' available for ages ' + band + '.';

        if (selected && options.some(function (p) { return p.key === selected; })) {
            programmeSelect.value = selected;
        } else if (options.length === 1) {
            programmeSelect.value = options[0].key;
        }
    }

    ageSelect.addEventListener('change', refresh);
    refresh();
})();
</script>
@endpush