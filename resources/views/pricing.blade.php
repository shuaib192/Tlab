@extends('layouts.app')

@section('title', 'Membership, Pricing & What Families Get')

@section('content')

@include('partials.nav')

{{-- Hero --}}
<section class="relative pt-36 pb-20 bg-ink overflow-hidden">
    <div class="absolute inset-0 z-0">
        <div class="absolute inset-0 bg-gradient-to-br from-green-950/40 via-ink to-indigo-950/40"></div>
        <div class="absolute top-1/4 right-0 w-80 h-80 rounded-full blur-[100px] opacity-25" style="background:#16A34A"></div>
        <div class="absolute bottom-1/4 left-0 w-80 h-80 rounded-full blur-[100px] opacity-20" style="background:#7C3AED"></div>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
        <span class="inline-block bg-primary/10 text-primary text-xs font-black uppercase tracking-widest px-5 py-2 rounded-full mb-6 reveal">Pricing</span>
        <h1 class="font-black text-5xl sm:text-6xl lg:text-7xl text-white mb-6 leading-tight reveal">
            Membership, Pricing & <span class="text-primary">What Families Get</span>
        </h1>
        <p class="text-white/70 font-semibold text-lg max-w-3xl mx-auto reveal leading-relaxed">
            TLab Clubs &middot; TLab Cohorts &middot; TLab Camps
        </p>
    </div>
</section>

