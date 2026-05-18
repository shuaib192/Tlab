@extends('layouts.app')
@section('title', 'Contact Us')

@section('content')

@include('partials.nav')

{{-- Hero Section --}}
<section class="relative pt-36 pb-20 bg-ink overflow-hidden">
    <div class="absolute inset-0 z-0">
        <div class="absolute inset-0 bg-gradient-to-br from-green-950/40 via-ink to-indigo-950/40"></div>
        <div class="absolute top-1/4 right-0 w-80 h-80 rounded-full blur-[100px] opacity-25" style="background:#16A34A"></div>
        <div class="absolute bottom-1/4 left-0 w-80 h-80 rounded-full blur-[100px] opacity-20" style="background:#7C3AED"></div>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
        <span class="inline-block bg-primary/10 text-primary text-xs font-black uppercase tracking-widest px-5 py-2 rounded-full mb-6 reveal">Get in Touch</span>
        <h1 class="font-black text-5xl sm:text-6xl lg:text-7xl text-white mb-6 leading-tight reveal">
            We'd Love to <span class="text-primary">Hear from You</span>
        </h1>
        <p class="text-white/70 font-semibold text-lg max-w-2xl mx-auto reveal leading-relaxed">
            Questions about curriculums, pricing, or local sessions? Shoot us a message or give us a call.
        </p>
    </div>
</section>

{{-- Contact Form + Info --}}
<section class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">

            {{-- Contact Information --}}
            <div class="space-y-6">
                <div class="tcard p-8 bg-surface border border-gray-100 reveal">
                    <h3 class="font-black text-2xl text-ink mb-8">Contact Information</h3>
                    <div class="space-y-6">

                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <div>
                                <div class="text-muted text-[0.62rem] font-black uppercase tracking-wider">Office Address</div>
                                <div class="font-semibold text-xs text-ink mt-0.5 leading-relaxed">12 Joel Ogunnaike St, Gbagada Phase 2, Lagos, Nigeria</div>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl bg-violet/10 flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-violet" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                            </div>
                            <div>
                                <div class="text-muted text-[0.62rem] font-black uppercase tracking-wider">Phone Lines</div>
                                <div class="font-semibold text-xs text-ink mt-0.5 leading-relaxed">+234 (0) 803 123 4567<br>+234 (0) 805 987 6543</div>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl bg-accent/10 flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div>
                                <div class="text-muted text-[0.62rem] font-black uppercase tracking-wider">Email Support</div>
                                <div class="font-semibold text-xs text-ink mt-0.5 leading-relaxed">admissions@tlab.ng<br>support@edfrica.org</div>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl bg-green-50 flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-primary" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12.031 0C5.385 0 0 5.386 0 12.034c0 2.128.555 4.195 1.61 6.01L.027 24l6.096-1.597A11.967 11.967 0 0 0 12.031 24c6.645 0 12.03-5.385 12.03-12.034C24.062 5.386 18.677 0 12.031 0zm5.503 16.479c-.302-.151-1.787-.883-2.062-.983-.276-.101-.477-.151-.678.15-.201.302-.779.983-.954 1.185-.176.201-.352.226-.653.075-2.228-1.116-3.557-2.315-4.9-4.603-.176-.302-.019-.465.132-.615.136-.136.302-.352.453-.528.151-.176.201-.302.302-.503.1-.201.05-.377-.025-.528-.076-.151-.678-1.633-.929-2.235-.245-.588-.494-.508-.678-.518-.175-.008-.376-.008-.577-.008-.2 0-.528.075-.804.377-1.055 1.029-1.055 2.512 0 3.115 1.08 2.913 1.231 3.114.151.201 2.125 3.24 5.143 4.544.718.31 1.278.495 1.716.634.721.228 1.378.196 1.895.118.577-.086 1.787-.73 2.038-1.436.251-.706.251-1.308.176-1.437-.075-.125-.276-.2-.577-.351z"/>
                                </svg>
                            </div>
                            <div>
                                <div class="text-muted text-[0.62rem] font-black uppercase tracking-wider">WhatsApp</div>
                                <a href="https://wa.me/2348031234567" target="_blank" class="font-semibold text-xs text-primary hover:underline mt-0.5 leading-relaxed block">Chat with Admissions</a>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="tcard p-6 bg-surface border border-gray-100 reveal" data-delay="80">
                    <h4 class="font-black text-sm text-ink mb-2">Office Hours</h4>
                    <p class="text-muted font-semibold text-xs leading-relaxed">Monday – Friday: 8am – 6pm<br>Saturday: 9am – 3pm<br>Sunday: Closed</p>
                </div>
            </div>

            {{-- Message Form --}}
            <div class="lg:col-span-2">
                <div class="tcard p-8 sm:p-10 border border-gray-100 reveal" data-delay="100">
                    <h3 class="font-black text-2xl text-ink mb-6">Send Us a Message</h3>

                    @if(session('success'))
                        <div class="flash flash-success mb-6">{{ session('success') }}</div>
                    @endif
                    @if($errors->any())
                        <div class="flash flash-error mb-6">@foreach($errors->all() as $err)<p>{{ $err }}</p>@endforeach</div>
                    @endif

                    <form method="POST" action="{{ route('contact.submit') }}" class="space-y-6">
                        @csrf
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" name="name" id="name" required class="form-input" placeholder="Your name" value="{{ old('name') }}">
                            </div>
                            <div>
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" name="email" id="email" required class="form-input" placeholder="email@domain.com" value="{{ old('email') }}">
                            </div>
                        </div>
                        <div>
                            <label for="subject" class="form-label">Subject</label>
                            <input type="text" name="subject" id="subject" required class="form-input" placeholder="How can we help you?" value="{{ old('subject') }}">
                        </div>
                        <div>
                            <label for="message" class="form-label">Your Message</label>
                            <textarea name="message" id="message" rows="6" required class="form-input py-4 resize-none" placeholder="Describe your question or request in detail...">{{ old('message') }}</textarea>
                        </div>
                        <button type="submit" class="btn-submit !py-4">
                            Send Message
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</section>

@include('partials.footer')

@endsection
