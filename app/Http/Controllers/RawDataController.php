<?php

namespace App\Http\Controllers;

use App\Models\IoTNode;
use App\Models\RawData;
use Illuminate\Http\Request;

class RawDataController extends Controller
{
    public function index(Request $request)
    {
        $iotNodes = IoTNode::get();
        $query = RawData::query();

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $data = $query->latest()->get();

        $locations = $data->map(function ($d) {
            return [
                'lat' => (float) $d->latitude,
                'lng' => (float) $d->longitude,
                'timestamp' => $d->created_at->format('d M Y H:i:s'),
                'distance' => $d->distance,
                'status' => $d->status,
            ];
        });

        return view('pages.raw-data.index', compact('iotNodes', 'data', 'locations'));
    }
}
