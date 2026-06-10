@extends('layouts.app')

@section('title', 'Pricing Plans — TLab')

@section('content')

@include('partials.nav')

{{-- Hero --}}
<section class="relative pt-36 pb-24 bg-ink overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-green-950/30 via-ink to-indigo-950/30"></div>
    <div class="absolute top-1/3 left-1/4 w-96 h-96 rounded-full blur-[120px] opacity-20" style="background:#16A34A"></div>
    <div class="absolute bottom-1/4 right-1/4 w-80 h-80 rounded-full blur-[100px] opacity-15" style="background:#7C3AED"></div>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
        <span class="inline-block bg-primary/10 text-primary text-xs font-black uppercase tracking-widest px-5 py-2 rounded-full mb-6 reveal">Pricing</span>
        <h1 class="font-black text-4xl sm:text-5xl lg:text-6xl text-white mb-5 leading-tight reveal">
            Simple, Transparent Pricing
        </h1>
        <p class="text-white/60 font-semibold text-base max-w-2xl mx-auto reveal leading-relaxed">
            Choose the right plan for your child. No hidden fees. Cancel anytime.
        </p>
    </div>
</section>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-10 relative z-20">

    {{-- Monthly Plans --}}
    <section class="mb-24">
        <div class="text-center mb-14 reveal">
            <span class="inline-block bg-primary/10 text-primary text-xs font-black uppercase tracking-widest px-5 py-2 rounded-full mb-5">Plans</span>
            <h2 class="font-black text-4xl sm:text-5xl text-ink mb-5 leading-tight">Monthly Membership <span class="text-primary">Plans</span></h2>
            <p class="text-muted font-semibold text-base max-w-2xl mx-auto">Pick the tier that fits your child's interests. All plans include premium facilitation and Edfrica quality standards.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8 max-w-5xl mx-auto">
            {{-- Explorer --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-lg transition-shadow duration-300 p-6 sm:p-8 flex flex-col reveal">
                <div class="mb-6">
                    <span class="text-xs font-black text-primary uppercase tracking-widest">EXPLORER</span>
                    <h3 class="text-xl font-black text-ink mt-2">1 Club</h3>
                    <div class="mt-4 flex items-baseline gap-1">
                        <span class="text-4xl font-black text-ink">&#8358;30,000</span>
                        <span class="text-muted font-bold text-sm">/month</span>
                    </div>
                    <p class="text-xs text-muted font-semibold mt-1">+ &#8358;30,000 registration (annual)</p>
                </div>
                <ul class="space-y-3 text-sm text-muted flex-1 mb-8">
                    <li class="flex items-start gap-3">
                        <svg class="w-4 h-4 text-primary mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                        <span>1 club of your choice</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-4 h-4 text-primary mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                        <span>4 Saturday sessions/month (90 min each)</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-4 h-4 text-primary mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                        <span>Monthly progress report (PDF)</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-4 h-4 text-primary mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                        <span>Welcome kit + TLab journal</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-4 h-4 text-primary mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                        <span>Student portal &amp; progress tracking</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-4 h-4 text-primary mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                        <span>Demo Day participation</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-4 h-4 text-primary mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                        <span>20% off Holiday Camps</span>
                    </li>
                </ul>
                <a href="{{ route('register') }}" class="block w-full text-center py-3.5 rounded-xl font-black text-sm border-2 border-gray-200 text-ink hover:border-primary hover:text-primary transition-all duration-200">
                    Choose Plan
                </a>
            </div>

            {{-- Builder (Featured) --}}
            <div class="bg-white rounded-2xl border-2 border-primary shadow-xl shadow-primary/10 p-6 sm:p-8 flex flex-col relative reveal md:scale-[1.02]">
                <div class="absolute -top-4 left-1/2 -translate-x-1/2 bg-primary text-white text-xs font-black uppercase tracking-wider px-4 py-1.5 rounded-full whitespace-nowrap">Most Popular</div>
                <div class="mb-6">
                    <span class="text-xs font-black text-primary uppercase tracking-widest">BUILDER</span>
                    <h3 class="text-xl font-black text-ink mt-2">2 Clubs</h3>
                    <div class="mt-4 flex items-baseline gap-1">
                        <span class="text-4xl font-black text-ink">&#8358;54,000</span>
                        <span class="text-muted font-bold text-sm">/month</span>
                    </div>
                    <p class="text-xs text-primary font-bold mt-1">Save &#8358;6,000 vs two Explorer plans</p>
                </div>
                <ul class="space-y-3 text-sm text-muted flex-1 mb-8">
                    <li class="flex items-start gap-3">
                        <svg class="w-4 h-4 text-primary mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                        <span>2 clubs of your choice</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-4 h-4 text-primary mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                        <span>4 Saturday sessions/month</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-4 h-4 text-primary mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                        <span>Priority scheduling &amp; seat reservation</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-4 h-4 text-primary mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                        <span>Bi-monthly parent progress meeting</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-4 h-4 text-primary mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                        <span>30% off Holiday Camps</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-4 h-4 text-primary mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                        <span>Student Spotlight feature</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-4 h-4 text-primary mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                        <span>Innovation Award eligibility</span>
                    </li>
                </ul>
                <a href="{{ route('register') }}" class="block w-full text-center py-3.5 rounded-xl font-black text-sm bg-primary text-white hover:bg-primary/90 transition-all duration-200 shadow-lg shadow-primary/25">
                    Choose Plan
                </a>
            </div>

            {{-- All-Access --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-lg transition-shadow duration-300 p-6 sm:p-8 flex flex-col reveal">
                <div class="mb-6">
                    <span class="text-xs font-black text-accent uppercase tracking-widest">ALL-ACCESS</span>
                    <h3 class="text-xl font-black text-ink mt-2">4 Clubs</h3>
                    <div class="mt-4 flex items-baseline gap-1">
                        <span class="text-4xl font-black text-ink">&#8358;100,000</span>
                        <span class="text-muted font-bold text-sm">/month</span>
                    </div>
                    <p class="text-xs text-muted font-semibold mt-1">The complete TLab experience</p>
                </div>
                <ul class="space-y-3 text-sm text-muted flex-1 mb-8">
                    <li class="flex items-start gap-3">
                        <svg class="w-4 h-4 text-accent mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                        <span>All 4 clubs — unlimited Saturday access (10am–4pm)</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-4 h-4 text-accent mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                        <span>Guaranteed seat every session</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-4 h-4 text-accent mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                        <span>Comprehensive cross-club monthly report</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-4 h-4 text-accent mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                        <span>VIP seating at all events</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-4 h-4 text-accent mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                        <span>50% off Holiday Camps</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-4 h-4 text-accent mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                        <span>Leadership Club mentoring included</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-4 h-4 text-accent mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                        <span>1-on-1 coaching per term</span>
                    </li>
                </ul>
                <a href="{{ route('register') }}" class="block w-full text-center py-3.5 rounded-xl font-black text-sm border-2 border-accent text-accent hover:bg-accent hover:text-white transition-all duration-200">
                    Choose Plan
                </a>
            </div>
        </div>
    </section>

    {{-- Registration Fee --}}
    <section class="mb-24 max-w-4xl mx-auto">
        <div class="text-center mb-12 reveal">
            <span class="inline-block bg-primary/10 text-primary text-xs font-black uppercase tracking-widest px-5 py-2 rounded-full mb-5">Registration</span>
            <h2 class="font-black text-3xl sm:text-4xl text-ink mb-4">One-Time Registration Fee</h2>
            <p class="text-muted font-semibold text-base max-w-2xl mx-auto">Every new member pays an annual registration fee that covers their welcome kit, student ID, and first-day readiness. Renewing members pay a reduced loyalty rate.</p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 reveal">
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5 sm:p-6 text-center">
                <div class="text-xs font-black text-primary uppercase tracking-widest mb-2">New Member</div>
                <div class="text-2xl font-black text-ink">&#8358;30,000</div>
                <div class="text-xs text-muted font-semibold mt-1">First child</div>
                <ul class="mt-4 text-xs text-muted space-y-1.5 text-left">
                    <li class="flex items-start gap-2"><svg class="w-3 h-3 text-primary mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg> Welcome kit + ID card</li>
                    <li class="flex items-start gap-2"><svg class="w-3 h-3 text-primary mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg> TLab T-shirt + journal</li>
                    <li class="flex items-start gap-2"><svg class="w-3 h-3 text-primary mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg> Demo Day VIP pass</li>
                </ul>
            </div>
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5 sm:p-6 text-center">
                <div class="text-xs font-black text-primary uppercase tracking-widest mb-2">Second Child</div>
                <div class="text-2xl font-black text-ink">&#8358;55,000</div>
                <div class="text-xs text-muted font-semibold mt-1">Same family (10% sibling discount)</div>
                <ul class="mt-4 text-xs text-muted space-y-1.5 text-left">
                    <li class="flex items-start gap-2"><svg class="w-3 h-3 text-primary mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg> Full welcome kit included</li>
                    <li class="flex items-start gap-2"><svg class="w-3 h-3 text-primary mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg> 10% sibling discount applied</li>
                    <li class="flex items-start gap-2"><svg class="w-3 h-3 text-primary mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg> Coordinated session scheduling</li>
                </ul>
            </div>
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5 sm:p-6 text-center">
                <div class="text-xs font-black text-primary uppercase tracking-widest mb-2">Renewal</div>
                <div class="text-2xl font-black text-ink">&#8358;24,000</div>
                <div class="text-xs text-muted font-semibold mt-1">Returning members (loyalty rate)</div>
                <ul class="mt-4 text-xs text-muted space-y-1.5 text-left">
                    <li class="flex items-start gap-2"><svg class="w-3 h-3 text-primary mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg> Updated journal + badge</li>
                    <li class="flex items-start gap-2"><svg class="w-3 h-3 text-primary mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg> Returning member ceremony</li>
                    <li class="flex items-start gap-2"><svg class="w-3 h-3 text-primary mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg> &#8358;6,000 savings vs new member</li>
                </ul>
            </div>
        </div>
    </section>

    {{-- Termly & Annual --}}
    <section class="mb-24 max-w-5xl mx-auto">
        <div class="text-center mb-12 reveal">
            <span class="inline-block bg-primary/10 text-primary text-xs font-black uppercase tracking-widest px-5 py-2 rounded-full mb-5">Save More</span>
            <h2 class="font-black text-3xl sm:text-4xl text-ink mb-4">Termly &amp; Annual Payment Options</h2>
            <p class="text-muted font-semibold text-base max-w-2xl mx-auto">Pay ahead and save. Commitment is rewarded with significant discounts.</p>
        </div>
        <div class="overflow-x-auto rounded-2xl border border-gray-100 shadow-sm reveal">
            <table class="w-full text-sm min-w-[600px]">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="text-left px-6 py-4 font-black text-ink text-xs uppercase tracking-wider">Payment Cycle</th>
                        <th class="text-center px-6 py-4 font-black text-ink text-xs uppercase tracking-wider">Explorer</th>
                        <th class="text-center px-6 py-4 font-black text-ink text-xs uppercase tracking-wider">Builder</th>
                        <th class="text-center px-6 py-4 font-black text-ink text-xs uppercase tracking-wider">All-Access</th>
                        <th class="text-right px-6 py-4 font-black text-ink text-xs uppercase tracking-wider">Saving</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4 font-bold text-ink">Monthly</td>
                        <td class="px-6 py-4 text-center text-muted font-semibold">&#8358;30,000</td>
                        <td class="px-6 py-4 text-center text-muted font-semibold">&#8358;54,000</td>
                        <td class="px-6 py-4 text-center text-muted font-semibold">&#8358;100,000</td>
                        <td class="px-6 py-4 text-right text-muted font-semibold">—</td>
                    </tr>
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4 font-bold text-ink">Termly <span class="text-muted font-semibold text-xs">(3 months)</span></td>
                        <td class="px-6 py-4 text-center font-semibold text-ink">&#8358;82,800</td>
                        <td class="px-6 py-4 text-center font-semibold text-ink">&#8358;149,000</td>
                        <td class="px-6 py-4 text-center font-semibold text-ink">&#8358;331,000</td>
                        <td class="px-6 py-4 text-right text-primary font-bold">~8%</td>
                    </tr>
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4 font-bold text-ink">Annual <span class="text-muted font-semibold text-xs">(12 months)</span></td>
                        <td class="px-6 py-4 text-center font-semibold text-ink">&#8358;316,800</td>
                        <td class="px-6 py-4 text-center font-semibold text-ink">&#8358;570,000</td>
                        <td class="px-6 py-4 text-center font-semibold text-ink">&#8358;1,267,000</td>
                        <td class="px-6 py-4 text-right text-primary font-bold">~13%</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>

    {{-- Discounts --}}
    <section class="mb-24 max-w-5xl mx-auto">
        <div class="text-center mb-12 reveal">
            <span class="inline-block bg-primary/10 text-primary text-xs font-black uppercase tracking-widest px-5 py-2 rounded-full mb-5">Discounts</span>
            <h2 class="font-black text-3xl sm:text-4xl text-ink mb-4">Discounts &amp; Special Access</h2>
            <p class="text-muted font-semibold text-base max-w-2xl mx-auto">We believe every child deserves access. Here's how we make it more affordable.</p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 reveal">
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
                <div class="w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center mb-3">
                    <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <div class="font-black text-sm text-ink mb-1">Sibling Discount</div>
                <div class="text-xs text-muted font-semibold mb-3">10% off monthly subscription for every additional child from the same family.</div>
                <div class="text-xs font-black text-primary">10% per child</div>
            </div>
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
                <div class="w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center mb-3">
                    <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                </div>
                <div class="font-black text-sm text-ink mb-1">School Group Enrollment</div>
                <div class="text-xs text-muted font-semibold mb-3">5+ children from the same school join together — each family gets a group discount.</div>
                <div class="text-xs font-black text-primary">15% off monthly fee</div>
            </div>
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
                <div class="w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center mb-3">
                    <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                </div>
                <div class="font-black text-sm text-ink mb-1">Referral Credit</div>
                <div class="text-xs text-muted font-semibold mb-3">Refer a friend. When their child completes their first month, you receive account credit.</div>
                <div class="text-xs font-black text-primary">&#8358;10,000 credit</div>
            </div>
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
                <div class="w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center mb-3">
                    <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </div>
                <div class="font-black text-sm text-ink mb-1">Scholarship Tier</div>
                <div class="text-xs text-muted font-semibold mb-3">5% of all slots reserved for children who qualify by need and merit. Screened each intake.</div>
                <div class="text-xs font-black text-primary">50% subsidized fee</div>
            </div>
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5 sm:col-span-2 lg:col-span-1">
                <div class="w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center mb-3">
                    <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                </div>
                <div class="font-black text-sm text-ink mb-1">Corporate Family Plan</div>
                <div class="text-xs text-muted font-semibold mb-3">Employers sponsor memberships for their teams' children. Billed quarterly to the company.</div>
                <div class="text-xs font-black text-primary">See below</div>
            </div>
        </div>
    </section>

    {{-- Corporate Plan --}}
    <section class="mb-24 max-w-5xl mx-auto">
        <div class="text-center mb-12 reveal">
            <span class="inline-block bg-primary/10 text-primary text-xs font-black uppercase tracking-widest px-5 py-2 rounded-full mb-5">Corporate</span>
            <h2 class="font-black text-3xl sm:text-4xl text-ink mb-4">Corporate Family Plan</h2>
            <p class="text-muted font-semibold text-base max-w-2xl mx-auto">Minimum 5 children per company. Billed annually or quarterly.</p>
        </div>
        <div class="overflow-x-auto rounded-2xl border border-gray-100 shadow-sm reveal">
            <table class="w-full text-sm min-w-[500px]">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="text-left px-6 py-4 font-black text-ink text-xs uppercase tracking-wider">Tier</th>
                        <th class="text-center px-6 py-4 font-black text-ink text-xs uppercase tracking-wider">Clubs</th>
                        <th class="text-center px-6 py-4 font-black text-ink text-xs uppercase tracking-wider">Annual per Child</th>
                        <th class="text-center px-6 py-4 font-black text-ink text-xs uppercase tracking-wider">Quarterly</th>
                        <th class="text-right px-6 py-4 font-black text-ink text-xs uppercase tracking-wider">vs. Retail</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4 font-bold text-ink">CORP EXPLORER</td>
                        <td class="px-6 py-4 text-center text-muted font-semibold">1 Club</td>
                        <td class="px-6 py-4 text-center font-bold text-primary">&#8358;300,000</td>
                        <td class="px-6 py-4 text-center text-muted font-semibold">&#8358;75,000</td>
                        <td class="px-6 py-4 text-right text-primary font-bold">~5% off</td>
                    </tr>
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4 font-bold text-ink">CORP BUILDER</td>
                        <td class="px-6 py-4 text-center text-muted font-semibold">2 Clubs</td>
                        <td class="px-6 py-4 text-center font-bold text-primary">&#8358;540,000</td>
                        <td class="px-6 py-4 text-center text-muted font-semibold">&#8358;135,000</td>
                        <td class="px-6 py-4 text-right text-primary font-bold">~7% off</td>
                    </tr>
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4 font-bold text-ink">CORP ALL-ACCESS</td>
                        <td class="px-6 py-4 text-center text-muted font-semibold">4 Clubs</td>
                        <td class="px-6 py-4 text-center font-bold text-primary">&#8358;900,000</td>
                        <td class="px-6 py-4 text-center text-muted font-semibold">&#8358;225,000</td>
                        <td class="px-6 py-4 text-right text-primary font-bold">~29% off</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>

    {{-- Techiecity --}}
    <section class="mb-24 max-w-5xl mx-auto">
        <div class="text-center mb-12 reveal">
            <span class="inline-block bg-primary/10 text-primary text-xs font-black uppercase tracking-widest px-5 py-2 rounded-full mb-5">Cohorts</span>
            <h2 class="font-black text-3xl sm:text-4xl text-ink mb-4">Techiecity</h2>
            <p class="text-muted font-semibold text-base max-w-2xl mx-auto">Short-term, on-site cohort programmes for specialised tech skills.</p>
        </div>
        <div class="overflow-x-auto rounded-2xl border border-gray-100 shadow-sm reveal">
            <table class="w-full text-sm min-w-[500px]">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="text-left px-6 py-4 font-black text-ink text-xs uppercase tracking-wider">Programme</th>
                        <th class="text-center px-6 py-4 font-black text-ink text-xs uppercase tracking-wider">Duration</th>
                        <th class="text-left px-6 py-4 font-black text-ink text-xs uppercase tracking-wider hidden md:table-cell">Best For</th>
                        <th class="text-right px-6 py-4 font-black text-ink text-xs uppercase tracking-wider">Pricing</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @php $techiecity = [
                        ['Web Development (Frontend) Basics', '16 Weeks', 'Beginners, IT graduates, developers', '₦250,000'],
                        ['UI/UX Design', '12 Weeks', 'Graduates, career-changers, design students', '₦180,000'],
                        ['Data Analytics', '12 Weeks', 'Professionals, analysts, graduates', '₦200,000'],
                        ['Data Science', '12 Weeks', 'Professionals, analysts, graduates', '₦250,000'],
                        ['Digital Marketing', '8 Weeks', 'Business owners, marketing staff, freelancers', '₦120,000'],
                        ['Graphic Design', '8 Weeks', 'Creatives, side-income seekers, students', '₦120,000'],
                        ['Product Management', '10 Weeks', 'Team leads, career-changers, tech graduates', '₦160,000'],
                        ['Video Editing', '8 Weeks', 'Content creators, media students, influencers', '₦150,000'],
                        ['Cloud Engineering', '12 Weeks', 'Prepares students for global remote jobs', '₦250,000'],
                        ['Cybersecurity Foundations', '8 Weeks', 'Direct path to roles in Banks and Fintechs', '₦250,000'],
                        ['IT Project Management', '6 Weeks', 'Essential for senior roles', '₦150,000'],
                    ] @endphp
                    @foreach($techiecity as $i => $t)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-3.5 font-bold text-ink text-xs">{{ $t[0] }}</td>
                        <td class="px-6 py-3.5 text-center text-muted font-semibold text-xs">{{ $t[1] }}</td>
                        <td class="px-6 py-3.5 text-muted text-xs hidden md:table-cell">{{ $t[2] }}</td>
                        <td class="px-6 py-3.5 text-right font-bold text-primary text-xs">{{ $t[3] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>

    {{-- Short Courses --}}
    <section class="mb-24 max-w-5xl mx-auto">
        <div class="text-center mb-12 reveal">
            <span class="inline-block bg-primary/10 text-primary text-xs font-black uppercase tracking-widest px-5 py-2 rounded-full mb-5">Short Courses</span>
            <h2 class="font-black text-3xl sm:text-4xl text-ink mb-4">Short Courses</h2>
            <p class="text-muted font-semibold text-base max-w-2xl mx-auto">Focused, affordable courses for quick skill acquisition.</p>
        </div>
        <div class="overflow-x-auto rounded-2xl border border-gray-100 shadow-sm reveal">
            <table class="w-full text-sm min-w-[500px]">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="text-left px-6 py-4 font-black text-ink text-xs uppercase tracking-wider">Course</th>
                        <th class="text-center px-6 py-4 font-black text-ink text-xs uppercase tracking-wider">Duration</th>
                        <th class="text-left px-6 py-4 font-black text-ink text-xs uppercase tracking-wider hidden md:table-cell">Best For</th>
                        <th class="text-right px-6 py-4 font-black text-ink text-xs uppercase tracking-wider">Pricing</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @php $shortcourses = [
                        ['Content Creation Bootcamp', '4 Weeks', 'Aspiring full-time creators, influencers', '₦70,000'],
                        ['AI Tools for Business', '3 Weeks', 'SME owners, managers, traders', '₦80,000'],
                        ['AI Prompt Engineering', '2 Weeks', 'Immediate productivity boost for any office worker', '₦15,000'],
                        ['Digital Marketing for SMEs', '3 Weeks', 'Market traders, shop owners, small businesses', '₦80,000'],
                        ['No-Code App Development', '4 Weeks', 'Entrepreneurs wanting to build MVPs without coding', '₦80,000'],
                        ['Motion Graphics for Social Media', '5 Weeks', 'Graphic designers looking to level up into animation', '₦70,000'],
                        ['Technical Writing', '4 Weeks', 'Writers looking to enter the tech industry', '₦50,000'],
                        ['Customer Success & CRM', '4 Weeks', 'Front-desk staff, sales reps, and customer support', '₦50,000'],
                    ] @endphp
                    @foreach($shortcourses as $s)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-3.5 font-bold text-ink text-xs">{{ $s[0] }}</td>
                        <td class="px-6 py-3.5 text-center text-muted font-semibold text-xs">{{ $s[1] }}</td>
                        <td class="px-6 py-3.5 text-muted text-xs hidden md:table-cell">{{ $s[2] }}</td>
                        <td class="px-6 py-3.5 text-right font-bold text-primary text-xs">{{ $s[3] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>

</div>

@include('partials.footer')

@endsection
