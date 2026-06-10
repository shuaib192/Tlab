<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\FeatureFlag;
use Illuminate\Http\Request;
class FeatureFlagController extends Controller
{
    public function index()
    {
        $flags = FeatureFlag::orderBy('key')->get();
        return view('admin.feature-flags', compact('flags'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'key' => 'required|string|unique:feature_flags,key|max:255',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'staging_only' => 'boolean',
            'enabled_for_roles' => 'nullable|array',
            'enabled_for_users' => 'nullable|array',
        ]);
        $data['is_active'] = $request->boolean('is_active');
        $data['staging_only'] = $request->boolean('staging_only');
        FeatureFlag::create($data);
        return redirect()->route('admin.feature-flags.index')->with('success', 'Feature flag created.');
    }

    public function toggle(FeatureFlag $flag)
    {
        $flag->update(['is_active' => !$flag->is_active]);
        return redirect()->route('admin.feature-flags.index')->with('success', 'Feature flag toggled.');
    }

    public function update(Request $request, FeatureFlag $flag)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'staging_only' => 'boolean',
            'enabled_for_roles' => 'nullable|array',
            'enabled_for_users' => 'nullable|array',
        ]);
        $data['is_active'] = $request->boolean('is_active');
        $data['staging_only'] = $request->boolean('staging_only');
        $flag->update($data);
        return redirect()->route('admin.feature-flags.index')->with('success', 'Feature flag updated.');
    }
}
