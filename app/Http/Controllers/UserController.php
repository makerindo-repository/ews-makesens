<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::get();
        return view('pages.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'profile_picture' => 'required|image|mimes:png,jpg,jpeg|max:2048',
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:8',
            'phone' => 'required|regex:/^0[0-9]{9,13}$/|unique:users,phone',
            'gender' => 'required|in:l,p',
            'address' => 'required|string',
        ], [
            'profile_picture.required' => 'Foto profil wajib diisi.',
            'profile_picture.image' => 'Foto profil harus berupa file gambar.',
            'profile_picture.mimes' => 'File harus berupa jpg, png, atau jpeg.',
            'profile_picture.max' => 'File tidak boleh lebih dari 2MB.',
            'name.required' => 'Nama wajib diisi.',
            'name.string' => 'Nama tidak valid',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Email tidak valid.',
            'email.unique' => 'Email ini sudah digunakan.',
            'password.required' => 'Password wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password minimal harus terdiri dari 8 karakter',
            'phone.required' => 'Nomor telepon wajib diisi.',
            'phone.regex' => 'Nomor telepon harus diawali 0 dan terdiri dari 10-14 digit.',
            'phone.unique' => 'Nomor telepon ini sudah digunakan.',
            'gender.required' => 'Jenis kelamin wajib diisi.',
            'gender.in' => 'Jenis kelamin hanya bisa diisi dengan "l" (laki-laki) atau "p" (perempuan)',
            'address.required' => 'Alamat wajib diisi.',
        ]);

        $profilePict = ImageService::image_intervention($request->file('profile_picture'), 'images/profile-picture/', 1 / 1);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'gender' => $request->gender,
            'address' => $request->address,
            'role' => 'admin',
            'profile_picture' => $profilePict,
        ];

        $post = User::create($data);

        return redirect()->route('user.index')->with('success', 'Data user berhasil disimpan!');
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
        $user = User::findOrFail($id);
        return view('pages.user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);
        $request->validate([
            'profile_picture' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|confirmed|min:8',
            'phone' => 'required|regex:/^0[0-9]{9,13}$/|unique:users,phone,' . $user->id,
            'gender' => 'required|in:l,p',
            'address' => 'required|string',
        ], [
            'profile_picture.image' => 'Foto profil harus berupa file gambar.',
            'profile_picture.mimes' => 'File harus berupa jpg, png, atau jpeg.',
            'profile_picture.max' => 'File tidak boleh lebih dari 2MB.',
            'name.required' => 'Nama wajib diisi.',
            'name.string' => 'Nama tidak valid',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Email tidak valid.',
            'email.unique' => 'Email ini sudah digunakan.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password minimal harus terdiri dari 8 karakter',
            'phone.required' => 'Nomor telepon wajib diisi.',
            'phone.regex' => 'Nomor telepon harus diawali 0 dan terdiri dari 10-14 digit.',
            'phone.unique' => 'Nomor telepon ini sudah digunakan.',
            'gender.required' => 'Jenis kelamin wajib diisi.',
            'gender.in' => 'Jenis kelamin hanya bisa diisi dengan "l" (laki-laki) atau "p" (perempuan)',
            'address.required' => 'Alamat wajib diisi.',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'address' => $request->address,
        ];

        $user->update($data);

        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        if ($request->hasFile('profile_picture')) {
            ImageService::deleteImage($user->profile_picture);
            $profilePict = ImageService::image_intervention($request->file('profile_picture'), 'images/profile-picture/', 1 / 1);
            $user->update(['profile_picture' => $profilePict]);
        }

        return redirect()->route('user.index')->with('success', 'Data user berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        if ($user->profile_picture) {
            ImageService::deleteImage($user->profile_picture);
        }
        $user->delete();

        return redirect()->route('user.index')->with('success', 'Data user berhasil dihapus!');
    }
}
