@extends('layouts.app')
@section('title', 'Home')

@section('content')

{{-- FLOATING NAVBAR --}}
@include('partials.nav')

{{-- HERO --}}
<section class="relative min-h-[92vh] flex items-center pt-24 overflow-hidden bg-ink">
    <div class="absolute inset-0 z-0">
        <img src="/Tlab/public/images/hero-bg.png"
             alt="African children learning robotics" class="w-full h-full object-cover opacity-25"
             onload="this.classList.remove('opacity-0')" onerror="this.style.display='none'">
        <div class="absolute inset-0" style="background:linear-gradient(100deg,#0F172A 45%,rgba(15,23,42,0.6) 75%,transparent 100%)"></div>
    </div>
    <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12 relative z-10 w-full py-24">
        <div class="max-w-2xl">
            @if(isset($slides) && $slides->count() > 0)
                {{-- Floating Interactive Announcement Carousel --}}
                <div class="mb-8 relative z-20 reveal max-w-md">
                    <div class="relative overflow-hidden rounded-2xl border border-white/10 bg-white/5 backdrop-blur-md p-4 pr-12">
                        @foreach($slides as $index => $slide)
                            <div class="slide-item {{ $index === 0 ? 'block' : 'hidden' }} transition-opacity duration-500" data-index="{{ $index }}">
                                <div class="flex items-center gap-3.5">
                                    @if($slide->image)
                                        <img src="{{ $slide->image }}" class="w-12 h-12 rounded-xl object-cover flex-shrink-0 border border-white/10">
                                    @elseif($slide->bg_color)
                                        <div class="w-12 h-12 rounded-xl flex-shrink-0 border border-white/10" style="background:{{ $slide->bg_color }}"></div>
                                    @endif
                                    <div class="min-w-0">
                                        <span class="text-[9px] font-black uppercase tracking-widest text-mint px-2 py-0.5 rounded bg-mint/10 border border-mint/20">Announcements</span>
                                        <h4 class="text-xs font-bold text-white mt-1 truncate">{{ $slide->title }}</h4>
                                        @if($slide->body)
                                            <p class="text-[11px] text-white/60 line-clamp-1 mt-0.5">{{ $slide->body }}</p>
                                        @endif
                                        @if($slide->link)
                                            <a href="{{ $slide->link }}" class="inline-flex items-center gap-1 text-[11px] font-bold text-mint hover:underline mt-1">
                                                {{ $slide->link_text ?? 'Learn More' }}
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        
                        @if($slides->count() > 1)
                            <button onclick="nextSlide()" class="absolute right-3 top-1/2 -translate-y-1/2 w-7 h-7 rounded-lg bg-white/5 hover:bg-white/10 flex items-center justify-center text-white/60 hover:text-white transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                            </button>
                        @endif
                    </div>
                </div>
                
                @if($slides->count() > 1)
                <script>
                    let currentSlide = 0;
                    const slides = document.querySelectorAll('.slide-item');
                    function nextSlide() {
                        slides[currentSlide].classList.add('hidden');
                        slides[currentSlide].classList.remove('block');
                        currentSlide = (currentSlide + 1) % slides.length;
                        slides[currentSlide].classList.remove('hidden');
                        slides[currentSlide].classList.add('block');
                    }
                    setInterval(nextSlide, 6000);
                </script>
                @endif
            @endif

            <div class="section-tag text-primary mb-5 reveal">Africa's Leading STEM Platform for Kids</div>
            <h1 class="font-black text-6xl sm:text-7xl lg:text-8xl text-white leading-[1.08] mb-6 reveal">
                Where Kids<br>
                <span style="color:#4ade80">Learn</span>,<br>
                <span style="color:#60a5fa">Build</span> &amp;<br>
                <span style="color:#c084fc">Lead</span>.
            </h1>
            <p class="text-white/70 font-semibold text-lg leading-relaxed mb-10 max-w-xl reveal">
                A safe, parent-controlled, gamified STEM ecosystem for children aged 3–15.
                Robotics, coding, creative arts and leadership — all through play.
            </p>
            <div class="flex flex-wrap gap-4 reveal">
                <a href="{{ route('register') }}" class="btn-hero">
                    Enrol Your Child Free
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                </a>
                <a href="{{ route('clubs') }}" class="btn-outline !border-white/30 !text-white hover:!border-white hover:!text-white">Explore Clubs</a>
            </div>
            <div class="flex flex-wrap gap-3 mt-10 reveal">
                @foreach(['4 Clubs','Ages 3–15','Parent Dashboard','COPPA Safe','Gamified Learning'] as $t)
                <span class="text-xs font-bold text-white/60 border border-white/20 px-4 py-2 rounded-full">{{ $t }}</span>
                @endforeach
            </div>
        </div>
    </div>
    <a href="https://wa.me/2348031234567" target="_blank"
       class="fixed bottom-8 right-6 z-50 flex items-center gap-3 text-white px-5 py-3 rounded-full shadow-2xl"
       style="background:#25D366">
        <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 0C5.385 0 0 5.386 0 12.034c0 2.128.555 4.195 1.61 6.01L.027 24l6.096-1.597A11.967 11.967 0 0 0 12.031 24c6.645 0 12.03-5.385 12.03-12.034C24.062 5.386 18.677 0 12.031 0zm5.503 16.479c-.302-.151-1.787-.883-2.062-.983-.276-.101-.477-.151-.678.15-.201.302-.779.983-.954 1.185-.176.201-.352.226-.653.075-2.228-1.116-3.557-2.315-4.9-4.603-.176-.302-.019-.465.132-.615.136-.136.302-.352.453-.528.151-.176.201-.302.302-.503.1-.201.05-.377-.025-.528-.076-.151-.678-1.633-.929-2.235-.245-.588-.494-.508-.678-.518-.175-.008-.376-.008-.577-.008-.2 0-.528.075-.804.377-1.055 1.029-1.055 2.512 0 3.114 0 3.115 1.08 2.914 1.231 3.115.151.201 2.125 3.24 5.143 4.544.718.31 1.278.495 1.716.634.721.228 1.378.196 1.895.118.577-.086 1.787-.73 2.038-1.436.251-.706.251-1.308.176-1.437-.075-.125-.276-.2-.577-.351z"/></svg>
        <div class="leading-tight">
            <div class="text-[0.6rem] font-bold uppercase tracking-wider opacity-80">Contact Admissions</div>
            <div class="font-black text-sm">WhatsApp</div>
        </div>
    </a>
