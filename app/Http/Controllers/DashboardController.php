<?php

namespace App\Http\Controllers;

use App\Models\WeatherSetting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    public function index()
    {
        $weather = null;

        // ambil adm4 dari DB (kode desa)
        $setting = WeatherSetting::first();
        if (!$setting || !$setting->village_code) {
            return view('dashboard', compact('weather'));
        }

        $adm4 = $this->formatAdm4($setting->village_code);

        // hit BMKG API
        $response = Http::get("https://api.bmkg.go.id/publik/prakiraan-cuaca?adm4={$adm4}");

        if ($response->successful()) {
            $json = $response->json();

            // pastikan ada data
            if (!empty($json['data'][0]['cuaca'])) {
                $now = Carbon::now('Asia/Jakarta');
                $nearest = null;
                $minDiff = PHP_INT_MAX;

                foreach ($json['data'][0]['cuaca'] as $slot) {
                    foreach ($slot as $forecast) {
                        if (empty($forecast['local_datetime'])) {
                            continue;
                        }

                        $dt = Carbon::parse($forecast['local_datetime'], 'Asia/Jakarta');
                        $diff = abs($now->diffInMinutes($dt));

                        if ($diff < $minDiff) {
                            $minDiff = $diff;
                            $nearest = $forecast;
                        }
                    }
                }

                if ($nearest) {
                    $weather = [
                        'temp'       => $nearest['t'] ?? '--',
                        'humidity'   => $nearest['hu'] ?? '--',
                        'wind'       => $nearest['ws'] ?? '--',
                        'rain'       => $nearest['tp'] ?? '--',
                        'desc'       => $nearest['weather_desc'] ?? '--',
                        'icon_url'   => $nearest['image'] ?? null,
                        'local_time' => $nearest['local_datetime'] ?? null,
                    ];
                }
            }
        }

        return view('dashboard', compact('weather'));
    }

    // Format kode desa sesuai adm4 BMKG
    private function formatAdm4(string $villageCode): string
    {
        $code = str_pad($villageCode, 10, '0', STR_PAD_LEFT);

        $adm1 = substr($code, 0, 2);
        $adm2 = substr($code, 2, 2);
        $adm3 = substr($code, 4, 2);
        $adm4 = substr($code, 6, 4);

        return "{$adm1}.{$adm2}.{$adm3}.{$adm4}";
    }
}
