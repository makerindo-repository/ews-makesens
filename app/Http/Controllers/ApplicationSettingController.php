<?php

namespace App\Http\Controllers;

use App\Models\ApplicationSetting;
use App\Services\ImageService;
use Illuminate\Http\Request;

class ApplicationSettingController extends Controller
{
    public function index()
    {
        $setting = ApplicationSetting::first();
        return view('pages.application_setting.index', compact('setting'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'name' => 'required|string',
            'tab_name' => 'required|string',
            'version' => 'required|string',
            'copyright' => 'required|string',
            'copyright_year' => 'required|string',
        ], [
            'image.image' => 'Logo harus berupa gambar.',
            'image.mimes' => 'Format logo harus berupa jpeg, png, atau jpg.',
            'image.max' => 'Ukuran logo melebihi 2MB.',
            'name.required' => 'Nama website harus diisi.',
            'tab_name.required' => 'Nama tab browser harus diisi.',
            'version.required' => 'Versi website harus diisi.',
            'copyright.required' => 'Copyright harus diisi.',
            'copyright_year.required' => 'Tahun copyright harus diisi.',
        ]);

        $setting = ApplicationSetting::first();
        if (!$setting) {
            $setting = new ApplicationSetting();
        }

        if ($request->hasFile('image')) {
            ImageService::deleteImage($setting->image);
            $imgPath = ImageService::image_intervention($request->file('image'), 'images/application-setting/');
            $setting->image = $imgPath;
        }

        $setting->name = $request->name;
        $setting->tab_name = $request->tab_name;
        $setting->version = $request->version;
        $setting->copyright = $request->copyright;
        $setting->copyright_year = $request->copyright_year;
        $setting->save();

        return redirect()->route('app-setting.index')->with('success', 'Pengaturan aplikasi berhasil disimpan!');
    }

    public function fetchApplicationSettings()
    {
        $setting = ApplicationSetting::first();
        return response()->json([
            'image' => $setting->image ?? null,
            'name' => $setting->name ?? 'Early Warning System',
            'version' => $setting->version ?? '1.0',
            'copyright' => $setting->copyright ?? 'MakeSens',
            'copyright_year' => $setting->copyright_year ?? '2025',
            'tab_name' => $setting->tab_name ?? null,
        ]);
    }
}
