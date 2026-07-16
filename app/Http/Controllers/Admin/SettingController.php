<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $setting = Setting::first();

        if (!$setting) {
            $setting = Setting::create([
                'site_name' => 'NEXUS',
            ]);
        }

        return view('admin.settings.index', compact('setting'));
    }

public function update(Request $request)
{
    $setting = Setting::first();

    $data = $request->except(['_token']);

    // Upload Logo
    if ($request->hasFile('logo')) {

        if ($setting->logo && Storage::disk('public')->exists($setting->logo)) {
            Storage::disk('public')->delete($setting->logo);
        }

        $data['logo'] = $request
            ->file('logo')
            ->store('settings/logo', 'public');
    }

    // Upload Favicon
    if ($request->hasFile('favicon')) {

        if ($setting->favicon && Storage::disk('public')->exists($setting->favicon)) {
            Storage::disk('public')->delete($setting->favicon);
        }

        $data['favicon'] = $request
            ->file('favicon')
            ->store('settings/favicon', 'public');
    }

    // Checkbox maintenance
    $data['maintenance'] = $request->has('maintenance');

    $setting->update($data);

    return back()->with('success', 'Website setting berhasil disimpan.');
}
}