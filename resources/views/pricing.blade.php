@extends('layouts.app')

@section('title', 'Pricing')

@section('content')
<div class="max-w-5xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
  <h1 class="text-4xl font-extrabold text-center text-ink mb-8">TLab Pricing</h1>

  <section class="mb-12">
    <h2 class="text-2xl font-bold text-primary mb-4">Our Pricing Philosophy</h2>
    <p class="text-muted mb-4">
      Tlab's pricing is deliberately set above the local market average in Abeokuta because quality costs, and parents who care deeply about their children's development understand that. We are not a ₦5,000‑per‑month computer class. We are a structured, premium development institution. However, we also offer flexible payment structures, sibling discounts, and scholarship options to ensure that access is not permanently out of reach for deserving families.
    </p>
  </section>

  <section class="mb-12">
    <h2 class="text-2xl font-bold text-primary mb-4">One‑Time Registration / Membership Fee</h2>
    <table class="min-w-full divide-y divide-gray-200">
      <thead class="bg-gray-50">
        <tr>
          <th class="px-6 py-3 text-left text-sm font-medium text-ink uppercase tracking-wider">Membership Type</th>
          <th class="px-6 py-3 text-left text-sm font-medium text-ink uppercase tracking-wider">Fee</th>
          <th class="px-6 py-3 text-left text-sm font-medium text-ink uppercase tracking-wider">What Is Included</th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-gray-200">
        <tr>
          <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-ink">New Member (First Child)</td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-primary">₦30,000</td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-muted">
            <ul class="list-disc pl-5 space-y-1">
              <li>Welcome Kit (branded folder, student ID card, Edfrica badge, Journal)</li>
              <li>Personalized welcome letter from assigned facilitator</li>
              <li>Demo Day VIP family pass (parent + child)</li>
              <li>Student portal access for progress tracking</li>
              <li>TLab Club T‑shirt in their size</li>
            </ul>
          </td>
        </tr>
        <tr>
          <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-ink">Second Child (Same Family)</td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-primary">₦55,000</td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-muted">
            Same full welcome kit • 10 % sibling discount on registration • Sibling pairs placed in sessions for single drop‑off/pick‑up
          </td>
        </tr>
        <tr>
          <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-ink">Annual Renewal (Returning Member)</td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-primary">₦24,000</td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-muted">
            Reduced annual fee as loyalty reward • Updated journal + badge for new year • Returning‑member ceremony on first Saturday of the year
          </td>
        </tr>
      </tbody>
    </table>
  </section>

  <section class="mb-12">
    <h2 class="text-2xl font-bold text-primary mb-4">Monthly Membership Plans – Three Tiers</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <!-- Explorer -->
      <div class="border border-gray-200 rounded-xl p-6 shadow-sm">
        <h3 class="text-xl font-semibold text-primary mb-2">EXPLORER</h3>
        <p class="text-muted mb-2">1 Club Membership</p>
        <p class="text-2xl font-bold text-ink mb-2">₦30,000 / month</p>
        <p class="text-sm text-muted mb-4">+ ₦30,000 registration (one‑time annual)</p>
        <ul class="list-disc pl-5 space-y-1 text-sm text-muted">
          <li>1 Club of your choice</li>
          <li>4 Saturday sessions per month (90 min each)</li>
          <li>Monthly progress PDF</li>
          <li>WhatsApp photo update after every session</li>
        </ul>
      </div>
      <!-- Builder -->
      <div class="border border-gray-200 rounded-xl p-6 shadow-sm">
        <h3 class="text-xl font-semibold text-primary mb-2">BUILDER</h3>
        <p class="text-muted mb-2">2 Club Membership</p>
        <p class="text-2xl font-bold text-ink mb-2">₦54,000 / month</p>
        <p class="text-sm text-muted mb-4">Save ₦6,000 vs two Explorer plans</p>
        <ul class="list-disc pl-5 space-y-1 text-sm text-muted">
          <li>Any 2 clubs (any combination)</li>
          <li>All 4 clubs unlimited Saturday access</li>
          <li>Comprehensive monthly report</li>
          <li>Bi‑monthly parent‑facilitator meeting</li>
        </ul>
      </div>
      <!-- All‑Access -->
      <div class="border border-gray-200 rounded-xl p-6 shadow-sm">
        <h3 class="text-xl font-semibold text-primary mb-2">ALL‑ACCESS</h3>
        <p class="text-muted mb-2">All Clubs Membership</p>
        <p class="text-2xl font-bold text-ink mb-2">₦120,000 / month</p>
        <p class="text-sm text-muted mb-4">The Complete Tlab Experience</p>
        <ul class="list-disc pl-5 space-y-1 text-sm text-muted">
          <li>All 4 clubs (STEM, Arts, Brain, Public Speaking & Leadership)</li>
          <li>Unlimited Saturday sessions</li>
          <li>VIP family seating at events</li>
          <li>50 % discount on all Holiday Camps</li>
          <li>Leadership Club mentoring sessions</li>
          <li>Annual Demo Day front‑row family seating</li>
          <li>Featured in monthly Student Spotlight</li>
        </ul>
      </div>
    </div>
  </section>

  <section class="mb-12">
    <h2 class="text-2xl font-bold text-primary mb-4">Termly & Annual Payment Options</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-center">
      <div class="p-4 border rounded">
        <h4 class="font-semibold text-primary mb-2">Monthly (standard)</h4>
        <p class="text-ink">Explorer – ₦30,000/mo</p>
        <p class="text-ink">Builder – ₦54,000/mo</p>
        <p class="text-ink">All‑Access – ₦100,000/mo</p>
      </div>
      <div class="p-4 border rounded">
        <h4 class="font-semibold text-primary mb-2">Termly (3 months)</h4>
        <p class="text-ink">Explorer – ₦82,800/term</p>
        <p class="text-ink">Builder – ₦149,000/term</p>
        <p class="text-ink">All‑Access – ₦331,000/term</p>
        <p class="text-sm text-muted">Save approx. 7‑8 %</p>
      </div>
      <div class="p-4 border rounded">
        <h4 class="font-semibold text-primary mb-2">Annual (4 terms)</h4>
        <p class="text-ink">Explorer – ₦316,800/yr</p>
        <p class="text-ink">Builder – ₦570,000/yr</p>
        <p class="text-ink">All‑Access – ₦1,267,000/yr</p>
        <p class="text-sm text-muted">Save approx. 11‑13 %</p>
      </div>
    </div>
  </section>

  <section class="mb-12">
    <h2 class="text-2xl font-bold text-primary mb-4">Discounts & Special Access</h2>
    <table class="min-w-full divide-y divide-gray-200">
      <thead class="bg-gray-50">
        <tr>
          <th class="px-6 py-3 text-left text-sm font-medium text-ink uppercase tracking-wider">Discount Type</th>
          <th class="px-6 py-3 text-left text-sm font-medium text-ink uppercase tracking-wider">How It Works</th>
          <th class="px-6 py-3 text-left text-sm font-medium text-ink uppercase tracking-wider">Amount</th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-gray-200">
        <tr>
          <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-ink">Sibling Discount</td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-muted">10 % off monthly subscription for every additional child enrolled from the same family at the same time</td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-primary">10 % per child</td>
        </tr>
        <tr>
          <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-ink">School Group Enrollment</td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-muted">When 5 or more children from the same school join together, each family gets a group discount</td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-primary">15 % off monthly fee</td>
        </tr>
        <tr>
          <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-ink">Referral Credit</td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-muted">When you refer a friend and their child completes their first full month, you receive account credit</td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-primary">₦10,000 credit</td>
        </tr>
        <tr>
          <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-ink">Scholarship Tier</td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-muted">5 % of all enrollment slots are reserved for children who qualify by need and merit screened each intake</td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-primary">50 % subsidized fee</td>
        </tr>
        <tr>
          <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-ink">Corporate Family Plan</td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-muted">Minimum enrollment: 5 children per company. Billed annually or quarterly.</td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-primary">See tiers below</td>
        </tr>
      </tbody>
    </table>
  </section>

  <section class="mb-12">
    <h2 class="text-2xl font-bold text-primary mb-4">Corporate Family Plan</h2>
    <table class="min-w-full divide-y divide-gray-200">
      <thead class="bg-gray-50">
        <tr>
          <th class="px-6 py-3 text-left text-sm font-medium text-ink uppercase tracking-wider">Tier</th>
          <th class="px-6 py-3 text-left text-sm font-medium text-ink uppercase tracking-wider">Clubs Included</th>
          <th class="px-6 py-3 text-left text-sm font-medium text-ink uppercase tracking-wider">Annual Fee (per child)</th>
          <th class="px-6 py-3 text-left text-sm font-medium text-ink uppercase tracking-wider">Quarterly Billing</th>
          <th class="px-6 py-3 text-left text-sm font-medium text-ink uppercase tracking-wider">Value vs. Retail</th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-gray-200">
        <tr>
          <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-ink">CORP EXPLORER</td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-muted">1 Club</td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-primary">₦300,000</td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-primary">₦75,000</td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-muted">~5 % Discount</td>
        </tr>
        <tr>
          <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-ink">CORP BUILDER</td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-muted">2 Clubs</td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-primary">₦540,000</td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-primary">₦135,000</td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-muted">~7 % Discount</td>
        </tr>
        <tr>
          <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-ink">CORP ALL‑ACCESS</td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-muted">4 Clubs</td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-primary">₦900,000</td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-primary">₦225,000</td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-muted">~29 % Discount</td>
        </tr>
      </tbody>
    </table>
  </section>

  <section class="mb-12">
    <h2 class="text-2xl font-bold text-primary mb-4">Techiecity Programme</h2>
    <p class="text-muted mb-4">Short‑term, on‑site cohort programmes for specialised tech skills.</p>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <div class="border border-gray-200 rounded p-4">
        <h3 class="font-semibold text-primary mb-2">Web Development (Frontend) – Basics</h3>
        <p class="text-sm text-muted">Duration: 16 Weeks</p>
        <p class="text-sm text-muted">Best For: Beginners, IT graduates, developers</p>
        <p class="text-sm text-primary">Pricing: ₦250,000 (Cohort – On‑site)</p>
      </div>
      <div class="border border-gray-200 rounded p-4">
        <h3 class="font-semibold text-primary mb-2">UI/UX Design</h3>
        <p class="text-sm text-muted">Duration: 12 Weeks</p>
        <p class="text-sm text-muted">Best For: Graduates, career‑changers, design students</p>
        <p class="text-sm text-primary">Pricing: ₦180,000 (Cohort – On‑site)</p>
      </div>
      <div class="border border-gray-200 rounded p-4">
        <h3 class="font-semibold text-primary mb-2">Data Analytics</h3>
        <p class="text-sm text-muted">Duration: 12 Weeks</p>
        <p class="text-sm text-muted">Best For: Professionals, analysts, graduates</p>
        <p class="text-sm text-primary">Pricing: ₦200,000 (Cohort – On‑site)</p>
      </div>
      <div class="border border-gray-200 rounded p-4">
        <h3 class="font-semibold text-primary mb-2">Data Science</h3>
        <p class="text-sm text-muted">Duration: 12 Weeks</p>
        <p class="text-sm text-muted">Best For: Professionals, analysts, graduates</p>
        <p class="text-sm text-primary">Pricing: ₦250,000 (Cohort – On‑site)</p>
      </div>
      <!-- Add more programme cards as needed -->
    </div>
  </section>

  <section class="mb-12">
    <h2 class="text-2xl font-bold text-primary mb-4">Short Courses</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <div class="border border-gray-200 rounded p-4">
        <h3 class="font-semibold text-primary mb-2">Content Creation Bootcamp</h3>
        <p class="text-sm text-muted">Duration: 4 Weeks</p>
        <p class="text-sm text-muted">Audience: Aspiring full‑time creators, influencers</p>
        <p class="text-sm text-primary">Pricing: ₦70,000 (On‑site)</p>
      </div>
      <div class="border border-gray-200 rounded p-4">
        <h3 class="font-semibold text-primary mb-2">AI Tools for Business</h3>
        <p class="text-sm text-muted">Duration: 3 Weeks</p>
        <p class="text-sm text-muted">Audience: SME owners, managers, traders</p>
        <p class="text-sm text-primary">Pricing: ₦80,000 (On‑site)</p>
      </div>
      <div class="border border-gray-200 rounded p-4">
        <h3 class="font-semibold text-primary mb-2">AI Prompt Engineering</h3>
        <p class="text-sm text-muted">Duration: 2 Weeks</p>
        <p class="text-sm text-muted">Audience: Immediate productivity boost for any office worker</p>
        <p class="text-sm text-primary">Pricing: ₦15,000</p>
      </div>
      <div class="border border-gray-200 rounded p-4">
        <h3 class="font-semibold text-primary mb-2">Digital Marketing for SMEs</h3>
        <p class="text-sm text-muted">Duration: 3 Weeks</p>
        <p class="text-sm text-muted">Audience: Market traders, shop owners, small businesses</p>
        <p class="text-sm text-primary">Pricing: ₦80,000 (On‑site)</p>
      </div>
      <!-- Add other short‑course cards similarly -->
    </div>
  </section>

</div>
@endsection
