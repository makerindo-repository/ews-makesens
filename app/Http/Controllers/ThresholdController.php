<?php

namespace App\Http\Controllers;

use App\Models\IoTNode;
use App\Models\Threshold;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ThresholdController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $thresholds = Threshold::with('node')->get();
        return view('pages.threshold.index', compact('thresholds'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $iotNodes = IoTNode::get();
        return view('pages.threshold.create', compact('iotNodes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'iot_node' => 'required|integer|unique:thresholds,iot_node_id',
            'waspada' => 'required|numeric',
            'siaga' => 'required|numeric',
            'awas' => 'required|numeric',
            'h2' => 'required|numeric',
            'h1' => 'required|numeric',
        ], [
            'iot_node.required' => 'IoT node wajib diisi.',
            'iot_node.integer' => 'IoT node tidak valid.',
            'iot_node.unique' => 'IoT node ini sudah memiliki threshold.',
            'waspada.required' => 'Parameter waspada wajib diisi.',
            'waspada.numeric' => 'Parameter waspada harus berupa angka.',
            'siaga.required' => 'Parameter siaga wajib diisi.',
            'siaga.numeric' => 'Parameter siaga harus berupa angka.',
            'awas.required' => 'Parameter awas wajib diisi.',
            'awas.numeric' => 'Parameter awas harus berupa angka.',
            'h2.required' => 'Parameter h2 wajib diisi.',
            'h2.numeric' => 'Parameter h2 harus berupa angka.',
            'h1.required' => 'Parameter h1 wajib diisi.',
            'h1.numeric' => 'Parameter h1 harus berupa angka.',
        ]);

        $data = [
            'iot_node_id' => $request->iot_node,
            'waspada' => $request->waspada,
            'siaga' => $request->siaga,
            'awas' => $request->awas,
            'h2' => $request->h2,
            'h1' => $request->h1,
        ];

        $post = Threshold::create($data);

        activity()
            ->performedOn($post)
            ->event('create')
            ->causedBy(Auth::user())
            ->log('Threshold baru ditambahkan untuk IoT Node dengan ID ' . $request->iot_node);

        return redirect()->route('threshold.index')->with('success', 'Data threshold berhasil disimpan!');
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
        $threshold = Threshold::findOrFail($id);
        return view('pages.threshold.edit', compact('iotNodes', 'threshold'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $threshold = Threshold::findOrFail($id);

        $request->validate([
            'waspada' => 'required|numeric',
            'siaga' => 'required|numeric',
            'awas' => 'required|numeric',
            'h2' => 'required|numeric',
            'h1' => 'required|numeric',
        ], [
            'waspada.required' => 'Parameter waspada wajib diisi.',
            'waspada.numeric' => 'Parameter waspada harus berupa angka.',
            'siaga.required' => 'Parameter siaga wajib diisi.',
            'siaga.numeric' => 'Parameter siaga harus berupa angka.',
            'awas.required' => 'Parameter awas wajib diisi.',
            'awas.numeric' => 'Parameter awas harus berupa angka.',
            'h2.required' => 'Parameter h2 wajib diisi.',
            'h2.numeric' => 'Parameter h2 harus berupa angka.',
            'h1.required' => 'Parameter h1 wajib diisi.',
            'h1.numeric' => 'Parameter h1 harus berupa angka.',
        ]);

        $data = [
            'waspada' => $request->waspada,
            'siaga' => $request->siaga,
            'awas' => $request->awas,
            'h2' => $request->h2,
            'h1' => $request->h1,
        ];

        $beforeUpdate = $threshold->getOriginal();
        $threshold->update($data);

        $changes = [];

        foreach ($data as $key => $value) {
            if (array_key_exists($key, $beforeUpdate) &&  $beforeUpdate[$key] !== $value) {
                $changes[$key] = [
                    'old' => $beforeUpdate[$key],
                    'new' => $value,
                ];
            }
        }

        activity()
            ->performedOn($threshold)
            ->event('update')
            ->withProperties(['changes' => $changes])
            ->causedBy(Auth::user())
            ->log('Threshold untuk IoT Node dengan ID ' . $threshold->iot_node_id . ' berhasil diupdate');

        return redirect()->route('threshold.index')->with('success', 'Data threshold berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $threshold = Threshold::findOrFail($id);
        $threshold->delete();

        activity()
            ->performedOn($threshold)
            ->event('delete')
            ->causedBy(Auth::user())
            ->log('Threshold untuk IoT Node dengan ID ' . $threshold->iot_node_id . ' dihapus');

        return redirect()->route('threshold.index')->with('success', 'Data threshold berhasil dihapus!');
    }
}
