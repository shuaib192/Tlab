@extends('layouts.app')
@section('title', 'Membership Pricing Plans — TLab')

@section('content')

@include('partials.nav')

{{-- Hero with background image --}}
<section class="relative min-h-[55vh] flex items-end pt-20 overflow-hidden bg-ink">
    <div class="absolute inset-0 z-0 bg-gradient-to-br from-slate-900 to-indigo-950">
        <img src="/Tlab/public/images/membership-hero.png"
             alt="African children studying" class="w-full h-full object-cover opacity-90 transition-opacity duration-300"
             onload="this.classList.remove('opacity-0')" onerror="this.style.display='none'">
        <div class="absolute inset-0" style="background:linear-gradient(to top,#0F172A 35%,rgba(15,23,42,0.6) 70%,rgba(15,23,42,0.2) 100%)"></div>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full pb-20">
        <span class="inline-block bg-primary/20 text-primary text-xs font-black uppercase tracking-widest px-5 py-2 rounded-full mb-5 reveal">Pricing Plans</span>
        <h1 class="font-black text-5xl sm:text-6xl lg:text-7xl text-white mb-4 leading-tight reveal">
            Invest in Your <span class="text-primary">Child's Future</span>
        </h1>
        <p class="text-white/70 font-semibold text-lg max-w-2xl reveal">
            Choose the right membership tier. Cancel or upgrade anytime — no contracts, no hidden fees.
        </p>
    </div>
</section>

