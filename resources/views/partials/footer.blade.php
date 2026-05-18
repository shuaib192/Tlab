{{-- FOOTER --}}
<footer class="bg-ink text-white pt-16 pb-8 px-4 sm:px-6 border-t border-white/10">
    <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-10 mb-12">
        <div class="md:col-span-2">
            <img src="/images/tlab-logo-white.png" alt="TLab" class="h-10 w-auto mb-5">
            <p class="text-white/50 font-semibold text-sm leading-relaxed max-w-sm mb-6">Africa's premier gamified STEM ecosystem. Safe, immersive, parent-controlled learning for children aged 3–15.</p>
        </div>
        <div>
            <h4 class="font-black text-sm uppercase tracking-wider mb-5">Platform</h4>
            <div class="space-y-3">
                <a href="{{ route('clubs') }}" class="block text-white/50 hover:text-white text-sm font-semibold transition-colors">STEM Clubs</a>
                <a href="{{ route('about') }}" class="block text-white/50 hover:text-white text-sm font-semibold transition-colors">About TLab</a>
                <a href="{{ route('membership') }}" class="block text-white/50 hover:text-white text-sm font-semibold transition-colors">Pricing Plans</a>
                <a href="{{ route('login') }}" class="block text-white/50 hover:text-white text-sm font-semibold transition-colors">Parent Login</a>
            </div>
        </div>
        <div>
            <h4 class="font-black text-sm uppercase tracking-wider mb-5">Legal</h4>
            <div class="space-y-3">
                <a href="#" class="block text-white/50 hover:text-white text-sm font-semibold transition-colors">Privacy Policy</a>
                <a href="#" class="block text-white/50 hover:text-white text-sm font-semibold transition-colors">Terms of Service</a>
                <a href="#" class="block text-primary text-sm font-bold">COPPA Compliance</a>
            </div>
        </div>
    </div>
    <div class="max-w-7xl mx-auto border-t border-white/10 pt-8 flex flex-col md:flex-row items-center justify-between gap-4">
        <p class="text-white/30 text-sm">&copy; {{ date('Y') }} Edfrica Ecosystem. All rights reserved.</p>
        <p class="text-white/30 text-sm">Powered by Edfrica Identity.</p>
    </div>
</footer>
