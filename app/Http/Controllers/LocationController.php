<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $locations = Location::get();
        return view('pages.location.index', compact('locations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.location.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'location_area' => 'required|decimal:0,2',
            'name' => 'required|string',
            'family_count' => 'required|integer|min:0',
            'polygon' => 'required|json',
        ], [
            'location_area.required' => 'Luas area wajib diisi.',
            'location_area.decimal' => 'Luas area harus berupa desimal.',
            'name.required' => 'Nama lokasi wajib diisi.',
            'name.string' => 'Nama lokasi harus berupa string.',
            'family_count.required' => 'Jumlah keluarga wajib diisi.',
            'family_count.integer' => 'Jumlah keluarga harus berupa angka.',
            'family_count.min' => 'Jumlah keluarga harus lebih dari 0.',
            'polygon.required' => 'Polygon wajib diisi.',
            'polygon.json' => 'Polygon harus berupa json.',
        ]);

        $data = [
            'location_area' => $request->location_area,
            'name' => $request->name,
            'family_count' => $request->family_count,
            'polygon' => $request->polygon,
        ];

        $post = Location::create($data);

        return redirect()->route('location.index')->with('success', 'Data lokasi berhasil disimpan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $location = Location::findOrFail($id);
        return view('pages.location.edit', compact('location'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'location_area' => 'required|decimal:0,2',
            'name' => 'required|string',
            'family_count' => 'required|integer|min:0',
            'polygon' => 'required|json',
        ], [
            'location_area.required' => 'Luas area wajib diisi.',
            'location_area.decimal' => 'Luas area harus berupa desimal.',
            'name.required' => 'Nama lokasi wajib diisi.',
            'name.string' => 'Nama lokasi harus berupa string.',
            'family_count.required' => 'Jumlah keluarga wajib diisi.',
            'family_count.integer' => 'Jumlah keluarga harus berupa angka.',
            'family_count.min' => 'Jumlah keluarga harus lebih dari 0.',
            'polygon.required' => 'Polygon wajib diisi.',
            'polygon.json' => 'Polygon harus berupa json.',
        ]);

        $data = [
            'location_area' => $request->location_area,
            'name' => $request->name,
            'family_count' => $request->family_count,
            'polygon' => $request->polygon,
        ];

        $location = Location::findOrFail($id);
        $location->update($data);

        return redirect()->route('location.index')->with('success', 'Data lokasi berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $location = Location::findOrFail($id);
        $location->delete();

        return redirect()->route('location.index')->with('success', 'Data lokasi berhasil dihapus!');
    }
}
