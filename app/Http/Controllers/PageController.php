<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Club;
use App\Models\CarouselSlide;

class PageController extends Controller
{
    private array $clubs = [
        'stem-club' => [
            'name'       => 'STEM Club',
            'slug'       => 'stem-club',
            'tagline'    => 'Code. Build. Invent.',
            'ages'       => '7–15',
            'color'      => '#16A34A',
            'bg'         => '#F0FDF4',
            'gradient'   => 'linear-gradient(135deg,#052e16,#14532d,#16A34A)',
            'glow'       => '#4ade80',
            'icon_path'  => 'M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z',
            'description'=> 'The STEM Club is where future engineers, scientists and programmers are born. Children work with real tools — from Python scripts to physical robots — in a structured, progressive curriculum designed for deep learning through doing.',
            'what_learn' => ['Python & Scratch programming','Robotics with Arduino & Lego','Science experiments & STEM projects','App design fundamentals','Engineering design challenges'],
            'outcomes'   => ['Build and code their own robot','Create working Python programs','Complete science lab reports','Design and present STEM projects','Earn STEM Club certification'],
            'schedule'   => 'Saturdays 10am – 12pm',
            'sessions'   => '2 sessions per week',
            'fee'        => 'See Membership Plans',
        ],
        'brain-club' => [
            'name'       => 'Brain Club',
            'slug'       => 'brain-club',
            'tagline'    => 'Think. Solve. Dominate.',
            'ages'       => '5–15',
            'color'      => '#2563EB',
            'bg'         => '#EFF6FF',
            'gradient'   => 'linear-gradient(135deg,#1e1b4b,#1d4ed8,#3b82f6)',
            'glow'       => '#93c5fd',
            'icon_path'  => 'M13 10V3L4 14h7v7l9-11h-7z',
            'description'=> 'Brain Club sharpens the minds of young learners through competitive mathematics, logic, chess and lateral thinking challenges. Children develop analytical skills that transfer across every subject and life situation.',
            'what_learn' => ['Math Olympiad problem solving','Chess strategy & tactics','Logic puzzles & critical thinking','Lateral thinking challenges','Mental arithmetic & speed maths'],
            'outcomes'   => ['Compete in inter-club math tournaments','Achieve chess ratings','Improve exam performance across subjects','Develop patience and strategic thinking','Earn Brain Club certification'],
            'schedule'   => 'Weekdays 4pm – 6pm',
            'sessions'   => '3 sessions per week',
            'fee'        => 'See Membership Plans',
        ],
        'art-craft' => [
            'name'       => 'Art & Craft',
            'slug'       => 'art-craft',
            'tagline'    => 'Design. Create. Express.',
            'ages'       => '3–12',
            'color'      => '#EA580C',
            'bg'         => '#FFF7ED',
            'gradient'   => 'linear-gradient(135deg,#431407,#c2410c,#f97316)',
            'glow'       => '#fdba74',
            'icon_path'  => 'M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z',
            'description'=> 'Art & Craft Club nurtures the creative side of every child. From digital design to hands-on crafting, children explore their artistic voice in a supportive and expressive environment guided by passionate instructors.',
            'what_learn' => ['Digital design with Canva','Lego StoryStarter & storytelling','Illustration & painting techniques','Animation fundamentals','Textile crafts & 3D art'],
            'outcomes'   => ['Build a personal creative portfolio','Design a full digital project','Tell compelling visual stories','Exhibit work at TLab showcases','Earn Art & Craft Club certification'],
            'schedule'   => 'Saturdays 12pm – 2pm',
            'sessions'   => '2 sessions per week',
            'fee'        => 'See Membership Plans',
        ],
        'leadership' => [
            'name'       => 'Leadership Club',
            'slug'       => 'leadership',
            'tagline'    => 'Speak. Lead. Inspire.',
            'ages'       => '8–15',
            'color'      => '#7C3AED',
            'bg'         => '#F5F3FF',
            'gradient'   => 'linear-gradient(135deg,#2e1065,#6d28d9,#a855f7)',
            'glow'       => '#d8b4fe',
            'icon_path'  => 'M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z',
            'description'=> 'Leadership Club transforms shy children into confident, articulate, entrepreneurial thinkers. Through debate, business planning, and public speaking workshops, young leaders discover their voice and learn to inspire others.',
            'what_learn' => ['Formal debate techniques','Public speaking & stage presence','Entrepreneurship & business basics','Emotional intelligence & conflict resolution','Community leadership projects'],
            'outcomes'   => ['Compete in inter-school debates','Pitch a business idea to a panel','Deliver a confident public speech','Lead a team project from start to finish','Earn Leadership Club certification'],
            'schedule'   => 'Sundays 2pm – 4pm',
            'sessions'   => '2 sessions per week',
            'fee'        => 'See Membership Plans',
        ],
    ];

    public function home()
    {
        $slides = CarouselSlide::active();
        return view('welcome', compact('slides'));
    }

    public function about()
    {
        return view('pages.about');
    }

    public function clubs()
    {
        return view('pages.clubs', ['clubs' => $this->clubs]);
    }

    public function clubDetail(string $slug)
    {
        $club = $this->clubs[$slug] ?? abort(404);
        return view('pages.club-detail', compact('club'));
    }

    public function membership()
    {
        return view('pages.membership');
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function contactSubmit(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:100',
            'email'   => 'required|email',
            'subject' => 'required|string|max:150',
            'message' => 'required|string|max:2000',
        ]);
        // TODO: send email via Mail facade
        return back()->with('success', 'Your message has been received. We will respond within 24 hours.');
    }
}
