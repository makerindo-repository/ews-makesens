<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Services\ImageService;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $reports = Report::get();
        return view('pages.report.index', compact('reports'));
    }

    public function show(string $id)
    {
        $report = Report::findOrFail($id);
        return view('pages.report.show', compact('report'));
    }

    public function receiveReport(Request $request)
    {
        $existing = Report::where('kode_laporan', $request->data['report_id'])->first();

        $request->validate([
            'data.report_id' => 'required|string',
            'data.kejadian' => $existing ? 'nullable|string' : 'required|string',
            'data.lokasi' => $existing ? 'nullable|string' : 'required|string',
            'data.kelurahan' => $existing ? 'nullable|string' : 'required|string',
            'data.kecamatan' => $existing ? 'nullable|string' : 'required|string',
            'data.kabupaten_kota' => $existing ? 'nullable|string' : 'required|string',
            'data.provinsi' => $existing ? 'nullable|string' : 'required|string',
            'data.alamat' => $existing ? 'nullable|string' : 'required|string',
            'data.tanggal' => $existing ? 'nullable|date' : 'required|date',
            'data.waktu' => $existing ? 'nullable|date_format:H:i' : 'required|date_format:H:i',
            'data.dampak' => $existing ? 'nullable|string' : 'required|string',
            'data.penyebab' => $existing ? 'nullable|string' : 'required|string',
            'data.kronologi' => $existing ? 'nullable|string' : 'required|string',
            'data.korban.pengungsi' => $existing ? 'nullable|integer' : 'required|integer',
            'data.korban.lukaBerat' => $existing ? 'nullable|integer' : 'required|integer',
            'data.korban.lukaRingan' => $existing ? 'nullable|integer' : 'required|integer',
            'data.korban.meninggal' => $existing ? 'nullable|integer' : 'required|integer',
            'data.pelapor.nama' => $existing ? 'nullable|string' : 'required|string',
            'data.kebutuhan.mendesak' => $existing ? 'nullable|string' : 'required|string',
            'data.kebutuhan.bantuan' => $existing ? 'nullable|string' : 'required|string',
        ]);

        if (!empty($request->data['lokasi'])) {
            $lokasi = $request->data['lokasi'];

            if (!str_contains($lokasi, ',')) {
                $lokasi = '-6.200000, 106.816666';
            }

            [$lat, $lng] = explode(',', $lokasi);
        } elseif ($existing) {
            $lat = $existing->latitude;
            $lng = $existing->longitude;
        } else {
            [$lat, $lng] = ['-6.200000', '106.816666'];
        }

        $data = [
            'kode_laporan' => $request->data['report_id'],
            'jenis_kejadian' => $request->data['kejadian'] ?? $existing?->jenis_kejadian,
            'tanggal_kejadian' => $request->data['tanggal'] ?? $existing?->tanggal_kejadian,
            'waktu_kejadian' => $request->data['waktu'] ?? $existing?->waktu_kejadian,
            'pelapor' => $request->data['pelapor']['nama'] ?? $existing?->pelapor,
            'latitude' => trim($lat),
            'longitude' => trim($lng),
            'kelurahan' => $request->data['kelurahan'] ?? $existing?->kelurahan,
            'kecamatan' => $request->data['kecamatan'] ?? $existing?->kecamatan,
            'kabupaten_kota' => $request->data['kabupaten_kota'] ?? $existing?->kabupaten_kota,
            'provinsi' => $request->data['provinsi'] ?? $existing?->provinsi,
            'alamat_lengkap' => $request->data['alamat'] ?? $existing?->alamat_lengkap,
            'penyebab' => $request->data['penyebab'] ?? $existing?->penyebab,
            'dampak' => $request->data['dampak'] ?? $existing?->dampak,
            'kronologi' => $request->data['kronologi'] ?? $existing?->kronologi,
            'pengungsi' => $request->data['korban']['pengungsi'] ?? $existing?->pengungsi,
            'luka_berat' => $request->data['korban']['lukaBerat'] ?? $existing?->luka_berat,
            'luka_ringan' => $request->data['korban']['lukaRingan'] ?? $existing?->luka_ringan,
            'meninggal' => $request->data['korban']['meninggal'] ?? $existing?->meninggal,
            'kebutuhan_mendesak' => $request->data['kebutuhan']['mendesak'] ?? $existing?->kebutuhan_mendesak,
            'kebutuhan_bantuan' => $request->data['kebutuhan']['bantuan'] ?? $existing?->kebutuhan_bantuan,
            'foto' => null,
        ];

        if ($existing) {
            $existing->update($data);
        } else {
            Report::create($data);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Laporan berhasil disimpan!'
        ]);
    }

    public function receiveImage(string $id, Request $request)
    {
        $report = Report::findOrFail($id);

        $request->validate([
            'foto' => 'required|array',
            'foto.*' => 'file|mimes:png,jpg,jpeg'
        ], [
            'foto.required' => 'Foto harus diisi.',
            'foto.array' => 'Foto harus berupa array.',
            'foto.*.mimes' => 'Format foto tidak valid.'
        ]);

        $foto = [];

        foreach ($request->file('foto') as $item) {
            $path = ImageService::image_intervention($item, 'images/report/');
            $foto[] = $path;
        }

        $report->update([
            'foto' => $foto
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Foto berhasil disimpan!',
        ]);
    }
}
