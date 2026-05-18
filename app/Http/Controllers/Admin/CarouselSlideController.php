<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CarouselSlide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CarouselSlideController extends Controller
{
    public function index()
    {
        $slides = CarouselSlide::orderBy('sort_order')->orderBy('id')->paginate(20);
        return view('admin.carousel.index', compact('slides'));
    }

    public function create()
    {
        return view('admin.carousel.form', ['slide' => null]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'      => 'required|string|max:120',
            'body'       => 'nullable|string|max:500',
            'link'       => 'nullable|url|max:255',
            'link_text'  => 'nullable|string|max:60',
            'bg_color'   => 'nullable|string|max:20',
            'sort_order' => 'nullable|integer|min:0',
            'active'     => 'nullable|boolean',
            'image'      => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = '/Tlab/public/storage/' . $request->file('image')->store('carousel', 'public');
        }

        $data['active'] = $request->boolean('active', true);
        CarouselSlide::create($data);

        return redirect()->route('admin.carousel.index')->with('success', 'Slide created successfully.');
    }

    public function edit(CarouselSlide $carousel)
    {
        return view('admin.carousel.form', ['slide' => $carousel]);
    }

    public function update(Request $request, CarouselSlide $carousel)
    {
        $data = $request->validate([
            'title'      => 'required|string|max:120',
            'body'       => 'nullable|string|max:500',
            'link'       => 'nullable|url|max:255',
            'link_text'  => 'nullable|string|max:60',
            'bg_color'   => 'nullable|string|max:20',
            'sort_order' => 'nullable|integer|min:0',
            'active'     => 'nullable|boolean',
            'image'      => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = '/Tlab/public/storage/' . $request->file('image')->store('carousel', 'public');
        }

        $data['active'] = $request->boolean('active', true);
        $carousel->update($data);

        return redirect()->route('admin.carousel.index')->with('success', 'Slide updated successfully.');
    }

    public function destroy(CarouselSlide $carousel)
    {
        $carousel->delete();
        return back()->with('success', 'Slide deleted.');
    }

    public function toggleActive(CarouselSlide $carousel)
    {
        $carousel->update(['active' => !$carousel->active]);
        return back()->with('success', 'Slide visibility updated.');
    }
}