</section>

{{-- STATS --}}
<section class="py-14" style="background:#111827">
    <div class="max-w-5xl mx-auto px-6">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            @foreach([['500+','Active Learners','#4ade80'],['4','STEM Clubs','#60a5fa'],['16+','Courses','#c084fc'],['5','Rank Levels','#fb923c']] as [$n,$l,$c])
            <div class="reveal">
                <div class="font-black text-5xl mb-1" style="color:{{ $c }}">{{ $n }}</div>
                <div class="text-white/50 font-semibold text-sm">{{ $l }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CLUBS SECTION (REDESIGNED WITH ASYMMETRICAL ROUNDED CORNERS & UNBOXED HIGH-END FEEL) --}}
<section id="clubs" class="py-28 px-6 sm:px-8 bg-white overflow-hidden">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-20">
            <span class="inline-block bg-primary/10 text-primary text-xs font-black uppercase tracking-widest px-5 py-2 rounded-full mb-5 reveal">Our Curriculum</span>
            <h2 class="font-black text-5xl sm:text-6xl text-ink mb-5 reveal leading-tight">Choose Your <span class="text-primary">Club</span></h2>
            <p class="text-muted font-semibold text-lg max-w-2xl mx-auto reveal">Four world-class programmes. One platform. Every child finds their brilliance here.</p>
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
            @foreach([
                ['STEM Club',    'linear-gradient(135deg,rgba(5,46,22,0.95),rgba(20,83,45,0.95),rgba(22,163,74,0.9))', '#4ade80', 'Ages 7–15', 'Most Popular', 'Python, Robotics, Scratch & Science. Kids build real things.', ['Python','Robotics','Scratch','Science Lab'], 'stem-club', '/Tlab/public/images/club-stem.png'],
                ['Brain Club',   'linear-gradient(135deg,rgba(30,27,75,0.95),rgba(29,78,216,0.95),rgba(59,130,246,0.9))', '#93c5fd', 'Ages 5–15', '', 'Math Olympiad, logic puzzles & strategy that sharpens young minds.', ['Math Olympiad','Logic','Chess','IQ Training'], 'brain-club', '/Tlab/public/images/club-brain.png'],
                ['Art & Craft',  'linear-gradient(135deg,rgba(67,20,7,0.95),rgba(194,75,28,0.95),rgba(249,115,22,0.9))', '#fdba74', 'Ages 3–12', 'Great for Beginners', 'Digital design, Lego storytelling, animation & creative expression.', ['Canva','Animation','Illustration','Storytelling'], 'art-craft', '/Tlab/public/images/club-art.png'],
                ['Leadership',   'linear-gradient(135deg,rgba(46,16,101,0.95),rgba(109,40,217,0.95),rgba(168,85,247,0.9))', '#d8b4fe', 'Ages 8–15', '', 'Debate, entrepreneurship & public speaking for tomorrow\'s leaders.', ['Debate','Public Speaking','Entrepreneurship','Confidence'], 'leadership', '/Tlab/public/images/club-leadership.png'],
            ] as [$name,$grad,$glow,$ages,$badge,$desc,$tags,$slug,$img])
            <div class="relative overflow-hidden group cursor-pointer reveal min-h-[380px] shadow-2xl transition-all duration-500 hover:-translate-y-2 hover:shadow-[0_40px_80px_-15px_rgba(0,0,0,0.3)]" 
                 style="border-top-left-radius: 4rem; border-bottom-right-radius: 4rem; border-top-right-radius: 0.5rem; border-bottom-left-radius: 0.5rem;">
                <div class="absolute inset-0 z-0">
                    <img src="{{ $img }}" alt="{{ $name }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                </div>
                <div class="absolute inset-0 z-10 transition-colors duration-500 group-hover:opacity-90" style="background:{{ $grad }}"></div>
                <div class="absolute top-0 right-0 w-64 h-64 rounded-full blur-3xl opacity-20 z-20" style="background:{{ $glow }};transform:translate(30%,-30%)"></div>
                <div class="relative z-30 p-10 h-full flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-6">
                            <span class="bg-white/15 text-white text-xs font-bold px-4 py-1.5 rounded-full border border-white/20">Ages {{ $ages }}</span>
                            @if($badge)<span class="bg-white/25 text-white text-[0.68rem] font-black uppercase tracking-wider px-3 py-1.5 rounded-full">{{ $badge }}</span>@endif
                        </div>
                        <h3 class="text-white font-black text-4xl mb-3">{{ $name }}</h3>
                        <p class="text-white/70 font-semibold text-sm leading-relaxed mb-6">{!! $desc !!}</p>
                        <div class="flex flex-wrap gap-2">
                            @foreach($tags as $tag)
                            <span class="bg-white/10 border border-white/20 text-white/80 text-xs font-bold px-3 py-1 rounded-full">{{ $tag }}</span>
                            @endforeach
                        </div>
                    </div>
                    <a href="{{ route('club.detail', $slug) }}" class="mt-8 inline-flex items-center gap-2 bg-white font-black text-sm px-6 py-3.5 rounded-xl hover:opacity-90 transition-all w-fit text-ink">
                        Explore Club
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- HOW IT WORKS (REDESIGNED AS Sleek Asymmetrical Glass cards) --}}
<section id="how" class="py-28 px-6 sm:px-8" style="background:#F8FAFC">
    <div class="max-w-6xl mx-auto">
        <div class="text-center mb-20">
            <span class="inline-block bg-violet/10 text-violet text-xs font-black uppercase tracking-widest px-5 py-2 rounded-full mb-5 reveal">Simple Process</span>
            <h2 class="font-black text-4xl sm:text-5xl text-ink mb-4 reveal">Up and Running in Minutes</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach([
                ['01','#16A34A','#F0FDF4','Create Parent Account','Sign up free. Your account manages all your children from one secure dashboard.'],
                ['02','#2563EB','#EFF6FF','Add Child Profiles','Create individual profiles with interests, age and a security PIN for each child.'],
                ['03','#7C3AED','#F5F3FF','Kids Earn XP &amp; Rank Up','Children complete sessions, earn XP, climb 5 ranks and unlock achievements.'],
            ] as [$step,$color,$bg,$title,$desc])
            <div class="p-8 bg-white border border-gray-100 shadow-[0_20px_45px_rgba(0,0,0,0.02)] transition-all duration-300 hover:-translate-y-2 hover:shadow-[0_30px_60px_rgba(0,0,0,0.05)]"
                 style="border-top-left-radius: 2rem; border-bottom-right-radius: 2rem; border-top-right-radius: 0.5rem; border-bottom-left-radius: 0.5rem;">
                <div class="w-14 h-14 rounded-2xl flex items-center justify-center font-black text-xl mb-6 text-white shadow-lg" style="background:{{ $color }}">{{ $step }}</div>
                <h3 class="font-black text-xl text-ink mb-3">{!! $title !!}</h3>
                <p class="text-muted font-semibold text-xs leading-relaxed">{!! $desc !!}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- FAQ --}}
