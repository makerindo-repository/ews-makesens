<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\User;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VolunteerController extends Controller
{
    public function index()
    {
        $volunteers = User::with('location')->where('role', 'relawan')->get();
        return view('pages.volunteer.index', compact('volunteers'));
    }

    public function create()
    {
        $volunteers = User::whereNotIn('role', ['superadmin', 'relawan'])->get();
        $locations = Location::get();
        return view('pages.volunteer.create', compact('volunteers', 'locations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'location' => 'required|exists:locations,id'
        ], [
            'user_id.required' => 'Pilih nama relawan.',
            'user_id.exists' => 'Nama relawan tidak valid.',
            'location.required' => 'Pilih lokasi tugas.',
            'location.exists' => 'Lokasi tugas tidak valid.',
        ]);

        $user = User::findOrFail($request->user_id);
        $user->update(['role' => 'relawan', 'location_id' => $request->location]);

        activity()
            ->performedOn($user)
            ->event('create')
            ->causedBy(Auth::user())
            ->log('Relawan baru ditambahkan: ' . $user->name);

        return redirect()->route('volunteer.index')->with('success', 'Data relawan berhasil disimpan!');
    }

    public function show(string $id)
    {
        // 
    }

    public function edit(string $id)
    {
        $user = User::with('location')->findOrFail($id);
        $volunteers = User::get();
        $locations = Location::get();
        return view('pages.volunteer.edit', compact('user', 'volunteers', 'locations'));
    }

    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'location' => 'required|exists:locations,id'
        ], [
            'location.required' => 'Pilih lokasi tugas.',
            'location.exists' => 'Lokasi tugas tidak valid.',
        ]);

        $data = [
            'location_id' => $request->location
        ];
        
        $beforeUpdate = $user->getOriginal();
        $user->update($data);

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
            ->performedOn($user)
            ->event('update')
            ->withProperties(['changes' => $changes])
            ->causedBy(Auth::user())
            ->log('Relawan dengan ID ' . $user->id . ' berhasil diupdate');

        return redirect()->route('volunteer.index')->with('success', 'Data relawan berhasil diubah!');
    }

    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        if ($user->profile_picture) {
            ImageService::deleteImage($user->profile_picture);
        }
        $user->delete();

        activity()
            ->performedOn($user)
            ->event('delete')
            ->causedBy(Auth::user())
            ->log('Relawan dihapus: ' . $user->name);

        return redirect()->route('volunteer.index')->with('success', 'Data relawan berhasil dihapus!');
    }
}
