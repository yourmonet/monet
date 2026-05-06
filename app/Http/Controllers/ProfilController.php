<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UpdateProfilRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfilController extends Controller
{
    public function edit()
    {
        return view('profil.edit');
    }

    public function update(UpdateProfilRequest $request)
    {
        $user = auth()->user();
        
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->hasFile('avatar')) {
            $disk = config('filesystems.default');
            if ($user->avatar && Storage::disk($disk)->exists($user->avatar)) {
                Storage::disk($disk)->delete($user->avatar);
            }
            $path = $request->file('avatar')->store('avatars', $disk);
            
            // Jika menggunakan S3 (Supabase), simpan full URL agar bisa langsung dirender
            if ($disk === 's3' || $disk === 'supabase') {
                $user->avatar = Storage::disk($disk)->url($path);
            } else {
                $user->avatar = $path;
            }
        }

        if ($request->filled('new_password')) {
            $user->password = Hash::make($request->new_password);
        }

        $user->save();

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }
}
