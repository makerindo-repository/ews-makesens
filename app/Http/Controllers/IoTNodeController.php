<?php

namespace App\Http\Controllers;

use App\Models\IoTNode;
use App\Models\Location;
use Illuminate\Http\Request;

class IoTNodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $nodes = IoTNode::with('location')->get();
        return view('pages.iot_node.index', compact('nodes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $locations = Location::get();
        return view('pages.iot_node.create', compact('locations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'serial_number' => 'required|string|unique:iot_nodes,serial_number',
            'name' => 'required|string',
            'location' => 'required|integer',
        ], [
            'serial_number.required' => 'Nomor serial wajib diisi.',
            'serial_number.string' => 'Nomor serial tidak valid.',
            'serial_number.unique' => 'Nomor serial ini sudah digunakan.',
            'name.required' => 'Nama node wajib diisi.',
            'name.string' => 'Nama node tidak valid.',
            'location.required' => 'Lokasi wajib diisi.',
            'location.integer' => 'Lokasi tidak valid.',
        ]);

        $data = [
            'serial_number' => $request->serial_number,
            'name' => $request->name,
            'location_id' => $request->location,
        ];

        $post = IoTNode::create($data);

        return redirect()->route('iot-node.index')->with('success', 'Data node berhasil disimpan!');
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
        $node = IoTNode::findOrFail($id);
        $locations = Location::get();
        return view('pages.iot_node.edit', compact('node', 'locations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $node = IoTNode::findOrFail($id);
        $request->validate([
            'serial_number' => 'required|string|unique:iot_nodes,serial_number,' . $node->serial_number,
            'name' => 'required|string',
            'location' => 'required|integer',
        ], [
            'serial_number.required' => 'Nomor serial wajib diisi.',
            'serial_number.string' => 'Nomor serial tidak valid.',
            'serial_number.unique' => 'Nomor serial ini sudah digunakan.',
            'name.required' => 'Nama node wajib diisi.',
            'name.string' => 'Nama node tidak valid.',
            'location.required' => 'Lokasi wajib diisi.',
            'location.integer' => 'Lokasi tidak valid.',
        ]);

        $data = [
            'serial_number' => $request->serial_number,
            'name' => $request->name,
            'location_id' => $request->location,
        ];

        $node->update($data);

        return redirect()->route('iot-node.index')->with('success', 'Data node berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $node = IoTNode::findOrFail($id);
        $node->delete();

        return redirect()->route('iot-node.index')->with('success', 'Data node berhasil dihapus!');
    }
}