<div class="max-w-7xl mx-auto py-16 px-4 sm:px-6 lg:px-8">

    {{-- Philosophy --}}
    <section class="mb-16">
        <h2 class="text-3xl font-black text-ink mb-6 reveal">Our Pricing Philosophy</h2>
        <p class="text-muted font-semibold leading-relaxed max-w-4xl reveal">
            TLab's pricing is deliberately set above the local market average in Abeokuta because quality costs, and parents who care deeply about their children's development understand that. We are not a &#8358;5,000-per-month computer class. We are a structured, premium development institution. However, we also offer flexible payment structures, sibling discounts, and scholarship options to ensure that access is not permanently out of reach for deserving families.
        </p>
    </section>

    {{-- Registration Fee --}}
    <section class="mb-16">
        <h2 class="text-2xl font-black text-ink mb-6 reveal">One-Time Registration / Membership Fee</h2>
        <p class="text-muted font-semibold mb-6 reveal">
            Every new member pays a one-time annual registration fee at the start of their membership. This fee is not a penalty; it is the investment that sets your child apart as a TLab member and gives them everything they need to show up on Day 1 ready to learn.
        </p>
        <div class="overflow-x-auto reveal">
            <table class="min-w-full divide-y divide-gray-200 border border-gray-200 rounded-xl">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-black text-ink uppercase tracking-wider">Membership Type</th>
                        <th class="px-6 py-4 text-left text-sm font-black text-ink uppercase tracking-wider">Fee</th>
                        <th class="px-6 py-4 text-left text-sm font-black text-ink uppercase tracking-wider">What Is Included in the Registration Fee</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr>
                        <td class="px-6 py-5 text-sm font-bold text-ink">New Member (First Child)</td>
                        <td class="px-6 py-5 text-sm font-black text-primary">&#8358;30,000</td>
                        <td class="px-6 py-5 text-sm text-muted">
                            <ul class="list-disc pl-5 space-y-1">
                                <li>Welcome Kit (branded folder, student ID card, Edfrica badge, Journal)</li>
                                <li>Personalized welcome letter from their assigned facilitator</li>
                                <li>Demo Day VIP family pass (for parent + child)</li>
                                <li>Student portal access for progress tracking</li>
                                <li>TLab Club T-shirt in their size</li>
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-6 py-5 text-sm font-bold text-ink">Second Child (Same Family)</td>
                        <td class="px-6 py-5 text-sm font-black text-primary">&#8358;55,000</td>
                        <td class="px-6 py-5 text-sm text-muted">
                            <ul class="list-disc pl-5 space-y-1">
                                <li>Same full welcome kit</li>
                                <li>10% sibling discount on registration</li>
                                <li>Sibling pairs are placed in sessions that allow parents one drop-off and one pick-up</li>
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-6 py-5 text-sm font-bold text-ink">Annual Renewal (Returning Member)</td>
                        <td class="px-6 py-5 text-sm font-black text-primary">&#8358;24,000</td>
                        <td class="px-6 py-5 text-sm text-muted">
                            <ul class="list-disc pl-5 space-y-1">
                                <li>Renewing members pay a reduced annual fee as a loyalty reward</li>
                                <li>Updated journal + badge for the new year</li>
                                <li>Returning member ceremony at the first Saturday of the new year</li>
                            </ul>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>

    {{-- Monthly Plans --}}
    <section class="mb-16">
        <h2 class="text-2xl font-black text-ink mb-2 reveal">Monthly Membership Plans: Three Tiers</h2>
        <p class="text-muted font-semibold mb-8 reveal">
            Parents choose a membership tier based on how many clubs they want their child to participate in. All tiers include the same quality of facilitation and the same Edfrica standards; the difference is simply how much of the weekly program the child accesses.
        </p>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Explorer --}}
            <div class="border border-gray-200 rounded-2xl p-8 shadow-sm bg-white reveal flex flex-col">
                <div class="text-xs font-black text-primary uppercase tracking-widest mb-1">EXPLORER</div>
                <h3 class="text-2xl font-black text-ink mb-1">1 Club Membership</h3>
                <div class="text-3xl font-black text-ink my-4">&#8358;30,000 <span class="text-sm font-bold text-muted">/ month</span></div>
                <p class="text-sm text-muted mb-6">+ &#8358;30,000 registration (one-time annual)</p>
                <ul class="space-y-2 text-sm text-muted flex-1">
                    <li class="flex items-start gap-2"><svg class="w-4 h-4 text-primary mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg> 1 Club of your choice (STEM, Arts and Craft, Brain Club, Public Speaking &amp; Leadership)</li>
                    <li class="flex items-start gap-2"><svg class="w-4 h-4 text-primary mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg> 4 Saturday sessions per month (90 minutes each)</li>
                    <li class="flex items-start gap-2"><svg class="w-4 h-4 text-primary mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg> Monthly written progress report (digital PDF)</li>
                    <li class="flex items-start gap-2"><svg class="w-4 h-4 text-primary mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg> Weekly WhatsApp photo update after every session</li>
                    <li class="flex items-start gap-2"><svg class="w-4 h-4 text-primary mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg> TLab journal and Edfrica activity cards</li>
                    <li class="flex items-start gap-2"><svg class="w-4 h-4 text-primary mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg> Access to all monthly mini-assessments</li>
                    <li class="flex items-start gap-2"><svg class="w-4 h-4 text-primary mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg> Annual Demo Day participation (4 per year)</li>
                    <li class="flex items-start gap-2"><svg class="w-4 h-4 text-primary mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg> Quarterly parent-facilitator check-in meeting</li>
                    <li class="flex items-start gap-2"><svg class="w-4 h-4 text-primary mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg> Student portal access to view progress online</li>
                    <li class="flex items-start gap-2"><svg class="w-4 h-4 text-primary mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg> 20% discount on all Holiday Camps</li>
                    <li class="flex items-start gap-2"><svg class="w-4 h-4 text-primary mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg> Birthday recognition at the Hub</li>
                    <li class="flex items-start gap-2"><svg class="w-4 h-4 text-primary mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg> One-on-one coaching session per term</li>
                    <li class="flex items-start gap-2"><svg class="w-4 h-4 text-primary mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg> Year-End Awards eligibility</li>
                    <li class="flex items-start gap-2"><svg class="w-4 h-4 text-primary mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg> Portfolio development support for University applications</li>
                    <li class="flex items-start gap-2"><svg class="w-4 h-4 text-primary mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg> Student portfolio management support</li>
                    <li class="flex items-start gap-2"><svg class="w-4 h-4 text-primary mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg> TLab Ambassador status after 6–8 months</li>
                </ul>
            </div>
            {{-- Builder --}}
            <div class="border-2 border-primary/30 rounded-2xl p-8 shadow-md bg-white reveal flex flex-col relative">
                <div class="absolute -top-3 right-6 bg-primary text-white text-xs font-black px-4 py-1 rounded-full">Save &#8358;6,000</div>
                <div class="text-xs font-black text-primary uppercase tracking-widest mb-1">BUILDER</div>
                <h3 class="text-2xl font-black text-ink mb-1">2 Club Membership</h3>
                <div class="text-3xl font-black text-ink my-4">&#8358;54,000 <span class="text-sm font-bold text-muted">/ month</span></div>
                <p class="text-sm text-muted mb-6">Save &#8358;6,000 vs two Explorer plans</p>
                <ul class="space-y-2 text-sm text-muted flex-1">
                    <li class="flex items-start gap-2"><svg class="w-4 h-4 text-primary mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg> 2 Clubs of your choice (any combination)</li>
                    <li class="flex items-start gap-2"><svg class="w-4 h-4 text-primary mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg> 4 Saturday sessions per month</li>
                    <li class="flex items-start gap-2"><svg class="w-4 h-4 text-primary mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg> Priority scheduling and seat reservation</li>
                    <li class="flex items-start gap-2"><svg class="w-4 h-4 text-primary mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg> Bi-monthly parent-facilitator progress meeting</li>
                    <li class="flex items-start gap-2"><svg class="w-4 h-4 text-primary mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg> Monthly written progress report (digital PDF)</li>
                    <li class="flex items-start gap-2"><svg class="w-4 h-4 text-primary mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg> Journal and branded portfolio folder</li>
                    <li class="flex items-start gap-2"><svg class="w-4 h-4 text-primary mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg> Weekly WhatsApp photo updates</li>
                    <li class="flex items-start gap-2"><svg class="w-4 h-4 text-primary mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg> Priority access to competitions and inter-school events</li>
                    <li class="flex items-start gap-2"><svg class="w-4 h-4 text-primary mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg> Annual Demo Day front-row family seating</li>
                    <li class="flex items-start gap-2"><svg class="w-4 h-4 text-primary mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg> Student portal access to view progress online</li>
                    <li class="flex items-start gap-2"><svg class="w-4 h-4 text-primary mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg> 30% discount on all Holiday Camps</li>
                    <li class="flex items-start gap-2"><svg class="w-4 h-4 text-primary mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg> Eligible for Edfrica Innovation Award (Band 4)</li>
                    <li class="flex items-start gap-2"><svg class="w-4 h-4 text-primary mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg> Featured in monthly Student Spotlight (social media)</li>
                    <li class="flex items-start gap-2"><svg class="w-4 h-4 text-primary mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg> Student portfolio management support</li>
                </ul>
            </div>
            {{-- All-Access --}}
            <div class="border border-gray-200 rounded-2xl p-8 shadow-sm bg-white reveal flex flex-col">
                <div class="text-xs font-black text-accent uppercase tracking-widest mb-1">ALL-ACCESS</div>
                <h3 class="text-2xl font-black text-ink mb-1">All Clubs Membership</h3>
                <div class="text-3xl font-black text-ink my-4">&#8358;120,000 <span class="text-sm font-bold text-muted">/ month</span></div>
                <p class="text-sm text-muted mb-6">The Complete TLab Experience</p>
                <ul class="space-y-2 text-sm text-muted flex-1">
                    <li class="flex items-start gap-2"><svg class="w-4 h-4 text-accent mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg> All 4 clubs have unlimited Saturday access (10:00am – 4:00pm)</li>
                    <li class="flex items-start gap-2"><svg class="w-4 h-4 text-accent mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg> Guaranteed seat in every session, every week</li>
                    <li class="flex items-start gap-2"><svg class="w-4 h-4 text-accent mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg> Comprehensive monthly report across all clubs</li>
                    <li class="flex items-start gap-2"><svg class="w-4 h-4 text-accent mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg> VIP family seating at all events and showcases</li>
                    <li class="flex items-start gap-2"><svg class="w-4 h-4 text-accent mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg> 50% discount on all Holiday Camps</li>
                    <li class="flex items-start gap-2"><svg class="w-4 h-4 text-accent mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg> Leadership Club mentoring sessions included</li>
                    <li class="flex items-start gap-2"><svg class="w-4 h-4 text-accent mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg> One-on-one coaching session per term</li>
                    <li class="flex items-start gap-2"><svg class="w-4 h-4 text-accent mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg> TLab Ambassador status after 6–8 months</li>
                </ul>
            </div>
        </div>
    </section>

    {{-- Termly & Annual Payment --}}
    <section class="mb-16">
        <h2 class="text-2xl font-black text-ink mb-6 reveal">Termly and Annual Payment Options</h2>
        <p class="text-muted font-semibold mb-6 reveal">
            We reward commitment. Families who pay for a full term or full year in advance receive a discount and the peace of mind that comes from not thinking about monthly payments.
        </p>
        <div class="overflow-x-auto reveal">
            <table class="min-w-full divide-y divide-gray-200 border border-gray-200 rounded-xl">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-black text-ink uppercase tracking-wider">Payment Cycle</th>
                        <th class="px-6 py-4 text-left text-sm font-black text-ink uppercase tracking-wider">Explorer</th>
                        <th class="px-6 py-4 text-left text-sm font-black text-ink uppercase tracking-wider">Builder</th>
                        <th class="px-6 py-4 text-left text-sm font-black text-ink uppercase tracking-wider">All-Access</th>
                        <th class="px-6 py-4 text-left text-sm font-black text-ink uppercase tracking-wider">Saving vs Monthly</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr>
                        <td class="px-6 py-5 text-sm font-bold text-ink">Monthly (standard)</td>
                        <td class="px-6 py-5 text-sm text-muted">&#8358;30,000/mo</td>
                        <td class="px-6 py-5 text-sm text-muted">&#8358;54,000/mo</td>
                        <td class="px-6 py-5 text-sm text-muted">&#8358;100,000/mo</td>
                        <td class="px-6 py-5 text-sm text-muted">—</td>
                    </tr>
                    <tr>
                        <td class="px-6 py-5 text-sm font-bold text-ink">Termly (3 months at once)</td>
                        <td class="px-6 py-5 text-sm text-muted">&#8358;82,800/term</td>
                        <td class="px-6 py-5 text-sm text-muted">&#8358;149,000/term</td>
                        <td class="px-6 py-5 text-sm text-muted">&#8358;331,000/term</td>
                        <td class="px-6 py-5 text-sm text-primary font-bold">Save approx. 7–8%</td>
                    </tr>
                    <tr>
                        <td class="px-6 py-5 text-sm font-bold text-ink">Annual (4 terms / full year)</td>
                        <td class="px-6 py-5 text-sm text-muted">&#8358;316,800/yr</td>
                        <td class="px-6 py-5 text-sm text-muted">&#8358;570,000/yr</td>
                        <td class="px-6 py-5 text-sm text-muted">&#8358;1,267,000/yr</td>
                        <td class="px-6 py-5 text-sm text-primary font-bold">Save approx. 11–13%</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>

    {{-- Discounts --}}
    <section class="mb-16">
        <h2 class="text-2xl font-black text-ink mb-6 reveal">Discounts and Special Access</h2>
        <div class="overflow-x-auto reveal">
            <table class="min-w-full divide-y divide-gray-200 border border-gray-200 rounded-xl">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-black text-ink uppercase tracking-wider">Discount Type</th>
                        <th class="px-6 py-4 text-left text-sm font-black text-ink uppercase tracking-wider">How It Works</th>
                        <th class="px-6 py-4 text-left text-sm font-black text-ink uppercase tracking-wider">Amount</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr>
                        <td class="px-6 py-5 text-sm font-bold text-ink">Sibling Discount</td>
                        <td class="px-6 py-5 text-sm text-muted">10% off monthly subscription for every additional child enrolled from the same family at the same time</td>
                        <td class="px-6 py-5 text-sm font-bold text-primary">10% per child</td>
                    </tr>
                    <tr>
                        <td class="px-6 py-5 text-sm font-bold text-ink">School Group Enrollment</td>
                        <td class="px-6 py-5 text-sm text-muted">When 5 or more children from the same school join together, each family gets a group discount</td>
                        <td class="px-6 py-5 text-sm font-bold text-primary">15% off monthly fee</td>
                    </tr>
                    <tr>
                        <td class="px-6 py-5 text-sm font-bold text-ink">Referral Credit</td>
                        <td class="px-6 py-5 text-sm text-muted">When you refer a friend and their child completes their first full month, you receive account credit</td>
                        <td class="px-6 py-5 text-sm font-bold text-primary">&#8358;10,000 credit</td>
                    </tr>
                    <tr>
                        <td class="px-6 py-5 text-sm font-bold text-ink">Scholarship Tier</td>
                        <td class="px-6 py-5 text-sm text-muted">5% of all enrollment slots are reserved for children who qualify by need and merit &mdash; screened each intake</td>
                        <td class="px-6 py-5 text-sm font-bold text-primary">50% subsidized fee</td>
                    </tr>
                    <tr>
                        <td class="px-6 py-5 text-sm font-bold text-ink">Corporate Family Plan</td>
                        <td class="px-6 py-5 text-sm text-muted">For companies whose employees want TLab memberships for their children &mdash; billed quarterly to employer</td>
                        <td class="px-6 py-5 text-sm font-bold text-primary">Explained below</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>

    {{-- Corporate Plan --}}
    <section class="mb-16">
        <h2 class="text-2xl font-black text-ink mb-2 reveal">The Corporate Family Plan</h2>
        <p class="text-muted font-semibold mb-6 reveal">Minimum enrollment: 5 children per company. Billed annually or quarterly.</p>
        <div class="overflow-x-auto reveal">
            <table class="min-w-full divide-y divide-gray-200 border border-gray-200 rounded-xl">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-black text-ink uppercase tracking-wider">Tier</th>
                        <th class="px-6 py-4 text-left text-sm font-black text-ink uppercase tracking-wider">Clubs Included</th>
                        <th class="px-6 py-4 text-left text-sm font-black text-ink uppercase tracking-wider">Annual Fee (per child)</th>
                        <th class="px-6 py-4 text-left text-sm font-black text-ink uppercase tracking-wider">Quarterly Billing</th>
                        <th class="px-6 py-4 text-left text-sm font-black text-ink uppercase tracking-wider">Value vs. Retail</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr>
                        <td class="px-6 py-5 text-sm font-bold text-ink">CORP EXPLORER</td>
                        <td class="px-6 py-5 text-sm text-muted">1 Club</td>
                        <td class="px-6 py-5 text-sm font-bold text-primary">&#8358;300,000</td>
                        <td class="px-6 py-5 text-sm text-muted">&#8358;75,000</td>
                        <td class="px-6 py-5 text-sm text-primary font-bold">~5% Discount</td>
                    </tr>
                    <tr>
                        <td class="px-6 py-5 text-sm font-bold text-ink">CORP BUILDER</td>
                        <td class="px-6 py-5 text-sm text-muted">2 Clubs</td>
                        <td class="px-6 py-5 text-sm font-bold text-primary">&#8358;540,000</td>
                        <td class="px-6 py-5 text-sm text-muted">&#8358;135,000</td>
                        <td class="px-6 py-5 text-sm text-primary font-bold">~7% Discount</td>
                    </tr>
                    <tr>
                        <td class="px-6 py-5 text-sm font-bold text-ink">CORP ALL-ACCESS</td>
                        <td class="px-6 py-5 text-sm text-muted">4 Clubs</td>
                        <td class="px-6 py-5 text-sm font-bold text-primary">&#8358;900,000</td>
                        <td class="px-6 py-5 text-sm text-muted">&#8358;225,000</td>
                        <td class="px-6 py-5 text-sm text-primary font-bold">~29% Discount</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>

    {{-- Techiecity --}}
    <section class="mb-16">
        <h2 class="text-2xl font-black text-ink mb-2 reveal">Techiecity</h2>
        <p class="text-muted font-semibold mb-6 reveal">Short-term, on-site cohort programmes for specialised tech skills.</p>
        <div class="overflow-x-auto reveal">
            <table class="min-w-full divide-y divide-gray-200 border border-gray-200 rounded-xl">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-black text-ink uppercase tracking-wider">Programme</th>
                        <th class="px-6 py-4 text-left text-sm font-black text-ink uppercase tracking-wider">Duration</th>
                        <th class="px-6 py-4 text-left text-sm font-black text-ink uppercase tracking-wider">Best For</th>
                        <th class="px-6 py-4 text-left text-sm font-black text-ink uppercase tracking-wider">Pricing</th>
                        <th class="px-6 py-4 text-left text-sm font-black text-ink uppercase tracking-wider">Format</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr><td class="px-6 py-5 text-sm font-bold text-ink">Web Development (Frontend) Basics</td><td class="px-6 py-5 text-sm text-muted">16 Weeks</td><td class="px-6 py-5 text-sm text-muted">Beginners, IT graduates, developers</td><td class="px-6 py-5 text-sm font-bold text-primary">&#8358;250,000</td><td class="px-6 py-5 text-sm text-muted">Cohort (On-site)</td></tr>
                    <tr><td class="px-6 py-5 text-sm font-bold text-ink">UI/UX Design</td><td class="px-6 py-5 text-sm text-muted">12 Weeks</td><td class="px-6 py-5 text-sm text-muted">Graduates, career-changers, design students</td><td class="px-6 py-5 text-sm font-bold text-primary">&#8358;180,000</td><td class="px-6 py-5 text-sm text-muted">Cohort (On-site)</td></tr>
                    <tr><td class="px-6 py-5 text-sm font-bold text-ink">Data Analytics</td><td class="px-6 py-5 text-sm text-muted">12 Weeks</td><td class="px-6 py-5 text-sm text-muted">Professionals, analysts, graduates</td><td class="px-6 py-5 text-sm font-bold text-primary">&#8358;200,000</td><td class="px-6 py-5 text-sm text-muted">Cohort (On-site)</td></tr>
                    <tr><td class="px-6 py-5 text-sm font-bold text-ink">Data Science</td><td class="px-6 py-5 text-sm text-muted">12 weeks</td><td class="px-6 py-5 text-sm text-muted">Professionals, analysts, graduates</td><td class="px-6 py-5 text-sm font-bold text-primary">&#8358;250,000</td><td class="px-6 py-5 text-sm text-muted">Cohort</td></tr>
                    <tr><td class="px-6 py-5 text-sm font-bold text-ink">Digital Marketing</td><td class="px-6 py-5 text-sm text-muted">8 Weeks</td><td class="px-6 py-5 text-sm text-muted">Business owners, marketing staff, freelancers</td><td class="px-6 py-5 text-sm font-bold text-primary">&#8358;120,000</td><td class="px-6 py-5 text-sm text-muted">Cohort</td></tr>
                    <tr><td class="px-6 py-5 text-sm font-bold text-ink">Graphic Design</td><td class="px-6 py-5 text-sm text-muted">8 Weeks</td><td class="px-6 py-5 text-sm text-muted">Creatives, side-income seekers, students</td><td class="px-6 py-5 text-sm font-bold text-primary">&#8358;120,000</td><td class="px-6 py-5 text-sm text-muted">Cohort</td></tr>
                    <tr><td class="px-6 py-5 text-sm font-bold text-ink">Product Management</td><td class="px-6 py-5 text-sm text-muted">10 Weeks</td><td class="px-6 py-5 text-sm text-muted">Team leads, career-changers, tech graduates</td><td class="px-6 py-5 text-sm font-bold text-primary">&#8358;160,000</td><td class="px-6 py-5 text-sm text-muted">Cohort</td></tr>
                    <tr><td class="px-6 py-5 text-sm font-bold text-ink">Video Editing</td><td class="px-6 py-5 text-sm text-muted">8 Weeks</td><td class="px-6 py-5 text-sm text-muted">Content creators, media students, influencers</td><td class="px-6 py-5 text-sm font-bold text-primary">&#8358;150,000</td><td class="px-6 py-5 text-sm text-muted">Cohort</td></tr>
                    <tr><td class="px-6 py-5 text-sm font-bold text-ink">Cloud Engineering</td><td class="px-6 py-5 text-sm text-muted">12 weeks</td><td class="px-6 py-5 text-sm text-muted">Prepares students for global remote jobs</td><td class="px-6 py-5 text-sm font-bold text-primary">&#8358;250,000</td><td class="px-6 py-5 text-sm text-muted">Cohort</td></tr>
                    <tr><td class="px-6 py-5 text-sm font-bold text-ink">Cybersecurity Foundations</td><td class="px-6 py-5 text-sm text-muted">8 weeks</td><td class="px-6 py-5 text-sm text-muted">Direct path to roles in Banks and Fintechs</td><td class="px-6 py-5 text-sm font-bold text-primary">&#8358;250,000</td><td class="px-6 py-5 text-sm text-muted">Cohort</td></tr>
                    <tr><td class="px-6 py-5 text-sm font-bold text-ink">IT Project Management</td><td class="px-6 py-5 text-sm text-muted">6 weeks</td><td class="px-6 py-5 text-sm text-muted">Essential for senior roles; the "bridge" between tech and business</td><td class="px-6 py-5 text-sm font-bold text-primary">&#8358;150,000</td><td class="px-6 py-5 text-sm text-muted">Cohort</td></tr>
                </tbody>
            </table>
        </div>
    </section>

    {{-- Short Courses --}}
    <section class="mb-16">
        <h2 class="text-2xl font-black text-ink mb-6 reveal">Short Courses</h2>
        <div class="overflow-x-auto reveal">
            <table class="min-w-full divide-y divide-gray-200 border border-gray-200 rounded-xl">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-black text-ink uppercase tracking-wider">Course</th>
                        <th class="px-6 py-4 text-left text-sm font-black text-ink uppercase tracking-wider">Duration</th>
                        <th class="px-6 py-4 text-left text-sm font-black text-ink uppercase tracking-wider">Best For</th>
                        <th class="px-6 py-4 text-left text-sm font-black text-ink uppercase tracking-wider">Pricing</th>
                        <th class="px-6 py-4 text-left text-sm font-black text-ink uppercase tracking-wider">Format</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr><td class="px-6 py-5 text-sm font-bold text-ink">Content Creation Bootcamp</td><td class="px-6 py-5 text-sm text-muted">4 Weeks</td><td class="px-6 py-5 text-sm text-muted">Aspiring full-time creators, influencers</td><td class="px-6 py-5 text-sm font-bold text-primary">&#8358;70,000</td><td class="px-6 py-5 text-sm text-muted">On-site</td></tr>
                    <tr><td class="px-6 py-5 text-sm font-bold text-ink">AI Tools for Business</td><td class="px-6 py-5 text-sm text-muted">3 Weeks</td><td class="px-6 py-5 text-sm text-muted">SME owners, managers, traders</td><td class="px-6 py-5 text-sm font-bold text-primary">&#8358;80,000</td><td class="px-6 py-5 text-sm text-muted">On-site</td></tr>
                    <tr><td class="px-6 py-5 text-sm font-bold text-ink">AI Prompt Engineering</td><td class="px-6 py-5 text-sm text-muted">2 weeks</td><td class="px-6 py-5 text-sm text-muted">Immediate productivity boost for any office worker</td><td class="px-6 py-5 text-sm font-bold text-primary">&#8358;15,000</td><td class="px-6 py-5 text-sm text-muted">—</td></tr>
                    <tr><td class="px-6 py-5 text-sm font-bold text-ink">Digital Marketing for SMEs</td><td class="px-6 py-5 text-sm text-muted">3 Weeks</td><td class="px-6 py-5 text-sm text-muted">Market traders, shop owners, small businesses</td><td class="px-6 py-5 text-sm font-bold text-primary">&#8358;80,000</td><td class="px-6 py-5 text-sm text-muted">On-site</td></tr>
                    <tr><td class="px-6 py-5 text-sm font-bold text-ink">No-Code App Development</td><td class="px-6 py-5 text-sm text-muted">4 weeks</td><td class="px-6 py-5 text-sm text-muted">Entrepreneurs wanting to build MVPs without coding</td><td class="px-6 py-5 text-sm font-bold text-primary">&#8358;80,000</td><td class="px-6 py-5 text-sm text-muted">—</td></tr>
                    <tr><td class="px-6 py-5 text-sm font-bold text-ink">Motion Graphics for Social Media</td><td class="px-6 py-5 text-sm text-muted">5 Weeks</td><td class="px-6 py-5 text-sm text-muted">Graphic designers looking to level up into animation</td><td class="px-6 py-5 text-sm font-bold text-primary">&#8358;70,000</td><td class="px-6 py-5 text-sm text-muted">—</td></tr>
                    <tr><td class="px-6 py-5 text-sm font-bold text-ink">Technical Writing</td><td class="px-6 py-5 text-sm text-muted">4 Weeks</td><td class="px-6 py-5 text-sm text-muted">Writers looking to enter the tech industry</td><td class="px-6 py-5 text-sm font-bold text-primary">&#8358;50,000</td><td class="px-6 py-5 text-sm text-muted">—</td></tr>
                    <tr><td class="px-6 py-5 text-sm font-bold text-ink">Customer Success &amp; CRM</td><td class="px-6 py-5 text-sm text-muted">4 weeks</td><td class="px-6 py-5 text-sm text-muted">Front-desk staff, sales reps, and customer support</td><td class="px-6 py-5 text-sm font-bold text-primary">&#8358;50,000</td><td class="px-6 py-5 text-sm text-muted">—</td></tr>
                </tbody>
            </table>
        </div>
    </section>

</div>

@include('partials.footer')

@endsection
