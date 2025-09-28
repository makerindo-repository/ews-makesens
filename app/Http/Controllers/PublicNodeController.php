<?php

namespace App\Http\Controllers;

use App\Models\IoTNode;
use App\Models\PublicNode;
use Illuminate\Http\Request;

class PublicNodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pubNodes = PublicNode::with('node')->get();
        return view('pages.public_node.index', compact('pubNodes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $iotNodes = IoTNode::get();
        return view('pages.public_node.create', compact('iotNodes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'serial_number' => 'required|string|unique:public_nodes,serial_number',
            'name' => 'required|string',
            'coordinate' => 'required',
            'iot_node' => 'required|integer',
        ], [
            'serial_number.required' => 'Nomor serial wajib diisi.',
            'serial_number.unique' => 'Nomor serial ini sudah digunakan.',
            'name.required' => 'Nama node wajib diisi.',
            'coordinate.required' => 'Titik lokasi wajib diisi.',
            'iot_node.required' => 'IoT node wajib diisi.',
            'iot_node.integer' => 'IoT node tidak valid.'
        ]);

        // Parsing latitude & longitude yang diterima
        [$lat, $lng] = explode(',', $request->coordinate);

        $data = [
            'serial_number' => $request->serial_number,
            'name' => $request->name,
            'latitude' => trim($lat),
            'longitude' => trim($lng),
            'iot_node_id' => $request->iot_node,
        ];

        $post = PublicNode::create($data);
        return redirect()->route('public-node.index')->with('success', 'Data publik node berhasil disimpan!');
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
        $iotNodes = IoTNode::get();
        $pubNode = PublicNode::findOrFail($id);
        return view('pages.public_node.edit', compact('iotNodes', 'pubNode'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $pubNode = PublicNode::findOrFail($id);

        $request->validate([
            'serial_number' => 'required|string|unique:public_nodes,serial_number,' . $pubNode->id,
            'name' => 'required|string',
            'coordinate' => 'required',
            'iot_node' => 'required|integer',
        ], [
            'serial_number.required' => 'Nomor serial wajib diisi.',
            'serial_number.unique' => 'Nomor serial ini sudah digunakan.',
            'name.required' => 'Nama node wajib diisi.',
            'coordinate.required' => 'Titik lokasi wajib diisi.',
            'iot_node.required' => 'IoT node wajib diisi.',
            'iot_node.integer' => 'IoT node tidak valid.'
        ]);

        // Parsing latitude & longitude yang diterima
        [$lat, $lng] = explode(',', $request->coordinate);

        $data = [
            'serial_number' => $request->serial_number,
            'name' => $request->name,
            'latitude' => trim($lat),
            'longitude' => trim($lng),
            'iot_node_id' => $request->iot_node,
        ];

        $pubNode->update($data);

        return redirect()->route('public-node.index')->with('success', 'Data publik node berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pubNode = PublicNode::findOrFail($id);
        $pubNode->delete();

        return redirect()->route('public-node.index')->with('success', 'Data publik node berhasil dihapus!');
    }
}
