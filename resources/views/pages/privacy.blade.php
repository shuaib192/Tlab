@extends('layouts.app')
@section('title', 'Privacy Policy')
@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <h1 class="font-black text-3xl text-ink mb-8">Privacy Policy</h1>
    <div class="prose prose-sm max-w-none text-muted space-y-6">
        <p class="font-semibold">Last Updated: June 2026</p>

        <h2 class="text-ink font-black text-xl mt-8">1. Introduction</h2>
        <p>TLab by Edfrica ("we," "our," or "us") is committed to protecting the privacy of children and their families. This Privacy Policy explains how we collect, use, and safeguard personal information in compliance with:</p>
        <ul class="list-disc pl-6 space-y-1">
            <li><strong>COPPA</strong> (Children's Online Privacy Protection Act)</li>
            <li><strong>GDPR-K</strong> (General Data Protection Regulation for children)</li>
            <li><strong>NDPR</strong> (Nigeria Data Protection Regulation)</li>
        </ul>

        <h2 class="text-ink font-black text-xl mt-8">2. Information We Collect</h2>
        <p><strong>From Parents:</strong> Name, email address, phone number, payment information.</p>
        <p><strong>From Children:</strong> Name, username, date of birth (for age verification and learning personalization), gender (optional), learning interests and progress, XP and rankings, submitted projects and assessment results.</p>
        <p><strong>Automatically Collected:</strong> Device information, browser type, IP address, usage patterns (for service improvement).</p>

        <h2 class="text-ink font-black text-xl mt-8">3. How We Use Information</h2>
        <ul class="list-disc pl-6 space-y-1">
            <li>To provide and improve our educational services</li>
            <li>To personalize learning experiences</li>
            <li>To communicate with parents about their child's progress</li>
            <li>To process payments and manage subscriptions</li>
            <li>To ensure platform safety and security</li>
            <li>To comply with legal obligations</li>
        </ul>

        <h2 class="text-ink font-black text-xl mt-8">4. Parental Controls & Consent</h2>
        <p>Parents have full control over their child's data:</p>
        <ul class="list-disc pl-6 space-y-1">
            <li>Review and export your child's data at any time</li>
            <li>Request deletion of your child's data</li>
            <li>Manage consent preferences</li>
            <li>Control which courses and features your child can access</li>
            <li>Opt out of data collection for non-essential purposes</li>
        </ul>

        <h2 class="text-ink font-black text-xl mt-8">5. Data Security</h2>
        <p>We implement industry-standard security measures including:</p>
        <ul class="list-disc pl-6 space-y-1">
            <li>Encryption of data in transit (TLS/SSL) and at rest</li>
            <li>Secure authentication via OAuth2</li>
            <li>Regular security audits and penetration testing</li>
            <li>Access controls and audit logging</li>
            <li>Child-safe architecture with no peer-to-peer messaging</li>
        </ul>

        <h2 class="text-ink font-black text-xl mt-8">6. Data Retention</h2>
        <p>We retain personal data only as long as necessary to provide services. Child activity data older than 12 months is archived. Accounts inactive for 2+ years are flagged for deletion. Parents may request earlier deletion at any time.</p>

        <h2 class="text-ink font-black text-xl mt-8">7. Third-Party Services</h2>
        <p>We use the following third-party services, each with their own privacy policies:</p>
        <ul class="list-disc pl-6 space-y-1">
            <li>Paystack (payment processing)</li>
            <li>Cloudflare Stream / Vimeo (video hosting)</li>
            <li>Edfrica Auth Server (authentication)</li>
        </ul>

        <h2 class="text-ink font-black text-xl mt-8">8. Contact Us</h2>
        <p>For privacy-related inquiries or to exercise your data rights, contact:<br>
        <strong>Email:</strong> privacy@tlab.edfrica.org<br>
        <strong>Address:</strong> Edfrica Innovation Hub, adjacent Revd Kuti School, Nawairudeen Road, Isabo, Abeokuta, Ogun State</p>
    </div>
</div>
@endsection
