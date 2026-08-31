@extends('layouts.app')
@section('title', 'Parental Consent')
@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <h1 class="font-black text-3xl text-ink mb-8">Parental Consent</h1>

    @if(session('success'))
    <div class="px-5 py-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-700 font-bold text-sm mb-8">{{ session('success') }}</div>
    @endif

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8 mb-8">
        <h2 class="font-black text-xl text-ink mb-4">Why We Need Your Consent</h2>
        <p class="text-muted font-semibold text-sm leading-relaxed">In compliance with COPPA (Children's Online Privacy Protection Act) and GDPR-K, we require verifiable parental consent before collecting personal information from children under the age of 13. This consent allows us to create a personalized, safe learning experience for your child.</p>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8 mb-8">
        <h2 class="font-black text-xl text-ink mb-4">What We Collect With Your Consent</h2>
        <ul class="space-y-3">
            <li class="flex items-start gap-3">
                <svg class="w-5 h-5 text-primary flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span class="text-sm text-muted font-semibold">Child's name and date of birth (for age-appropriate learning)</span>
            </li>
            <li class="flex items-start gap-3">
                <svg class="w-5 h-5 text-primary flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span class="text-sm text-muted font-semibold">Learning progress, assessment results, and XP data</span>
            </li>
            <li class="flex items-start gap-3">
                <svg class="w-5 h-5 text-primary flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span class="text-sm text-muted font-semibold">Submitted projects and assignment work</span>
            </li>
            <li class="flex items-start gap-3">
                <svg class="w-5 h-5 text-primary flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span class="text-sm text-muted font-semibold">Platform usage data for service improvement</span>
            </li>
        </ul>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8">
        <h2 class="font-black text-xl text-ink mb-4">Your Rights</h2>
        <p class="text-muted font-semibold text-sm mb-4">You have the right to:</p>
        <ul class="space-y-2 mb-6">
            <li class="flex items-start gap-3 text-sm text-muted"><span class="w-1.5 h-1.5 rounded-full bg-primary flex-shrink-0 mt-2"></span> Review the personal information we have collected</li>
            <li class="flex items-start gap-3 text-sm text-muted"><span class="w-1.5 h-1.5 rounded-full bg-primary flex-shrink-0 mt-2"></span> Withdraw your consent at any time</li>
            <li class="flex items-start gap-3 text-sm text-muted"><span class="w-1.5 h-1.5 rounded-full bg-primary flex-shrink-0 mt-2"></span> Request deletion of your child's data</li>
            <li class="flex items-start gap-3 text-sm text-muted"><span class="w-1.5 h-1.5 rounded-full bg-primary flex-shrink-0 mt-2"></span> Opt out of non-essential data collection</li>
        </ul>
        <p class="text-sm text-muted font-semibold">To exercise any of these rights, contact us at <strong class="text-primary">privacy@tlab.edfrica.org</strong> or visit your parent dashboard.</p>
    </div>
</div>
@endsection
