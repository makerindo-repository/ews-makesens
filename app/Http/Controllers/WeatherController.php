<?php

namespace App\Http\Controllers;

use App\Models\WeatherSetting;
use Illuminate\Http\Request;
use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Models\District;
use Laravolt\Indonesia\Models\Province;
use Laravolt\Indonesia\Models\Village;

class WeatherController extends Controller
{
    public function index()
    {
        $provinces = Province::get();
        return view('pages.weather.index', compact('provinces'));
    }

    public function store(Request $request) {
        $request->validate([
            'province' => 'required',
            'city' => 'required',
            'district' => 'required',
            'village' => 'required',
        ], [
            'province.required' => 'Provinsi wajib diisi.',
            'city.required' => 'Kota/Kabupaten wajib diisi.',
            'district.required' => 'Kecamatan wajib diisi.',
            'village.required' => 'Desa wajib diisi.',
        ]);

        $weather = WeatherSetting::first();
        if (!$weather) {
            $weather = new WeatherSetting();
        }

        $weather->province_code = $request->province;
        $weather->city_code = $request->city;
        $weather->district_code = $request->district;
        $weather->village_code = $request->village;
        $weather->save();

        return redirect()->route('weather.index')->with('success', 'Data wilayah cuaca berhasil disimpan!');
    }

    public function getCities(Request $request)
    {
        return City::where('province_code', $request->province_code)->get();
    }

    public function getDistricts(Request $request)
    {
        return District::where('city_code', $request->city_code)->get();
    }

    public function getVillages(Request $request)
    {
        return Village::where('district_code', $request->district_code)->get();
    }
}