{{-- Plans --}}
<section class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-stretch">

            {{-- Explorer / Starter --}}
            <div class="tcard p-8 sm:p-10 flex flex-col reveal">
                <div>
                    <span class="text-xs font-black text-primary uppercase tracking-widest bg-primary/10 px-4 py-1.5 rounded-full">Explorer</span>
                    <h3 class="font-black text-3xl text-ink mt-6">Starter Plan</h3>
                    <p class="text-muted font-semibold text-xs mt-2 leading-relaxed max-w-xs">For kids exploring their first STEM interest area.</p>
                    <div class="my-8 flex items-end gap-2">
                        <span class="font-black text-5xl text-ink">&#8358;15,000</span>
                        <span class="text-muted font-bold text-xs mb-2">/ month</span>
                    </div>
                    <div class="space-y-4 pt-4 border-t border-gray-100">
                        @foreach(['1 Active STEM Club','Weekly Live Mentorship','XP & Ranking System','Parent Dashboard & Analytics','Digital Certificates','Ad-Free Safe Platform'] as $f)
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 text-primary flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                            <span class="text-muted font-semibold text-xs">{{ $f }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
                <a href="{{ route('register') }}" class="btn-outline !text-primary !border-primary hover:!bg-primary/5 w-full text-center mt-10 py-4 font-black">
                    Choose Starter
                </a>
            </div>

            {{-- Innovator / Premium - FEATURED --}}
            <div class="tcard p-8 sm:p-10 flex flex-col border-2 border-primary relative overflow-hidden reveal shadow-2xl" data-delay="80" style="box-shadow:0 24px 80px rgba(22,163,74,0.18)">
                <div class="absolute top-0 right-0 bg-primary text-white text-[0.58rem] font-black uppercase tracking-wider px-6 py-2 rounded-bl-2xl">
                    Best Value
                </div>
                <div>
                    <span class="text-xs font-black text-violet uppercase tracking-widest bg-violet/10 px-4 py-1.5 rounded-full">Innovator</span>
                    <h3 class="font-black text-3xl text-ink mt-6">Premium Plan</h3>
                    <p class="text-muted font-semibold text-xs mt-2 leading-relaxed max-w-xs">Ideal for learners pursuing skills across all four STEM clubs.</p>
                    <div class="my-8 flex items-end gap-2">
                        <span class="font-black text-5xl text-ink">&#8358;35,000</span>
                        <span class="text-muted font-bold text-xs mb-2">/ quarter</span>
                    </div>
                    <div class="space-y-4 pt-4 border-t border-gray-100">
                        @foreach(['All 4 STEM Clubs Included','All Live Sessions + Recordings','Fast-Track Rank Promotions','Priority Feedback & Grading','Printed Certificates & Pins','TLab Hackathons & Contests'] as $f)
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 text-violet flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                            <span class="text-muted font-semibold text-xs">{{ $f }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
                <a href="{{ route('register') }}" class="btn-submit w-full text-center mt-10 py-4 font-black">
                    Choose Premium
                </a>
            </div>

            {{-- Master Inventor / VIP --}}
            <div class="tcard p-8 sm:p-10 flex flex-col reveal" data-delay="160">
                <div>
                    <span class="text-xs font-black text-accent uppercase tracking-widest bg-accent/10 px-4 py-1.5 rounded-full">Master Inventor</span>
                    <h3 class="font-black text-3xl text-ink mt-6">Mastery VIP</h3>
                    <p class="text-muted font-semibold text-xs mt-2 leading-relaxed max-w-xs">For elite students seeking mentorship, custom roadmaps, and career foundations.</p>
                    <div class="my-8 flex items-end gap-2">
                        <span class="font-black text-5xl text-ink">&#8358;120,000</span>
                        <span class="text-muted font-bold text-xs mb-2">/ year</span>
                    </div>
                    <div class="space-y-4 pt-4 border-t border-gray-100">
                        @foreach(['All Clubs + Specialized Labs','1-on-1 Monthly Founder Mentorship','Custom Learning Roadmap','Physical Welcome Box (Kit + Shirt)','VIP Event Entry & Demo Stands','Portfolio Site + Recommendation Letter'] as $f)
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 text-accent flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                            <span class="text-muted font-semibold text-xs">{{ $f }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
                <a href="{{ route('register') }}" class="btn-outline !text-accent !border-accent hover:!bg-accent/5 w-full text-center mt-10 py-4 font-black">
                    Choose Mastery
                </a>
            </div>
        </div>
    </div>
</section>

{{-- Trust Strip --}}
<section class="py-16 bg-surface border-t border-b border-gray-100">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-8 text-center">
            @foreach([
                ['M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z','#16A34A','COPPA & GDPR-K Compliant','No data selling. No ads. Ever.'],
                ['M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z','#2563EB','Secure Paystack Payments','Local bank cards fully supported.'],
                ['M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15','#7C3AED','Cancel Anytime','No lock-in. Switch or cancel freely.'],
            ] as [$icon,$color,$title,$sub])
            <div class="flex flex-col items-center reveal">
                <div class="w-14 h-14 rounded-2xl flex items-center justify-center mb-4" style="background:{{ $color }}18">
                    <svg class="w-6 h-6" style="color:{{ $color }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $icon }}"/></svg>
                </div>
                <div class="font-black text-base text-ink mb-1">{{ $title }}</div>
                <div class="text-muted font-semibold text-xs">{{ $sub }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- FAQ --}}
<section class="py-24 bg-white">
    <div class="max-w-3xl mx-auto px-4 sm:px-6">
        <div class="text-center mb-14">
            <h2 class="font-black text-4xl text-ink mb-3 reveal">Pricing Questions</h2>
        </div>
        <div class="space-y-4">
            @foreach([
                ['Can I switch plans?', 'Yes, you can upgrade or downgrade your plan at any time from your parent dashboard. Changes take effect at the next billing cycle.'],
                ['Is there a free trial?', 'Yes. All new accounts get a 7-day free trial on the Starter plan with no credit card required.'],
                ['What payment methods are accepted?', 'We accept all major Nigerian debit/credit cards via Paystack. Bank transfers are also supported.'],
                ['Can one plan cover multiple children?', 'Each child profile has its own club enrolments. Plans are per child, but managed from one parent account.'],
            ] as $i => [$q,$a])
            <div class="tcard overflow-hidden reveal" data-delay="{{ $i * 60 }}">
                <button onclick="toggleFaq(this)" class="w-full flex items-center justify-between p-6 text-left font-black text-sm text-ink hover:text-primary transition-colors">
                    <span>{{ $q }}</span>
                    <svg class="w-5 h-5 flex-shrink-0 ml-4 transition-transform duration-300 faq-icon text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div class="faq-body max-h-0 overflow-hidden transition-all duration-300">
                    <p class="px-6 pb-6 text-muted font-semibold text-sm leading-relaxed">{{ $a }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

@include('partials.footer')

@push('scripts')
<script>
function toggleFaq(btn) {
    const body = btn.nextElementSibling;
    const icon = btn.querySelector('.faq-icon');
    const isOpen = body.style.maxHeight && body.style.maxHeight !== '0px';
    document.querySelectorAll('.faq-body').forEach(b => b.style.maxHeight = '0px');
    document.querySelectorAll('.faq-icon').forEach(i => i.style.transform = '');
    if (!isOpen) { body.style.maxHeight = body.scrollHeight + 'px'; icon.style.transform = 'rotate(180deg)'; }
}
</script>
@endpush

@endsection
