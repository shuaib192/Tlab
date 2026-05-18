<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SettingController extends Controller
{
    public function index()
    {
        $settings = SiteSetting::orderBy('group')->orderBy('label')->get()->groupBy('group');
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'settings'          => 'required|array',
            'settings.*.key'   => 'required|string',
            'settings.*.value' => 'nullable|string',
        ]);

        foreach ($request->input('settings', []) as $item) {
            SiteSetting::set($item['key'], $item['value'] ?? '');
        }

        return back()->with('success', 'Settings saved successfully.');
    }

    public function create()
    {
        return view('admin.settings.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'key'   => 'required|string|max:100|unique:site_settings,key',
            'label' => 'required|string|max:150',
            'group' => 'required|string|max:50',
            'type'  => 'required|in:text,textarea,color,boolean,number,image',
            'value' => 'nullable|string',
        ]);

        SiteSetting::create($data);

        return redirect()->route('admin.settings.index')
            ->with('success', "Setting \"{$data['label']}\" created.");
    }

    public function destroy(SiteSetting $setting)
    {
        Cache::forget("setting:{$setting->key}");
        $setting->delete();
        return back()->with('success', 'Setting removed.');
    }
}
