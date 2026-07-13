<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StoreSetting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = StoreSetting::all()->keyBy('key')->map(function ($setting) {
            return $setting->value;
        })->toArray();

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'settings' => 'required|array',
        ]);

        foreach ($request->settings as $key => $value) {
            $group = 'general';
            if (in_array($key, ['meta_title', 'meta_description'])) {
                $group = 'seo';
            } elseif (in_array($key, ['facebook_url', 'instagram_url', 'tiktok_url'])) {
                $group = 'social';
            } elseif (in_array($key, ['store_logo', 'store_favicon', 'announcement_bar_text', 'announcement_bar_active'])) {
                $group = 'appearance';
            }

            StoreSetting::set($key, $value, $group);
        }

        return redirect()->route('admin.settings.index')->with('success', 'Pengaturan berhasil disimpan.');
    }
}
