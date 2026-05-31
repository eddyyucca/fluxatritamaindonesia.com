<?php

namespace Modules\Setting\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Setting\Models\Setting;
use Illuminate\Support\Facades\Cache;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->groupBy('group');
        return view('setting::index', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->except(['_token', '_method']);
        
        foreach ($data as $key => $value) {
            $setting = Setting::where('key', $key)->first();
            if ($setting) {
                // If it's json type, make sure it's valid JSON
                if ($setting->type === 'json' && is_array($value)) {
                    $setting->value = json_encode($value);
                } else {
                    $setting->value = $value;
                }
                $setting->save();
            }
        }

        Cache::forget('app_settings');

        return redirect()->route('setting.index')->with('success', 'Pengaturan berhasil diperbarui.');
    }
}
