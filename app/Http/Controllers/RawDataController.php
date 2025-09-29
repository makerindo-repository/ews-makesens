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

        $data = $query->get();
        return view('pages.raw-data.index', compact('iotNodes', 'data'));
    }
}