<section id="faq" class="py-24 px-6 sm:px-8 bg-white">
    <div class="max-w-3xl mx-auto">
        <div class="text-center mb-16">
            <span class="inline-block bg-amber/10 text-amber text-xs font-black uppercase tracking-widest px-5 py-2 rounded-full mb-5 reveal">Got Questions?</span>
            <h2 class="font-black text-4xl sm:text-5xl text-ink mb-3 reveal">
                Frequently Asked <span class="text-primary">Questions</span>
            </h2>
        </div>
        <div class="space-y-4" id="faq-list">
            @php
            $faqs = [
                ['How do I enrol my child?', 'Create a free parent account, add your child\'s profile, select a club and complete enrolment. It takes less than 5 minutes.'],
                ['What age groups does TLab cater to?', 'TLab is designed for children aged 3 to 15. Each club has its own age-appropriate curriculum and pace.'],
                ['Is TLab safe for my child?', 'Absolutely. TLab is fully COPPA and GDPR-K compliant. There are no ads, no data selling, and parents control all access.'],
                ['What is the XP and ranking system?', 'Children earn XP points for attending sessions, completing challenges and helping peers. They progress through 5 ranks: Explorer, Innovator, Builder, Creator, and Master Inventor.'],
                ['Can I manage multiple children under one account?', 'Yes! One parent account can have unlimited child profiles, each with their own dashboard, XP, and course enrolments.'],
                ['What if my child wants to switch clubs?', 'Children can be enrolled in multiple clubs simultaneously. Contact admissions for any changes to active enrolments.'],
            ];
            @endphp
            @foreach($faqs as $i => [$q, $a])
            <div class="bg-white border border-gray-100 overflow-hidden reveal" data-delay="{{ $i * 60 }}"
                 style="border-top-left-radius: 1.5rem; border-bottom-right-radius: 1.5rem; border-top-right-radius: 0.5rem; border-bottom-left-radius: 0.5rem;">
                <button onclick="toggleFaq(this)" class="w-full flex items-center justify-between p-6 text-left font-black text-sm sm:text-base text-ink hover:text-primary transition-colors">
                    <span>{{ $q }}</span>
                    <svg class="w-5 h-5 flex-shrink-0 ml-4 transition-transform duration-300 faq-icon text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div class="faq-body max-h-0 overflow-hidden transition-all duration-300">
                    <p class="px-6 pb-6 text-muted font-semibold text-xs leading-relaxed">{{ $a }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="py-28 px-6 text-center" style="background:#0F172A">
    <div class="max-w-3xl mx-auto">
        <span class="inline-block bg-primary/20 text-primary text-xs font-black uppercase tracking-widest px-5 py-2 rounded-full mb-6 reveal">Get Started Today</span>
        <h2 class="font-black text-4xl sm:text-5xl text-white mb-5 reveal">Give Your Child a Head Start</h2>
        <p class="text-white/60 font-semibold text-lg mb-10 reveal">Join hundreds of African families already using TLab to build the next generation of innovators.</p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center reveal">
            <a href="{{ route('register') }}" class="btn-hero !px-10">Enrol Free Today</a>
            <a href="#faq" class="btn-outline !border-white/30 !text-white hover:!border-white">Read the FAQ</a>
        </div>
    </div>
</section>

{{-- FOOTER --}}
@include('partials.footer')

@push('scripts')
<script>
function toggleFaq(btn) {
    const body = btn.nextElementSibling;
    const icon = btn.querySelector('.faq-icon');
    const isOpen = body.style.maxHeight && body.style.maxHeight !== '0px';
    document.querySelectorAll('.faq-body').forEach(b => b.style.maxHeight = '0px');
    document.querySelectorAll('.faq-icon').forEach(i => i.style.transform = '');
    if (!isOpen) {
        body.style.maxHeight = body.scrollHeight + 'px';
        icon.style.transform = 'rotate(180deg)';
    }
}
</script>
@endpush

@endsection
